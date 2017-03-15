<?php
//DEAWid 
class ControllerAccountReferrers extends Controller { 
	public function index() {
		if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
	  
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	} 
	
		$this->language->load('account/referrer');

		$this->document->setTitle($this->language->get('heading_title'));
  
  	$data['breadcrumbs'] = array();
  	$data['breadcrumbs'][] = array(
    	'text'      => $this->language->get('text_home'),
    	'href'      => $this->url->link('common/home'),
    	'separator' => false
  	); 
		$this->language->load('account/account');
  	$data['breadcrumbs'][] = array(       	
    	'text'      => $this->language->get('text_account'),
    	'href'      => $this->url->link('account/account', '', 'SSL'),
    	'separator' => $this->language->get('text_separator')
  	);
		$this->language->load('account/referrer');
  	$data['breadcrumbs'][] = array(       	
    	'text'      => $this->language->get('heading_title'),
    	'href'      => $this->url->link('account/referrers', '', 'SSL'),
    	'separator' => $this->language->get('text_separator')
  	);
		
		if (isset($this->session->data['success'])) {
    	$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
    	$data['heading_title']         = $this->language->get('heading_title');
    	$data['text_direct_referrers'] = $this->language->get('text_direct_referrers');
    	$data['text_sub_referrers']    = $this->language->get('text_sub_referrers');
    	$data['text_referer_name']     = $this->language->get('text_referer_name');
    	$data['text_referer_register'] = $this->language->get('text_referer_register');
    	$data['text_num_of_purchases'] = $this->language->get('text_num_of_purchases');
    	$data['text_profit']           = $this->language->get('text_profit');
    	$data['text_no_referrers']     = $this->language->get('text_no_referrers');
    	$data['text_link_referrer']    = $this->language->get('text_link_referrer');
    	$data['text_your_balance']     = $this->language->get('text_your_balance');




		$this->load->model('account/referrer');
    $data['shop_url']         = $this->model_account_referrer->getShopURL();
    $data['actual_currency']  = $this->model_account_referrer->getActualCurrency();
    $data['my_balance']       = $this->model_account_referrer->getMyBalance($this->customer->getId());
		
    $data['dirrect_referrers'] = $this->model_account_referrer->getDirrectReferrersFromCustomerID($this->customer->getId());
		$data['sub_referrers'] = $this->model_account_referrer->getSubReferrers($this->customer->getId());
		
		foreach($data['dirrect_referrers'] as $referrer){
		  $data['all_purchases'][$referrer['customer_id']] = $this->model_account_referrer->getNumOfPurchasesFromCustomer($referrer['customer_id']);
		  $data['all_points'][$referrer['customer_id']] = $this->model_account_referrer->getPriceFromCustomer($referrer['customer_id']);
		}
		
		foreach($data['sub_referrers'] as $referrer){
		  $data['all_purchases'][$referrer['customer_id']] = $this->model_account_referrer->getNumOfPurchasesFromCustomer($referrer['customer_id']);
		  $data['all_points'][$referrer['customer_id']] = $this->model_account_referrer->getPriceFromCustomer($referrer['customer_id']);
		}



    $data['customer_id'] = $this->customer->getId();
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/referrers', $data));



  	}
}
?>