<?php
class ControllerExtensionModuleVipCustomer extends Controller {
  private $version = '4.1.6';
  private $error = array();

  public function index() {
    $vip = new vip_customer($this->registry);

    $this->load->language('extension/extension/module');
    $this->load->model('tool/image');
    $this->load->model('extension/module');
    $this->load->model('setting/setting');

    $data['lng'] = $this->load->language('extension/module/vip_customer');

    $data['text_layout'] = sprintf($this->language->get('text_layout'), $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL'));

    $this->document->setTitle($this->language->get('heading_title'));

    $data['heading_title'] = $this->language->get('heading_title') . ' - ' . $this->version;

    $module_id = isset($this->request->get['module_id']) ? $this->request->get['module_id'] : '';

    $data['token'] = $this->session->data['token'];
    $data['url'] = $this->url->link('extension/module/vip_customer', 'token=' . $this->session->data['token'] . '&module_id=' . $module_id, 'SSL');
    $data['url'] = html_entity_decode($data['url'], ENT_QUOTES, 'UTF-8');

    $this->document->setTitle($this->language->get('heading_title'));

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_home'),
      'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      'separator' => false
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_module'),
      'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL'),
      'separator' => ' :: '
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('heading_title'),
      'href' => $data['url'],
      'separator' => ' :: '
    );

    if (isset($this->request->get['tab'])) {
      $data['tab'] = $this->request->get['tab'];
    } elseif (!empty($this->request->get['module_id'])) {
      $data['tab'] = 'module';
    } else {
      $data['tab'] = 'setting';
    }

    if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
      if ($module_id && $data['tab'] == 'module') {
        $this->model_extension_module->editModule($module_id, $this->request->post);
        $this->session->data['success'] = $this->language->get('text_success');
      } elseif ($data['tab'] == 'module') {
        $this->model_extension_module->addModule('vip_customer', $this->request->post);
        $module_id = $this->db->getLastId();
        $this->session->data['success'] = $this->language->get('text_success');
      } elseif ($data['tab'] == 'setting') {
        $this->saveSettings($this->request->post);
        $this->session->data['success'] = $this->language->get('text_success');
      }

