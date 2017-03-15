<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-fb-login" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
    <?php if ($update) { ?>
    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $update; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>  
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-fb-login" class="form-horizontal">
			<ul class="nav nav-tabs" id="tabs">
				<li class="active"><a href="#tab-general" data-toggle="tab"><i class="fa fa-fw fa-wrench"></i> <?php echo $tab_general; ?></a></li>
				<li><a href="#tab-new-account" data-toggle="tab"><i class="fa fa-fw fa-user"></i> <?php echo $tab_new_account; ?></a></li>				
				<li><a href="#tab-registration-mail" data-toggle="tab"><i class="fa fa-fw fa-envelope"></i> <?php echo $tab_registration_mail; ?></a></li>								
				<li><a href="#tab-fb-button" data-toggle="tab"><i class="fa fa-fw fa-facebook"></i> <?php echo $tab_fb_button; ?></a></li>
				<li><a href="#tab-help" data-toggle="tab"><i class="fa fa-fw fa-question"></i> <?php echo $tab_help; ?></a></li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane active" id="tab-general">  
					<div class="tab-content">
						<div class="form-group hidden">
							<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="fb_login_status" id="input-status" class="form-control">
									<?php if ($fb_login_status) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>					
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-app-id"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_app_id; ?>"><?php echo $entry_app_id;?></span></label>
							<div class="col-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-key"></i></span>	
									<input type="text" name="fb_login_app_id" placeholder="<?php echo $entry_app_id; ?>" id="input-app-id" value="<?php echo $fb_login_app_id; ?>" class="form-control" />
								</div>
								<?php if ($error_app_id) { ?>
								<div class="text-danger"><?php echo $error_app_id; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-mode"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_mode; ?>"><?php echo $entry_mode; ?></span></label>
							<div class="col-sm-10">
								<select name="fb_login_mode" id="input-mode" class="form-control">
									<?php if ($fb_login_mode == "advanced-mode") { ?>
									<option value="advanced-mode" selected="selected"><?php echo $text_advanced; ?></option>
									<option value="standard-mode"><?php echo $text_standard; ?></option>
									<?php } else { ?>
									<option value="advanced-mode"><?php echo $text_advanced; ?></option>
									<option value="standard-mode" selected="selected"><?php echo $text_standard; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<fieldset id="standard-mode">
							<legend><?php echo $text_standard; ?></legend>
							<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_standard_mode_info; ?></div>
						</fieldset>	

						<fieldset id="advanced-mode">
							<legend><?php echo $text_advanced; ?></legend>
							<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $help_advanced_mode_info; ?></div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-redirect-mode"><?php echo $entry_redirect_mode; ?></label>
								<div class="col-sm-10">
									<select name="fb_login_redirect_mode" id="input-redirect-mode" class="form-control">
									<?php if ($fb_login_redirect_mode == 'account') { ?>
										<option value="account" selected="selected"><?php echo $text_redirect_account; ?></option>
										<option value="same-page"><?php echo $text_redirect_same_page; ?></option>
									<?php } else { ?>
										<option value="account"><?php echo $text_redirect_account; ?></option>
										<option value="same-page" selected="selected"><?php echo $text_redirect_same_page; ?></option>
									<?php } ?>
									</select>
								</div>
							</div>							
							
							<ul class="nav nav-tabs" id="designs-code">
								<?php foreach ($designs as $design) { ?>
								<li><a data-toggle="tab" href="#design-code-<?php echo $design['class']; ?>"><?php echo $design['name']; ?></a></li>
								<?php } ?>
							</ul>
							
							<div class="tab-content">
								<?php foreach($designs as $design) { ?>
								<div id="design-code-<?php echo $design['class']; ?>" class="tab-pane">
									<legend class="small"><?php echo $help_code; ?></legend>
									<div class="well">
										<?php echo htmlspecialchars('<a class="ocx-fb-login-trigger ocx-fb-login-custom-position ocx-fb-login-hidden-initial btn ' . $design['class'] . '" href="javascript:void(0);"></a>'); ?>
									</div>
									
									<legend class="small"><?php echo $help_code_result; ?></legend>
									<a class="ocx-fb-login-trigger btn <?php echo $design['class']; ?>" href="javascript:void(0);"></a>
								</div>
								<?php } ?>
							</div>	
						</fieldset>						
	
					</div>
				</div>

				<div class="tab-pane" id="tab-new-account">
					<div class="tab-content">
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-customer-group-id"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_customer_group; ?>"><?php echo $entry_customer_group; ?></span></label>
							<div class="col-sm-10">
								<select name="fb_login_customer_group_id" id="input-customer-group-id" class="form-control">
									<option value=""><?php echo $text_select; ?></option>
									<?php foreach($customer_groups as $customer_group) { ?>
									<?php if ($customer_group['customer_group_id'] == $fb_login_customer_group_id) { ?>
									<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
								<?php if ($error_customer_group_id) { ?>
								<div class="text-danger"><?php echo $error_customer_group_id; ?></div>
								<?php } ?>
							</div>
						</div>
						
						<div class="alert alert-info"><i class="fa fa-fw fa-arrow-down"></i> <?php echo $help_required_info; ?></div>
						
						<fieldset>
							<legend><?php echo $entry_required_info; ?></legend>
							<?php foreach($extra_fields as $extra_field) { ?>
							<div class="form-group">
								<label class="control-label col-sm-2"><?php echo ${'entry_' . $extra_field}; ?></label>
								<div class="col-sm-10">
									<input type="checkbox" <?php echo (${'fb_login_' . $extra_field}) ? 'checked' : ''; ?> id="fb_login_<?php echo $extra_field; ?>" data-toggle="toggle" data-on="<?php echo addslashes($text_required); ?>" data-off="<?php echo addslashes($text_not_required); ?>" data-width="200" data-onstyle="success" class="required-info-on-off" />
									<input type="hidden" name="fb_login_<?php echo $extra_field; ?>" value="<?php echo ${'fb_login_' . $extra_field}; ?>">
								</div>
							</div>
							<?php } ?>
						</fieldset>
					</div>
				</div>					
				
				<div class="tab-pane" id="tab-registration-mail">
					<div class="tab-content">
						<ul class="nav nav-tabs" id="languages">
							<?php foreach ($languages as $language) { ?>
							<li><a data-toggle="tab" href="#language-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
							<?php } ?>
						</ul>
							
						<?php foreach ($languages as $language) { ?>
						<div id="language-<?php echo $language['language_id']; ?>" class="tab-pane">
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-subject-<?php echo $language['language_id']; ?>"><?php echo $entry_subject; ?></label>
								<div class="col-sm-10">
									<input name="fb_login_mail[<?php echo $language['language_id']; ?>][subject]" placeholder="<?php echo $entry_subject; ?>" id="input-subject-<?php echo $language['language_id']; ?>" value="<?php echo isset($fb_login_mail[$language['language_id']]) ? $fb_login_mail[$language['language_id']]['subject'] : ''; ?>" data-toggle="popover" data-placement="top" title="<?php echo $help_special_keywords_title; ?>" data-content="<?php echo $help_subject; ?>" data-html="true" data-trigger="focus" class="form-control" />
									<?php if (isset($error_subject[$language['language_id']])) { ?>
									<div class="text-danger"><?php echo $error_subject[$language['language_id']]; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="message-<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_message; ?>"><?php echo $entry_message; ?></span></label>
								<div class="col-sm-10">
									<textarea name="fb_login_mail[<?php echo $language['language_id']; ?>][message]" placeholder="<?php echo $entry_message; ?>" id="message-<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($fb_login_mail[$language['language_id']]) ? $fb_login_mail[$language['language_id']]['message'] : ''; ?></textarea>
									<?php if (isset($error_message[$language['language_id']])) { ?>
									<div class="text-danger"><?php echo $error_message[$language['language_id']]; ?></div>
									<?php } ?>
								</div>
							</div>							
						</div>
						<?php } ?>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-use-html-email"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_use_html_email; ?>"><?php echo $entry_use_html_email; ?></span></label>
							<div class="col-sm-10">
								<select name="fb_login_use_html_email" id="input-use-html-email" class="form-control">
									<?php if ($fb_login_use_html_email) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>						
					</div>
				</div>								
				
				<div class="tab-pane" id="tab-fb-button">
					<div class="tab-content">
						<fieldset>
							<legend><?php echo $text_button_text; ?></legend>
							<?php foreach ($languages as $language) { ?>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="fb-login-button-name-<?php echo $language['language_id']; ?>"><?php echo $entry_button_text . ' (' . $language['name'] . ')' ; ?></label>
								<div class="col-sm-10">
									<div class="input-group">
										<span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="fb_login_button_name_<?php echo $language['language_id'];?>" placeholder="<?php echo $entry_button_text; ?>" id="fb-login-button-name-<?php echo $language['language_id'];?>" value="<?php echo ${'fb_login_button_name_' . $language['language_id']}; ?>" class="form-control" />
									</div>
								</div>
								<?php if (isset($error_button_name[$language['language_id']])) { ?>
								<span class="error"><?php echo $error_button_name[$language['language_id']]; ?></span>
								<?php } ?>
							</div>
							<?php } ?>
						</fieldset>
						
						<fieldset>
							<legend><?php echo $text_button_design; ?></legend>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-button-design"><?php echo $entry_button_design; ?></label>
								<div class="col-sm-10">
									<select name="fb_login_button_design" id="input-button-design" class="form-control">
										<?php foreach($designs as $design) { ?>
										<option value="<?php echo $design['class']; ?>" <?php echo ($fb_login_button_design == $design['class'])? 'selected="selected"' : ''; ?>><?php echo $design['name']; ?></option>
										<?php } ?>
									</select>
								</div>	
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="fb-login-preview"><?php echo $entry_button_preview; ?></label>
								<div class="col-sm-10">
									<a href="javascript:void(0);" id="fb-login-preview"></a>
								</div>	
							</div>							
						</fieldset>
						
						<fieldset>
							<ul class="nav nav-tabs" id="extra-infos">
								<?php foreach ($languages as $language) { ?>
								<li><a data-toggle="tab" href="#extra-info-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
								<?php } ?>
							</ul>
							
							<div class="tab-content">
								<?php foreach ($languages as $language) { ?>
								<div id="extra-info-<?php echo $language['language_id']; ?>" class="tab-pane">
									<div class="form-group required">
										<label class="col-sm-2 control-label" for="exinfo-<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_extra_info_message; ?>"><?php echo $entry_extra_info_message; ?></span></label>
										<div class="col-sm-10">
											<textarea name="fb_login_extra_info[<?php echo $language['language_id']; ?>][message]" placeholder="<?php echo $entry_message; ?>" id="exinfo-<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($fb_login_extra_info[$language['language_id']]) ? $fb_login_extra_info[$language['language_id']]['message'] : ''; ?></textarea>
											<?php if (isset($extra_info_message[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $extra_info_message[$language['language_id']]; ?></div>
											<?php } ?>
										</div>
									</div>							
								</div> 
								<?php } ?>						
							</div>
						</fieldset>
					</div>
				</div>				
				
				<div class="tab-pane" id="tab-help">
					<div class="tab-content">
						Change Log and HELP Guide is available : <a href="http://www.oc-extensions.com/Facebook-Login" target="blank">HERE</a><br /><br />
						If you need support email us at <strong>support@oc-extensions.com</strong> (Please first read help guide) 					
					</div>
				</div>
			</div>
		</form>	
    </div>
  </div>
<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
<script type="text/javascript"><!--
// ---- Start use mode standard / advanced
$('select[name=\'fb_login_mode\']').on('change', function(){
	if ($(this).val() == 'standard-mode') {
		$('#standard-mode').show();
		$('#advanced-mode').hide();
	} else {
		$('#standard-mode').hide();
		$('#advanced-mode').show();
	}
});

$('select[name=\'fb_login_mode\']').trigger('change');
// ---- STOP use mode standard / advanced

// ---- Start required fields checkboxed on/off
$('.required-info-on-off').on('change', function(){
	if ($(this).prop('checked') == true) {
		$('[name=\'' + $(this).attr('id') + '\']').val(1);
	} else {
		$('[name=\'' + $(this).attr('id') + '\']').val(0);
	}
});
// ---- Stop required fields checkboxed on/off

// ---- Start FB Login Button preview
$('#fb-login-button-name-<?php echo $default_language_id; ?>').on('keyup', function(){
	$('#fb-login-preview').html('<i class="fa fa-fw fa-facebook"></i> ' + $(this).val());
	$('.ocx-fb-login-trigger').html('<i class="fa fa-fw fa-facebook"></i> ' + $(this).val());
});

$('#fb-login-button-name-<?php echo $default_language_id; ?>').trigger('keyup');

$('select[name=\'fb_login_button_design\']').on('change', function(){
	$('#fb-login-preview').attr('class', 'btn ' + $(this).val());
});

$('select[name=\'fb_login_button_design\']').trigger('change');
// ---- Stop FB Login Button preview

// ---- Start chnage code for redirect mode
$('select[name=\'fb_login_redirect_mode\']').on('change', function() {

	if ($(this).val() == 'same-page') {
		$('.well').each(function(){
			$(this).html($(this).html().replace("ocx-fb-login-trigger", "ocx-fb-login-trigger ocx-stay-here"));
		});
	} 
	
	if ($(this).val() == 'account') {
		$('.well').each(function(){
			$(this).html($(this).html().replace("ocx-fb-login-trigger ocx-stay-here", "ocx-fb-login-trigger"));
		});
	}
});

$('select[name=\'fb_login_redirect_mode\']').trigger('change');
// ---- Start chnage code for redirect mode

$('#languages li:first-child a, #designs-code li:first-child a, #extra-infos li:first-child a').tab('show');

$('[data-toggle="popover"]').popover();
//--></script></div>
<?php echo $footer; ?>