<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
    
    
    
    
  <h3><?php echo $text_your_balance;?> <strong style="color: green"><?php echo $actual_currency['symbol_left'].$my_balance.$actual_currency['symbol_right']; ?></strong></h3>
  <i><?php echo $text_link_referrer.' '.$shop_url.'index.php?route=account/register&amp;ref='.$customer_id;?></i>
  <br /><br />
  <div class="fb-send" style="float: left; margin-top: 2px; margin-right: 10px;" data-href="<?php echo $shop_url.'index.php?route=account/register&amp;ref='.$customer_id;?>"></div>


<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo $shop_url;?>index.php?route=account/referrers"></div>

<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>


  <br /><br />
  <h2><?php echo $text_direct_referrers; ?></h2>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="left"><?php echo $text_referer_name; ?></td>
        <td class="left"><?php echo $text_referer_register; ?></td>
        <td class="left"><?php echo $text_num_of_purchases; ?></td>
        <td class="right"><?php echo $text_profit; ?></td>
      </tr>
    </thead>
    <tbody>
    <?php
      if($dirrect_referrers){
        foreach($dirrect_referrers as $referrer){?>
      <tr>
        <td class="left"><?php echo $referrer['firstname'].' '.$referrer['lastname']; ?></td>
        <td class="left"><?php echo $referrer['date_added']; ?></td>
        <td class="right"><?php echo $all_purchases[$referrer['customer_id']]; ?></td>
        <td class="right"><?php echo $actual_currency['symbol_left'].$all_points[$referrer['customer_id']].$actual_currency['symbol_right'];?></td>
      </tr>
    <?php
        }
      }else{
    ?>
      <tr>
        <td class="center" colspan="4"><?php echo $text_no_referrers; ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  
  
  <br /><br />
  
  
  <h2><?php echo $text_sub_referrers; ?></h2>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="left"><?php echo $text_referer_name; ?></td>
        <td class="left"><?php echo $text_referer_register; ?></td>
        <td class="left"><?php echo $text_num_of_purchases; ?></td>
        <td class="right"><?php echo $text_profit; ?></td>
      </tr>
    </thead>
    <tbody>
    <?php
      if($sub_referrers){
        foreach($sub_referrers as $referrer){?>
      <tr>
        <td class="left"><?php echo $referrer['firstname'].' '.$referrer['lastname']; ?></td>
        <td class="left"><?php echo $referrer['date_added']; ?></td>
        <td class="right"><?php echo $all_purchases[$referrer['customer_id']]; ?></td>
        <td class="right"><?php echo $actual_currency['symbol_left'].$all_points[$referrer['customer_id']].$actual_currency['symbol_right'];?></td>
      </tr>
    <?php
        }
      }else{
    ?>
      <tr>
        <td class="center" colspan="4"><?php echo $text_no_referrers; ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>


    
    
    
    
    
    
    
    
    
    
    </div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>