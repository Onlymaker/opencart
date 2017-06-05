<?php echo $header; 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config'); 
include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/themeglobal/themeglobal_top.tpl'); ?>

<?php echo $text_message; ?>
<div class="buttons">
  <div class="pull-right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
</div>

<?php include('catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/template/themeglobal/themeglobal_bottom.tpl'); ?>
<?php echo $footer; ?>

<?php if (isset($feedback)) { ?>
<script type="text/javascript">
  var google_conversion_id = 939341970;
  var google_conversion_language = "en";
  var google_conversion_format = "3";
  var google_conversion_color = "ffffff";
  var google_conversion_label = "aYsDCLSd3WsQkvH0vwM";
  var google_conversion_value = "<?php echo $total; ?>";
  var google_conversion_currency = "<?php echo $currency; ?>";
  var google_remarketing_only = false;
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
<noscript>
  <div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/939341970/?value=<?php echo $total; ?>&amp;currency_code=<?php echo $currency; ?>&amp;label=aYsDCLSd3WsQkvH0vwM&amp;guid=ON&amp;script=0"/>
  </div>
</noscript>
<?php } ?>

<?php if (isset($webgainsUrl)) echo $webgainsUrl; ?>
