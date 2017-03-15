<?php
// Heading
$_['heading_title']       		  = 'Facebook Login';

// Tab
$_['tab_general']         		  = 'General Settings';
$_['tab_fb_button']               = 'Facebook Login Button';
$_['tab_new_account']     		  = 'New Account Settings';
$_['tab_registration_mail']       = 'Registration Email';
$_['tab_help']           		  = 'Help';

// Text
$_['text_module']                 = 'Modules';
$_['text_success']        		  = 'Success: You have modified module Facebook Login!';
$_['text_edit']                   = 'Edit Facebook Login';

$_['text_content_top']            = 'Content Top';
$_['text_content_bottom']         = 'Content Bottom';
$_['text_column_left']    		  = 'Column Left';
$_['text_column_right']   		  = 'Column Right';

$_['text_standard']               = 'Standard Mode';
$_['text_advanced']               = 'Advanced Mode (only for advanced users)';
$_['text_required']               = 'Required';
$_['text_not_required']           = 'Not Required';
$_['text_link_only']              = 'Link Only';
$_['text_standard_no_icon']       = 'Standard (no icon)';
$_['text_standard_icon']          = 'Standard (with icon)';
$_['text_rounded_no_icon']        = 'Rounded (no icon)';
$_['text_rounded_icon']           = 'Rounded (with icon)';
$_['text_button_text']            = 'Button Text';
$_['text_button_design']          = 'Button Design';
$_['text_for_design']             = 'For design';
$_['text_use_code']               = 'use code';
$_['text_redirect_account']       = 'Redirect to Account Page (useful in login / register page)';
$_['text_redirect_same_page']     = 'Stay on same page (useful on checkout page)';

// Entry 
$_['entry_app_id']                = 'Facebook APP ID';
$_['entry_mode']                  = 'Mode';

$_['entry_layout']        		  = 'Layout';
$_['entry_position']      		  = 'Position';
$_['entry_status']        		  = 'Status';
$_['entry_sort_order']    		  = 'Sort Order';

$_['entry_customer_group']        = 'Customer group';
$_['entry_required_info']         = 'Customer required info';
$_['entry_telephone']             = 'Telephone';
$_['entry_fax']                   = 'Fax';
$_['entry_company']               = 'Company';
$_['entry_address_1']             = 'Address';
$_['entry_city']                  = 'City';
$_['entry_postcode']              = 'Post Code';
$_['entry_country_id']            = 'Country';
$_['entry_zone_id']               = 'Region / State';

$_['entry_button_text']           = 'Button Text';
$_['entry_button_design']         = 'Design';
$_['entry_button_preview']        = 'Preview';
$_['entry_extra_info_message']    = 'Extra Info Message';

$_['entry_subject']               = 'Subject';
$_['entry_message']               = 'Message';
$_['entry_use_html_email']        = 'Send email with <a href="http://www.oc-extensions.com/HTML-Email">HTML Email Extension</a>';
$_['entry_redirect_mode']         = 'Redirect Mode';

// Help
$_['help_app_id']                 = 'Please check help guide to find instructions about how to create an FB APP and where to find APP ID';
$_['help_mode']                   = 'Standard = show button in default opencart positions<br />Advanced = you can add button anywhere in your store pages';
$_['help_standard_mode_info']     = 'After you have configured FB Login, press Save button and then go to System > Design > Layout. Click Edit on layout where you want to show FB Login.<br />In layout page press Add Button ("<i class="fa fa-plus-circle"></i>") and choose FB Login (for column module), position (top/bottom etc), Sort Order';
$_['help_advanced_mode_info']     = 'Advanced Mode means that you have basic knowledge about how to add few lines of code in your template file';
$_['help_customer_group']         = 'Customer group for new account created using Facebook Login button';
$_['help_required_info']          = 'If extension can\'t import some info (ex: telephone) from customer facebook account then will show popup to ask this info. (only for first login)<br />General rule: Set as required, fields that are also required in your default registration system.';
$_['help_extra_info_message']     = 'Ex: We can\'t import all required info from your facebook account. Please fill fields below<br /><br />(used only once in case of info ex: phone, if can\'t be imported from FB account)';
$_['help_special_keywords_title'] = 'Special Keywords';
$_['help_subject']                = '{firstname} = first name<br />{lastname} = last name<br />{email} = customer email<br />{password} = auto generated password<br />{login_link} = login link<br />{store_name} = your store name';
$_['help_message']                = 'Special Keywords:<br />{firstname} = first name<br />{lastname} = last name<br />{email} = customer email<br />{password} = auto generated password<br />{login_link} = login link<br />{store_name} = your store name';
$_['help_use_html_email']         = 'If HTML Email Extension is not installed on your store then is used default mail system';
$_['help_code']                   = 'Copy code below and paste it in your template';  
$_['help_code_result']            = 'Result';  

// Error
$_['error_permission']    		     = 'Warning: You do not have permission to modify module Facebook Login!';
$_['error_in_tab']      		     = 'Warning: You have errors in tab %s!';
$_['error_app_id']    				 = 'Error: Facebook APP ID is required!';
$_['error_button_name']              = 'Error: Button name (text) can\'t be empty!';
$_['error_customer_group_id']        = 'Error: Please select default customer group for accounts created with Facebook Login!';
$_['error_extra_info_message']       = 'Error: Extra info message is required!';
$_['error_subject']                  = 'Error: Registration mail subject is required!';
$_['error_message']                  = 'Error: Registration mail message is required!';
$_['error_message_no_credential']    = 'Error: No login credential ({email} and {password}) detected in mail message (for case when customer want to use later his account without pressing "Login with Facebook" button)!';
$_['error_html_email_not_installed'] = 'Registration Emails can\'t be sent with <a href="http://www.oc-extensions.com/HTML-Email">HTML Email Extension</a> because this extension is not available on your store. Please set option to Disabled!';
?>