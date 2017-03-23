<?php
class ModelSaleReferrer extends Model {

	public function isInstalled(){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'module'");
    $modules = $query->rows;
    $ref_module_installed = false;
    foreach($modules as $module){
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
  
  
  
  public function giveReferrerProfit($order_id){
    
    
    $order = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE `order_id` = '$order_id'");
    
  
    $order_price      = $this->db->query("SELECT `value` FROM " . DB_PREFIX . "setting WHERE `key` = 'order_price'");
    $order_price_min  = $this->db->query("SELECT `value` FROM " . DB_PREFIX . "setting WHERE `key` = 'min_order_price'");

    if(!$order_price->row){
      return false;
    }else{
      $order_price      = $order_price->row['value'];
      $order_price_min  = $order_price_min->row['value'];
    }
    
    if($order_price AND $order->row['total'] <= $order_price_min){
      return false;
    }else{
      if(isset($order->row['give_referrer_profit'])){
        return true;
      }else{
        return false;
      }
    }
  }
  
  public function checkOrderMinPrice($order_id){
    
    $order = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE `order_id` = '$order_id'");
    
    $order_price      = $this->db->query("SELECT `value` FROM " . DB_PREFIX . "setting WHERE `key` = 'order_price'");
    $order_price_min  = $this->db->query("SELECT `value` FROM " . DB_PREFIX . "setting WHERE `key` = 'min_order_price'");

    if(!$order_price->row){
      return false;
    }else{
      $order_price      = $order_price->row['value'];
      $order_price_min  = $order_price_min->row['value'];
    }
    
    if($order_price AND $order->row['total'] <= $order_price_min){
      return true;
    }else{
      return false;
    }

  
  }
  
  
  
	public function getReferrerProfits($order_id) {
	
	
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` = 'referrer_level'");
    if(!$query->row){
      $levels = 1;
    }else{$levels = $query->row['value'];}
    
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE `order_id` = '$order_id'");
    $order = $query->row;
    
    
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "currency` WHERE `currency_id` = '".$order['currency_id']."'");
    $currency = $query->row;
    
    
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer` WHERE `customer_id` = '".$order['customer_id']."'");
    $customer = $query->row;
    
    
    
    
    $profit_type = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'referrer_profit_type'");
    if(!$profit_type->row){
      $profit_type = 'percentage';
    }else{$profit_type = $profit_type->row['value'];}
      
    $ref_id = $customer['referrer_id'];
    $i = 0;
    $j = 0;

    $referrer_profit = array();
    while($i<=$levels){
      $query           = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer` WHERE `customer_id` = '$ref_id'");
      if($query->row){
        $j++;
        
        $profit_value = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `key` = 'referrer_profit_level_".$j."_".$profit_type."'");
        if(!$profit_value->row){
          $profit_value = 0;
        }else{
          $profit_value = $profit_value->row['value'];
        }
        
        
        if($profit_type == 'percentage'){$profit = $order['total']/100*$profit_value;}
        if($profit_type == 'fixed'){$profit = $profit_value;}
        
        $referrer_profit[$j]['name']    = '['.$query->row['customer_id'].'] '.$query->row['firstname'].' '.$query->row['lastname'];
        $referrer_profit[$j]['profit']  = $currency['symbol_left'].$profit.$currency['symbol_right'];
        
        
        if($profit_type == 'percentage'){$referrer_profit[$j]['profit'] .= ' ('.$order['total'].''.'*'.$profit_value.'%)';}
        if($profit_type == 'fixed'){$referrer_profit[$j]['profit'] .= ' (+'.$currency['symbol_left'].$profit_value.$currency['symbol_right'].')';}
        
        
        $ref_id = $query->row['referrer_id'];
      }
      $i++;
    }
    
      return $referrer_profit;
	}
}
?>