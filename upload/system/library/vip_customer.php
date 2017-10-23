<?php
class vip_customer {
  private $registry;
  private $data = array();

  public function __construct($registry) {
    $this->registry = $registry;
    $this->config = $registry->get('config');
    $this->db = $registry->get('db');
    $this->request = $registry->get('request');
    $this->session = $registry->get('session');
    $this->log = $registry->get('log');
  } //construct end

  public function __get($name) {
    return $this->registry->get($name);
  } //get end

  public function __set($key, $value) {
    $this->registry->set($key, $value);
  }

  public function getLevels() {
    $vip_levels = array();

    $this->load->model('tool/image');

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vip_customer WHERE vip_id > 0 GROUP BY vip_id ORDER BY spending ASC");
    if ($query->num_rows) {
      foreach ($query->rows as $r) {
        foreach ($this->db->query("SELECT language_id, name FROM " . DB_PREFIX . "vip_customer WHERE vip_id = '" . (int)$r['vip_id'] . "'")->rows as $n) {
          $names[$n['language_id']] = $n['name'];
        }

        $vip_levels[$r['vip_id']] = $r;
        $vip_levels[$r['vip_id']]['image_link'] = $this->model_tool_image->resize(($r['image'] ? $r['image'] : 'no_image.png'), 100, 100);
        $vip_levels[$r['vip_id']]['name'] = $names;
      }
    }

    return $vip_levels;
  } //getLevels end

