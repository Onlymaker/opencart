<style type="text/css">
.vip-customer .vip-badge {text-align: center;}
.vip-customer img {display: inline;}
.vip-customer table td {padding-right: 5px; padding-bottom: 2px; border-bottom: 1px solid #aaa;}
</style>
<div class="panel panel-default vip-customer">
  <div class="panel-heading panel-title"><?php echo $lng['heading_title']; ?></div>
  <div class="panel-body">
    <?php if ($customer && $customer['vip_status']) { ?>
    <table>
      <?php if ($customer['image']) { ?>
      <tr>
        <td colspan="2" class="vip-badge"><img src="<?php echo $customer['image']; ?>" alt="<?php echo $customer['vip_level']; ?>"></td>
      </tr>
      <?php } ?>
      <tr>
        <td><?php echo $lng['entry_level']?>:</td>
        <td><?php echo $customer['vip_level']; ?></td>
      </tr>
      <tr>
        <td><?php echo $lng['entry_discount']; ?>:</td>
        <td><?php echo $customer['discount']; ?>%</td>
      </tr>
      <?php if ($customer['vip_type'] != 'all' && $customer['vip_type'] != 'days') { ?>
      <tr>
        <td><?php echo $lng['entry_discount_end_date']; ?>:</td>
        <td><?php echo $customer['discount_end_date']; ?></td>
      </tr>
      <?php } ?>
      <tr><td colspan="2"></td></tr>
      <tr>
        <td><?php echo $lng['entry_vip_order']; ?>:</td>
        <td><?php echo $customer['total']; ?></td>
      </tr>
      <?php if ($customer['next_level']) { ?>
      <tr>
        <td><?php echo $lng['entry_next_level']; ?>:</td>
        <td><?php echo $customer['next_level']; ?></td>
      </tr>
      <tr>
        <td><?php echo $lng['entry_next_discount']; ?>:</td>
        <td><?php echo $customer['next_discount']; ?>%</td>
      </tr>
      <tr>
        <td><?php echo $lng['entry_amount_to_next']; ?>:</td>
        <td><?php echo $customer['amount_to_next']; ?></td>
      </tr>
      <?php } ?>
      <?php if ($customer['vip_type'] != 'all' && $customer['vip_type'] != 'days') { ?>
      <?php if ($customer['next_cutoff_date']) { ?>
      <tr>
        <td><?php echo $lng['entry_next_cutoff_date']; ?>:</td>
        <td><?php echo $customer['next_cutoff_date']; ?></td>
      </tr>
      <?php } ?>
      <?php if ($customer['next_start_date']) { ?>
      <tr>
        <td><?php echo $lng['entry_next_start_date']; ?>:</td>
        <td><?php echo $customer['next_start_date']; ?></td>
      </tr>
      <?php } ?>
      <?php } ?>
    </table>
    <?php if (isset($detail_url)) { ?>
    <div class="vip-detail-link"><a href="<?php echo $detail_url; ?>" target="_blank"><?php echo $lng['text_detail']; ?></a></div>
    <?php } ?>
    <?php } else echo $lng['text_vip_not_applicable']; ?>
  </div>
</div>
