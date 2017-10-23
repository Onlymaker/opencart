<?php
class ControllerExtensionModuleVipCustomer extends Controller {
  public function index($setting) {
    $data['lng'] = $this->load->language('extension/module/vip_customer');

    $vip = new vip_customer($this->registry);
    $data['customer'] = $vip->getVip($this->customer->getId());

    $data['detail_url'] = $this->url->link('extension/module/vip_customer/getDetail');

    return $this->load->view('extension/module/vip_customer.tpl', $data);
  } //index end

  public function updateVip($route = '', $data = array()) {
    if (!empty($this->request->get['customer_id'])) $customer_id = $this->request->get['customer_id'];

    if (!empty($data[0])) {
      $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$data[0] . "'");
      if ($query->num_rows) $customer_id = $query->row['customer_id'];
    } elseif ($this->config->get('vip_customer_log')) {
      $this->log->write(print_r($data, true));
    }

    if (isset($customer_id)) {
      $vip = new vip_customer($this->registry);
      $vip->setVip($customer_id);
      if ($this->config->get('vip_customer_log')) $this->log->write('vip_customer: updateVip for customer_id: ' . $customer_id);
    }
  } //updateVip end

  public function updateAll() {
    $vip = new vip_customer($this->registry);

    $start = file_exists(DIR_LOGS . 'vip_customer_update_status.txt') ? (int)file_get_contents(DIR_LOGS . 'vip_customer_update_status.txt') : 0;

    $limit = $this->db->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . DB_DATABASE . "' AND TABLE_NAME='" . DB_PREFIX . "customer'")->row['AUTO_INCREMENT'];

    $query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer LIMIT " . $start . ", " . $limit);
    foreach ($query->rows as $r) {
      $vip->setVip($r['customer_id']);
      file_put_contents(DIR_LOGS . 'vip_customer_update_status.txt', $r['customer_id']);
    }

    file_put_contents(DIR_LOGS . 'vip_customer_update_status.txt', 0);

    $this->response->setOutput('Updated ' . $query->num_rows . ' customers.');
  } //updateAll end

  public function getDetail() {
    $data['lng'] = $this->load->language('extension/module/vip_customer');

    $vip = new vip_customer($this->registry);

    $this->load->model('setting/setting');
    $data['setting'] = $this->model_setting_setting->getSetting('vip_customer');

    $customer_id = $this->customer->getId();

    if (isset($this->request->get['customer'])) {
      $customer = explode('-', $this->request->get['customer']);
      if (count($customer) > 1) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer[0] . "' AND salt = '" . $this->db->escape($customer[1]) . "'");
        if ($query->num_rows) $customer_id = $query->row['customer_id'];
      }
    }

    if ($data['setting']['vip_customer_type'] == 'all') $data['setting']['vip_customer_type'] = $this->language->get('text_all');
    elseif ($data['setting']['vip_customer_type'] == 'monthly') $data['setting']['vip_customer_type'] = $this->language->get('text_monthly');
    elseif ($data['setting']['vip_customer_type'] == 'quarterly') $data['setting']['vip_customer_type'] = $this->language->get('text_quarterly');
    elseif ($data['setting']['vip_customer_type'] == 'semiannually') $data['setting']['vip_customer_type'] = $this->language->get('text_semiannually');
    elseif ($data['setting']['vip_customer_type'] == 'annually') $data['setting']['vip_customer_type'] = $this->language->get('text_annually');

    $data['customer'] = $vip->getVip($customer_id);
    $data['vip_levels'] = $vip->getLevels($customer_id);
    $data['vip_data'] = $vip->getDetail($customer_id);
    $data['vip_data_next'] = $this->config->get('current_period') ? array() : $vip->getDetail($customer_id, 'next');
    $data['store'] = $vip->getStore($data['customer']['store_id']);

    $data['heading_title'] = str_replace('{customer_name}', $data['customer']['fullname'], $this->language->get('heading_detail_title'));
    $data['date'] = date($this->language->get('date_format_long'));
    $data['language_id'] = $this->config->get('config_language_id');

    $data['lng']['text_detail_current'] = str_replace('{date_range}', $data['vip_data']['date']['range'], $this->language->get('text_detail_current'));
    unset($data['vip_data']['date']);

    $data['lng']['text_detail_next'] = str_replace('{date_range}', $data['vip_data_next']['date']['range'], $this->language->get('text_detail_next'));
    $data['lng']['text_vip_start_date'] = str_replace('{start_date}', $data['vip_data_next']['date']['start'], $this->language->get('text_vip_start_date'));
    unset($data['vip_data_next']['date']);

    $data['vip_summary'] = $this->load->view('extension/module/vip_customer.tpl', $data);

    $this->response->setOutput($this->load->view('extension/module/vip_customer_detail.tpl', $data));
  } //function detail end
} //class end
?>
