<?php
class ControllerFBStoreFBCheckoutSuccess extends Controller {
	public function index() {
$this->load->model('fbstore/fbstore');
		
		$this->load->language('fbstore/fbstore');
		$this->load->language('checkout/success');
		
		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();

			// Add to activity log
			$this->load->model('account/activity');

			if ($this->customer->isLogged()) {
				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
					'order_id'    => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_account', $activity_data);
			} else {
				$activity_data = array(
					'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
					'order_id' => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_guest', $activity_data);
			}

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}

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
			'text' => $this->language->get('text_success'),
			'href' => $this->model_fbstore_fbstore->link('fbstore/fbcheckout/success')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) { 
			$data['text_message'] = $this->language->get('order_placed');
			//$data['text_message'] = sprintf($this->language->get('text_customer'), $this->model_fbstore_fbstore->link('fbstore/fbcheckout/checkout', '', true), $this->model_fbstore_fbstore->link('fbstore/fbcheckout/checkout', '', true), $this->model_fbstore_fbstore->link('fbstore/fbcheckout/checkout', '', true), $this->model_fbstore_fbstore->link('fbstore/fbcheckout/checkout'));
		} else {
			$data['text_message'] = $this->language->get('order_placed');
			//$data['text_message'] = sprintf($this->language->get('text_guest'), $this->model_fbstore_fbstore->link('information/contact'));
		}

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