  public function getVip($customer_id = 0) {
    if (!$this->config->get('vip_customer_status')) {
      $this->db->query("UPDATE " . DB_PREFIX . "customer SET vip_id = 0, vip_total = 0");
      if ($this->config->get('vip_customer_log')) $this->log->write('vip_customer ' . __FUNCTION__ . ' extension is disabled.');
      return;
    }

    $vip_query = $this->db->query("SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS fullname, c.store_id, c.customer_group_id, c.email, vc.name AS vip_level, s.name AS store_name, s.url FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "vip_customer vc ON c.vip_id = vc.vip_id LEFT JOIN " . DB_PREFIX . "store s ON c.store_id = s.store_id WHERE vc.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.customer_id = '" . (int)$customer_id . "'");

    if ($vip_query->num_rows) {
      $current = $vip_query->row;
    } else {
      if ($this->config->get('vip_customer_log')) $this->log->write('vip_customer ' . __FUNCTION__ . ' No current VIP data.');
      return;
    }

    if (!$current['store_name']) $current['store_name'] = $this->db->query("SELECT value FROM " . DB_PREFIX . "setting WHERE `key` = 'config_name' AND store_id = '" . (int)$current['store_id'] . "'")->row['value'];
    if (!$current['url']) $current['url'] = HTTP_SERVER;

    $vip_status = in_array($current['store_id'], $this->config->get('vip_customer_store')) && in_array($current["customer_group_id"], $this->config->get('vip_customer_group')) && $this->config->get('config_complete_status') ? 1 : 0;

    $current_end_date = '';
    switch ($this->config->get('vip_customer_type')) {
      case 'annually':
        $daterange = $this->getDateRange('annually', $this->config->get('vip_customer_current_period'));
        $current_end_date = $daterange[3];
        break;
      case 'semiannually':
        $daterange = $this->getDateRange('semiannually', $this->config->get('vip_customer_current_period'));
        $current_end_date = $daterange[3];
        break;
      case 'quarterly':
        $daterange = $this->getDateRange('quarterly', $this->config->get('vip_customer_current_period'));
        $current_end_date = $daterange[3];
        break;
      case 'monthly':
        $daterange = $this->getDateRange('monthly', $this->config->get('vip_customer_current_period'));
        $current_end_date = $daterange[3];
    }

    $next_start_date = $current_end_date ? date('Y-m-d', strtotime($current_end_date) + 1) . ' 00:00:00' : '';

    $date_format = $this->config->get('vip_customer_date_format') ? $this->config->get('vip_customer_date_format') : 'Y-m-d h:i:s';

    $next = array();
    $next_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vip_customer WHERE spending > '" . (float)$current['vip_total'] . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY spending ASC");
    if ($next_query->num_rows) $next = $next_query->row;

    $this->load->model('tool/image');

    $customer_data = array(
      'vip_status' => $vip_status,
      'vip_type' => $this->config->get('vip_customer_type'),
      'customer_id' => $current['customer_id'],
      'fullname' => $current['fullname'],
      'firstname' => $current['firstname'],
      'lastname' => $current['lastname'],
      'vip_id' => $current['vip_id'],
      'vip_init' => $current['vip_init'],
      'store_id' => $current['store_id'],
      'customer_group_id' => $current['customer_group_id'],
      'vip_level' => $current['vip_level'],
      'discount' => $current['discount'],
      'image' => $this->model_tool_image->resize($current['image'], 100, 100),
      'spending' => $this->currency->format($current['spending'], $this->session->data['currency']),
      'total' => $this->currency->format($current['vip_total'], $this->session->data['currency']),
      'discount_end_date' => date($date_format, strtotime($current_end_date)),
      'next_id' => ($next ? $next['vip_id'] : 0),
      'next_level' => ($next ? $next['name'] : ''),
      'next_discount' => ($next ? $next['discount'] : ''),
      'next_start_date' => date($date_format, strtotime($next_start_date)),
      'next_cutoff_date' => date($date_format, strtotime($current_end_date)),
      'next_image' => ($next ? $this->model_tool_image->resize($next['image'], 100, 100) : ''),
      'next_spending' => ($next ? $this->currency->format($next['spending'], $this->session->data['currency']) : ''),
      'amount_to_next' => ($next ? $this->currency->format($next['spending'] - $current['vip_total'], $this->session->data['currency']) : ''),
      'email' => $current['email'],
      'store_name' => $current['store_name'],
      'store_url' => $current['url']
    );

    return $customer_data;
  } //getVip end

  public function setVip($customer_id = 0) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

    if ($query->num_rows) {
      $customer = $query->row;
    } else {
      if ($this->config->get('vip_customer_log')) $this->log->write('vip_customer ' . __FUNCTION__ . ' customer query is emptied');
      return;
    }

    if (!$this->config->get('vip_customer_status')) {
      $this->db->query("UPDATE " . DB_PREFIX . "customer SET vip_id = 0, vip_total = 0");
      if ($this->config->get('vip_customer_log')) $this->log->write('vip_customer ' . __FUNCTION__ . ' is disabled');
      return;
    }

    if (!$this->config->get('vip_customer_group') || !$this->config->get('vip_customer_store') || !in_array($customer['customer_group_id'], $this->config->get('vip_customer_group')) || !in_array($customer['store_id'], $this->config->get('vip_customer_store'))) {
      $this->db->query("UPDATE " . DB_PREFIX . "customer SET vip_id = 0, vip_total = 0 WHERE customer_id = '" . (int)$customer_id . "'");
      if ($this->config->get('vip_customer_log')) $this->log->write('vip_customer ' . __FUNCTION__ . ' ' . $customer['fullname'] . ' vip_id set to 0 because customer group or store or order status are emptied or customer does not belong to customer group or store.');
      return;
    }

    $daterange = $this->getDateRange($this->config->get('vip_customer_type'), $this->config->get('vip_customer_current_period'));
    $vip_datequery = empty($daterange) ? 1 : "o.date_added BETWEEN '" . $daterange[0] . "' AND '" . $daterange[1] . "'";
    $datequery = empty($daterange) ? 1 : "o.date_added BETWEEN '" . $daterange[2] . "' AND '" . $daterange[3] . "'";

    $totals[] = "'sub_total'";
    if ($this->config->get('vip_customer_shipping')) $totals[] = "'shipping'";
    if ($this->config->get('vip_customer_tax')) $totals[] = "'tax'";
    if ($this->config->get('vip_customer_credit')) $totals[] = "'credit'";
    if ($this->config->get('vip_customer_reward')) $totals[] = "'reward'";
    if ($this->config->get('vip_customer_coupon')) $totals[] = "'coupon'";

    $orderstatusquery = "o.order_status_id IN (" . implode(',', $this->config->get('config_complete_status')) . ")";

    $vip_ordertotal = $this->db->query("SELECT SUM(ot.value) AS total FROM " . DB_PREFIX . "order_total ot JOIN `" . DB_PREFIX . "order` o ON ot.order_id=o.order_id WHERE o.customer_id = '" . (int)$customer_id . "' AND code IN (" . implode(',', $totals) . ") AND (" . $vip_datequery . ") AND (" . $orderstatusquery . ")")->row['total'] + $customer['vip_init'];

    $ordertotal = $this->db->query("SELECT SUM(ot.value) AS total FROM " . DB_PREFIX . "order_total ot JOIN `" . DB_PREFIX . "order` o ON ot.order_id=o.order_id WHERE o.customer_id = '" . (int)$customer_id . "' AND code IN (" . implode(',', $totals) . ") AND (" . $datequery . ") AND (" . $orderstatusquery . ")")->row['total'] + $customer['vip_init'];

    $vip_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vip_customer WHERE spending <= '" . (float)$vip_ordertotal . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY spending DESC");
    $vip_id = $vip_query->num_rows ? $vip_query->row['vip_id'] : 0;

    $this->db->query("UPDATE " . DB_PREFIX . "customer SET vip_id = '" . (int)$vip_id . "', vip_total = '" . (float)$ordertotal . "' WHERE customer_id = '" . (int)$customer_id . "'");
    if ($this->config->get('vip_customer_log')) $this->log->write('vip_customer ' . __FUNCTION__ . ' ' . $customer['firstname'] . ' ' . $customer['lastname'] . ' vip status change to ' . ($vip_query->num_rows ? $vip_query->row['name'] : '__none__'));

    if ($vip_id != $customer['vip_id']) {
      $this->sendNotification($customer_id);
    }

    if (isset($this->request->get['test'])) {
      $this->sendNotification($customer_id);
    }
  } //setVip end

