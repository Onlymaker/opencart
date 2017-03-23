<?php
class ControllerExtensionModuleFBLogin extends Controller {
	public function index() {
		
		if ($this->config->get('fb_login_mode') == 'standard-mode') { 
		
			$data['button_name'] = $this->config->get('fb_login_button_name_' . $this->config->get('config_language_id'));
			$data['button_class'] = $this->config->get('fb_login_button_design');
			
			if (!$this->customer->isLogged()) { // if is not logged show button | no reason to show if is logged
				return $this->load->view('extension/module/fb_login', $data);
			}
		}	
	}	
	
	public function checkuser() {
		
		$this->load->model('extension/module/fb_login');
		$this->load->model('account/customer');
		
		$this->session->data['fb_user_info'] = $this->request->post;
		
		if (isset($this->request->post['email'])) { 
		
			if (!$this->model_extension_module_fb_login->getTotalCustomersByEmail($this->request->post['email'])) {
				if (!$this->isAdditionalRequired($this->request->post)) {
					
					$this->createAccount();
					
					// Clear any previous login attempts for unregistered accounts.
					$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
					
					$this->customer->login($this->request->post['email'], '', true);

					$this->setAfterLoginDetails();
					
					$this->FBLoginRedirectTo('account/account');
					
				} else {
					$this->accountExtraInfo();
				}			
				
			} else {
			
				if (!$this->customer->isLogged()) {
					$this->customer->login($this->request->post['email'], '', true);
					
					$this->setAfterLoginDetails();
				}
				
				$this->FBLoginRedirectTo('account/account');
			}
			
		} else {
			
			$this->FBLoginRedirectTo('account/register');
		}		
	}
	
	private function setAfterLoginDetails() {
		// Unset guest
		unset($this->session->data['guest']);
			
		// Default Shipping Address
		$this->load->model('account/address');

		if ($this->config->get('config_tax_customer') == 'payment') {
			$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
		}

		if ($this->config->get('config_tax_customer') == 'shipping') {
			$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
		}

		// Wishlist
		if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
			$this->load->model('account/wishlist');

			foreach ($this->session->data['wishlist'] as $key => $product_id) {
				$this->model_account_wishlist->addWishlist($product_id);

				unset($this->session->data['wishlist'][$key]);
			}
		}

		// Add to activity log
		$this->load->model('account/activity');

		$activity_data = array(
			'customer_id' => $this->customer->getId(),
			'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
		);

