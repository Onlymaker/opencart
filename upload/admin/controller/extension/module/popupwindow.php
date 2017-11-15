<?php
class ControllerExtensionModulePopupWindow extends Controller {
	
	// Module Unifier
    private $moduleName;
    private $moduleNameSmall;
    private $modulePath;
    private $extensionsLink;
    private $callModel;
    private $moduleModel;
    private $moduleVersion;
    private $data = array();
    private $error = array();
    // Module Unifier

    public function __construct($registry)
    {
        parent::__construct($registry);
        
        $this->config->load('isenselabs/popupwindow');
        
        /* OC version-specific declarations - Begin */
        $this->moduleName      = $this->config->get('popupwindow_name');
        $this->moduleNameSmall = $this->config->get('popupwindow_name_small');
        $this->extensionsLink  = $this->url->link($this->config->get('popupwindow_extensions_link'), 'token=' . $this->session->data['token'] . $this->config->get('popupwindow_extensions_link_params'), 'SSL');
        $this->modulePath      = $this->config->get('popupwindow_path');
        /* OC version-specific declarations - End */
        
        /* Module-specific declarations - Begin */
        $this->load->language($this->modulePath);
        $this->load->model($this->modulePath);
        $this->callModel     = $this->config->get('popupwindow_model_call');
        $this->moduleModel   = $this->{$this->callModel};
        $this->moduleVersion = $this->config->get('popupwindow_version');
        /* Module-specific declarations - End */
        
        /* Module-specific loaders - Begin */
        $this->load->model('setting/store');
        $this->load->model('setting/setting');
        $this->load->model('localisation/language');
        $this->load->model('localisation/currency');
        $this->load->model('localisation/country');
        $this->load->model('design/layout');
        /* Module-specific loaders - End */        
        
        $this->data['modulePath'] = $this->modulePath;
		$this->data['moduleName'] = $this->moduleName;
		$this->data['moduleNameSmall'] = $this->moduleNameSmall;
		$this->data['moduleData_module'] = $this->moduleData_module;
		$this->data['moduleModel'] = $this->moduleModel;		
    }

