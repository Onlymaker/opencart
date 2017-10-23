<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $heading_title; ?></title>
<style type="text/css">
body {width:680px;}
table {border-collapse: collapse;}
.border th, .border td {border:1 px solid grey;}
th, td {padding: 2px 10px;}
.right {text-align: right;}
.total td {font-weight: bold; border-top: 2px solid black;}
.content {border: 1px solid grey; padding: 10px; margin: 20px 0;}
.heading {font-weight: bold; font-size: large; margin: 5px 0;}
</style>
</head>
<body>
<div><a href="<?php echo $store['url']; ?>" title="<?php echo $store['name']; ?>"><img src="<?php echo $store['logo']; ?>" alt="<?php echo $store['name']; ?>" /></a></div>
<?php echo $date; ?>
<h1><?php echo $heading_title; ?></h1>
<?php if ($customer['vip_id'] == -1) echo $lng['text_vip_not_applicable']; else { ?>
<div class="content">
  <div class="heading"><?php echo $lng['text_vip_summary']; ?></div>
  <div><?php echo $vip_summary; ?></div>
</div>
<div class="content">
  <div class="heading"><?php echo $lng['text_vip_levels']; ?></div>
  <table class="border">
    <tr>
      <th><?php echo $lng['column_level']; ?></th>
      <th><?php echo $lng['column_spending']; ?></th>
      <th><?php echo $lng['column_discount']; ?></th>
    </tr>
    <?php foreach ($vip_levels as $v) { ?>
    <tr>
      <td><?php echo $v['name'][$language_id]; ?></td>
      <td class="right"><?php echo $v['spending']; ?></td>
      <td class="right"><?php echo $v['discount']; ?>%</td>
    </tr>
    <?php } ?>
  </table>
</div>
<div class="content">
  <div class="heading"><?php echo $lng['text_vip_generals']; ?></div>
  <table>
    <tr>
      <td><?php echo $lng['entry_spending_type']; ?></td>
      <td><?php echo ($setting['vip_customer_type'] == 'days' ? $setting['vip_customer_days_from_today'] . ' ' . $setting['vip_customer_type'] : $setting['vip_customer_type']); ?></td>
    </tr>
    <tr>
      <td><?php echo $lng['entry_shipping']; ?></td>
      <td><?php echo (isset($setting['vip_customer_shipping']) ? $lng['text_yes'] : $lng['text_no']); ?></td>
    </tr>
    <tr>
      <td><?php echo $lng['entry_tax']; ?></td>
      <td><?php echo (isset($setting['vip_customer_tax']) ? $lng['text_yes'] : $lng['text_no']); ?></td>
    </tr>
    <tr>
      <td><?php echo $lng['entry_credit']; ?></td>
      <td><?php echo (isset($setting['vip_customer_credit']) ? $lng['text_yes'] : $lng['text_no']); ?></td>
    </tr>
    <tr>
      <td><?php echo $lng['entry_reward']; ?></td>
      <td><?php echo (isset($setting['vip_customer_reward']) ? $lng['text_yes'] : $lng['text_no']); ?></td>
    </tr>
    <tr>
      <td><?php echo $lng['entry_coupon']; ?></td>
      <td><?php echo (isset($setting['vip_customer_coupon']) ? $lng['text_yes'] : $lng['text_no']); ?></td>
    </tr>
  </table>
</div>
<div class="content">
  <div class="heading"><?php echo $lng['text_detail_current']; ?></div>
  <table class="border">
    <tr>
      <th><?php echo $lng['column_order_id']; ?></th>
      <th><?php echo $lng['column_order_date']; ?></th>
      <th><?php echo $lng['column_order_total']; ?></th>
      <th><?php echo $lng['column_vip_amt']; ?></th>
      <th><?php echo $lng['column_total']; ?></th>
      <th><?php echo $lng['column_level']; ?></th>
    </tr>
    <tr>
      <td colspan="4" class="right"><?php echo $lng['column_vip_init']; ?></td>
      <td class="right"><?php echo $customer['vip_init']; ?></td>
      <td>
        <?php foreach (array_reverse($vip_levels) as $v) { ?>
        <?php if ($customer['vip_init'] >= $v['spending']) { ?>
        <?php echo $v['name'][$language_id]; break; ?>
        <?php } ?>
        <?php } ?>
      </td>
    </tr>
    <?php foreach ($vip_data as $r) { ?>
    <tr>
      <td class="right"><?php echo $r['order_id']; ?></td>
      <td><?php echo $r['order_date']; ?></td>
      <td class="right"><?php echo $r['order_total']; ?></td>
      <td class="right"><?php echo $r['vip_total']; ?></td>
      <td class="right"><?php echo $r['vip_sub_total'] + $customer['vip_init']; ?></td>
      <td>
        <?php foreach (array_reverse($vip_levels) as $v) { ?>
        <?php if ($r['vip_sub_total'] >= $v['spending']) { ?>
        <?php echo $v['name'][$language_id]; break; ?>
        <?php } ?>
        <?php } ?>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>
<?php if (strtolower($setting['vip_customer_type']) != 'all' && $setting['vip_customer_type'] != 'days' && empty($setting['vip_customer_current_period'])) { ?>
<div class="content">
  <div class="heading"><?php echo $lng['text_detail_next']; ?></div>
  <span><?php echo $lng['text_vip_start_date']; ?></span>
  <table class="border">
    <tr>
      <th><?php echo $lng['column_order_id']; ?></th>
      <th><?php echo $lng['column_order_date']; ?></th>
      <th><?php echo $lng['column_order_total']; ?></th>
      <th><?php echo $lng['column_vip_amt']; ?></th>
      <th><?php echo $lng['column_total']; ?></th>
      <th><?php echo $lng['column_level']; ?></th>
    </tr>
    <tr>
      <td colspan="4" class="right"><?php echo $lng['column_vip_init']; ?></td>
      <td class="right"><?php echo $customer['vip_init']; ?></td>
      <td>
        <?php foreach (array_reverse($vip_levels) as $v) { ?>
        <?php if ($customer['vip_init'] >= $v['spending']) { ?>
        <?php echo $v['name'][$language_id]; break; ?>
        <?php } ?>
        <?php } ?>
      </td>
    </tr>
    <?php foreach ($vip_data_next as $r) { ?>
    <tr>
      <td class="right"><?php echo $r['order_id']; ?></td>
      <td><?php echo $r['order_date']; ?></td>
      <td class="right"><?php echo $r['order_total']; ?></td>
      <td class="right"><?php echo $r['vip_total']; ?></td>
      <td class="right"><?php echo $r['vip_sub_total'] + $customer['vip_init']; ?></td>
      <td>
        <?php foreach (array_reverse($vip_levels) as $v) { ?>
        <?php if ($r['vip_sub_total'] >= $v['spending']) { ?>
        <?php echo $v['name'][$language_id]; break; ?>
        <?php } ?>
        <?php } ?>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>
<?php } ?>
<?php } ?>
</body>
</html>
