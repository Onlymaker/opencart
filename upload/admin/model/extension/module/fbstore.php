<?php 
if (!class_exists('Facebook\Facebook')) {
			require_once(DIR_SYSTEM . '../vendors/facebook-sdk-v5/autoload.php');

}


class ModelExtensionModuleFBStore extends Model {

  	public function install() {
		$this->load->model('design/layout');
		$layout_route = array(array('store_id' => 0 , 'route' => 'fbstore'), array('store_id' => 0 , 'route' => 'fbstore/*'));
		$data = array('name' => 'FacebookStore',
			'layout_route'	=> $layout_route);
		$this->model_design_layout->addLayout($data);
  	} 
  
  	public function uninstall() {
  		$this->load->model('design/layout');
		$id = $this->db->query("SELECT layout_id FROM " . DB_PREFIX . "layout WHERE `name` = 'FacebookStore'")->row;
		$this->model_design_layout->deleteLayout($id['layout_id']);
  	}

  	public function deleteStoreTab($module_id){
  		/*
  		$this->load->model('extension/module');
  		$settings = $this->db->query("SELECT * FROM `" . DB_PREFIX . "module` WHERE `module_id` = '" . $this->db->escape($module_id) . "'")->row;

  		if($settings['code'] == 'fbstore'){
  			$fbstoresettings = json_decode($settings['setting'], true);
  			$page_data = explode("||", $fbstoresettings['selectedPage']);

  			if(!empty($page_data)){

			$page_id = $page_data[0];
			$page_access_token = $page_data[1];

  			$fb = new Facebook\Facebook(array(
			  'app_id' => '1696355113951420',
			  'app_secret' => '83181a727229b2fb80281292ada91d2a',
			  'default_graph_version' => 'v2.5',
			));
  			try {
	  			$response = $fb->delete('/' . $page_id . '/tabs', array(
				'tab' => 'app_1696355113951420',
				), $page_access_token);
  			}
  			catch(Facebook\Exceptions\FacebookResponseException $e) {
		  		return;
			}


			}
			return;
  		}
  		*/
  	}

  	public function login($fb){

		$helper = $fb->getJavaScriptHelper();

		$accessToken = $this->getToken($fb);
			
		return $accessToken;
			

  	}

  	private function getModuleSettings($page_id){
  		$this->load->model('extension/module');
  		/*
  		$settings = $this->db->query("SELECT * FROM ". DB_PREFIX . "module WHERE setting LIKE '%".$page_id."%' limit 1")->row; //_'.$this->request->post['page_id'].'"'
		if(!$settings){
			return false;
		}
		$settings = json_decode($settings['setting'], true);

		*/

		$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		return $module_info;
  	}

  	public function getPageTabs($fb, $page_id){
  		$tabs = '';
  		$pages = $this->getPages($fb , $page_id);
  		$page_token = '';

  		if(!empty($pages)){
  			foreach ($pages as $fbpage) {
	  			if($page_id == $fbpage['id']){
	  				$page_token = $fbpage['access_token'];
	  			}
  			}
  		}

  		try {
		 
		  $response = $fb->get('/'.$page_id.'/tabs', $page_token);
		  $body = $response->getDecodedBody();
		  $tabsData = $body['data'];
		  $count = 0;
		  foreach ($tabsData as $tab) {
		  	$count++;
	  		if(isset($tab['application']['id']) && $tab['application']['id']  == '1696355113951420'){
			  	$tabs = array('name' => $tab['name'],
			  				  'link' => 'https://facebook.com'.$tab['link'],
			  				  'position' => $tab['position']);
		  	}
		  }
		  $tabs['max_position'] = $count;


		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  	return $this->redirect($e);
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			return $this->redirect($e);
		}
		
  			
  		return $tabs;


  	}

  	public function checkIfPageExists($fb, $page_id){
  		$pages = $this->getPages($fb, $page_id);
  		foreach ($pages as $page) {
  			if($page_id == $page['id']){
  				return true;
  			}
  		}

  		return false;
  	}

  	public function getPages($fb, $page_id = ''){

  		$pages = array();

  		try {
		 	
		  $response = $fb->get('/me/accounts', $this->getToken($fb, $page_id));
		  $body = $response->getDecodedBody();

		  if(!empty($body['data'])){
			  foreach ($body['data'] as $value) {
			  	$pages[] = array('name' => $value['name'], 'id' => $value['id'], 'access_token' => $value['access_token']);
			  }
		  }

		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  	return $this->redirect($e);
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			return $this->redirect($e);
		}
		
  			
  		return $pages;


  	}

  	public function getToken($fb, $page_id = ''){

  			if (!empty($page_id)) {

  				if(isset($_SESSION['fb_access_token'])){
  					return $_SESSION['fb_access_token'];
  				}



	  			$access_token = $this->getModuleSettings($page_id)['access_token'];
	  			if($access_token){

	  			try {  			
	  				$response = $fb->get('/me', $access_token);	
	  			}
	  			catch(Facebook\Exceptions\FacebookResponseException $e) {
	  				if(isset($_SESSION['fb_access_token'])){
						return $_SESSION['fb_access_token'];
					}
			  		$data['moduleURL'] = $this->url->link('module/fbstore', 'token=' . $this->session->data['token'].$module_id, true);
			  		return $this->response->redirect($data['moduleURL']);	
				}


	  			return $access_token;
	  			}
  			}

  			if(isset($_SESSION['fb_access_token'])){
				
				try {  			
	  				$response = $fb->get('/me', $_SESSION['fb_access_token']);	
	  			}
	  			catch(Facebook\Exceptions\FacebookResponseException $e) {
					unset($_SESSION['fb_access_token']);
					$data['moduleURL'] = $this->url->link('module/fbstore', 'token=' . $this->session->data['token'].$module_id, true);
			  		return $this->response->redirect($data['moduleURL']);	
				}
				 
				return $_SESSION['fb_access_token'];
				
			}

			return NULL;
  	}

  	/*
  	public function getToken($fb, $page_id = ''){

  		if (!empty($page_id)) {
  			$access_token = $this->getModuleSettings($page_id)['access_token'];
  			if($access_token){
  				return $access_token;
  			}
  		}

  		
	  		if(isset($_SESSION['fb_access_token'])){
				$accessToken = $_SESSION['fb_access_token'];
			} else {
				try {
					$helper = $fb->getJavaScriptHelper();
				  	$accessToken = $helper->getAccessToken();
			   		$oAuth2Client = $fb->getOAuth2Client();
	    			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	    			$_SESSION['fb_access_token'] = (string)$accessToken;
				  //$expires = time() + 60 * 60 * 24 * 10;
				  //$accessToken = new Facebook\Authentication\AccessToken($accessToken, $expires);

				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  return $this->redirect($e);
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  return $this->redirect($e);
				}
			}
		

		//return (string)$accessToken;
  	}
	*/

  	public function extendToken(){

  	}

  	public function addTab(){

  	}
	
  	private function redirect($message = NULL){
  			//ADD ERROR LOG
		if(isset($message)){
			//echo 'Caught exception: ',  $message->getMessage(), "\n";
			//exit;
		}

		return false;
 		//header('Location: '. $this->url->link('module/fbstore').'&token='.$this->session->data['token']);
	    //exit;
  	}

  }
?>