    public function index() {
        if(VERSION >= '2.1.0.1'){
			$this->load->model('customer/customer_group');
			$this->data['customerGroups'] = $this->model_customer_customer_group->getCustomerGroups();
		} else {
			$this->load->model('sale/customer_group');
			$this->data['customerGroups'] = $this->model_sale_customer_group->getCustomerGroups();
		}
		
		$this->document->setTitle($this->language->get('heading_title'));
	
        $catalogURL = $this->getCatalogURL();
      
 		$this->document->addStyle('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
       	$this->document->addStyle('view/stylesheet/'.$this->moduleNameSmall.'/'.$this->moduleNameSmall.'.css');
		$this->document->addStyle('view/javascript/summernote/summernote.css');

		$this->document->addScript('view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addScript('view/javascript/'.$this->moduleNameSmall.'/nprogress.js');
		$this->document->addScript('view/javascript/summernote/summernote.min.js');	
       
        if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }
	
        $store = $this->getCurrentStore($this->request->get['store_id']);
		
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) { 
			if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
                $this->request->post[$this->moduleNameSmall]['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
            }
            if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
                $this->request->post[$this->moduleNameSmall]['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
            }
			$store = $this->getCurrentStore($this->request->post['store_id']);	
            
			if (!$this->user->hasPermission('modify', $this->modulePath)) {
                $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
            }
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			if(!isset($this->request->post[$this->moduleData_module])) {
				$this->request->post[$this->moduleData_module] = array();
			}

			$data = $this->model_setting_setting->getSetting($this->moduleNameSmall, $store['store_id']);

			$oldArrayIDs = array();
			$newArrayIDs = array();

			if(isset($this->request->post['popupwindow']['PopupWindow'])) {
				foreach ($this->request->post['popupwindow']['PopupWindow'] as $popup) {
					array_push($newArrayIDs, $popup['id']);
				}
			}

			if(isset($data['popupwindow']['PopupWindow'])) {
				foreach ($data['popupwindow']['PopupWindow'] as $popup) {
					array_push($oldArrayIDs, $popup['id']);
				}
			}

			$deletedIDs = array_diff($oldArrayIDs, $newArrayIDs);

			if($deletedIDs) {
				foreach($deletedIDs as $id) {
					$this->moduleModel->deletePopupID($id);
				}
			}

			$this->model_setting_setting->editSetting($this->moduleNameSmall, $this->request->post, $this->request->post['store_id']);
			$this->response->redirect($this->url->link($this->modulePath,  'store_id='.$this->request->post['store_id'] . '&token=' . $this->session->data['token'], 'SSL'));
        }

        if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

        $this->data['breadcrumbs']   = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->extensionsLink,
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link($this->modulePath, 'token=' . $this->session->data['token'], 'SSL'),
        );

		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}
		
		if (isset($this->error['height'])) {
	      $data['popup_height'] = $this->error['height'];
	    } else {
	      $data['popup_height'] = '';
	    }

        $languageVariables = array(
		    // Main
			'heading_title',
			'error_permission',
			'text_success',
			'text_enabled',
			'text_disabled',
			'button_cancel',
			'save_changes',
			'text_default',
			'text_module',
			// Control panel
            'entry_code',
			'entry_code_help',      
            'entry_popup_options',  
			'entry_action_options',
            'button_add_module',
            'button_remove',
			'text_url',
			'entry_content',
			'entry_size',
			'text_show_on',
			'text_window_load',
			'text_page_load',
			'text_body_click'
        );
       
        foreach ($languageVariables as $languageVariable) {
            $this->data[$languageVariable] = $this->language->get($languageVariable);
        }
 		$this->data['heading_title'] = $this->data['heading_title'] . ' ' . $this->moduleVersion;
        $this->data['stores'] = array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $this->data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
        $this->data['error_warning']          = '';  
        $this->data['languages']              = $this->model_localisation_language->getLanguages();
        //2.2.0.0 language flag image fix
		foreach ($this->data['languages'] as $key => $value) {
			if(version_compare(VERSION, '2.2.0.0', "<")) {
				$this->data['languages'][$key]['flag_url'] = 'view/image/flags/'.$this->data['languages'][$key]['image'];
			} else {
				$this->data['languages'][$key]['flag_url'] = 'language/'.$this->data['languages'][$key]['code'].'/'.$this->data['languages'][$key]['code'].'.png"';
			}
		}
        $this->data['store']                  = $store;
        $this->data['token']                  = $this->session->data['token'];
        $this->data['action']                 = $this->url->link($this->modulePath, 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel']                 = $this->extensionsLink;
        $this->data['data']                   = $this->model_setting_setting->getSetting($this->moduleNameSmall, $store['store_id']);
        $this->data['impressions']			  = $this->moduleModel->getImpressions();
        $this->data['layouts']                = $this->model_design_layout->getLayouts();
        $this->data['catalog_url']			= $catalogURL;
		if (isset($this->data['data'][$this->moduleNameSmall])) {
		// Module Unifier
		$this->data['moduleData'] = $this->data['data'][$this->moduleNameSmall];
		// Module Unifier
		}
		
      	$this->data['header']  					 = $this->load->controller('common/header');
		$this->data['column_left']				= $this->load->controller('common/column_left');
		$this->data['footer']					 = $this->load->controller('common/footer');
		
        $this->response->setOutput($this->load->view($this->modulePath . '.tpl', $this->data));

    }
	
	public function get_popupwindow_settings() {        
         if(VERSION >= '2.1.0.1'){
			$this->load->model('customer/customer_group');
			$this->data['customerGroups'] = $this->model_customer_customer_group->getCustomerGroups();
		} else {
			$this->load->model('sale/customer_group');
			$this->data['customerGroups'] = $this->model_sale_customer_group->getCustomerGroups();
		}
        
		$this->data['currency']			   = $this->config->get('config_currency');
		$this->data['languages']              = $this->model_localisation_language->getLanguages();
		//2.2.0.0 language flag image fix
		foreach ($this->data['languages'] as $key => $value) {
			if(version_compare(VERSION, '2.2.0.0', "<")) {
				$this->data['languages'][$key]['flag_url'] = 'view/image/flags/'.$this->data['languages'][$key]['image'];
			} else {
				$this->data['languages'][$key]['flag_url'] = 'language/'.$this->data['languages'][$key]['code'].'/'.$this->data['languages'][$key]['code'].'.png"';
			}
		}
		$this->data['popup']['id']		    = $this->request->get['popup_id'];
		$store_id							 = $this->request->get['store_id'];
		$this->data['token']                  = $this->session->data['token'];
		$this->data['data']                   = $this->model_setting_setting->getSetting($this->moduleNameSmall, $store_id);
		$this->data['moduleName']			 = $this->moduleName;
		$this->data['moduleData']			 = (isset($this->data['data'][$this->moduleNameSmall])) ? $this->data['data'][$this->moduleNameSmall] : array();
		$this->data['newAddition']			= true;
		
		$this->response->setOutput($this->load->view($this->modulePath . '/tab_popuptab.tpl', $this->data));
	}

    private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }

    private function getServerURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_SERVER;
        } else {
            $storeURL = HTTP_SERVER;
        } 
        return $storeURL;
    }

    private function getCurrentStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->model_setting_store->getStore($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL(); 
        }
        return $store;
    }
    
    public function install() {
	    $this->moduleModel->install($this->moduleNameSmall);
    }
    
    public function uninstall() {
    	$this->load->model('setting/setting');
		
		$this->load->model('setting/store');
		$this->model_setting_setting->deleteSetting($this->moduleData_module,0);
		$stores=$this->model_setting_store->getStores();
		foreach ($stores as $store) {
			$this->model_setting_setting->deleteSetting($this->moduleData_module, $store['store_id']);
		}
		
        $this->moduleModel->uninstall($this->moduleNameSmall);
    }
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', $this->modulePath)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		
		return !$this->error;
	}
}

?>