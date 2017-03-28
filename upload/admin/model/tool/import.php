<?php
/**
 * TMD(http://opencartextensions.in/)
 *
 * Copyright (c) 2006 - 2012 TMD
 * This package is Copyright so please us only one domain 
 * 
 */
class ModelToolImport extends Model {
	
		public function category($category,$parent_id,$store_id,$language_id)
		{
			
			$pos = strpos($category, '>');
			if ($pos === false) {
			$category=trim($category);
			$category=str_replace('&','&amp;',$category);
			$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.name = '".$this->db->escape($category)."' and c.parent_id='".$parent_id."' and cd.language_id='".$language_id."' and c2s.store_id='".$store_id."'");
			
			if($query->row)
			{
			return $query->row['category_id'];
			}
			else
			{
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$parent_id . "', `top` = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', `column` = '0', sort_order = '0', status = '1', date_modified = NOW(), date_added = NOW()");

			$category_id = $this->db->getLastId();
			
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '" . $language_id . "', name = '" . $this->db->escape($category) . "', meta_keyword = '" . $this->db->escape($category) . "', meta_description = '" . $this->db->escape($category) . "', description = '" . $this->db->escape($category) . "'");
			
			$level = 0;
		
				$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY `level` ASC");
				
				foreach ($query->rows as $result) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");
					
					$level++;
				}
		
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '".$store_id."'");
			
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE keyword = '" .$this->db->escape(str_replace("'",'',$category)). "'");
			if(!$query->row)
			{
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape(str_replace("'",'',$category)) . "'");
			}
			else
			{
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($category) .'-'.$category_id."'");
			}
			return $category_id;
			}
			
			
			
			}
			else
			{
			$categories=explode('>',$category);
			$count=count($categories);
			$parent_id1=0;
			for($r=0;$r<=$count;$r++)
			{
					if(!empty($categories[$r]))
					{
					$parent_id1=$this->category($categories[$r],$parent_id1,$store_id,$language_id);
					}
			}
			return $parent_id1;
			}
			
			
			
		}
		
		public function barnd($barnd,$store_id)
		{
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "manufacturer m left join " . DB_PREFIX . "manufacturer_to_store mts on mts.manufacturer_id=m.manufacturer_id WHERE m.name = '" .  $this->db->escape($barnd)."' and mts.store_id='".$store_id."'");
		
		if($query->row)
		{
		return $query->row['manufacturer_id'];			
		}
		else
		{
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($barnd) . "', sort_order = '0'");
		
		$manufacturer_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '".$store_id."'");
			
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE keyword = '" .$this->clean($barnd). "'");
		if(!$query->row)
			{
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->clean($barnd) . "'");
			}
			else
			{
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->clean($barnd) .'-'.$manufacturer_id."'");
			}
			return $manufacturer_id;
			}
			
				
		
		}
	
	public function option($data,$language_id)
	{
		
		$option=explode(":",$data);
		$optionname=$option[0];
		$type=$option[1];
		$optionname=str_replace('&','&amp;',$optionname);
		$optionname=str_replace('/','-',$optionname);
		$query=$this->db->query("select * from  " . DB_PREFIX . "option_description where  name = '" . $this->db->escape($optionname) . "' limit 0,1");
		if($query->row)
		{
		return $query->row['option_id'];
		}
		else
		{
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "option` SET type = '" .$type. "', sort_order = '0'");
		
		$option_id = $this->db->getLastId();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($optionname) . "'");
		
		return $option_id;
		}
		
		
	}
	
	public function optionvalue($data,$language_id)
	{	
		$option=explode(":",$data);
		$optionname=$option[0];
		$optionname=str_replace('&','&amp;',$optionname);
		$optionname=str_replace('/','-',$optionname);
		$query=$this->db->query("select * from  " . DB_PREFIX . "option_description where  name = '" .$this->db->escape($optionname) . "' limit 0,1");
		$option_id=$query->row['option_id'];
		
		////// Option value set 
		if(isset($option[1])){
		$optionvalues=explode("-",$option[1]);
		
		$optionvaluename=$optionvalues[0];
		$qty=$optionvalues[1];
		$subtract=$optionvalues[2];
		$price=$optionvalues[3];
		$points=$optionvalues[4];
		$weight=$optionvalues[5];
		
		if(isset($optionvalues[6]))
		{
		$sort_order=$optionvalues[6];
		}
		else
		{
		$sort_order=0;
		}
		
		$optionvaluename=str_replace('&','&amp;',$optionvaluename);
		$query=$this->db->query("select  * from  " . DB_PREFIX . "option_value_description where option_id = '" . (int)$option_id . "' and name = '" . $this->db->escape($optionvaluename) . "'");
		if($query->row)
		{
		$option_value_id=$query->row['option_value_id'];
		$this->db->query("update " . DB_PREFIX . "option_value  set sort_order = '".$sort_order."' where option_value_id='".$option_value_id."'");
		}
		else
		{
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value SET option_id = '" . (int)$option_id . "', sort_order = '".$sort_order."'");
				
				$option_value_id = $this->db->getLastId();
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
		
				$this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET option_value_id = '" . (int)$option_value_id . "', language_id = '" . (int)$language_id . "', option_id = '" . (int)$option_id . "', name = '" . $this->db->escape($optionvaluename) . "'");
				
				
		}
		$data=array(
			'option_id'=>$option_id,
			'option_value_id'=>$option_value_id,
			'qty'=>$qty,
			'subtract'=>$subtract,
			'price'=>$price,
			'points'=>$points,
			'weight'=>$weight,
			
		
		
		);
		return $data;
		////// Option value set 
		}
		
		
	}
	
	public function imagesave($image)
	{
					
				$pos = strpos($image, '=');
				if ($pos === false) {
				
				$path='data/productimage/';
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
				}
				else
				{
				$image=explode('=',$image);
				$path='data/'.$image[0].'/';
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
				$image=$image[1];
				}
				
				
				$pos = strpos($image, 'http://');
				if ($pos === false) {
				$imagepath=$image;
				//$imagepath1=DIR_IMAGE.$path.$image;
				} else {
				$handlerr = curl_init($image);
				curl_setopt($handlerr,  CURLOPT_RETURNTRANSFER, TRUE);
				$resp = curl_exec($handlerr);
				$ht = curl_getinfo($handlerr, CURLINFO_HTTP_CODE);
				$imagename=explode('/',$image);
				$count=count($imagename);
				$image=str_replace(';','',$imagename[$count-1]);
				$imagepath=$path.$image;
				$imagepath1=DIR_IMAGE.$path.$image;
				// Write the contents back to the file
				@file_put_contents($imagepath1, $resp);
				}
				return $imagepath;
				
				
	}
	
	public function getproductbymodel($model)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product where model='".$model."'");
		if($query->row)
		{
		return $query->row['product_id'];
		}
	}
		
	public function addproduct($data,$language_id,$extra)
	{
		
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '".$data['available']."', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '".$data['point']."', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '".$data['tax_class_id']."', sort_order = '" . (int)$data['sort_order'] . "',viewed='".(int)$data['viewed']."', date_added = NOW()");
		
		$product_id = $this->db->getLastId();
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id. "'");
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id. "', name = '" . $this->db->escape($data['name']) . "', meta_keyword = '" . $this->db->escape($data['meta_keyword']) . "', meta_description = '" . $this->db->escape($data['meta_description']) . "', description = '" . $this->db->escape($data['description']) . "', tag = '" . $this->db->escape($data['tag']) . "',meta_title = '" . $this->db->escape($data['meta_title']) . "'");
		
		
	$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $product_image. "', sort_order = '0'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		
		if ($data['keyword']) {
			$data['keyword']=$this->clean($data['keyword']);
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value  WHERE product_id = '" . (int) $product_id . "'");
		
		foreach($data['productoptions'] as $option)
		{
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option where option_id='".$option['option_id']."' and product_id='".$product_id."'");
			if($query->row)
			{
			$product_option_id=$query->row['product_option_id'];
			}
			else
			{
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option['option_id'] . "', required = '1'");
			$product_option_id = $this->db->getLastId();
			}
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value where option_id='".$option['option_id']."' and option_value_id='".$option['option_value_id']."' and product_id='".$product_id."'");
			if(!$query->row)
			{
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET  product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$option['option_id'] . "', option_value_id = '" . (int)$option['option_value_id'] . "', quantity = '" . (int)$option['qty'] . "', subtract = '" . (int)$option['subtract'] . "', price = '" . (float)$option['price'] . "', price_prefix = '+', points = '+', points_prefix = '+', weight = '" . (float)$option['weight'] . "', weight_prefix = '+'");
			}
		
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}		
		}
		if (isset($data['product_category'])) {
				$category_ids=array();
				foreach ($data['product_category'] as $category_id) {
				$newcategory=array_unique($this->getsubcategory($category_id));
				foreach($newcategory as $newid)
				{
				$category_ids[]=$newid;
				}
				
				}
				
		}
		
		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				
				if (isset($category_ids)) {
				foreach ($category_ids as $category_id) {
				$query=$this->db->query("select filter_id from  " . DB_PREFIX . "category_filter where category_id = '" . (int)$category_id . "' and filter_id = '" . (int)$filter_id . "'");
				if(!$query->row)
				{
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
				}
				}
				}
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		if (isset($data['attributes'])) {
			foreach ($data['attributes'] as $attribute) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' and attribute_id = '" . (int)$attribute['attribute_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET  	attribute_id = '" . (int)$attribute['attribute_id'] . "', product_id='".$product_id."', text = '" . $this->db->escape($attribute['text']). "',language_id = '".(int)$this->config->get('config_language_id') ."'");
			
		}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		;
		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		if (isset($data['discounts'])) {
			foreach ($data['discounts'] as $discount) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET  	customer_group_id = '" . (int)$discount['customer_group_id'] . "', product_id='".$product_id."', quantity='".$discount['quantity']."',priority='".$discount['priority']."',price='".$discount['price']."',date_start='".$discount['date_start']."',date_end='".$discount['date_end']."'");
			
		}
		}
		
		if(isset($data['reviews']))
		{
			$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
			foreach($data['reviews'] as $review)
			{
				$this->db->query("insert " . DB_PREFIX . "review set product_id = '" . (int)$product_id . "',customer_id='".$review['customer_id']."',author='".$this->db->escape($review['author'])."',text='".$this->db->escape($review['text'])."',rating='".$review['rating']."',status='".$review['status']."',date_added='".$review['date_added']."',date_modified='".$review['date_modified']."'");
			}
			
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
		
		if (isset($data['productdownloads'])) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
			foreach ($data['productdownloads'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		// Extra filed
		
		if(isset($extra))
		{
			foreach($extra as $key=>$value)
			{
				$this->db->query("update " . DB_PREFIX . "product set `".$key."`='".$this->db->escape($value)."' WHERE product_id = '" . (int)$product_id . "'");
			}
		}
	}
	
	public function editproduct($data,$product_id,$language_id,$extra)
	{
		
		
		$this->db->query("update   " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '".$data['available']."', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '".$data['point']."', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '".$data['tax_class_id']."', sort_order = '" . (int)$data['sort_order'] . "',viewed='".(int)$data['viewed']."', date_added = NOW()   WHERE product_id = '" . (int)$product_id . "'");
		
		
		
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "' and language_id = '" . (int)$language_id. "'");
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id. "', name = '" . $this->db->escape($data['name']) . "', meta_keyword = '" . $this->db->escape($data['meta_keyword']) . "', meta_description = '" . $this->db->escape($data['meta_description']) . "', description = '" . $this->db->escape($data['description']) . "', tag = '" . $this->db->escape($data['tag']) . "',meta_title = '" . $this->db->escape($data['meta_title']) . "'");
		
		
	$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $product_image. "', sort_order = '0'");
			}
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
			}
		}
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");
		
		if ($data['keyword']) {
			$data['keyword']=$this->clean($data['keyword']);
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value  WHERE product_id = '" . (int) $product_id . "'");
		
		foreach($data['productoptions'] as $option)
		{
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option where option_id='".$option['option_id']."' and product_id='".$product_id."'");
			if($query->row)
			{
			$product_option_id=$query->row['product_option_id'];
			}
			else
			{
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option['option_id'] . "', required = '1'");
			$product_option_id = $this->db->getLastId();
			}
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value where option_id='".$option['option_id']."' and option_value_id='".$option['option_value_id']."' and product_id='".$product_id."'");
			if(!$query->row)
			{
		
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET  product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$option['option_id'] . "', option_value_id = '" . (int)$option['option_value_id'] . "', quantity = '" . (int)$option['qty'] . "', subtract = '" . (int)$option['subtract'] . "', price = '" . (float)$option['price'] . "', price_prefix = '+', points = '+', points_prefix = '+', weight = '" . (float)$option['weight'] . "', weight_prefix = '+'");
			}
		
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");
		
		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
			}		
		}
		if (isset($data['product_category'])) {
				$category_ids=array();
				foreach ($data['product_category'] as $category_id) {
				$newcategory=array_unique($this->getsubcategory($category_id));
				foreach($newcategory as $newid)
				{
				$category_ids[]=$newid;
				}
				
				}
				
		}
		
		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				
				if (isset($category_ids)) {
				foreach ($category_ids as $category_id) {
				$query=$this->db->query("select filter_id from  " . DB_PREFIX . "category_filter where category_id = '" . (int)$category_id . "' and filter_id = '" . (int)$filter_id . "'");
				if(!$query->row)
				{
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_filter SET category_id = '" . (int)$category_id . "', filter_id = '" . (int)$filter_id . "'");
				}
				}
				}
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		if (isset($data['attributes'])) {
			foreach ($data['attributes'] as $attribute) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' and attribute_id = '" . (int)$attribute['attribute_id'] . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET  	attribute_id = '" . (int)$attribute['attribute_id'] . "', product_id='".$product_id."', text = '" . $this->db->escape($attribute['text']). "',language_id = '".(int)$this->config->get('config_language_id') ."'");
			
		}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");
		;
		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");
		if (isset($data['discounts'])) {
			foreach ($data['discounts'] as $discount) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET  	customer_group_id = '" . (int)$discount['customer_group_id'] . "', product_id='".$product_id."', quantity='".$discount['quantity']."',priority='".$discount['priority']."',price='".$discount['price']."',date_start='".$discount['date_start']."',date_end='".$discount['date_end']."'");
			
		}
		}
		
		if(isset($data['reviews']))
		{
			$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int)$product_id . "'");
			foreach($data['reviews'] as $review)
			{
				$this->db->query("insert " . DB_PREFIX . "review set product_id = '" . (int)$product_id . "',customer_id='".$review['customer_id']."',author='".$this->db->escape($review['author'])."',text='".$this->db->escape($review['text'])."',rating='".$review['rating']."',status='".$review['status']."',date_added='".$review['date_added']."',date_modified='".$review['date_modified']."'");
			}
			
		}
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");
		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
			}
		}
		
		if (isset($data['productdownloads'])) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");
			foreach ($data['productdownloads'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
			}
		}
		// Extra filed
		
		if(isset($extra))
		{
			foreach($extra as $key=>$value)
			{
				$this->db->query("update " . DB_PREFIX . "product set `".$key."`='".$this->db->escape($value)."' WHERE product_id = '" . (int)$product_id . "'");
			}
		}
	}
	public function getsubcategory($category_id)
	{	
		$category_ids=array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path where category_id='".$category_id."'");
		if($query->rows)
		{
		foreach($query->rows as $categroy)
		{
			$category_ids[]=$categroy['path_id'];
		}
		}
		return $category_ids;
	}
	public function filtergroup($filtergroup,$language_id)
	{
			$data=explode(":",$filtergroup);
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter_group_description where name='".$this->db->escape($data[0])."' and language_id='".$language_id."'");
			if(!$query->row) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "filter_group` SET sort_order = '" . (int)$data[1] . "'");
			$filter_group_id = $this->db->getLastId();
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "filter_group_description SET filter_group_id = '" . (int)$filter_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($data[0]) . "'");
			
			}
	 
	}	
	
	public function filtername($filtername,$language_id)
	{

		$filter_id='';
		$datafull=explode("=",$filtername);
		
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter_group_description where name='".$this->db->escape($datafull[0])."' and language_id='".$language_id."'");
		
		if($query->row) {
			$filter_group_id = $query->row['filter_group_id'];
			}
		$data=explode(":",$datafull[1]);
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "filter_description where name='".$this->db->escape($data[0])."' and filter_group_id = '" . (int)$filter_group_id . "'");
		if(!$query->row) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "filter SET filter_group_id = '" . (int)$filter_group_id . "', sort_order = '" . (int)$data[1] . "'");
				
				$filter_id = $this->db->getLastId();
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
				
				
					$this->db->query("INSERT INTO " . DB_PREFIX . "filter_description SET filter_id = '" . (int)$filter_id . "', language_id = '" . (int)$language_id . "', filter_group_id = '" . (int)$filter_group_id . "', name = '" . $this->db->escape($data[0]) . "'");
				
			
		}	
		else
		{
		$filter_id=$query->row['filter_id'];
		}
		return $filter_id;
	}
	
	public function atributeallinfo($attribute,$language_id)
	{
	$data=array();
	$groupinfo=explode('=',$attribute);
	$groupinfo1=explode(':',$groupinfo[0]);
	$groupname='';
	if(isset($groupinfo1[0]))
	{
	$groupname=$groupinfo1[0];
	}
	$groupsortorder='';
	if(isset($groupinfo1[1]))
	{
	$groupsortorder=$groupinfo1[1];
	}
	$attinfo='';
	if(isset($groupinfo[1]))
	{
	$attinfo=explode('-',$groupinfo[1]);
	}
	
	if(isset($attinfo[0]))
	{
	$attname='';
	if(isset($attinfo[0]))
	{
	$attname=$attinfo[0];
	}
	$text='';
	if(isset($attinfo[1]))
	{
	$text=$attinfo[1];
	}
	$attsortorder='';
	if(isset($attinfo[2]))
	{
	$attsortorder=$attinfo[2];
	}
	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_group_description where name='".$this->db->escape($groupname)."' and language_id = '" . (int)$language_id . "'");
			if($query->row) {
			$attribute_group_id = $query->row['attribute_group_id'];
			}
			else
			{
			$this->db->query("INSERT INTO `" . DB_PREFIX . "attribute_group` SET sort_order = '" . (int)$groupsortorder . "'");
			$attribute_group_id = $this->db->getLastId();
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group_description SET attribute_group_id = '" . (int)$attribute_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($groupname) . "'");
			
			}
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description where name='".$this->db->escape($attname)."' and language_id = '" . $language_id . "'");
			if($query->row) {
			$attribute_id = $query->row['attribute_id'];
			}
			else
			{
			$this->db->query("INSERT INTO `" . DB_PREFIX . "attribute` SET sort_order='".$attsortorder."', attribute_group_id ='".$attribute_group_id."'");
			$attribute_id = $this->db->getLastId();
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET  language_id = '" . (int)$language_id . "',attribute_id='".$attribute_id."', name = '" . $this->db->escape($attname) . "'");
			
			}
			$data=array(
				'attribute_id'=>$attribute_id,
				'text'=>$text
			);
			
	}
	return $data;
	
	}
	
	public function getstorebyname($store)
	{	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store where name='".$store."'");
		if($query->rows)
		{
		return $query->row['store_id'];
		}
		else
		{
			return 0;
		}
		
	}
	
	
	public function clean($string){
	$string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(amp|acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
	$string = str_replace('amp', '', $string);
	$string = str_replace(',', '', $string);
	$string = str_replace(':', '', $string);
	$string = str_replace('%', '', $string);
	$string = str_replace(';', '', $string);
	$string = str_replace('(', '', $string);
	$string = str_replace(')', '', $string);
	$string = str_replace('*', '', $string);
	$string = str_replace('.', '', $string);
	$string = str_replace('', '-', $string);
	$string= str_replace(' ', '-', $string);
	$string= str_replace('--', '-', $string);
	$string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
		}

	
	
}
?>