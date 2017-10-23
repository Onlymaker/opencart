<?php
class ModelExtensionTotalVipTotal extends Model {
  public function getTotal($total) {
    if (!$this->config->get('vip_customer_status')) return;

    $this->load->language('extension/module/vip_customer');

    $vip = new vip_customer($this->registry);
    $customer = $vip->getVip($this->customer->getId());

    if ($customer) {
      $discount_total = 0;

      foreach ($this->cart->getProducts() as $product) {
        $discount = 0;
        $product_id = $product["product_id"];
        $customer_group_id = $this->customer->getGroupId();

        if (!$this->config->get('vip_customer_discount_product')) {
          $discount_quantity = 0;

          $product_discount_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount pd JOIN " . DB_PREFIX . "cart c ON pd.product_id = c.product_id WHERE c.product_id = '" . (int)$product_id . "' AND c.customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND pd.customer_group_id = '" . (int)$customer_group_id . "' AND pd.quantity <= c.quantity AND ((pd.date_start = '0000-00-00' OR pd.date_start < NOW()) AND (pd.date_end = '0000-00-00' OR pd.date_end > NOW())) ORDER BY pd.quantity DESC, pd.priority ASC, pd.price ASC LIMIT 1");

          if ($product_discount_query->num_rows) continue;
        }

        if (!$this->config->get('vip_customer_special_product')) {
          $product_special_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

          if ($product_special_query->num_rows) continue;
        }

        $discount = $product['total'] / 100 * $customer['discount'];

        if ($product['tax_class_id']) {
          $tax_rates = $this->tax->getRates($product['total'] - ($product['total'] - $discount), $product['tax_class_id']);

          foreach ($tax_rates as $tax_rate) {
            if ($tax_rate['type'] == 'P') {
              $total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
            }
          }
        }

        $discount_total += $discount;
      }

      $total['totals'][] = array(
        'code'       => 'vip_total',
        'title'      => str_replace('{vip_discount}', $customer['discount'] . '%', $this->language->get('text_vip_discount_total')),
        'value'      => -$discount_total,
        'sort_order' => $this->config->get('vip_total_sort_order')
      );

      $total['total'] -= $discount_total;
    }
  } //gettotal end

  public function confirm($order_info, $order_total) {
    $vip = new vip_customer($this->registry);
    $vip->setVip($order_info['customer_id']);
  } //confirm end

  public function unconfirm($order_id) {
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
    if ($query->num_rows) {
      $vip = new vip_customer($this->registry);
      $vip->setVip($query->row['customer_id']);
    }
  } //unconfirm end

} //class end
?>