      $this->response->redirect($data['url'] . '&tab=' . $data['tab']);
    }

    $data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

    $data['success'] = isset($this->session->data['success']) ? $this->session->data['success'] : '';
    unset($this->session->data['success']);

    if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      $module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
    }

    $data['name'] = isset($module_info['name']) ? $module_info['name'] : '';
    $data['info'] = isset($module_info['info']) ? $module_info['info'] : '';
    $data['status'] = isset($module_info['status']) ? $module_info['status'] : '';

    $data['default_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

    $data['vip_levels'] = $vip->getLevels();

    $this->load->model('localisation/language');
    $data['languages'] = $this->model_localisation_language->getLanguages();

    $this->load->model('design/layout');
    $data['layouts'] = $this->model_design_layout->getLayouts();

    $complete_status = $this->db->query("SELECT GROUP_CONCAT(name SEPARATOR ', ') AS complete_status FROM " . DB_PREFIX . "order_status WHERE language_id='" . (int)$this->config->get('config_language_id') . "' AND order_status_id IN (" . implode(',', $this->config->get('config_complete_status')) . ")")->row['complete_status'];
    $data['complete_status'] = $complete_status;

    $data['vip_customer_group'] = $this->config->get('vip_customer_group');
    $data['vip_customer_store'] = $this->config->get('vip_customer_store');
    $data['vip_customer_type'] = $this->config->get('vip_customer_type');
    $data['vip_customer_shipping'] = $this->config->get('vip_customer_shipping');
    $data['vip_customer_tax'] = $this->config->get('vip_customer_tax');
    $data['vip_customer_credit'] = $this->config->get('vip_customer_credit');
    $data['vip_customer_reward'] = $this->config->get('vip_customer_reward');
    $data['vip_customer_coupon'] = $this->config->get('vip_customer_coupon');
    $data['vip_customer_email_customer'] = $this->config->get('vip_customer_email_customer');
    $data['vip_customer_email_admin'] = $this->config->get('vip_customer_email_admin');
    $data['vip_customer_show_vip_price_table'] = $this->config->get('vip_customer_show_vip_price_table');
    $data['vip_customer_price_table_format'] = $this->config->get('vip_customer_price_table_format');
    $data['vip_customer_discount_product'] = $this->config->get('vip_customer_discount_product');
    $data['vip_customer_special_product'] = $this->config->get('vip_customer_special_product');
    $data['vip_customer_hide_price'] = $this->config->get('vip_customer_hide_price');
    $data['vip_customer_log'] = $this->config->get('vip_customer_log');
    $data['vip_customer_date_format'] = $this->config->get('vip_customer_date_format');
    $data['vip_customer_current_period'] = $this->config->get('vip_customer_current_period');
    $data['vip_customer_days_from_today'] = $this->config->get('vip_customer_days_from_today');
    $data['vip_customer_status'] = $this->config->get('vip_customer_status');

    if (file_exists(DIR_APPLICATION . 'model/sale/customer_group.php')) {
      $this->load->model('sale/customer_group');
      $data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
    } elseif (file_exists(DIR_APPLICATION . 'model/customer/customer_group.php')) {
      $this->load->model('customer/customer_group');
      $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
    } else {
      $data['customer_group'] = array();
    }

    $this->load->model('setting/store');
    $data['stores'] = $this->model_setting_store->getStores();
    array_unshift($data['stores'], array(
      'store_id' => 0,
      'name' => $this->config->get('config_name')
    ));

    $url = '';

    if (isset($this->request->get['filter_customer_name'])) {
      $data['filter_customer_name'] = $this->request->get['filter_customer_name'];
      $url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
    } else {
      $data['filter_customer_name'] = '';
    }

    if (isset($this->request->get['filter_customer_email'])) {
      $data['filter_customer_email'] = $this->request->get['filter_customer_email'];
      $url .= '&filter_customer_email=' . $this->request->get['filter_customer_email'];
    } else {
      $data['filter_customer_email'] = '';
    }

    if (isset($this->request->get['filter_vip_customer'])) {
      $data['filter_vip_customer'] = $this->request->get['filter_vip_customer'];
      $url .= '&filter_vip_customer=' . $this->request->get['filter_vip_customer'];
    } else {
      $data['filter_vip_customer'] = '*';
    }

    if (isset($this->request->get['filter_vip_customer_init'])) {
      $data['filter_vip_customer_init'] = $this->request->get['filter_vip_customer_init'];
      $url .= '&filter_vip_customer_init=' . $this->request->get['filter_vip_customer_init'];
    } else {
      $data['filter_vip_customer_init'] = '*';
    }

    if (isset($this->request->get['filter_vip_customer_total'])) {
      $data['filter_vip_customer_total'] = $this->request->get['filter_vip_customer_total'];
      $url .= '&filter_vip_customer_total=' . $this->request->get['filter_vip_customer_total'];
    } else {
      $data['filter_vip_customer_total'] = '';
    }

    if (isset($this->request->get['filter_vip_customer_total_mode'])) {
      $data['filter_vip_customer_total_mode'] = $this->request->get['filter_vip_customer_total_mode'];
      $url .= '&filter_vip_customer_total_mode=' . $this->request->get['filter_vip_customer_total_mode'];
    } else {
      $data['filter_vip_customer_total_mode'] = '';
    }

    $data['order'] = isset($this->request->get['order']) ? $this->request->get['order'] : 'desc';
    $url .= '&order=' . ($data['order'] == 'desc' ? 'asc' : 'desc');

    $data['sort_url'] = $data['url'] . $url . '&tab=data';

    if (isset($this->request->get['sort'])) {
      $data['sort'] = $this->request->get['sort'];
      $url .= '&sort=' . $this->request->get['sort'];
    } else {
      $data['sort'] = 'fullname';
    }

    $data['page'] = empty($this->request->get['page']) ? 1 : $this->request->get['page'];

    $data['limit'] = $this->config->get('config_limit_admin');
    $data['start'] = ($data['page'] - 1) * $data['limit'];

    $data['customers'] = $this->getCustomers($data);

    $data['total_customers'] = $this->getCustomersTotal($data);

    $pagination = new Pagination();
    $pagination->total = $data['total_customers'];
    $pagination->page = $data['page'];
    $pagination->limit = $data['limit'];
    $pagination->url = $data['url'] . '&tab=data&page={page}';

    $data['pagination'] = $pagination->render();

    $data['pagination_text'] = sprintf($this->language->get('text_pagination'), ($data['total_customers']) ? (($data['page'] - 1) * $data['limit']) + 1 : 0, ((($data['page'] - 1) * $data['limit']) > ($data['total_customers'] - $data['limit'])) ? $data['total_customers'] : ((($data['page'] - 1) * $data['limit']) + $data['limit']), $data['total_customers'], ceil($data['total_customers'] / $data['limit']));

    $data['config_language_id'] = $this->config->get('config_language_id');

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/module/vip_customer.tpl', $data));
  } //index end

  public function getCustomers($data=array()) {
    $sql = "SELECT *, vc.name AS vip_level, CONCAT(c.firstname, ' ', c.lastname) AS fullname FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "vip_customer vc ON c.vip_id=vc.vip_id WHERE c.vip_id >= 0 AND vc.language_id='" . (int)$this->config->get('config_language_id') . "'";

    if (!empty($data['filter_customer_name'])) {
      $sql .= " AND LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(strtolower($data['filter_customer_name'])) . "%'";
    }

    if (!empty($data['filter_customer_email'])) {
      $sql .= " AND LCASE(c.email) LIKE '%" . $this->db->escape(strtolower($data['filter_customer_email'])) . "%'";
    }

    if (!empty($data['filter_vip_customer']) && $data['filter_vip_customer'] != '*') {
      $sql .= " AND c.vip_id='" . (int)$data['filter_vip_customer'] . "'";
    }

    if (!empty($data['filter_vip_customer_init']) && $data['filter_vip_customer_init'] != '*') {
      $sql .= " AND c.vip_init " . ($data['filter_vip_customer_init'] ? '>' : '=') . " 0";
    }

    if (isset($data['filter_vip_customer_total']) && is_numeric($data['filter_vip_customer_total'])) {
      if ($data['filter_vip_customer_total_mode'] == 'gt') $sql .= " AND c.vip_total > '" . (float)$data['filter_vip_customer_total'] . "'";
      elseif ($data['filter_vip_customer_total_mode'] == 'lt') $sql .= " AND c.vip_total < '" . (float)$data['filter_vip_customer_total'] . "'";
      elseif ($data['filter_vip_customer_total_mode'] == 'eq') $sql .= " AND c.vip_total = '" . (float)$data['filter_vip_customer_total'] . "'";
    }

    $sql .= " ORDER BY " . $this->db->escape($data['sort']) . " " . $this->db->escape(strtoupper($data['order'])) . " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];

    $query = $this->db->query($sql);

    return ($query->num_rows ? $query->rows : array());
  } //getCustomers end

  public function getCustomersTotal($data=array()) {
    $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "vip_customer vc ON c.vip_id=vc.vip_id WHERE c.vip_id >= 0 AND vc.language_id='" . (int)$this->config->get('config_language_id') . "'";

    if (!empty($data['filter_customer_name'])) {
      $sql .= " AND LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '%" . $this->db->escape(strtolower($data['filter_customer_name'])) . "%'";
    }

    if (!empty($data['filter_customer_email'])) {
      $sql .= " AND LCASE(c.email) LIKE '%" . $this->db->escape(strtolower($data['filter_customer_email'])) . "%'";
    }

    if (!empty($data['filter_vip_customer']) && $data['filter_vip_customer'] != '*') {
      $sql .= " AND c.vip_id='" . (int)$data['filter_vip_customer'] . "'";
    }

    if (!empty($data['filter_vip_customer_init']) && $data['filter_vip_customer_init'] != '*') {
      $sql .= " AND c.vip_init " . ($data['filter_vip_customer_init'] ? '>' : '=') . " 0";
    }

    if (isset($data['filter_vip_customer_total']) && is_numeric($data['filter_vip_customer_total'])) {
      if ($data['filter_vip_customer_total_mode'] == 'gt') $sql .= " AND c.vip_total > '" . (float)$data['filter_vip_customer_total'] . "'";
      elseif ($data['filter_vip_customer_total_mode'] == 'lt') $sql .= " AND c.vip_total < '" . (float)$data['filter_vip_customer_total'] . "'";
      elseif ($data['filter_vip_customer_total_mode'] == 'eq') $sql .= " AND c.vip_total = '" . (float)$data['filter_vip_customer_total'] . "'";
    }

    return $this->db->query($sql)->row['total'];
  } //getCustomersTotal end

  public function saveSettings($data=array()) {
    $this->model_setting_setting->editSetting('vip_customer', $this->request->post);

    $this->db->query("TRUNCATE " . DB_PREFIX . "vip_customer");

    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();

    if (isset($this->request->post['vip_level'])) {
      foreach ($this->request->post['vip_level'] as $vip_id => $v) {
        foreach ($v['name'] as $language_id => $name) {
          $this->db->query("INSERT INTO " . DB_PREFIX . "vip_customer SET vip_id='" . (int)$vip_id . "', name='" . $this->db->escape($name) . "', language_id='" . (int)$language_id . "', spending='" . (float)$v['spending'] . "', discount='" . (float)$v['discount'] . "', image='" . $this->db->escape($v['image']) . "'");
        }
      }
    }
  } //saveSettings end

  public function editVipInit() {
    $json = array();

    if (isset($this->request->post['customer_id']) && isset($this->request->post['vip_init'])) {
      $this->db->query("UPDATE " . DB_PREFIX . "customer SET vip_init='" . (float)$this->request->post['vip_init'] . "' WHERE customer_id='" . (int)$this->request->post['customer_id'] . "'");

      $vip = new vip_customer($this->registry);
      $vip->setVip($this->request->post['customer_id']);

      $json = $vip->getVip($this->request->post['customer_id']);
    }

    $this->response->setOutput(json_encode($json));
  } //changeVipInit end

  public function updateVip() {
    if (empty($this->request->get['customer_id'])) return;

    $vip = new vip_customer($this->registry);
    $vip->setVip($this->request->get['customer_id']);
  } //updateVip end

  protected function validate() {
    if (!$this->user->hasPermission('modify', 'extension/module/vip_customer')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }

    if (!$this->error) {
      return true;
    } else {
      return false;
    }
  } //validate end

  public function install() {
    $this->load->language('extension/module/vip_customer');

    $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "vip_customer (
      vip_id int(11) NOT NULL,
      language_id int(11) NOT NULL,
      name text NOT NULL,
      spending decimal(15,4) NOT NULL,
      discount decimal(15,4) NOT NULL,
      image text NOT NULL
    ) ENGINE=InnoDB COLLATE=utf8_general_ci");

    $this->load->model('extension/event');
    $this->model_extension_event->deleteEvent('vip_customer');

    $this->model_extension_event->addEvent('vip_customer', 'catalog/model/checkout/order/editOrder/after', 'extension/module/vip_customer/updateVip');
    $this->model_extension_event->addEvent('vip_customer', 'catalog/model/checkout/order/deleteOrder/after', 'extension/module/vip_customer/updateVip');
    $this->model_extension_event->addEvent('vip_customer', 'catalog/model/checkout/order/addOrderHistory/after', 'extension/module/vip_customer/updateVip');
    $this->model_extension_event->addEvent('vip_customer', 'catalog/controller/account/login/after', 'extension/module/vip_customer/login');

    $this->load->model('extension/extension');
    $this->load->model('user/user_group');
    $this->load->model('setting/setting');

    $this->model_extension_extension->uninstall('total', 'vip_total');
    $this->model_extension_extension->install('total', 'vip_total');

    $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/total/vip_total');
    $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/total/vip_total');

    $this->model_setting_setting->editSetting('vip_total', array(
      'vip_total_status' => 1,
      'vip_total_sort_order' => 2
    ));

    if (!$this->db->query("DESC " . DB_PREFIX . "customer vip_id")->num_rows) $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD vip_id int(11) NOT NULL");

    if (!$this->db->query("DESC " . DB_PREFIX . "customer vip_total")->num_rows) $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD vip_total float(15,4) NOT NULL");

    if (!$this->db->query("DESC " . DB_PREFIX . "customer vip_init")->num_rows) $this->db->query("ALTER TABLE " . DB_PREFIX . "customer ADD vip_init float(15,4) NOT NULL");

    $this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE type = 'total' AND code = 'vip_customer_total'");

    $this->session->data['success'] = $this->language->get('text_success');
    
    $this->db->query("UPDATE " . DB_PREFIX . "modification SET status = '1' WHERE `code` = 'vip_customer'");

    $this->response->redirect($this->url->link('module/vip_customer', 'token=' . $this->session->data['token'] . '&refreshModCache=1', 'SSL'));
  } //install end

  public function uninstall() {
    $this->db->query("DELETE FROM " . DB_PREFIX . "event WHERE code = 'vip_customer'");
    $this->db->query("UPDATE " . DB_PREFIX . "modification SET status = '0' WHERE `code` = 'vip_customer'");
	  $modification = $this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token']);
  } //uninstall end

} //class end
?>
