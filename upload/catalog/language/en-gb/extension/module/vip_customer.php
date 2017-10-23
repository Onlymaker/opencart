<?php
// text enclosed in curly bracket {} will be replaced by actual value.  For example, {vip_name} will be replaced by Gold

$_['heading_title'] = 'VIP Status';

$_['text_login'] = 'Please <a href="index.php?route=account/login">login</a> to view your VIP status.';

$_['text_vip_discount_total'] = 'VIP Discount ({vip_discount})';

$_['text_vip_price'] = 'VIP Price';
$_['text_vip_prices'] = 'VIP Prices';

$_['text_all'] = 'All';
$_['text_monthly'] = 'Monthly';
$_['text_quarterly'] = 'Quarterly';
$_['text_semiannually'] = 'Semiannually';
$_['text_annually'] = 'Annually';

$_['email_subject'] = '{store_name} VIP Membership Notification';
$_['email_content'] = '
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
  <div><a href="{store_url}"><img src="{store_logo}" alt="{store_name}"></a></div>
  <div>
    Dear {customer_firstname},<br/>
    <img src="{vip_image}" alt="{vip_level}"><br/>
    Your VIP level is now <b>{vip_level}</b> and your discount on regular price product is <b>{vip_discount} %</b>.  Please <a href="{store_url}">visit the store</a> and enjoy your new saving.<br/>
    Best Regards,<br/>
    {store_name}
  </div>
</body>
</html>
';

$_['text_detail'] = 'VIP Details';
$_['heading_detail_title'] = '{customer_name} VIP Data';
$_['text_detail_current'] = 'Data For Current VIP Level ({date_range})';
$_['text_detail_next'] = 'Data For Upcoming VIP Level ({date_range})';
$_['text_all_date_range'] = 'All Dates';
$_['text_vip_start_date'] = 'Start Date: {start_date}';
$_['text_vip_generals'] = 'VIP Calculation Parameters';
$_['text_vip_levels'] = 'VIP Levels';
$_['text_vip_summary'] = 'Current VIP Summary';

$_['column_order_id'] = 'Order ID';
$_['column_order_date'] = 'Order Date';
$_['column_order_total'] = 'Order Total';
$_['text_vip_not_applicable'] = 'VIP data is not available!';

$_['entry_spending_type'] = 'Order Period:';
$_['entry_shipping'] = 'Include Shipping:';
$_['entry_tax'] = 'Include Tax:';
$_['entry_credit'] = 'Include Store Credit:';
$_['entry_reward'] = 'Include Reward:';
$_['entry_coupon'] = 'Include Coupon:';

$_['column_level'] = 'VIP Level';
$_['column_spending'] = 'Qualified Spending';
$_['column_discount'] = 'Discount';
$_['column_vip_amt'] = 'Amount Toward VIP';
$_['column_total'] = 'VIP Total';
$_['column_vip_init'] = 'VIP Initial Amount';

$_['entry_level'] = 'Current VIP Level';
$_['entry_discount'] = 'Current VIP Discount';
$_['entry_discount_end_date'] = 'Current VIP Discount End Date';
$_['entry_vip_order'] = 'Current VIP Order Total';
$_['entry_next_level'] = 'Next VIP Level';
$_['entry_next_discount'] = 'Next VIP Discount';
$_['entry_amount_to_next'] = 'Amount Needed to Next VIP Level';
$_['entry_next_cutoff_date'] = 'Next VIP Level Cutoff Date';
$_['entry_next_start_date'] = 'Next VIP Level Start Date';
?>
