<?php
class ModelUserReferrer extends Model {

	public function checkInstall() {
    return false;
//    $result=@mysql_query("SELECT * FROM " . DB_PREFIX . "referrer_log");
//    if(!$result){return false;}else{return true;}
	}
	
 	public function installReferrer() {

  $result=$this->db->query("SELECT * FROM " . DB_PREFIX . "referrer_log");
  if(!$result){
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "referrer_log` (`id` int(11) NOT NULL AUTO_INCREMENT,`customer_id` int(11) NOT NULL,`sponzor_id` int(11) NOT NULL,`order_id` int(11) NOT NULL,`price` decimal(10,2) NOT NULL,`currency_id` int(11) NOT NULL,`currency_value` decimal(15,8) NOT NULL,`date` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
    $this->db->query("INSERT INTO `" . DB_PREFIX . "extension` (`type`,`code`) VALUES('payment','referrer')");
    $this->db->query("ALTER TABLE `" . DB_PREFIX . "customer` ADD `referrer_id` INT( 11 ) NOT NULL AFTER `customer_id` , ADD `referrer_price` DECIMAL( 10, 2 ) NOT NULL AFTER `referrer_id`");
    $this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `give_referrer_profit` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `order_id` ");
  }


    return false;
//  @mysql_query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "referrer_log` (`id` int(11) NOT NULL AUTO_INCREMENT,`customer_id` int(11) NOT NULL,`sponzor_id` int(11) NOT NULL,`order_id` int(11) NOT NULL,`price` decimal(10,2) NOT NULL,`currency_id` int(11) NOT NULL,`currency_value` decimal(15,8) NOT NULL,`date` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
//  @mysql_query("INSERT INTO `" . DB_PREFIX . "extension` (`type`,`code`) VALUES('payment','referrer')");
//  @mysql_query("ALTER TABLE `" . DB_PREFIX . "customer` ADD `referrer_id` INT( 11 ) NOT NULL AFTER `customer_id` , ADD `referrer_price` DECIMAL( 10, 2 ) NOT NULL AFTER `referrer_id`");
//  @mysql_query("ALTER TABLE `" . DB_PREFIX . "order` ADD `give_referrer_profit` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `order_id` ");
	}
	
	

	public function getDefaultCurrency() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE `value` = '1'");
		return $query->row;
	}

}
?>