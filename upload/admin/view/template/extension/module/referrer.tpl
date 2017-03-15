<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<style type="text/css">
  .form-group label small {font-weight: normal;font-size: 10px;}
  .col-sm-2 {width: 18.6667%;min-height: 43px;padding-top: 0px;padding-bottom: 0px;}
  .col-sm-10 {width: 81.3333%;padding: 14px 0px;}
  .col-sm-10 select,.col-sm-10 input[type=text] {width: auto !important;display: inline-block;margin: 0px 5px;min-width: 100px;}
  .form-group {margin: 0px;border-bottom: 1px dotted #e8e8e8;}
  .table .form-control {width: auto;display: inline-block;margin: 0px 5px;}
</style>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-referrer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

  <form action="<?php echo $action; ?>" method="post" id="form-referrer" class="form-horizontal">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="profit_type_percentage"><?php echo $text_profit_type; ?></label>
            <div class="col-sm-10">
              <input type="radio" name="referrer_profit_type" value="percentage" id="profit_type_percentage" <?php if(isset($value_referrer['referrer_profit_type']) AND $value_referrer['referrer_profit_type'] == 'percentage'){echo ' checked="checked"';}?> />&nbsp;<label for="profit_type_percentage"><?php echo $text_percentage;?></label>&nbsp;
              <input type="radio" name="referrer_profit_type" value="fixed" id="profit_type_fixed" <?php if(!isset($value_referrer['referrer_profit_type']) || $value_referrer['referrer_profit_type'] == 'fixed'){echo ' checked="checked"';}?> />&nbsp;<label for="profit_type_fixed"><?php echo $text_fixed;?></label>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="order_price_1"><?php echo $text_higher_total; ?></label>
            <div class="col-sm-10">
              <input type="radio" name="referrer_order_price" value="1" id="order_price_1" onClick="switchOrderPrice();"<?php if(isset($value_referrer['referrer_order_price']) AND $value_referrer['referrer_order_price'] == 1){echo ' checked="checked"';}?> />&nbsp;<label for="order_price_1"><?php echo $text_yes;?></label>&nbsp;
              <input type="radio" name="referrer_order_price" value="0" id="order_price_0" onClick="switchOrderPrice();"<?php if(!isset($value_referrer['referrer_order_price']) || $value_referrer['referrer_order_price'] == 0){echo ' checked="checked"';}?> />&nbsp;<label for="order_price_0"><?php echo $text_no;?></label>
            </div>
          </div>
          <div class="form-group required" id="min_order_price">
            <label class="col-sm-2 control-label" for="min_order_price"><?php echo $text_min_order_total; ?></label>
            <div class="col-sm-10">
              <?php echo $primary_currency['symbol_left'];?><input type="text" name="referrer_min_order_price" class="form-control" id="min_order_price" value="<?php if(isset($value_referrer['referrer_min_order_price'])){echo $value_referrer['referrer_min_order_price'];}?>" size="7" /><?php echo $primary_currency['symbol_right'];?>
            </div>
          </div>


          <div class="form-group required" id="min_order_price">
            <label class="col-sm-2 control-label" for="referrer_level"><?php echo $text_ref_levels; ?></label>
            <div class="col-sm-10">
              <select name="referrer_level" id="referrer_level" class="form-control" onChange="setRefProfit();">
              <?php
                $i = 1;
                WHILE($i<=10){
                  if(isset($value_referrer['referrer_level']) AND $i == $value_referrer['referrer_level']){$selected = ' selected="selected"';}
                  else{$selected = '';}
                  echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
                  $i++;
                }
              ?>
              </select>
            </div>
          </div>
          <div class="form-group required" style="display: none;">
            <label class="col-sm-2 control-label" for="ref_product_link_1"><?php echo $text_ref_product_link; ?></label>
            <div class="col-sm-10">
              <input type="radio" name="referrer_ref_product_link" value="1" id="referrer_ref_product_link_1" onClick="switchOrderPrice();"<?php if(isset($value_referrer['referrer_ref_product_link']) AND $value_referrer['referrer_ref_product_link'] == 1){echo ' checked="checked"';}?> />&nbsp;<label for="ref_product_link_1"><?php echo $text_yes;?></label>&nbsp;
              <input type="radio" name="referrer_ref_product_link" value="0" id="referrer_ref_product_link_0" onClick="switchOrderPrice();"<?php if(!isset($value_referrer['referrer_ref_product_link']) || $value_referrer['referrer_ref_product_link'] == 0){echo ' checked="checked"';}?> />&nbsp;<label for="ref_product_link_0"><?php echo $text_no;?></label>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="ref_compulsory_reg_1"><?php echo $text_ref_compulsory_reg; ?></label>
            <div class="col-sm-10">
              <input type="radio" name="referrer_ref_compulsory_reg" value="1" id="" onClick="switchOrderPrice();"<?php if(isset($value_referrer['referrer_ref_compulsory_reg']) AND $value_referrer['referrer_ref_compulsory_reg'] == 1){echo ' checked="checked"';}?> />&nbsp;<label for="ref_compulsory_reg_1"><?php echo $text_yes;?></label>&nbsp;
              <input type="radio" name="referrer_ref_compulsory_reg" value="0" id="ref_compulsory_reg_0" onClick="switchOrderPrice();"<?php if(!isset($value_referrer['referrer_ref_compulsory_reg']) || $value_referrer['referrer_ref_compulsory_reg'] == 0){echo ' checked="checked"';}?> />&nbsp;<label for="ref_compulsory_reg_0"><?php echo $text_no;?></label>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="referrer_status"><?php echo $text_status; ?></label>
            <div class="col-sm-10">
              <select name="referrer_status" id="referrer_status" class="form-control" onChange="enableOrDisable(this.value);">
                <option value="1"<?php if(isset($value_referrer['referrer_status']) AND $value_referrer['referrer_status'] == '1'){echo ' selected="selected"';}?>><?php echo $text_enable; ?></option>
                <option value="0"<?php if(isset($value_referrer['referrer_status']) AND $value_referrer['referrer_status'] == '0'){echo ' selected="selected"';}?>><?php echo $text_disable; ?></option>
              </select>
            </div>
          </div>


        
        
        
        
        
        
        
        
        
      </div>
    </div>









<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_ref_profit; ?></h3>
  </div>
  <div class="panel-body">

      <table class="table table-striped table-bordered table-hover">
        <tr>
          <td><h4 style="padding: 0px; margin: 2px;"><?php echo $text_ref_level;?></h4></td>
          <td><h4 style="padding: 0px; margin: 2px;"><?php echo $text_ref_percentage_profit;?></h4></td>
          <td><h4 style="padding: 0px; margin: 2px;"><?php echo $text_ref_fixed_profit;?></h4></td>
          <td><h4 style="padding: 0px; margin: 2px;"><?php echo $text_ref_info;?></h4></td>
        </tr>
      <?php $i=1;while($i<=10){?>
        <tr id="ref-profit-<?php echo $i;?>">
          <td style="width: 100px !important;"><label for="referrer_profit_level_<?php echo $i;?>_percentage"><b><?php echo $i;?>. <?php echo $text_referrer;?></b></label></td>
          <td style="width: 150px !important;"><input type="text" class="form-control" name="referrer_profit_level_<?php echo $i;?>_percentage" id="referrer_profit_level_<?php echo $i;?>_percentage" value="<?php if(isset($value_referrer['referrer_profit_level_'.$i.'_percentage'])){echo $value_referrer['referrer_profit_level_'.$i.'_percentage'];}else{echo "0";}?>" size="7" />%</td>
          <td style="width: 150px !important;"><?php echo $primary_currency['symbol_left'];?><input type="text" class="form-control" name="referrer_profit_level_<?php echo $i;?>_fixed" id="referrer_profit_level_<?php echo $i;?>_fixed" value="<?php if(isset($value_referrer['referrer_profit_level_'.$i.'_fixed'])){echo $value_referrer['referrer_profit_level_'.$i.'_fixed'];}else{echo "0";}?>" size="7" /><?php echo $primary_currency['symbol_right'];?></td>
          <td><u><?php echo $text_you;?></u> <small>&laquo;</small> <?php
            $j = 2;
            while($j <= $i){
              echo "<small>REF ".($j-1)." < </small>";
              $j++;
            }
          ?><b><?php echo $text_this_ref;?></b></td>
        </tr>
      <?php $i++;}?>
      </table>
      <input type="hidden" name="referrer_module" value="<?php echo $referrer_module; ?>" />


  </div>
</div>
    </form>
  <script type="text/javascript">
    function hideRefProfit(){
      var i = 1;
      while(i<=10){
        document.getElementById('ref-profit-'+i.toString()).style.display = "none";
        i++;
      }
    }
    
    function setRefProfit(){
      var referrer_level = document.getElementById('referrer_level').value;
      var i = 1;
      hideRefProfit();
      while(i<=referrer_level){
        document.getElementById('ref-profit-'+i.toString()).style.display = "";
        i++;
      }
    }
  
    function switchOrderPrice(){
      if(document.getElementById('order_price_1').checked){
        document.getElementById('min_order_price').style.display = "";
      }else{
        document.getElementById('min_order_price').style.display = "none";
      }
    }
    
    
    function enableOrDisable(value){
      if(value == 0){
        document.getElementById('profit_type_percentage').disabled = true;
        document.getElementById('profit_type_fixed').disabled                   = true;
        document.getElementById('order_price_1').disabled                       = true;
        document.getElementById('order_price_0').disabled                       = true;
        document.getElementById('min_order_price').disabled                     = true;
        document.getElementById('referrer_level').disabled                      = true;
        document.getElementById('ref_product_link_1').disabled                  = true;
        document.getElementById('ref_product_link_0').disabled                  = true;
        document.getElementById('ref_compulsory_reg_1').disabled                = true;
        document.getElementById('ref_compulsory_reg_0').disabled                = true;
        document.getElementById('referrer_profit_level_1_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_2_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_3_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_4_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_5_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_6_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_7_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_8_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_9_fixed').disabled       = true;
        document.getElementById('referrer_profit_level_10_fixed').disabled      = true;
        document.getElementById('referrer_profit_level_1_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_2_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_3_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_4_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_5_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_6_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_7_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_8_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_9_percentage').disabled  = true;
        document.getElementById('referrer_profit_level_10_percentage').disabled = true;
      }else{
        document.getElementById('profit_type_percentage').disabled              = false;
        document.getElementById('profit_type_fixed').disabled                   = false;
        document.getElementById('order_price_1').disabled                       = false;
        document.getElementById('order_price_0').disabled                       = false;
        document.getElementById('min_order_price').disabled                     = false;
        document.getElementById('referrer_level').disabled                      = false;
        document.getElementById('ref_product_link_1').disabled                  = false;
        document.getElementById('ref_product_link_0').disabled                  = false;
        document.getElementById('ref_compulsory_reg_1').disabled                = false;
        document.getElementById('ref_compulsory_reg_0').disabled                = false;
        document.getElementById('referrer_profit_level_1_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_2_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_3_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_4_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_5_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_6_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_7_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_8_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_9_fixed').disabled       = false;
        document.getElementById('referrer_profit_level_10_fixed').disabled      = false;
        document.getElementById('referrer_profit_level_1_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_2_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_3_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_4_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_5_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_6_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_7_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_8_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_9_percentage').disabled  = false;
        document.getElementById('referrer_profit_level_10_percentage').disabled = false;
        
        
      }
    
    }
</script>

<script type="text/javascript">
  setRefProfit(document.getElementById('referrer_level').value);
  switchOrderPrice();
</script>

        







  </div>
</div>
<?php echo $footer; ?>