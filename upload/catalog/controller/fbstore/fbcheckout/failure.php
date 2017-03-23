<?php
class ControllerFBStoreFBCheckoutFailure extends Controller {
	public function index() {
$this->load->model('fbstore/fbstore');
		$this->load->language('checkout/failure');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->model_fbstore_fbstore->link('fbstore/index')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->model_fbstore_fbstore->link('fbstore/fbcheckout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->model_fbstore_fbstore->link('fbstore/fbcheckout/checkout', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_failure'),
			'href' => $this->model_fbstore_fbstore->link('fbstore/fbcheckout/failure')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_message');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->model_fbstore_fbstore->link('fbstore/index');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('fbstore/common/footer');
		$data['header'] = $this->load->controller('fbstore/common/header');

		$this->response->setOutput($this->model_fbstore_fbstore->getOutput('fbstore/fbcheckout/success', $data));
	}
}