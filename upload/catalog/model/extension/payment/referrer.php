<?php 
class ModelExtensionPaymentReferrer extends Model {
  	public function getMethod($address, $total) {

    $this->language->load('extension/payment/referrer');
		
	  $currency = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE `currency_id` = '".(int)$this->currency->getId($this->session->data['currency'])."'");

    $query_r = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = 'referrer_status'");

    
    $balance = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	  $balance = $balance->row['referrer_price'];
	  $converted_balance = round($balance*$currency->row['value'],2);
	 
	  if($query_r->row['value'] == 1){
  		if ($balance >= $total) {
  			$status = true;
  		}else {
		  	$status = false;
		  }
    } else {
			$status = false;
		}
		
		$method_data = array();
	
		if ($status) {
      		$method_data = array( 
        		'code'       => 'referrer',
        		'title'      => $this->language->get('text_title').' ('.$currency->row['symbol_left'].$converted_balance.$currency->row['symbol_right'].')',
     				'terms'      => '',
		    		'sort_order' => 1
      		);
    	}
   
    	return $method_data;
  	}
}
?>