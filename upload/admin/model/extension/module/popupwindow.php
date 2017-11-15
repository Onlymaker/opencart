<?php 
class ModelExtensionModulePopupWindow extends Model {

  	public function getSetting($group, $store_id = 0) {
	    $data = array(); 
	    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
	    foreach ($query->rows as $result) {
	      if (!$result['serialized']) {
	        $data[$result['key']] = $result['value'];
	      } else {
	        $data[$result['key']] = unserialize($result['value']);
	      }
	    } 
	    return $data;
	}
  
  	public function editSetting($group, $data, $store_id = 0) {
	    $this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
	    foreach ($data as $key => $value) {
	      if (!is_array($value)) {
	        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
	      } else {
	        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `group` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
	      }
	    }
	}

	public function getImpressions() {
		$query = $this->db->query("SELECT * FROM oc_popupwindow_stats");

		return $query->rows;
	}

	public function deletePopupID($popup_id) {
		$this->db->query("DELETE FROM oc_popupwindow_stats WHERE popup_id = '" . (int)$popup_id . "'");
	}
	
  	public function install($moduleName) {
	  $this->db->query("CREATE TABLE IF NOT EXISTS `oc_popupwindow_stats` (
		`popup_id` int(11) NOT NULL ,
		`impressions` int(11) NOT NULL DEFAULT '0',
		PRIMARY KEY (`popup_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8");

		$this->load->model('design/layout');
		$layouts = array();
		$layouts = $this->model_design_layout->getLayouts();
			
		foreach ($layouts as $layout) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "layout_module 
				SET layout_id = '" . (int)$layout['layout_id'] . "', code = '" . $this->db->escape($moduleName) . "', position = '" . 
				$this->db->escape('content_bottom') . "', sort_order = '0'");
			
			$this->event->trigger('post.admin.edit.layout', array($layout['layout_id']));
		}
  	} 
  
  	public function uninstall($moduleName) {
  		$this->db->query("DROP TABLE IF EXISTS `oc_popupwindow_stats`");
		$this->load->model('design/layout');
		$layouts = array();
		$layouts = $this->model_design_layout->getLayouts();
			
		foreach ($layouts as $layout) {
			$this->db->query("DELETE FROM " . DB_PREFIX . 
				"layout_module 
				WHERE layout_id = '" . (int)$layout['layout_id'] . "' and  
				code = '" . $this->db->escape($moduleName)."'");
		}
  	}
	
  }
?>