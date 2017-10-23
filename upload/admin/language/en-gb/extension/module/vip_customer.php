<?php
$_['heading_title'] = 'VIP Customer Discount';
$_['text_edit'] = 'Edit ' . $_['heading_title'];
$_['text_module'] = 'Modules';
$_['text_success'] = 'Your changes have been saved!';

$_['text_vip_notification'] = 'VIP level for {customer_name} is now {vip_name}';
$_['text_note'] = 'Note: To manually assign customer to certain VIP level, edit customer (sales->customers->customers->edit) and set the "Initial VIP Amount" value to the same value as the "Qualified Spending" for that level';
$_['error_permission'] = 'Warning: You do not have permission to modify!';
$_['entry_init_vip'] = 'Initial VIP Amount:';
$_['help_init_vip'] = 'This amount will be added to customer order total to determine his/her VIP level';
$_['success'] = 'Your changes were saved!';
$_['attn_setup'] = 'Please setup your General Settings first!';
$_['text_disable_module'] = 'Disable Module';

$_['tab_setting'] = 'VIP Settings';
$_['heading_vip_level'] = 'VIP Levels';
$_['column_level_name'] = 'Name';
$_['column_level_spending'] = 'Spending';
$_['column_level_discount'] = 'Discount %';
$_['column_level_image'] = 'Badge';
$_['column_action'] = 'Action';
$_['button_remove'] = 'Remove';
$_['button_add_level'] = 'Add Level';
$_['text_browse'] = 'Browse Images';
$_['text_clear'] = 'Clear Image';

$_['entry_status'] = 'Status:';

$_['tab_general'] = 'General Settings';
$_['help_general'] = 'The below settings apply to all VIP levels';
$_['text_spending_type_all'] = 'All';
$_['text_spending_type_annually'] = 'Annually';
$_['text_spending_type_semiannually'] = 'Semi-Annually';
$_['text_spending_type_quarterly'] = 'Quarterly';
$_['text_spending_type_monthly'] = 'Monthly';
$_['text_spending_type_days'] = 'Days from today';
$_['text_day'] = 'Days';
$_['entry_spending'] = 'Qualified Spending:';
$_['help_spending'] = 'Amount customer must meet to qualify for this VIP level';
$_['entry_spending_type'] = 'Order Period:';
$_['help_spending_type'] = 'All: Use all orders <br/>Annually: Use order since last year <br/>Semi-Annually: Use orders since last half of the year<br/>Quarterly: Use orders since last quarter (Q1:1-3, Q2:4-6, Q3:7-9, Q4:10-12) <br/>Monthly: Use orders since last month';
$_['entry_shipping'] = 'Include Shipping:';
$_['help_shipping'] = 'Include shipping cost in the calculation of customer spending (yes would increase order total)';
$_['entry_tax'] = 'Include Tax:';
$_['help_tax'] = 'Include tax in the calculation of customer spending (yes would increase order total)';
$_['entry_credit'] = 'Include Store Credit:';
$_['help_credit'] = 'Include store credit in the calculation of customer spending (yes would decrease order total)';
$_['entry_reward'] = 'Include Reward:';
$_['help_reward'] = 'Include reward point in the calculation of customer spending (yes would decrease order total)';
$_['entry_coupon'] = 'Include Coupon:';
$_['help_coupon'] = 'Include coupon discount in the calculation of customer spending (yes would decrease order total)';
$_['entry_show_vip_price_table'] = 'Show VIP Prices Table:';
$_['help_show_vip_price_table'] = 'Show VIP prices table on product page.  This show product discounted price only, option price is not included';
$_['entry_customer_group'] = 'Customer Groups:';
$_['help_customer_group'] = 'VIP calculation will be applied only to selected customer groups';
$_['entry_store'] = 'Stores:';
$_['help_store'] = 'VIP calculation will be applied only to selected stores';
$_['entry_email_customer'] = 'Email Customer:';
$_['help_email_customer'] = 'Email customer when VIP level changes.  Email will not be sent if VIP level is changed to none';
$_['entry_email_admin'] = 'Email Admin:';
$_['help_email_admin'] = 'Email admin when VIP level changes.  Email will not be sent if VIP level is changed to none';
$_['text_vip_price'] = 'VIP Dicounted Price';
$_['text_vip_discount'] = 'VIP Discounted Percent';
$_['entry_discount_product'] = 'Apply VIP discount on discount product';
$_['help_discount_product'] = 'Checked to apply VIP discount on discount product (product > discount tab).  Customer will receive double discount';
$_['entry_special_product'] = 'Apply VIP discount on special product';
$_['help_special_product'] = 'Checked to apply VIP discount on special product (product > special tab).  Customer will receive double discount';
$_['entry_hide_vip_price'] = 'Hide VIP Price on storefront';
$_['entry_complete_status'] = 'Complete Order Statuses';
$_['help_complete_status'] = 'Complete order statuses are selected under option tab for store settings';
$_['entry_current_period'] = 'Use Current Period';
$_['entry_log'] = 'Log';
$_['help_log'] = 'Log output in error log';

$_['tab_data'] = 'Customer Data';
$_['column_customer_name'] = 'Customer Name';
$_['column_customer_email'] = 'Customer Email';
$_['column_vip_customer'] = 'VIP Level';
$_['column_vip_customer_init'] = 'Init. VIP Amount';
$_['column_vip_customer_total'] = 'VIP Current Total';

$_['text_vip_detail'] = 'VIP Detail';

$_['button_clear_filter'] = 'Clear Filter';

$_['email_subject'] = '{store_name} VIP Membership Notification';

$_['text_short_date'] = 'Short Date';
$_['text_long_date'] = 'Long Date';
$_['text_custom'] = 'Custom';
$_['text_date_format'] = 'Date Format';
$_['help_date_format'] = 'Date format characters can be found at';
$_['update_customers'] = 'Customer VIP status will be updated automatically when they login or make a purchase.  You can also run the link below to update all customers manually.  For large database, update process may timeout, please refresh the page until you see a successful message.  For monthly, quarterly, semi-annually, and annually period calculation, you can run this link in cronjob at the beginning of the period to update all customers.';
?>
