<?php
class ModelAccountReferrer extends Model {

	
	public function getSetting($group, $store_id = 0) {
		$data = array(); 
    		
    if(VERSION <= '2.0.0.0'){
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
    }else{
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($group) . "'");
    }

		
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = unserialize($setting['value']);
			}
		}

		return $data;
	}
	
  
	public function isInstalled(){
	
      $ref_module_installed = false;
      $modules = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `type` = 'module'");
      foreach($modules->rows as $module){
        if($module['code'] == 'referrer'){$ref_module_installed = true;}
      }
      
      if($ref_module_installed){
        $enabled = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'referrer_status'");
        if(!$enabled->row){
          $ref_module_installed = false;
        }else{
          $ref_module_installed = $enabled->row['value'];
        }
      }
      
      
      
      return $ref_module_installed;
	}


	public function getMyBalance($customer_id) {
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '$customer_id'");
  	$currency = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE `currency_id` = '".(int)$this->currency->getId($this->session->data['currency'])."'");
    return round(($query->row['referrer_price']*$currency->row['value']),2);
  }

	public function getDirrectReferrersFromCustomerID($customer_id) {
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE referrer_id = '$customer_id'");
    return $query->rows;
  }

	public function getSubReferrers($customer_id) {
	
    	$referrer_level = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE `key` = 'referrer_level'");



	    $i = 0;
	    $ref_id = $customer_id;
	    $customer_ids = array();
	    while($i<=$referrer_level->row['value']){
      $query           = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `referrer_id` = '$ref_id'");
      if($query->row){
        if($i != 0){
          $customer_ids[] = $query->row['customer_id'];
        }
        $ref_id = $query->row['customer_id'];
      }
      $i++;
    }
    
    $sql_customer_ids = "customer_id = '".implode("' or customer_id = '",$customer_ids)."'";
    
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE ".$sql_customer_ids);
    return $query->rows;
    
  }
  
  
	public function getActualCurrency() {
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE currency_id = '".(int)$this->currency->getId($this->session->data['currency'])."'");
    return $query->row;
  }
  
	public function getShopURL() {
	  $query = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE `key` = 'config_secure'");
    if(isset($query->row['value'])){$ssl = 'https';}else{$ssl = 'http';}
    $url = HTTP_SERVER;
    $url = str_replace('http://','',$url);
    return $ssl.'://'.$url;
  }
  
	public function getNumOfPurchasesFromCustomer($customer_id) {
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "referrer_log WHERE `customer_id` = '$customer_id' AND sponzor_id = '".$this->customer->getId()."'");
    return count($query->rows);
  }
  
	public function getPriceFromCustomer($customer_id) {
	
	  $return_profit = 0;
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "referrer_log WHERE `customer_id` = '".$customer_id."' AND sponzor_id = '".$this->customer->getId()."'");
    foreach($query->rows as $profit){
      $return_profit = $return_profit+$profit['price'];
    }
    
    $currency_profit = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE `currency_id` = '".(int)$this->currency->getId($this->session->data['currency'])."'");
  	$currency = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE `currency_id` = '".(int)$this->currency->getId($this->session->data['currency'])."'");

    return round(($return_profit*$currency->row['value']),2);
  }
	
}

?>