		$this->model_account_activity->addActivity('login', $activity_data);
	}
	
	private function FBLoginRedirectTo($route) {
		$json = array();
			
		$json['redirect'] = $this->url->link($route, '', 'SSL');
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
	
	public function createAccount() {
		$this->load->model('extension/module/fb_login');
		
		$oc_customer_data = $this->createOCCustomerData();
		$customer_id = $this->model_extension_module_fb_login->addCustomer($oc_customer_data);
		
		if ($customer_id) {
			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $customer_id,
				'name'        => $oc_customer_data['firstname'] . ' ' . $oc_customer_data['lastname']
			);

			$this->model_account_activity->addActivity('register', $activity_data);
		}
	}
	
	public function accountExtraInfo() {
		$this->language->load('extension/module/fb_login');
	
		$this->load->model('extension/module/fb_login');
		
		$account_success = false;
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post['fb_additional_info'])) {
			if (!$json) {
				
				$dinamic_strlen = 'utf8_strlen';
		 
				if ( !function_exists('utf8_strlen') ) {
					$dinamic_strlen = 'strlen';
				}
				
				if ($this->config->get('fb_login_zone_id')) {
					if (!isset($this->request->post['fb_login_zone_id']) || $this->request->post['fb_login_zone_id'] == '' || !is_numeric($this->request->post['fb_login_zone_id'])) {
						$json['error']['warning'] = $this->language->get('error_zone');
					}
				}	
				
				if ($this->config->get('fb_login_country_id')) {
					if ($this->request->post['fb_login_country_id'] == '') {
						$json['error']['warning'] = $this->language->get('error_country');
					}				
				}
				
				if ($this->config->get('fb_login_postcode') && isset($this->request->post['fb_login_country_id'])) {
					if ($this->request->post['fb_login_country_id'] != '') {
					
						$this->load->model('localisation/country');
						$country_info = $this->model_localisation_country->getCountry($this->request->post['fb_login_country_id']);

						if ($country_info && $country_info['postcode_required'] && (($dinamic_strlen($this->request->post['fb_login_postcode']) < 2) || ($dinamic_strlen($this->request->post['fb_login_postcode']) > 10))) {
							$json['error']['warning'] = $this->language->get('error_postcode');
						}
					}
				}				
				
				if ($this->config->get('fb_login_city')) {
					if (($dinamic_strlen($this->request->post['fb_login_city']) < 2) || ($dinamic_strlen($this->request->post['fb_login_city']) > 128)) {
						$json['error']['warning'] = $this->language->get('error_city');
					}
				}
				
				if ($this->config->get('fb_login_address_1')) {
					if (($dinamic_strlen($this->request->post['fb_login_address_1']) < 3) || ($dinamic_strlen($this->request->post['fb_login_address_1']) > 128)) {
						$json['error']['warning'] = $this->language->get('error_address_1');
					}
				}				
				
				if ($this->config->get('fb_login_company')) {
					if (($dinamic_strlen($this->request->post['fb_login_company']) < 1)) {
						$json['error']['warning'] = $this->language->get('error_company');
					}
				}				
				
				if ($this->config->get('fb_login_fax')) {
					if (($dinamic_strlen($this->request->post['fb_login_fax']) < 3) || ($dinamic_strlen($this->request->post['fb_login_fax']) > 32)) {
						$json['error']['warning'] = $this->language->get('error_fax');
					}
				}
				
				if ($this->config->get('fb_login_telephone')) {
					if (($dinamic_strlen($this->request->post['fb_login_telephone']) < 3) || ($dinamic_strlen($this->request->post['fb_login_telephone']) > 32)) {
						$json['error']['warning'] = $this->language->get('error_telephone');
					}
				}
				
				$customer_group_id = $this->config->get('fb_login_customer_group_id');

				// Custom field validation
				$this->load->model('account/custom_field');

				$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

				foreach ($custom_fields as $custom_field) {
					if ($custom_field['required'] && empty($this->request->post['fb_login_custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
						$json['error']['warning'] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
					} elseif (($custom_field['type'] == 'text' && !empty($custom_field['validation'])) && !filter_var($this->request->post['fb_login_custom_field'][$custom_field['location']][$custom_field['custom_field_id']], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $custom_field['validation'])))) {
						$json['error']['warning'] = sprintf($this->language->get('error_custom_field_validate'), $custom_field['name']);
					}
				}				
			}
			
			if (!$json) {
				
				$this->session->data['fb_user_extra_info'] = $this->request->post;
				
				$this->createAccount();
				
				$this->load->model('account/customer');
				
				// Clear any previous login attempts for unregistered accounts.
				$this->model_account_customer->deleteLoginAttempts($this->session->data['fb_user_info']['email']);
				
				$this->customer->login($this->session->data['fb_user_info']['email'], '', true);
				
				$this->setAfterLoginDetails();
				
				$account_success = true;
				
				$this->FBLoginRedirectTo('account/account');
		
			}
		
		} else {
			
			$extra_info = $this->config->get('fb_login_extra_info');
			
			if (isset($extra_info[$this->config->get('config_language_id')]['message'])) {
				$data['text_explain_info'] = html_entity_decode($extra_info[$this->config->get('config_language_id')]['message'], ENT_QUOTES, 'UTF-8');
			} else {
				$data['text_explain_info'] = '';
			}
			
			$data['text_yes'] = $this->language->get('text_yes');
			$data['text_no'] = $this->language->get('text_no');
			$data['text_select'] = $this->language->get('text_select');
			$data['text_none'] = $this->language->get('text_none');
			$data['text_modal_title'] = $this->config->get('fb_login_button_name_' . $this->config->get('config_language_id'));
							
			$data['entry_customer_group'] = $this->language->get('entry_customer_group');
			$data['entry_telephone'] = $this->language->get('entry_telephone');
			$data['entry_fax'] = $this->language->get('entry_fax');
			$data['entry_company'] = $this->language->get('entry_company');
			$data['entry_address_1'] = $this->language->get('entry_address_1');
			$data['entry_address_2'] = $this->language->get('entry_address_2');
			$data['entry_postcode'] = $this->language->get('entry_postcode');
			$data['entry_city'] = $this->language->get('entry_city');
			$data['entry_country'] = $this->language->get('entry_country');
			$data['entry_zone'] = $this->language->get('entry_zone');
			
			if ($this->config->get('fb_login_telephone')) {
				$data['telephone_required'] = true;
			} else {
				$data['telephone_required'] = false;
			}
			
			if ($this->config->get('fb_login_fax')) {
				$data['fax_required'] = true;
			} else {
				$data['fax_required'] = false;
			}

			if ($this->config->get('fb_login_company')) {
				$data['company_required'] = true;
			} else {
				$data['company_required'] = false;
			}

			if ($this->config->get('fb_login_address_1')) {
				$data['address_1_required'] = true;
			} else {
				$data['address_1_required'] = false;
			}

			if ($this->config->get('fb_login_city')) {
				$data['city_required'] = true;
			} else {
				$data['city_required'] = false;
			}			
			
			if ($this->config->get('fb_login_postcode')) {
				$data['postcode_required'] = true;
			} else {
				$data['postcode_required'] = false;
			}

			if ($this->config->get('fb_login_country_id')) {
				$data['country_id_required'] = true;
			} else {
				$data['country_id_required'] = false;
			}

			if ($this->config->get('fb_login_zone_id')) {
				$data['zone_id_required'] = true;
			} else {
				$data['zone_id_required'] = false;
			}

			$data['customer_group_id'] = $this->config->get('fb_login_customer_group_id');						
			
			// Custom Fields
			$this->load->model('account/custom_field');

			$data['custom_fields'] = $this->model_account_custom_field->getCustomFields();

			$data['register_custom_field'] = array();							
			
			$data['button_register_now'] = $this->language->get('button_register_now');
			
			$data['country_id'] = $this->config->get('config_country_id');
			$data['zone_id'] = $this->config->get('config_zone_id');
			
			$this->load->model('localisation/country');
			$data['countries'] = $this->model_localisation_country->getCountries();
		
			$json['output'] = $this->load->view('extension/module/fb_login_ai', $data);
		}
		
		if (!$account_success) { 
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}	
	}
	
	public function createOCCustomerData() {
		
		$this->load->model('extension/module/fb_login');
		
		// create customer data in oc format
		$oc_customer_data = array(
			'firstname'  		=> $this->session->data['fb_user_info']['first_name'],
			'lastname'   		=> $this->session->data['fb_user_info']['last_name'],
			'email'      		=> $this->session->data['fb_user_info']['email'],
			'telephone'  		=> isset($this->session->data['fb_user_extra_info']['fb_login_telephone']) ? $this->session->data['fb_user_extra_info']['fb_login_telephone'] : '', 
			'fax'        		=> isset($this->session->data['fb_user_extra_info']['fb_login_fax']) ? $this->session->data['fb_user_extra_info']['fb_login_fax'] : '',
			'password'   		=> $this->model_extension_module_fb_login->generateRandomPassword(), 
			'newsletter' 		=> '1',
			'customer_group_id' => isset($this->session->data['fb_user_extra_info']['fb_login_customer_group_id']) ? $this->session->data['fb_user_extra_info']['fb_login_customer_group_id'] : $this->config->get('fb_login_customer_group_id'),
			'status'            => '1',
			'approved'          => '1',
			'company'           => isset($this->session->data['fb_user_extra_info']['fb_login_company']) ? $this->session->data['fb_user_extra_info']['fb_login_company'] : '',			
			'address_1'         => isset($this->session->data['fb_user_extra_info']['fb_login_address_1']) ? $this->session->data['fb_user_extra_info']['fb_login_address_1'] : '', 
			'address_2'         => isset($this->session->data['fb_user_extra_info']['fb_login_address_2']) ? $this->session->data['fb_user_extra_info']['fb_login_address_2'] : '', 
			'city'              => isset($this->session->data['fb_user_extra_info']['fb_login_city']) ? $this->session->data['fb_user_extra_info']['fb_login_city'] : '', 
			'postcode'          => isset($this->session->data['fb_user_extra_info']['fb_login_postcode']) ? $this->session->data['fb_user_extra_info']['fb_login_postcode'] : '', 
			'country_id'        => isset($this->session->data['fb_user_extra_info']['fb_login_country_id']) ? $this->session->data['fb_user_extra_info']['fb_login_country_id'] : '', 
			'zone_id'           => isset($this->session->data['fb_user_extra_info']['fb_login_zone_id']) ? $this->session->data['fb_user_extra_info']['fb_login_zone_id'] : '',
			'custom_field'      => isset($this->session->data['fb_user_extra_info']['fb_login_custom_field']) ? $this->session->data['fb_user_extra_info']['fb_login_custom_field'] : '',
		);
		
		return $oc_customer_data;
	}
	
	private function isAdditionalRequired($user_info) {
		$show_extra_dialog = false;
		
		if ($this->config->get('fb_login_telephone') && !isset($user_info['telephone'])) {
			$show_extra_dialog = true;
		}
		
		if ($this->config->get('fb_login_fax') && !isset($user_info['fax'])) {
			$show_extra_dialog = true;
		}		
		
		if ($this->config->get('fb_login_company') && !isset($user_info['company'])) {
			$show_extra_dialog = true;
		}
		
		if ($this->config->get('fb_login_address_1') && !isset($user_info['address_1'])) {
			$show_extra_dialog = true;
		}		
		
		if ($this->config->get('fb_login_city') && !isset($user_info['city'])) {
			$show_extra_dialog = true;
		}	

		if ($this->config->get('fb_login_postcode') && !isset($user_info['postcode'])) {
			$show_extra_dialog = true;
		}		
		
		if ($this->config->get('fb_login_country_id') && !isset($user_info['country_id'])) {
			$show_extra_dialog = true;
		}	

		if ($this->config->get('fb_login_zone_id') && !isset($user_info['zone_id'])) {
			$show_extra_dialog = true;
		}		
		
		return $show_extra_dialog;
	}
	
	public function checkLoginStatusAndSetButtonText() {
		$json = array();
		
		$json['logged'] = ($this->customer->isLogged()) ? 1 : 0;   // or just use cast (int)
		$json['button_text'] = $this->config->get('fb_login_button_name_' . $this->config->get('config_language_id'));
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>