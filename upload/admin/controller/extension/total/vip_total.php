<?php
class ControllerExtensionTotalVipTotal extends Controller {
  private $error = array();

  public function index() {
    $data['lng'] = $this->language->load('extension/total/vip_total');

    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('setting/setting');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
      $this->model_setting_setting->editSetting('vip_total', $this->request->post);

      $this->session->data['success'] = $this->language->get('text_success');

      $this->response->redirect($this->url->link('extension/total/vip_total', 'token=' . $this->session->data['token'], 'SSL'));
    }

    if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];
      unset($this->session->data['success']);
    }

    if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => false
    );

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_total'),
      'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', 'SSL'),
      'separator' => ' :: '
    );

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('heading_title'),
      'href'      => $this->url->link('extension/total/vip_total', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => ' :: '
    );

    $data['action'] = $this->url->link('extension/total/vip_total', 'token=' . $this->session->data['token'], 'SSL');

    $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=total', 'SSL');

    if (isset($this->request->post['vip_total_status'])) {
      $data['vip_total_status'] = $this->request->post['vip_total_status'];
    } else {
      $data['vip_total_status'] = $this->config->get('vip_total_status');
    }

    if (isset($this->request->post['vip_total_sort_order'])) {
      $data['vip_total_sort_order'] = $this->request->post['vip_total_sort_order'];
    } else {
      $data['vip_total_sort_order'] = $this->config->get('vip_total_sort_order');
    }

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/total/vip_total.tpl', $data));
  }

  protected function validate() {
    if (!$this->user->hasPermission('modify', 'extension/total/vip_total')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }

    return !$this->error;
  }
}
?>
