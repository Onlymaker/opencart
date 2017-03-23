<?php
class ControllerExtensionModuleFBLogin extends Controller {
	private $error = array();
	private $version = '1.6.0';	
	
	public function index() {   
		$this->load->language('extension/module/fb_login');

		$this->document->setTitle($this->language->get('heading_title') . ' ' . $this->version);
		
		$this->document->addScript('view/javascript/jquery/bootstrap-toggle/bootstrap-toggle.js');
		$this->document->addStyle('view/stylesheet/bootstrap-toggle.css');
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('fb_login', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}
				 
		$data['heading_title'] = $this->language->get('heading_title') . ' ' . $this->version;
		
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_fb_button'] = $this->language->get('tab_fb_button');
		$data['tab_new_account'] = $this->language->get('tab_new_account');
		$data['tab_registration_mail'] = $this->language->get('tab_registration_mail');
		$data['tab_help'] = $this->language->get('tab_help');
		
		$data['text_edit'] = $this->language->get('text_edit');		
		$data['text_select'] = $this->language->get('text_select');		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_required'] = $this->language->get('text_required');
		$data['text_not_required'] = $this->language->get('text_not_required');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['text_standard'] = $this->language->get('text_standard');
		$data['text_advanced'] = $this->language->get('text_advanced');
		$data['text_link_only'] = $this->language->get('text_link_only');
		$data['text_standard_no_icon'] = $this->language->get('text_standard_no_icon');
		$data['text_standard_icon'] = $this->language->get('text_standard_icon');
		$data['text_rounded_no_icon'] = $this->language->get('text_rounded_no_icon');
		$data['text_rounded_icon'] = $this->language->get('text_rounded_icon');
		$data['text_button_text'] = $this->language->get('text_button_text');
		$data['text_button_design'] = $this->language->get('text_button_design');
		$data['text_for_design'] = $this->language->get('text_for_design');
		$data['text_use_code'] = $this->language->get('text_use_code');
		$data['text_redirect_account'] = $this->language->get('text_redirect_account');
		$data['text_redirect_same_page'] = $this->language->get('text_redirect_same_page');
		
		$data['entry_app_id'] = $this->language->get('entry_app_id');
		$data['entry_mode'] = $this->language->get('entry_mode');
	
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_required_info'] = $this->language->get('entry_required_info');
		
		$extra_fields = array(
			'telephone',
			'fax',
			'company',
			'address_1',
			'city',
			'postcode',
			'country_id',
			'zone_id'
		);
		
		foreach($extra_fields as $extra_field) {
			$data['entry_' . $extra_field] = $this->language->get('entry_' . $extra_field);
		}		
		
		$data['entry_button_text'] = $this->language->get('entry_button_text');
		$data['entry_button_design'] = $this->language->get('entry_button_design');
		$data['entry_button_preview'] = $this->language->get('entry_button_preview');
		
		$data['entry_subject'] = $this->language->get('entry_subject');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_use_html_email'] = $this->language->get('entry_use_html_email');
		$data['entry_extra_info_message'] = $this->language->get('entry_extra_info_message');
		$data['entry_redirect_mode'] = $this->language->get('entry_redirect_mode');
		
		$data['help_app_id'] = $this->language->get('help_app_id');
		$data['help_mode'] = $this->language->get('help_mode');
		$data['help_standard_mode_info'] = $this->language->get('help_standard_mode_info');
		$data['help_advanced_mode_info'] = $this->language->get('help_advanced_mode_info');
		$data['help_customer_group'] = $this->language->get('help_customer_group');
		$data['help_required_info'] = $this->language->get('help_required_info');
		$data['help_special_keywords_title'] = $this->language->get('help_special_keywords_title');
		$data['help_subject'] = $this->language->get('help_subject');
		$data['help_message'] = $this->language->get('help_message');
		$data['help_extra_info_message'] = $this->language->get('help_extra_info_message');
		$data['help_use_html_email'] = $this->language->get('help_use_html_email');
		$data['help_code'] = $this->language->get('help_code');
		$data['help_code_result'] = $this->language->get('help_code_result');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['app_id'])) {
			$data['error_app_id'] = $this->error['app_id'];
		} else {
			$data['error_app_id'] = '';
		}
		
		if (isset($this->error['button_name'])) {
			$data['error_button_name'] = $this->error['button_name'];
		} else {
			$data['error_button_name'] = array();
		}		
		
		if (isset($this->error['customer_group_id'])) {
			$data['error_customer_group_id'] = $this->error['customer_group_id'];
		} else {
			$data['error_customer_group_id'] = '';
		}

		if (isset($this->error['extra_info_message'])) {
			$data['error_extra_info_message'] = $this->error['extra_info_message'];
		} else {
			$data['error_extra_info_message'] = array();
		}		
		
		if (isset($this->error['subject'])) {
			$data['error_subject'] = $this->error['subject'];
		} else {
			$data['error_subject'] = array();
		}	

		if (isset($this->error['message'])) {
			$data['error_message'] = $this->error['message'];
		} else {
			$data['error_message'] = array();
		}

		if (isset($this->error['use_html_email'])) {
			$data['error_use_html_email'] = $this->error['use_html_email'];
		} else {
			$data['error_use_html_email'] = array();
		}		
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/fb_login', 'token=' . $this->session->data['token'], true)
   		);
		
		$data['action'] = $this->url->link('extension/module/fb_login', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

		$this->update_check();
		
		if (isset($this->error['update'])) {
			$data['update'] = $this->error['update'];
		} else {
			$data['update'] = '';
		}			
		
		if (isset($this->request->post['fb_login_status'])){
			$data['fb_login_status'] = $this->request->post['fb_login_status'];
		} elseif ( $this->config->get('fb_login_status')){
			$data['fb_login_status'] = $this->config->get('fb_login_status');
		} else {
			$data['fb_login_status'] = 1;  // enabled by default; hidden in tpl
		}		

		if (isset($this->request->post['fb_login_app_id'])){
			$data['fb_login_app_id'] = $this->request->post['fb_login_app_id'];
		} elseif ( $this->config->get('fb_login_app_id')){
			$data['fb_login_app_id'] = $this->config->get('fb_login_app_id');
		} else {
			$data['fb_login_app_id'] = '';
		}
		
		if (isset($this->request->post['fb_login_mode'])){
			$data['fb_login_mode'] = $this->request->post['fb_login_mode'];
		} elseif ( $this->config->get('fb_login_mode')){
			$data['fb_login_mode'] = $this->config->get('fb_login_mode');
		} else {
			$data['fb_login_mode'] = '';
		}

		if (isset($this->request->post['fb_login_redirect_mode'])){
			$data['fb_login_redirect_mode'] = $this->request->post['fb_login_redirect_mode'];
		} elseif ( $this->config->get('fb_login_redirect_mode')){
			$data['fb_login_redirect_mode'] = $this->config->get('fb_login_redirect_mode');
		} else {
			$data['fb_login_redirect_mode'] = '';
		}		
		
		if (isset($this->request->post['fb_login_customer_group_id'])){
			$data['fb_login_customer_group_id'] = $this->request->post['fb_login_customer_group_id'];
		} elseif ( $this->config->get('fb_login_customer_group_id')){
			$data['fb_login_customer_group_id'] = $this->config->get('fb_login_customer_group_id');
		} else {
			$data['fb_login_customer_group_id'] = '';
		}		
		
		foreach($extra_fields as $extra_field) {
			if (isset($this->request->post['fb_login_' . $extra_field])){
				$data['fb_login_' . $extra_field] = $this->request->post['fb_login_' . $extra_field];
			} elseif ( $this->config->get('fb_login_' . $extra_field)){
				$data['fb_login_' . $extra_field] = $this->config->get('fb_login_' . $extra_field);
			} else {
				$data['fb_login_' . $extra_field] = '';
			} 
		}	
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		foreach($data['languages'] as $language) {
			if (isset($this->request->post['fb_login_button_name_' . $language['language_id']])){
				$data['fb_login_button_name_' . $language['language_id']] = $this->request->post['fb_login_button_name_' . $language['language_id']];
			} elseif ( $this->config->get('fb_login_button_name_' . $language['language_id'])){
				$data['fb_login_button_name_' . $language['language_id']] = $this->config->get('fb_login_button_name_' . $language['language_id']);
			} else {
				$data['fb_login_button_name_' . $language['language_id']] = '';
			}
		}
		
		if (isset($this->request->post['fb_login_button_design'])){
			$data['fb_login_button_design'] = $this->request->post['fb_login_button_design'];
		} elseif ( $this->config->get('fb_login_button_design')){
			$data['fb_login_button_design'] = $this->config->get('fb_login_button_design');
		} else {
			$data['fb_login_button_design'] = '';
		}		
		
		if (isset($this->request->post['fb_login_use_html_email'])){
			$data['fb_login_use_html_email'] = $this->request->post['fb_login_use_html_email'];
		} elseif ( $this->config->get('fb_login_use_html_email')){
			$data['fb_login_use_html_email'] = $this->config->get('fb_login_use_html_email');
		} else {
			$data['fb_login_use_html_email'] = '';
		}		
		
		if (isset($this->request->post['fb_login_extra_info'])){
			$data['fb_login_extra_info'] = $this->request->post['fb_login_extra_info'];
		} elseif ( $this->config->get('fb_login_extra_info')){
			$data['fb_login_extra_info'] = $this->config->get('fb_login_extra_info');
		} else {
			$data['fb_login_extra_info'] = array();
		}		
		
		if (isset($this->request->post['fb_login_mail'])){
			$data['fb_login_mail'] = $this->request->post['fb_login_mail'];
		} elseif ( $this->config->get('fb_login_mail')){
			$data['fb_login_mail'] = $this->config->get('fb_login_mail');
		} else {
			$data['fb_login_mail'] = array();
		}		
		
		$data['designs'] = array(
			array(
				'name'  => 'White',
				'class' => 'btn-default'
			),
			array(
				'name'  => 'Blue',
				'class' => 'btn-primary'
			),	
			array(
				'name'  => 'Green',
				'class' => 'btn-success'
			),	
			array(
				'name'  => 'Light Blue',
				'class' => 'btn-info'
			),	
			array(
				'name'  => 'Orange',
				'class' => 'btn-warning'
			),	
			array(
				'name'  => 'Red',
				'class' => 'btn-danger'
			),	
			array(
				'name'  => 'Transparent',
				'class' => 'btn-link'
			)			
		);
		
		$this->load->model('customer/customer_group');
		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();		
		
		$this->load->model('design/layout');
		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$data['extra_fields'] = $extra_fields;
		$data['default_language_id'] = $this->config->get('config_language_id');
		
		$data['token'] = $this->session->data['token'];
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('extension/module/fb_login', $data));
	}
	
	
	private function validate() {
	
		if (!$this->user->hasPermission('modify', 'extension/module/fb_login')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$dinamic_strlen = 'utf8_strlen';
		 
		if ( !function_exists('utf8_strlen') ) {
			$dinamic_strlen = 'strlen';
		}
		
		if ($dinamic_strlen($this->request->post['fb_login_app_id']) == 0){
			$this->error['app_id'] = $this->language->get('error_app_id');
			$this->error['warning'] = sprintf($this->language->get('error_in_tab'), $this->language->get('tab_general'));
		}		
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach($languages as $language) {
			$key = 'fb_login_button_name_' . $language['language_id'];
			
			if (isset($this->request->post[$key])) {
				if ($dinamic_strlen($this->request->post[$key]) < 1) {
					$this->error['button_name'][$language_id] = $this->language->get('error_button_name');
					$this->error['warning'] = sprintf($this->language->get('error_in_tab'), $this->language->get('tab_fb_button'));
				}
			}
		}		
		
		if ($dinamic_strlen($this->request->post['fb_login_customer_group_id']) == 0){
			$this->error['customer_group_id'] = $this->language->get('error_customer_group_id');
			$this->error['warning'] = sprintf($this->language->get('error_in_tab'), $this->language->get('tab_new_account'));
		}		
		
		foreach ($this->request->post['fb_login_mail'] as $language_id => $value) {
			if ($dinamic_strlen($value['subject']) < 1) {
        		$this->error['subject'][$language_id] = $this->language->get('error_subject');
        		$this->error['warning'] = sprintf($this->language->get('error_in_tab'), $this->language->get('tab_registration_mail'));
      		}
			
			if ($dinamic_strlen($value['message']) < 1) {
        		$this->error['message'][$language_id] = $this->language->get('error_message');
        		$this->error['warning'] = sprintf($this->language->get('error_in_tab'), $this->language->get('tab_registration_mail'));
      		}
			
			if (strpos($value['message'], "{email}") === false || strpos($value['message'], "{password}") === false) {
				$this->error['message'][$language_id] = $this->language->get('error_message_no_credential');
        		$this->error['warning'] = sprintf($this->language->get('error_in_tab'), $this->language->get('tab_registration_mail'));
			}
		}	
		
		if ($this->request->post['fb_login_use_html_email'] == 1 && !$this->isHTMLEmailExtensionInstalled() ) {
			$this->error['use_html_email'] = $this->language->get('error_html_email_not_installed');
			$this->error['warning'] = sprintf($this->language->get('error_in_tab'), $this->language->get('tab_registration_mail'));
		}

		foreach ($this->request->post['fb_login_extra_info'] as $language_id => $value) {
			if ($dinamic_strlen($value['message']) < 1) {
        		$this->error['extra_info_message'][$language_id] = $this->language->get('error_extra_info_message');
        		$this->error['warning'] = sprintf($this->language->get('error_in_tab'), $this->language->get('tab_fb_button'));
      		}
		}
		
		return !$this->error;
	}
	
	private function isHTMLEmailExtensionInstalled() {
		$installed = false;
		
		if ($this->config->get('html_email_default_word') && file_exists(DIR_APPLICATION . 'model/tool/html_email.php') && file_exists(DIR_CATALOG . 'model/tool/html_email.php')) {
			$installed = true;	
		}
		
		return $installed;
	}	
	
	private function update_check() {
		$data = 'v=' . $this->version . '&ex=14&e=' . $this->config->get('config_email') . '&ocv=' . VERSION;
        $curl = false;
        
        if (extension_loaded('curl')) {
			$ch = curl_init();
			
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_URL, 'https://www.oc-extensions.com/api/v1/update_check');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'OCX-Adaptor: curl'));
			curl_setopt($ch, CURLOPT_REFERER, HTTP_CATALOG);
			
			if (function_exists('gzinflate')) {
				curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
			}
            
			$result = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			if ($http_code == 200) {
				$result = json_decode($result);
				
                if ($result) {
                    $curl = true;
                }
                
                if ( isset($result->version) && ($result->version > $this->version) ) {
				    $this->error['update'] = 'A new version of this extension is available. <a target="_blank" href="' . $result->url . '">Click here</a> to see the Changelog.';
				}
			}
		}
        
        if (!$curl) {
			if (!$fp = @fsockopen('ssl://www.oc-extensions.com', 443, $errno, $errstr, 20)) {
				return false;
			}

			socket_set_timeout($fp, 20);
			
			$headers = array();
			$headers[] = "POST /api/v1/update_check HTTP/1.0";
			$headers[] = "Host: www.oc-extensions.com";
			$headers[] = "Referer: " . HTTP_CATALOG;
			$headers[] = "OCX-Adaptor: socket";
			if (function_exists('gzinflate')) {
				$headers[] = "Accept-encoding: gzip";
			}	
			$headers[] = "Content-Type: application/x-www-form-urlencoded";
			$headers[] = "Accept: application/json";
			$headers[] = 'Content-Length: '.strlen($data);
			$request = implode("\r\n", $headers)."\r\n\r\n".$data;
			fwrite($fp, $request);
			$response = $http_code = null;
			$in_headers = $at_start = true;
			$gzip = false;
			
			while (!feof($fp)) {
				$line = fgets($fp, 4096);
				
				if ($at_start) {
					$at_start = false;
					
					if (!preg_match('/HTTP\/(\\d\\.\\d)\\s*(\\d+)\\s*(.*)/', $line, $m)) {
						return false;
					}
					
					$http_code = $m[2];
					continue;
				}
				
				if ($in_headers) {

					if (trim($line) == '') {
						$in_headers = false;
						continue;
					}

					if (!preg_match('/([^:]+):\\s*(.*)/', $line, $m)) {
						continue;
					}
					
					if ( strtolower(trim($m[1])) == 'content-encoding' && trim($m[2]) == 'gzip') {
						$gzip = true;
					}
					
					continue;
				}
				
                $response .= $line;
			}
					
			fclose($fp);
			
			if ($http_code == 200) {
				if ($gzip && function_exists('gzinflate')) {
					$response = substr($response, 10);
					$response = gzinflate($response);
				}
				
				$result = json_decode($response);
				
                if ( isset($result->version) && ($result->version > $this->version) ) {
				    $this->error['update'] = 'A new version of this extension is available. <a target="_blank" href="' . $result->url . '">Click here</a> to see the Changelog.';
				}
			}
		}
	}	
}
?>