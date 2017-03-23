<?php
class ControllerFbStoreErrorNotFound extends Controller {
	public function index() {
$this->load->model('fbstore/fbstore');
		$this->load->language('error/not_found');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->model_fbstore_fbstore->link('fbstore/index')
		);

		if (isset($this->request->get['route'])) {
			$url_data = $this->request->get;

			unset($url_data['_route_']);

			$route = $url_data['route'];

			unset($url_data['route']);

			$url = '';

			if ($url_data) {
				$url = '&' . urldecode(http_build_query($url_data, '', '&'));
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->model_fbstore_fbstore->link($route, $url, $this->request->server['HTTPS'])
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_error'] = $this->language->get('text_error');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->model_fbstore_fbstore->link('fbstore/index');

		$data['footer'] = $this->load->controller('fbstore/common/footer');
		$data['header'] = $this->load->controller('fbstore/common/header');

		$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

		$this->response->setOutput($this->model_fbstore_fbstore->getOutput('fbstore/error/not_found', $data));
	}
}