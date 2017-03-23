<?php
class ControllerExtensionModuleTGfashionistaMegamenu extends Controller {
		public function index($setting) {
		
		$this->load->model('menu/tg_fashionista_megamenu');

		$data['menu'] = $this->model_menu_tg_fashionista_megamenu->getMenu();

		$lang_id = $this->config->get('config_language_id');
		$data['settings'] = array(
			
			'animation' => $setting['animation'],
			'animation_time' => $setting['animation_time'],
			'navigation_text' => $setting['navigation_text'],
		);
		
		$data['navigation_text'] = 'Navigation';
		if(isset($setting['navigation_text'][$lang_id])) {
			if(!empty($setting['navigation_text'][$lang_id])) {
				$data['navigation_text'] = $setting['navigation_text'][$lang_id];
			}
		}

		$data['lang_id'] = $this->config->get('config_language_id');

		return $this->load->view('extension/module/tg_fashionista_megamenu', $data);
	}
}
?>