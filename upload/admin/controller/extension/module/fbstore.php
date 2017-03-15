<?php
class ControllerExtensionModuleFBStore extends Controller {
	private $moduleName;
    private $moduleVersion;
    private $callModel;
    private $modulePath;
    private $moduleModel;
    private $extensionsLink;
    private $error = array(); 
    private $data = array();
	

	public function __construct($registry) {
        parent::__construct($registry);
        $this->config->load('isenselabs/facebookstore');

        $this->document->addStyle('view/stylesheet/fbstore/fbstore.css');

        // Module VERSION
        $this->moduleVersion = $this->config->get('fbstore_moduleVersion');        
        


        /* OC version-specific declarations - Begin */
        $this->moduleName        = $this->config->get('fbstore_moduleName');        
        $this->callModel         = $this->config->get('fbstore_callModel');
        $this->modulePath        = $this->config->get('fbstore_modulePath');
        $this->extensionsLink    = $this->url->link($this->config->get('fbstore_extensionsLink'), 'token=' . $this->session->data['token'].$this->config->get('fbstore_extensionsLink_type'), 'SSL');
        /* OC version-specific declarations - End */


        /* Module-specific declarations - Begin */
        $this->load->language($this->modulePath);
        $this->load->model($this->modulePath);
        $this->moduleModel = $this->{$this->callModel};
        
        // Multi-Store
        $this->load->model('setting/store');
        // Settings
        $this->load->model('setting/setting');
        // Multi-Lingual
        $this->load->model('localisation/language');

		$this->load->model('extension/module');
        
		$this->load->model('catalog/category');

        // Variables
        $this->data['moduleName'] 		= $this->moduleName;
        $this->data['modulePath']       = $this->modulePath;
        /* Module-specific loaders - End */
    }



	private function login(){

			$data['heading_title'] 				= $this->language->get('heading_title') . ' ' . $this->moduleVersion;
			$data['token']						= $this->session->data['token'];
			$data['header']						= $this->load->controller('common/header');
			$data['column_left']				= $this->load->controller('common/column_left');
			$data['footer']						= $this->load->controller('common/footer');

			
			$data['saveTokenURL'] = $this->url->link($this->modulePath.'/saveToken', 'token=' . $this->session->data['token'], true);
			$data['loginUrl'] = 'https://facebookstore.isenselabs.com/api/page/login';
		    $module_id = (isset($this->request->get['module_id'])) ? '&module_id='.$this->request->get['module_id'] : '';
			$data['moduleURL'] = $this->url->link($this->modulePath, 'token=' . $this->session->data['token'].$module_id, true);
   			$this->response->setOutput($this->load->view($this->modulePath.'.tpl' , $data));
	}


	public function saveToken(){
		$token = $this->request->post['token'];
		$_SESSION['fb_access_token'] = (string)$token;

	}


