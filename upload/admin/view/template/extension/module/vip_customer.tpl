<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="index.php?route=extension/extension&type=module&token=<?php echo $token; ?>" data-toggle="tooltip" title="<?php echo $lng['button_cancel']; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $lng['text_edit']; ?></h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <li class="<?php if ($tab == 'setting') echo 'active'; ?>"><a href="#tab-setting" data-toggle="tab"><?php echo $lng['tab_setting']; ?></a></li>
          <li class="<?php if ($tab == 'data') echo 'active'; ?>"><a href="#tab-data" data-toggle="tab"><?php echo $lng['tab_data']; ?></a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane <?php if ($tab == 'setting') echo 'active'; ?>" id="tab-setting">
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_layout; ?></div>
            <div class="alert alert-info">
              <i class="fa fa-info-circle"></i> <?php echo $lng['update_customers']; ?>
              <p><a target="_blank" href="<?php echo HTTP_CATALOG; ?>index.php?route=extension/module/vip_customer/updateAll"><?php echo HTTP_CATALOG; ?>index.php?route=extension/module/vip_customer/updateAll</a></p>
            </div>
            <form action="<?php echo $url ?>&tab=setting" method="post" enctype="multipart/form-data" id="form-setting" class="form-horizontal">
              <div class="pull-right">
                <button type="submit" form="form-setting" data-toggle="tooltip" title="<?php echo $lng['button_save']; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $lng['button_save']; ?></button>
              </div>
              <table id="vip-level" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="left"><?php echo $lng['column_level_name']; ?></td>
                    <td class="left"><?php echo $lng['column_level_spending']; ?></td>
                    <td class="left"><?php echo $lng['column_level_discount']; ?></td>
                    <td class="left"><?php echo $lng['column_level_image']; ?></td>
                    <td><?php echo $lng['column_action']; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php $row = 1; ?>
                  <?php foreach ($vip_levels as $vip_id => $v) { ?>
                  <tr>
                    <td class="left">
                      <?php foreach ($languages as $l) { ?>
                      <input type="text" name="vip_level[<?php echo $vip_id; ?>][name][<?php echo $l['language_id']; ?>]" value="<?php echo $v['name'][$l['language_id']]; ?>" />
                      <?php if (version_compare(VERSION, '2.2') >= 0) { ?>
                      <img src="language/<?php echo $l['code']; ?>/<?php echo $l['code']; ?>.png" title="<?php echo $l['name']; ?>" /><br/>
                      <?php  } else { ?>
                      <img src="view/image/flags/<?php echo $l['image']; ?>" alt="" title="<?php echo $l['name']; ?>" align="top" /><br/>
                      <?php } ?>
                      <?php } ?>
                    </td>
                    <td class="left"><input type="text" name="vip_level[<?php echo $vip_id; ?>][spending]" value="<?php echo $v['spending']; ?>" /></td>
                    <td class="left"><input type="text" name="vip_level[<?php echo $vip_id; ?>][discount]" value="<?php echo $v['discount']; ?>" /></td>
                    <td class="left">
                      <a href="" id="thumb-image<?php echo $vip_id; ?>" data-toggle='image' class="img-thumbnail"><img src="<?php echo $v['image_link']; ?>" alt="" title="" data-placeholder="<?php echo $default_image; ?>" /></a>
                      <input type="hidden" name="vip_level[<?php echo $vip_id; ?>][image]" value="<?php echo $v['image']; ?>" id="input-image<?php echo $vip_id; ?>" />
                    </td>
                    <td class="left"><button type="button" onclick="removeRow(this);" data-toggle="tooltip" title="<?php echo $lng['button_remove']; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                  </tr>
                  <?php $row = $vip_id; ?>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4"></td>
                    <td class="left"><button type="button" onclick="addVipLevel();" data-toggle="tooltip" title="<?php echo $lng['button_add_level']; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                </tfoot>
              </table>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $lng['entry_status']; ?></label>
                <div class="col-sm-2">
                  <select id="vip-status" name="vip_customer_status" class="form-control">
                    <option value="0"><?php echo $lng['text_disabled']; ?></option>
                    <option <?php if ($vip_customer_status) echo 'selected'; ?> value="1"><?php echo $lng['text_enabled']; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_complete_status']; ?>"><?php echo $lng['entry_complete_status']; ?></label>
                <div class="col-sm-10 checkbox-inline"><?php echo $complete_status; ?></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_customer_group']; ?>"><?php echo $lng['entry_customer_group']; ?></span></label>
                <div class="col-sm-10">
                  <?php foreach ($customer_groups as $r) { ?>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="vip_customer_group[<?php echo $r['customer_group_id']; ?>]" value="<?php echo $r['customer_group_id']; ?>" <?php if (isset($vip_customer_group[$r['customer_group_id']])) echo 'checked'; ?> />
                    <?php echo $r['name']; ?>
                  </label>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_store']; ?>"><?php echo $lng['entry_store']; ?></span></label>
                <div class="col-sm-10">
                  <?php foreach ($stores as $r) { ?>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="vip_customer_store[<?php echo $r['store_id']; ?>]" value="<?php echo $r['store_id']; ?>" <?php if (isset($vip_customer_store[$r['store_id']])) echo 'checked'; ?> />
                    <?php echo $r['name']; ?>
                  </label>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_spending_type']; ?>"><?php echo $lng['entry_spending_type']; ?></span></label>
                <div class="col-sm-2">
                  <select name="vip_customer_type" class="form-control">
                    <option value="all" <?php echo ($vip_customer_type == "all" ? "selected" : ""); ?>><?php echo $lng['text_spending_type_all']; ?></option>
                    <option <?php if ($vip_customer_type == "annually") echo "selected"; ?> value="annually"><?php echo $lng['text_spending_type_annually']; ?></option>
                    <option <?php if ($vip_customer_type == "semiannually") echo "selected"; ?> value="semiannually"><?php echo $lng['text_spending_type_semiannually']; ?></option>
                    <option <?php if ($vip_customer_type == "quarterly") echo "selected"; ?> value="quarterly"><?php echo $lng['text_spending_type_quarterly']; ?></option>
                    <option <?php if ($vip_customer_type == "monthly") echo "selected"; ?> value="monthly"><?php echo $lng['text_spending_type_monthly']; ?></option>
                    <option <?php if ($vip_customer_type == "days") echo "selected"; ?> value="days"><?php echo $lng['text_spending_type_days']; ?></option>
                  </select>
                </div>
                <div class="col-sm-1">
                  <input class="form-control" type="number" name="vip_customer_days_from_today" value="<?php echo $vip_customer_days_from_today; ?>" /> <?php echo $lng['text_day']; ?>
                </div>
                <div class="col-sm-2">
                  <label for="current-period" class="checkbox-inline"><input type="checkbox" name="vip_customer_current_period" value="1" id="current-period" <?php if ($vip_customer_current_period) echo 'checked'; ?> /> <?php echo $lng['entry_current_period']; ?></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_shipping']; ?>"><?php echo $lng['entry_shipping']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_shipping" value="1" <?php if ($vip_customer_shipping) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_tax']; ?>"><?php echo $lng['entry_tax']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_tax" value="1" <?php if ($vip_customer_tax) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_credit']; ?>"><?php echo $lng['entry_credit']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_credit" value="1" <?php if ($vip_customer_credit) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_reward']; ?>"><?php echo $lng['entry_reward']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_reward" value="1" <?php if ($vip_customer_reward) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_coupon']; ?>"><?php echo $lng['entry_coupon']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_coupon" value="1" <?php if ($vip_customer_coupon) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $lng['text_date_format']; ?></label>
                <div class="col-sm-10">
                  <button type="button" class="btn" onclick="$('#date_format').val('<?php echo $lng['date_format_short']; ?>');"><?php echo $lng['text_short_date']; ?></button>
                  <button type="button" class="btn" onclick="$('#date_format').val('<?php echo $lng['date_format_long']; ?>');"><?php echo $lng['text_long_date']; ?></button>
                  <button type="button" class="btn" onclick="$('#date_format').select();"><?php echo $lng['text_custom']; ?></button>
                  <input type="text" name="vip_customer_date_format" id="date_format" value="<?php echo $vip_customer_date_format; ?>" />
                  <div class="help"><?php echo $lng['help_date_format']; ?> <a target="_blank" href="http://php.net/manual/en/function.date.php">http://php.net/manual/en/function.date.php</a></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_show_vip_price_table']; ?>"><?php echo $lng['entry_show_vip_price_table']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline">
                    <input type="checkbox" name="vip_customer_show_vip_price_table" value="1" <?php if ($vip_customer_show_vip_price_table) echo 'checked'; ?> />
                    <select name="vip_customer_price_table_format">
                      <option value="price"><?php echo $lng['text_vip_price']?></option>
                      <option <?php if (isset($vip_customer_price_table_format) == 'percent') echo 'selected'; ?> value="percent"><?php echo $lng['text_vip_discount']?></option>
                    </select>
                  </label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $lng['entry_hide_vip_price']; ?></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_hide_price" value="1" <?php if ($vip_customer_hide_price) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_email_customer']; ?>"><?php echo $lng['entry_email_customer']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_email_customer" value="1" <?php if ($vip_customer_email_customer) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_email_admin']; ?>"><?php echo $lng['entry_email_admin']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_email_admin" value="1" <?php if ($vip_customer_email_admin) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" ><span data-toggle="tooltip" title="<?php echo $lng['help_discount_product']; ?>"><?php echo $lng['entry_discount_product']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_discount_product" value="1" <?php if ($vip_customer_discount_product) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_special_product']; ?>"><?php echo $lng['entry_special_product']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_special_product" value="1" <?php if ($vip_customer_special_product) echo 'checked'; ?> /></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $lng['help_log']; ?>"><?php echo $lng['entry_log']; ?></span></label>
                <div class="col-sm-10">
                  <label class="checkbox-inline"><input type="checkbox" name="vip_customer_log" value="1" <?php if ($vip_customer_log) echo 'checked'; ?> /></label>
                </div>
              </div>
            </form>
            <div class="pull-right">
              <button type="submit" form="form-setting" data-toggle="tooltip" title="<?php echo $lng['button_save']; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $lng['button_save']; ?></button>
            </div>
          </div><!--tab-setting-->
          <div class="tab-pane <?php if ($tab == 'data') echo 'active'; ?>" id="tab-data">
            <div class="well">
              <div class="row">
                <form id="form-filter" class="form-horizontal">
                  <div class="col-sm-2 form-group">
                    <label class="control-label" for="filter_customer_name"><?php echo $lng['column_customer_name']; ?></label>
                    <input type="text" name="filter_customer_name" value="<?php echo $filter_customer_name; ?>" class="form-control" />
                  </div>
                  <div class="col-sm-2 form-group">
                    <label class="control-label" for="filter_customer_email"><?php echo $lng['column_customer_email']; ?></label>
                    <input type="text" name="filter_customer_email" value="<?php echo $filter_customer_email; ?>" class="form-control" />
                  </div>
                  <div class="col-sm-2 form-group">
                    <label class="control-label" for="filter_vip_customer"><?php echo $lng['column_vip_customer']; ?></label>
                    <select name="filter_vip_customer" class="form-control">
                      <option value="*"></option>
                      <?php foreach ($vip_levels as $r) { ?>
                      <option <?php if ($r['vip_id'] == $filter_vip_customer) echo 'selected'; ?> value="<?php echo $r['vip_id']?>"><?php echo $r['name'][$config_language_id]; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-sm-2 form-group">
                    <label class="control-label" for="filter_vip_customer_init"><?php echo $lng['column_vip_customer_init']; ?></label>
                    <select name="filter_vip_customer_init" class="form-control">
                      <option value="*"></option>
                      <option <?php if ($filter_vip_customer_init == 1) echo 'selected'; ?> value="1"><?php echo $lng['text_yes']; ?></option>
                      <option <?php if (!$filter_vip_customer_init) echo 'selected'; ?> value="1"><?php echo $lng['text_no']; ?></option>
                    </select>
                  </div>
                  <div class="col-sm-4 form-group">
                    <label class="control-label" style="display: block; text-align: left;" for="filter_vip_customer_total"><?php echo $lng['column_vip_customer_total']; ?></label>
                    <select name="filter_vip_customer_total_mode" class="form-control" style="width: 60px; display: inline;">
                      <option value="lt">&lt;</option>
                      <option <?php if ($filter_vip_customer_total_mode == 'eq') echo 'selected'; ?> value="eq">=</option>
                      <option <?php if ($filter_vip_customer_total_mode == 'gt') echo 'selected'; ?> value="gt">&gt;</option>
                    </select>
                    <input type="text" name="filter_vip_customer_total" class="form-control" style="width: 200px; display: inline;" value="<?php echo $filter_vip_customer_total; ?>">
                  </div>
                  <div class="col-sm-3" style="clear: both;">
                    <button type="button" form="form-filter" onclick="filter();" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo $lng['button_filter']; ?></button>
                    <button type="button" form="form-filter" onclick="filter(1);" class="btn btn-primary"><i class="fa fa-eraser"></i> <?php echo $lng['button_clear_filter']; ?></button>
                  </div>
                </form>
              </div>
            </div>
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left">
                    <a href="<?php echo $sort_url; ?>&sort=fullname" class="<?php if ($sort == 'fullname') echo $order; ?>"><?php echo $lng['column_customer_name']; ?></a>
                  </td>
                  <td class="text-left">
                    <a href="<?php echo $sort_url; ?>&sort=c.email" class="<?php if ($sort == 'c.email') echo $order; ?>"><?php echo $lng['column_customer_email']; ?></a>
                  </td>
                  <td class="text-left">
                    <a href="<?php echo $sort_url; ?>&sort=vip_level" class="<?php if ($sort == 'vip_level') echo $order; ?>"><?php echo $lng['column_vip_customer']; ?></a>
                  </td>
                  <td class="text-left">
                    <a href="<?php echo $sort_url; ?>&sort=c.vip_init" class="<?php if ($sort == 'c.vip_init') echo $order; ?>"><?php echo $lng['column_vip_customer_init']; ?></a>
                  </td>
                  <td class="text-left">
                    <a href="<?php echo $sort_url; ?>&sort=c.vip_total" class="<?php if ($sort == 'c.vip_total') echo $order; ?>"><?php echo $lng['column_vip_customer_total']; ?></a>
                  </td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($customers as $r) { ?>
                <tr>
                  <td class="text-left"><?php echo $r['fullname']; ?></td>
                  <td class="text-left"><?php echo $r['email']; ?></td>
                  <td class="text-left vip_level"><?php echo $r['vip_level']; ?></td>
                  <td class="text-left"><input type="text" style="display: none;" /><span><?php echo $r['vip_init']; ?></span> <button class="edit" onclick="changeVipInit(this, <?php echo $r['customer_id']; ?>)"><?php echo $lng['button_edit']; ?></button> <button class="cancel" onclick="changeVipInit(this);" style="display: none;"><?php echo $lng['button_cancel']; ?></button></td>
                  <td class="text-left vip_total"><?php echo $r['vip_total']; ?></td>
                  <td class="text-left">
                    <a target="_blank" href="../index.php?route=extension/module/vip_customer/getDetail&customer=<?php echo $r['customer_id'] . '-' . $r['salt']; ?>" class="btn btn-default"><?php echo $lng['text_vip_detail']; ?></a>
                    <div class="btn-group" data-toggle="tooltip" title="<?php echo $lng['button_login']; ?>">
                      <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fa fa-lock"></i></button>
                      <ul class="dropdown-menu pull-right">
                        <li><a href="index.php?route=customer/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $r['customer_id']; ?>&store_id=0" target="_blank"><?php echo $lng['text_default']; ?></a></li>
                        <?php foreach ($stores as $store) { ?>
                        <li><a href="index.php?route=customer/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $r['customer_id']; ?>&store_id=<?php echo $store['store_id']; ?>" target="_blank"><?php echo $store['name']; ?></a></li>
                        <?php } ?>
                      </ul>
                    </div>
                    <a target="_blank" href="index.php?route=customer/customer/edit&token=<?php echo $token; ?>&customer_id=<?php echo $r['customer_id']; ?>" data-toggle="tooltip" title="<?php echo $lng['button_edit']; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <div class="row">
              <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
              <div class="col-sm-6 text-right"><?php echo $pagination_text; ?></div>
            </div>
          </div><!--tab-data-->
        </div><!--tab-content-->
      </div><!--panel-body-->
    </div><!--panel-->
    <div class="row" id="support"><a href="mailto:trile7@gmail.com?Subject=<?php echo urlencode($heading_title); ?>">Support Email</a></div>
    <div class="row" id="upgrade">Upgrade:
      <ol>
        <li><a href="http://tlecoding.gurleegirl.com/vip_customer" target="_blank">Check for new upgrade</a></li>
        <li>Download, unzip, and upload file to opencart installation root</li>
        <li><a href="index.php?route=extension/module/vip_customer/install&token=<?php echo $token; ?>&redirect=1">Complete upgrade process</a></li>
      </ol>
      <a href="http://tlecoding.gurleegirl.com" target="_blank">My other extensions</a>
    </div>
  </div>
</div><!--id content end-->
<table id="vip-level-template" style="display: none;"><tbody>
  <tr>
    <td class="left">
      <?php foreach ($languages as $l) { ?>
      <input type="text" name="vip_level[{row}][name][<?php echo $l['language_id']; ?>]" />
      <?php if (version_compare(VERSION, '2.2') >= 0) { ?>
      <img src="language/<?php echo $l['code']; ?>/<?php echo $l['code']; ?>.png" title="<?php echo $l['name']; ?>" /><br/>
      <?php  } else { ?>
      <img src="view/image/flags/<?php echo $l['image']; ?>" alt="" title="<?php echo $l['name']; ?>" align="top" /><br/>
      <?php } ?>
      <?php } ?>
    </td>
    <td class="left"><input type="text" name="vip_level[{row}][spending]" /></td>
    <td class="left"><input type="text" name="vip_level[{row}][discount]" /></td>
    <td class="left">
      <a href="" id="thumb-image{row}" data-toggle='image' class="img-thumbnail"><img src="<?php echo $default_image; ?>" alt="" title="" data-placeholder="<?php echo $default_image; ?>" /></a>
      <input type="hidden" name="vip_level[{row}][image]" value="" id="input-image{row}" />
    </td>
    <td class="left"><button type="button" onclick="removeRow(this);" data-toggle="tooltip" title="<?php echo $lng['button_remove']; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
  </tr>
</tbody></table>
<script type="text/javascript">
if (getURLVar('refreshModCache')) {
  $.get('index.php?route=extension/modification/refresh&token=<?php echo $token; ?>');
}

function changeVipInit(obj, customer_id) {
  if (!customer_id) {
    $(obj).siblings('input').hide();
    $(obj).hide();
    $(obj).siblings('span').show();
    return;
  }

  if ($(obj).siblings('input').is(':visible')) {
    $.ajax({
      url: 'index.php?route=extension/module/vip_customer/editVipInit&token=<?php echo $token; ?>',
      data: 'customer_id=' + customer_id + '&vip_init=' + $(obj).siblings('input').val(),
      type: 'post',
      dataType: 'json',
      error: function(jqxhr, textstatus, errorthrown) {
        console.log(textstatus);
        console.log(errorthrown);
      },
      success: function(json) {
        $(obj).siblings('input, .cancel').hide();
        $(obj).siblings('span').text(json.vip_init);
        $(obj).parents('tr').find('.vip_total').text(json.vip_total);
        $(obj).parents('tr').find('.vip_level').text(json.vip_level);
        $(obj).siblings('span').show();
      }
    });
  } else {
    $(obj).siblings('span').hide();
    $(obj).siblings('input').val($(obj).siblings('span').text());
    $(obj).siblings('input, .cancel').show();
  }
} //changeVipInit end

row = <?php echo $row; ?> + 1;
function addVipLevel() {
  html = $('#vip-level-template tbody').html().replace(/{row}/g, row);

  $('#vip-level tbody').append(html);

  row++;
} //addVipLevel end

function filter(clear_filter) {
  if (clear_filter) {
    url = '<?php echo $url ?>&tab=data';
  } else {
    url = '<?php echo $url ?>&tab=data&' + $('#form-filter').serialize();
  }

  location = url;
} //filter end

function removeRow(obj) {
  $(obj).parents("tr").remove();
} //removeRow end
</script>
<?php echo $footer; ?>
