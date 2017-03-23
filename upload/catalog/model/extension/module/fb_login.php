<?php
class ModelExtensionModuleFBLogin extends Model {
	
	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row['total'];
	}
	
	public function addCustomer($data) {
		$customer_group_id = $this->config->get('fb_login_customer_group_id');

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? serialize($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW() ON DUPLICATE KEY UPDATE status = '1'");

		$customer_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? serialize($data['custom_field']['address']) : '') . "'");

		$address_id = $this->db->getLastId();

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");

		$find = array(
			'{firstname}',
			'{lastname}',
			'{email}',
			'{password}',
			'{login_link}',
			'{store_name}',
		);
		
		$replace = array(
			'firstname'  => $data['firstname'],
			'lastname'   => $data['lastname'],
			'email'      => $data['email'],
			'password'   => $data['password'],
			'login_link' => '<a href="' . $this->url->link('account/login', '', 'SSL') . '">' . $this->url->link('account/login', '', 'SSL') . '</a>',
			'store_name' => $this->config->get('config_name')	
		);
		
		$fb_login_mail = $this->config->get('fb_login_mail');
		
		$subject = str_replace($find, $replace, html_entity_decode($fb_login_mail[$this->config->get('config_language_id')]['subject'], ENT_QUOTES, 'UTF-8'));
		
		$message = str_replace($find, $replace, html_entity_decode($fb_login_mail[$this->config->get('config_language_id')]['message'], ENT_QUOTES, 'UTF-8'));
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		
        $mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject($subject);
		
		if ($this->config->get('fb_login_use_html_email') && $this->isHTMLEmailExtensionInstalled()) {
						
			$this->load->model('tool/html_email');
			$html = $this->model_tool_html_email->getHTMLEmail($this->config->get('config_language_id'), $subject, $message, 'html');
			
			$mail->setHtml($html);
			
		} else {		 
			$mail->setHtml($message);
		}	
		
		$mail->send();

		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail')) {
			$this->load->language('mail/customer');
			
			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . $this->config->get('config_name') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
			$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";

			$mail->setTo($this->config->get('config_email'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setHtml(''); // clear HTML message sent to customer to allow text message
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();

			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_mail_alert'));

			foreach ($emails as $email) {
				if (utf8_strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}

		return $customer_id;
	}	
	
	public function generateRandomPassword( $length = 8){
		$password = "";
		$start = 97; // ascii code for a
		$stop  = 122; // ascii code for z
		
		while (strlen ($password) != $length ){
			$password.= chr(rand($start, $stop));
		}
			
		return $password;
	}
	
	private function isHTMLEmailExtensionInstalled() {
		$installed = false;
		
		if ($this->config->get('html_email_default_word') && file_exists(DIR_APPLICATION . 'model/tool/html_email.php')) {
			$installed = true;	
		}
		
		return $installed;
	}
}
?>