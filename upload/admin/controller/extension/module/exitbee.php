<?php class ControllerExtensionModuleExitBee extends Controller {
        private $error = array();

        public function index() {
                $this->load->language('extension/module/exitbee');
                $this->document->setTitle($this->language->get('heading_title'));
                $this->load->model('setting/setting');
                //save settings if sent
                if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                  $this->model_setting_setting->editSetting('exitbee', $this->request->post);
                  $this->session->data['success'] = $this->language->get('text_success');
                  $this->cache->delete('exitbee');
                  $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
                }

				        $data = array();
                $data['heading_title'] = $this->language->get('heading_title');
				        $data['exitbee_site_key'] = html_entity_decode($this->config->get('exitbee_site_key'));

                //entry texts
                $data['entry_site_key'] = $this->language->get('entry_site_key');
                $data['entry_status'] = $this->language->get('entry_status');
                $data['entry_ecommerce_tracking'] = $this->language->get('entry_ecommerce_tracking');



                //texts
                $data['text_disabled'] = $this->language->get('text_disabled');
                $data['text_enabled'] = $this->language->get('text_enabled');
				        $data['text_edit'] = $this->language->get('text_edit');
                $data['text_help_site_key'] = $this->language->get('text_help_site_key');
                $data['text_help_ecommerce_tracking'] = $this->language->get('text_help_ecommerce_tracking');
                $data['text_where_find_key'] = $this->language->get('text_where_find_key');

                //buttons texts
                $data['button_save'] = $this->language->get('button_save');
                $data['button_cancel'] = $this->language->get('button_cancel');
                $data['button_add_module'] = $this->language->get('button_add_module');
                $data['button_remove'] = $this->language->get('button_remove');

                //breadcrumbs
                $data['breadcrumbs'] = array();
                $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                        'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
                );
                $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
                );

                $data['action'] = $this->url->link('extension/module/exitbee', 'token=' . $this->session->data['token'], 'SSL');

                $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
				        if (isset($this->request->post['exitbee_site_key'])) {
                  $data['exitbee_site_key'] = $this->request->post['exitbee_site_key'];
                }
                if (isset($this->request->post['exitbee_status'])) {
                  $data['exitbee_status'] = $this->request->post['exitbee_status'];
                } else {
                  $data['exitbee_status'] = $this->config->get('exitbee_status') !=null ? $this->config->get('exitbee_status')  : 1;
                }

                if (isset($this->request->post['exitbee_ecommerce_status'])) {
                  $data['exitbee_ecommerce_status'] = $this->request->post['exitbee_ecommerce_status'];
                } else {
                  $data['exitbee_ecommerce_status'] = $this->config->get('exitbee_ecommerce_status') !=null ? $this->config->get('exitbee_ecommerce_status') : 1 ;
                }

                if (isset($this->error) && count ($this->error)) {
            			$data['error'] = $this->error;
            		} else {
            			$data['error'] = array();
            		}

    					$data['header'] = $this->load->controller('common/header');
    					$data['column_left'] = $this->load->controller('common/column_left');
    				  $data['footer'] = $this->load->controller('common/footer');
    				  $this->response->setOutput($this->load->view('extension/module/exitbee.tpl', $data));
         }

         protected function validate() {
           if (!$this->user->hasPermission('modify', 'extension/module/exitbee')) {
             $this->error['warning'] = $this->language->get('error_permission');
           }
           $keyPosted = $this->request->post['exitbee_site_key'];

           if (!$keyPosted) {
             $this->error['error_key_required'] = $this->language->get('error_key_required');
           }
           else {
             $uuidpattern = '/^[\da-f]{8}-([\da-f]{4}-){3}[\da-f]{12}$/';
             preg_match($uuidpattern, $keyPosted, $matches);
             if (!$matches) {
               $this->error['error_key_invalid'] = $this->language->get('error_key_invalid');
             }
          }
       		return !$this->error;
       	 }
  }
?>
