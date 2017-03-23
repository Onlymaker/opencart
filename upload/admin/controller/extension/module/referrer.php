<?php
class ControllerExtensionModuleReferrer extends Controller {
	private $error = array(); 
	
	public function index(){
		$this->language->load('extension/module/referrer');
		$this->document->setTitle($this->language->get('heading_title'));

	//if news tables don't exist
		$this->load->model('user/referrer');
		if(!$this->model_user_referrer->checkInstall()){
      $this->model_user_referrer->installReferrer();
    }

		$data['primary_currency'] = $this->model_user_referrer->getDefaultCurrency();

		$this->load->model('setting/setting');
		
		if(($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_setting_setting->editSetting('referrer', $this->request->post);		
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title']              = $this->language->get('heading_title');
		$data['text_status']                = $this->language->get('text_status');
		$data['text_module']                = $this->language->get('text_module');
		$data['text_enable']                = $this->language->get('text_enable');
		$data['text_disable']               = $this->language->get('text_disable');
		$data['button_save']                = $this->language->get('button_save');
		$data['button_cancel']              = $this->language->get('button_cancel');
		$data['text_profit']                = $this->language->get('text_profit');
		$data['text_profit_type']           = $this->language->get('text_profit_type');
		$data['text_percentage']            = $this->language->get('text_percentage');
		$data['text_fixed']                 = $this->language->get('text_fixed');
		$data['text_higher_total']          = $this->language->get('text_higher_total');
		$data['text_yes']                   = $this->language->get('text_yes');
		$data['text_no']                    = $this->language->get('text_no');
		$data['text_min_order_total']       = $this->language->get('text_min_order_total');
		$data['text_ref_level']             = $this->language->get('text_ref_level');
		$data['text_ref_profit']            = $this->language->get('text_ref_profit');
		$data['text_ref_level']             = $this->language->get('text_ref_level');
		$data['text_ref_info']              = $this->language->get('text_ref_info');
		$data['text_you']                   = $this->language->get('text_you');
		$data['text_this_ref']              = $this->language->get('text_this_ref');
		$data['text_referrer']              = $this->language->get('text_referrer');
		$data['text_ref_percentage_profit'] = $this->language->get('text_ref_percentage_profit');
		$data['text_ref_fixed_profit']      = $this->language->get('text_ref_fixed_profit');
		$data['text_ref_product_link']      = $this->language->get('text_ref_product_link');
		$data['text_ref_compulsory_reg']    = $this->language->get('text_ref_compulsory_reg');
		$data['text_ref_levels']            = $this->language->get('text_ref_levels');

		$data['value_referrer'] = $this->model_setting_setting->getSetting('referrer');	

		$this->load->model('user/referrer');
 		if (isset($this->error['warning'])) {$data['error_warning'] = $this->error['warning'];}
    else{$data['error_warning'] = '';}

		$data['breadcrumbs'] = array();
 		$data['breadcrumbs'][] = array(
    	'text'      => $this->language->get('text_home'),
    	'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
    	'separator' => false
 		);
 		$data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_module'),
      'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => ' :: '
 		);
 		$data['breadcrumbs'][] = array(
      'text'      => $this->language->get('heading_title'),
      'href'      => $this->url->link('extension/module/referrer', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => ' :: '
 		);
		
		$data['action'] = $this->url->link('extension/module/referrer', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['referrer_module'])) {
			$modules = explode(',', $this->request->post['referrer_module']);
		} elseif ($this->config->get('referrer_module') != '') {
			$modules = explode(',', $this->config->get('referrer_module'));
		} else {
			$modules = array();
		}		

		$data['modules'] = $modules;
		
		if(isset($this->request->post['referrer_module'])){$data['referrer_module'] = $this->request->post['referrer_module'];}
    else{$data['referrer_module'] = $this->config->get('referrer_module');}


		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/referrer.tpl', $data));




	}
}
?>