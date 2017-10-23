<style type="text/css">
#vip-price-table {
  display: none;
}
.vip-price-table {
  font-size: 12px;
  margin: 10px 0px;
}
.vip-price-table table {
  border-collapse: collapse;
  border: 1px solid black;
}
.vip-price-table table td {
  border: 1px solid black;
  padding: 5px;
}
.vip-price-table > div {
  font-weight: bold;
}
</style>
<div id="vip-price-table"><div class="vip-price-table">
  <div><?php echo $lng['text_vip_prices']; ?></div>
  <table>
    <thead>
      <tr>
        <td><?php echo $lng['column_level']; ?></td>
        <td><?php echo ($show_price ? $lng['text_vip_price'] : $lng['column_discount']); ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($vip_prices as $r) { ?>
      <tr>
        <td><?php echo $r['vip_level']; ?></td>
        <td><?php echo ($show_price ? $r['price'] : $r['discount'] . '%')?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div></div>
<script type="text/javascript">
vip_price_table = $('#vip-price-table').html();
$('.vip-price-table').remove();
$('#product').before(vip_price_table);
</script>