  public function getDetail($customer_id = 0, $vip_period = '') {
    $detail_data = array();

    $daterange = $this->getDateRange($this->config->get('vip_customer_type'), $this->config->get('vip_customer_current_period'));

    if ($vip_period == 'next') {
      $datequery = empty($daterange) ? 1 : "o.date_added BETWEEN '" . $daterange[2] . "' AND '" . $daterange[3] . "'";
      $detail_data['date']['range'] = empty($daterange) ? $this->language->get('text_all_date_range') : date($this->language->get('date_format_short'), strtotime($daterange[2])) . ' - ' . date($this->language->get('date_format_short'), strtotime($daterange[3]));
    } else {
      $datequery = empty($daterange) ? 1 : "o.date_added BETWEEN '" . $daterange[0] . "' AND '" . $daterange[1] . "'";
      $detail_data['date']['range'] = empty($daterange) ? $this->language->get('text_all_date_range') : date($this->language->get('date_format_short'), strtotime($daterange[0])) . ' - ' . date($this->language->get('date_format_short'), strtotime($daterange[1]));
    }

    $detail_data['date']['start'] = $daterange ? date($this->language->get('date_format_short'), strtotime($daterange[3] ) + 1) : '';

    $totals[] = "'sub_total'";
    if ($this->config->get('vip_customer_shipping')) $totals[] = "'shipping'";
    if ($this->config->get('vip_customer_tax')) $totals[] = "'tax'";
    if ($this->config->get('vip_customer_credit')) $totals[] = "'credit'";
    if ($this->config->get('vip_customer_reward')) $totals[] = "'reward'";
    if ($this->config->get('vip_customer_coupon')) $totals[] = "'coupon'";

    $order_sub_total = 0;
    $vip_sub_total = 0;

    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id IN (" . implode(',', $this->config->get('config_complete_status')) . ") AND (" . $datequery . ") AND o.customer_id = '" . (int)$customer_id . "' ORDER BY date_added ASC");

    foreach ($query->rows as $r) {
      $vip_total = $this->db->query("SELECT SUM(value) AS total FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$r['order_id'] . "' AND code IN (" . implode(',', $totals) . ")")->row['total'];

      $vip_sub_total += $vip_total;
      $order_sub_total += $r['total'];

      $detail_data[$r['order_id']] = array(
        'order_id' => $r['order_id'],
        'order_date' => date($this->language->get('date_format_short'), strtotime($r['date_added'])),
        'order_total' => $r['total'],
        'order_sub_total' => $order_sub_total,
        'vip_total' => $vip_total,
        'vip_sub_total' => $vip_sub_total
      );
    }
    return $detail_data;
  } //getDetail end

  public function getDateRange($type = '', $current_period = 0) {
    $daterange = array();

    if ($type == 'annually') {
      $daterange[2] = date('Y') . '-01-01 00:00:00';
      $daterange[3] = date('Y') . '-12-31 23:59:59';
      $daterange[0] = $current_period ? $daterange[2] : date('Y')-1 . '-01-01 00:00:00';
      $daterange[1] = $current_period ? $daterange[3] : date('Y')-1 . '-12-31 23:59:59';
    } elseif ($type == 'semiannually') {
      if (date('m') > 6) {
        $daterange[2] = date('Y') . '-07-01 00:00:00';
        $daterange[3] = date('Y') . '-12-31 23:59:59';
        $daterange[0] = $current_period ? $daterange[2] : date('Y') . '-01-01 00:00:00';
        $daterange[1] = $current_period ? $daterange[3] : date('Y') . '-06-30 23:59:59';
      } else {
        $daterange[2] = date('Y') . '-01-01 00:00:00';
        $daterange[3] = date('Y') . '-06-30 23:59:59';
        $daterange[0] = $current_period ? $daterange[2] : date('Y')-1 . '-07-01 00:00:00';
        $daterange[1] = $current_period ? $daterange[3] : date('Y')-1 . '-12-31 23:59:59';
      }
    } elseif ($type == 'monthly') {
      $daterange[2] = date('Y-m-d', strtotime('first day of this month')) . ' 00:00:00';
      $daterange[3] = date('Y-m-d', strtotime('last day of this month')) . ' 23:59:59';
      $daterange[0] = $current_period ? $daterange[2] : date('Y-m-d', strtotime('first day of last month')) . ' 00:00:00';
      $daterange[1] = $current_period ? $daterange[3] : date('Y-m-d', strtotime('last day of last month')) . ' 23:59:59';
    } elseif ($type == 'quarterly') {
      $q0 = ceil(date('m')/3);
      if ($q0 == 1) {
        $daterange[2] = date('Y') . '-01-01 00:00:00';
        $daterange[3] = date('Y') . '-03-31 23:59:59';
        $daterange[0] = $current_period ? $daterange[2] : date('Y')-1 . '-10-01 00:00:00';
        $daterange[1] = $current_period ? $daterange[3] : date('Y')-1 . '-12-31 23:59:59';
      } elseif ($q0 == 2) {
        $daterange[2] = date('Y') . '-04-01 00:00:00';
        $daterange[3] = date('Y') . '-06-31 23:59:59';
        $daterange[0] = $current_period ? $daterange[2] : date('Y') . '-01-01 00:00:00';
        $daterange[1] = $current_period ? $daterange[3] : date('Y') . '-03-31 23:59:59';
      } elseif ($q0 == 3) {
        $daterange[2] = date('Y') . '-07-01 00:00:00';
        $daterange[3] = date('Y') . '-09-30 23:59:59';
        $daterange[0] = $current_period ? $daterange[2] : date('Y') . '-04-01 00:00:00';
        $daterange[1] = $current_period ? $daterange[3] : date('Y') . '-06-31 23:59:59';
      } elseif ($q0 == 4) {
        $daterange[2] = date('Y') . '-10-01 00:00:00';
        $daterange[3] = date('Y') . '-12-31 23:59:59';
        $daterange[0] = $current_period ? $daterange[2] : date('Y') . '-07-01 00:00:00';
        $daterange[1] = $current_period ? $daterange[3] : date('Y') . '-09-30 23:59:59';
      }
    } elseif ($type == 'days') {
      $daterange[0] = $daterange[2] = date('Y-m-d', strtotime('today') - $this->config->get('vip_customer_days_from_today') * 86400) . ' 00:00:00';
      $daterange[1] = $daterange[3] = date('Y-m-d') . ' 23:59:59';
    }

    return $daterange;
  } //getDateRange end

  public function getStore($store_id=0) {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store WHERE store_id = '" . (int)$store_id . "'");
    if ($query->num_rows) {
      $store['name'] = $query->row['name'];
      $store['url'] = $query->row['url'];
      $store['logo'] = $this->config->get('config_logo') ? $store['url'] . 'image/' . $this->config->get('config_logo') : '';
    } else {
      $store['name'] = $this->config->get('config_name');
      $store['url'] = defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER;
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `key` = 'config_logo'");
      $store['logo'] = $query->num_rows ? $store['url'] . 'image/' . $query->row['value'] : '';
    }
    return $store;
  } //getStore end

  public function sendNotification($customer_id = 0) {
    if (!$customer_id) return;

    $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE customer_id = '" . (int)$customer_id . "' ORDER BY order_id DESC LIMIT 1");
    $language_id = $order_query->num_rows ? $order_query->row['language_id'] : 1;

    $vip_query = $this->db->query("SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS fullname, c.store_id, c.customer_group_id, c.email, vc.name AS vip_level, s.name AS store_name, s.url FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "vip_customer vc ON c.vip_id = vc.vip_id LEFT JOIN " . DB_PREFIX . "store s ON c.store_id = s.store_id WHERE vc.language_id = '" . (int)$language_id . "' AND c.customer_id = '" . (int)$customer_id . "'");
    if ($vip_query->num_rows) $customer = $vip_query->row;
    else return;

    $lng = $this->loadCatalogLanguage('extension/module/vip_customer', $language_id);

    $store = $this->getStore($customer['store_id']);

    $emails = array();

    if ($this->config->get('vip_customer_email_admin')) {
      if ($this->config->get('config_mail_alert_email')) $emails = explode(',', $this->config->get('config_mail_alert_email'));
      $emails[] = $this->config->get('config_email');
    }

    if ($this->config->get('vip_customer_email_customer') || isset($this->request->get['test'])) {
      $emails[] = $customer['email'];
    }

    if ($emails) {
      $find = array(
        '{store_url}',
        '{store_logo}',
        '{store_name}',
        '{customer_firstname}',
        '{customer_lastname}',
        '{vip_image}',
        '{vip_level}',
        '{vip_discount}'
      );

      $replace = array(
        $store['url'],
        $store['logo'],
        $store['name'],
        $customer['firstname'],
        $customer['lastname'],
        $store['url'] . basename(DIR_IMAGE) . '/' . $customer['image'],
        $customer['vip_level'],
        $customer['discount']
      );

      $email_content = str_replace($find, $replace, $lng['email_content']);
      $email_subject = html_entity_decode(str_replace('{store_name}', $store['name'], $lng['email_subject']), ENT_QUOTES, 'UTF-8');

      if (isset($this->request->get['test'])) die($email_subject . '<br/>' . $email_content);

      $mail = new Mail();
      $mail->protocol = $this->config->get('config_mail_protocol');
      $mail->parameter = $this->config->get('config_mail_parameter');
      $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
      $mail->smtp_username = $this->config->get('config_mail_smtp_username');
      $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
      $mail->smtp_port = $this->config->get('config_mail_smtp_port');
      $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

      $mail->setFrom($this->config->get('config_email'));
      $mail->setSender(html_entity_decode($store['name'], ENT_QUOTES, 'UTF-8'));
      $mail->setSubject($email_subject);
      $mail->setHtml($email_content);

      foreach ($emails as $email) {
        $email = trim($email);
        if ($email && preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $email)) {
          $mail->setTo($email);
          $mail->send();
          if ($this->config->get('vip_customer_log')) $this->log->write('vip_customer ' . __FUNCTION__ . ' email sent to ' . $email);
        }
      }
    }
  } //sendNotification end

  private function loadCatalogLanguage($filename = '', $language_id = 1) {
    $_ = array();

    $file = DIR_SYSTEM . '../catalog/language/english/' . $filename . '.php';

    if (file_exists($file)) {
      require($file);
    }

    $file = DIR_SYSTEM . '../catalog/language/en-gb/' . $filename . '.php';

    if (file_exists($file)) {
      require($file);
    }

    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE language_id = '" . (int)$language_id . "'");
    if ($query->num_rows) {
      $file = DIR_SYSTEM . '../catalog/language/' . $query->row['directory'] . '/' . $filename . '.php';
    }

    if (file_exists($file)) {
      require($file);
    }

    $this->data = array_merge($this->data, $_);

    return $this->data;
  } //loadCatalogLanguage end

} //class end
?>