	public function index(){
		if (!extension_loaded('mbstring')) { 
			die("The Facebook SDK requires enabled php extension 'mbstring'. Please contact your system administrator or hosting provider.");
		}

		if (!class_exists('Facebook\Facebook')) {
			require_once(DIR_SYSTEM . '../vendors/facebook-sdk-v5/autoload.php');
		}

		$fb = new Facebook\Facebook(array(
		  'app_id' => '1696355113951420',
		  'app_secret' => '83181a727229b2fb80281292ada91d2a',
		  'default_graph_version' => 'v2.5',
		));

		if(!isset($_SESSION['fb_access_token'])){
			$this->login();
			return;
		}

		$data['token'] = $this->{$this->callModel}->login($fb);

       	if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] 	= 0; 
        }
		
		// Get store info
        $store 								= $this->getCurrentStore($this->request->get['store_id']);
        $data['module_id'] = (isset($this->request->get['module_id'])) ? '&module_id='.$this->request->get['module_id'] : '';
       


       if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->user->hasPermission('modify', $this->modulePath )) {
       		if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
                $this->request->post[$this->moduleName]['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
            }
            if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
                $this->request->post[$this->moduleName]['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
            }

			$this->model_setting_setting->editSetting($this->moduleName, $this->request->post);
		}

       if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {

       		$this->addtab();
			if (!isset($this->request->get['module_id'])) {
				$page_data = explode("||", $this->request->post['selectedPage']);
				$page_id = $page_data[0];
				$this->addToIsenselabsApi($page_id);
				$this->model_extension_module->addModule('fbstore', $this->request->post);
				$module_id = $this->db->getLastId();
				$this->response->redirect($this->url->link($this->modulePath , 'token=' . $this->session->data['token'].'&module_id='.$module_id, true));
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
				$this->response->redirect($this->url->link($this->modulePath , 'token=' . $this->session->data['token'].'&module_id='.$this->request->get['module_id'], true));
			}

		}

		$data['heading_title'] = $this->language->get('heading_title'). ' ' . $this->moduleVersion;

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_tabname'] = $this->language->get('entry_tabname');
		$data['entry_chooseapage'] = $this->language->get('entry_chooseapage2');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');


		if (isset($this->request->get['module_id'])){
			$data['ModuleEdit'] = true;
		} else {
			$data['ModuleEdit'] = false;
		}

		if(!$data['ModuleEdit']) {
			$data['button_save'] = $this->language->get('button_addtotab');
			$data['entry_chooseapage'] = $this->language->get('entry_chooseapage');
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {     
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['page-name'])) {
			$data['error_page_name'] = $this->error['page-name'];
		} else {
			$data['error_page_name'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->extensionsLink
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link($this->modulePath , 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link($this->modulePath , 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}

		if (isset($this->request->get['module_id'])) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);

			if(empty($module_info)){
				$this->response->redirect($this->url->link($this->modulePath , 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$data['stores']						= array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());

		$data['store']                  	= $store;
		$data['moduleSettings']		= $this->model_setting_setting->getSetting($this->moduleName);
        $data['moduleData']			= (isset($data['moduleSettings'][$this->moduleName])) ? $data['moduleSettings'][$this->moduleName] : array();

		if(isset($module_info)){

			$data['selectedPage'] = $module_info['selectedPage'];
			$data['categories'] =  isset($module_info['categories']) ? $module_info['categories'] : array();
			$data['access_token'] = $module_info['access_token'];

			if($data['access_token'] != $data['token']){
				$data['access_token'] = $data['token'];
			}
			$data['store'] =  $this->getCurrentStore($module_info['store_id']);
			$page_data = explode("||", $data['selectedPage']);
			$data['tab'] = $this->{$this->callModel}->getPageTabs($fb, $page_data[0]);
			$data['pages'] = $this->{$this->callModel}->getPages($fb , $page_data[0]);
			
			$data['isOwner'] = false;
			foreach ($data['pages'] as $value) {
				if($page_data[0] == $value['id']){
					$data['isOwner'] = true;
				}
			}

			$data['limit'] = isset($module_info['limit']) ? $module_info['limit'] : '9' ;
			$data['imageWidth'] = isset($module_info['imageWidth']) ? $module_info['imageWidth'] : '150' ;
			$data['imageHeight'] = isset($module_info['imageHeight']) ? $module_info['imageHeight'] : '150' ;

		} else {
			$data['isOwner'] = array();
			$data['selectedPage'] = '';
			$data['categories'] = array();
			$data['access_token'] = $this->{$this->callModel}->getToken($fb);
			$data['pages'] = $this->{$this->callModel}->getPages($fb);
		}

		

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link($this->modulePath , 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link($this->modulePath , 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['moduleName'] 	  = $this->moduleName;
        $data['modulePath']       = $this->modulePath;
        $data['moduleNameSmall']  = $this->moduleName;

        
		$data['cancel'] = $this->extensionsLink;
		$data['token']  = $this->session->data['token'];			
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
   		$this->response->setOutput($this->load->view($this->modulePath.'/settings.tpl' , $data));

	}


	private function addToIsenselabsApi($page_id){

		$post = array(
		    'page_id' => $page_id,
		    'domain' => HTTPS_CATALOG,
		    'platform'   => 'opencart',
		);
		try {
		$ch = curl_init('https://facebookstore.isenselabs.com/api/page/includeInOurApi');
		if (FALSE === $ch) throw new Exception('failed to initialize');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

		// execute!
		$response = curl_exec($ch);
		 if (FALSE === $response) throw new Exception(curl_error($ch), curl_errno($ch));
		// close the connection, release resources used
		curl_close($ch);
		} catch(Exception $e) {
			echo '<h2>There is some error with adding your facebook page to our database. Plase contact us at https://isenselabs.com</h2>';
			echo '<br> ERROR : ';
			var_dump($e->getMessage());exit;
		}
		if($response != 'success'){
			$this->session->data['success'] = 'There is some error with adding your facebook page to our database. Plase contact us at https://isenselabs.com';
			$this->response->redirect($this->url->link($this->modulePath , 'token=' . $this->session->data['token'], true));
		}
	}

	private function getCategory(){
		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
				// Level 1
				if($category['parent_id'] == 0) {
					$data['categories'][] = array(
						'name'     => $category['name'],
						'category_id' => $category['category_id'],
						'href'  => $this->url->link($this->modulePath , '&category=' . $category['category_id'])
					);
				}
		}

		return $data['categories'];
	}

	public function addtab(){
		if (!class_exists('Facebook\Facebook')) {
			require_once(DIR_SYSTEM . '../vendors/facebook-sdk-v5/autoload.php');
		}

		$fb = new Facebook\Facebook(array(
		  'app_id' => '1696355113951420',
		  'app_secret' => '83181a727229b2fb80281292ada91d2a',
		  'default_graph_version' => 'v2.5',
		));

		$this->load->model($this->modulePath );
		//TODO IF VALID ACCESTOKEN

		$page_data = explode("||", $this->request->post['selectedPage']);
		$page_id = $page_data[0];
		$position = isset($this->request->post['position']) ? $this->request->post['position'] : 1 ;
		$page_access_token = $page_data[1];
		$page_name = $this->request->post['page-name'];

		//$pageExists = $this->{$this->callModel}->checkIfPageExists($fb, $page_id);
		//if(!$pageExists){
		//	echo 'false';exit;
		//}

		try {
	  			$response = $fb->post('/' . $page_id . '/tabs', array(
					'app_id' => '1696355113951420',
					'custom_name' => $page_name,
					'position' => $position,
					'access_token' => $page_access_token
				), $page_access_token);

				$addPageCallToAction = $fb->post('/' . $page_id . '/call_to_actions', array(
					'type' => 'SHOP_NOW',
					'web_destination_type' => 'WEBSITE',
					'web_url' => 'https://facebookstore.isenselabs.com/api/&page='.$page_id
				), $page_access_token);

				$body = $response->getDecodedBody();
				$this->session->data['success'] = 'You have successfully added a tab to your Facebook Page!';

  			}
  			catch(Facebook\Exceptions\FacebookResponseException $e) {
		  		return;
			}
		
		
	}
	

	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->modulePath )) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['page-name']) < 3) || (utf8_strlen($this->request->post['page-name']) > 64)) {
			$this->error['page-name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}


	public function install() {
	    $this->{$this->callModel}->install();
    }
	
	public function uninstall() {
        $this->{$this->callModel}->uninstall();
    }	

	private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
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
}
?>