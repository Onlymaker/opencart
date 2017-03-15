<?php
class ControllerFBStoreCommonSearch extends Controller {
	public function index() {
$this->load->model('fbstore/fbstore');
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->model_fbstore_fbstore->getOutput('fbstore/common/search', $data);
	}
}