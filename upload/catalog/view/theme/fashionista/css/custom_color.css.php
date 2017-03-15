<?php header('Content-type: text/css; charset=utf-8'); ?>

<?php if(!isset($_GET['color_status'])) { ?>
	<?php if($_GET['body_font_text'] != '') { ?>
	body, .hotline-title
	{
		color: #<?php echo $_GET['body_font_text']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['body_font_links'] != '') { ?>
	a, .product-filter .options .button-group button, .product-compare a {
		color: #<?php echo $_GET['body_font_links']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['body_font_links_hover'] != '') { ?>
	
	a:hover, .product-grid .product .name a:hover, .name a:hover,  .product-compare a:hover,
	 .product-filter .options .button-group button:hover, .product-filter .options .button-group .active, .review a:hover,
	.product-info .cart .add-to-cart .quantity #q_up:hover, .product-info .cart .add-to-cart .quantity #q_down:hover, #header .button-search, #livesearch_search_results li:hover a,
	#livesearch_search_results .highlighted a, .ui-notify .style_text h3 a, ul.megamenu li .sub-menu .content a:hover
	{
		color: #<?php echo $_GET['body_font_links_hover']; ?>;
	}
	.pagination .links b, .pagination .links a:hover
	{
		color: #<?php echo $_GET['body_font_links_hover']; ?>;
		border: 1px solid #<?php echo $_GET['body_font_links_hover']; ?>;
	}
	.product-info .description .fa { background: #<?php echo $_GET['body_font_links_hover']; ?>; }
	#cart .cart-heading .cart-icon {
		background: url("../image/icon-cart2.png") repeat scroll 0 0 #<?php echo $_GET['body_font_links_hover']; ?>;
	}
	
	.jcarousel-skin-opencart .jcarousel-next-horizontal {
		background: url("../image/button-next.png") no-repeat scroll center center #<?php echo $_GET['body_font_links_hover']; ?>!important;
	}
	.jcarousel-skin-opencart .jcarousel-prev-horizontal {
		background: url("../image/button-prev.png") no-repeat scroll center center #<?php echo $_GET['body_font_links_hover']; ?>!important;
	}
	<?php } ?>
	
	<?php if($_GET['body_price_text'] != '') { ?>
	.product-grid .product .price, .product-list .price, .product-info .price .price-new,.col-sm-3 .products .row > div .product .price, .col-sm-4 .products .row > div .product .price, ul.megamenu li .product .price, 
	.product-list .actions > div .price
	{
		color: #<?php echo $_GET['body_price_text']; ?>;
	}

	<?php } ?>
	
	<?php if($_GET['body_price_old_text'] != '') { ?>
	product-grid .product .price .price-old, .price .price-old, .product-list .price .price-old {
		color: #<?php echo $_GET['body_price_old_text']; ?> !important;
	}
	<?php } ?>
	
	<?php if($_GET['headlines_product_strong_text_color'] != '') { ?>
	.box .box-heading, h2, .box-heading, .filter-product .filter-tabs ul > li > a, .aboutus-title
	 
	{
		color: #<?php echo $_GET['headlines_product_strong_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['headlines_active_text_color'] != '') { ?>
	.filter-product .filter-tabs ul > li > a:hover, .filter-product .filter-tabs ul > li.active > a 
	 
	{
		color: #<?php echo $_GET['headlines_active_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['headlines_product_strong_text_color'] != '') { ?>
	.box .heading-border
	{
		background: #<?php echo $_GET['headlines_product_strong_text_color']; ?>;
	}
	<?php } ?>
	
	
	
	<?php if($_GET['product_name_text_color'] != '') { ?>
	.product-grid .product .name a, .name a, .product-grid .product .name-latest a, .name-latest a, ul.megamenu li .product .name a, .product-list .name a
	 
	{
		color: #<?php echo $_GET['product_name_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['product_name_text_color_hover'] != '') { ?>
	.product-grid .product .name a:hover, .name a:hover, .product-grid .product .name-latest a:hover, .name-latest a:hover, ul.megamenu li .product .name a:hover, .product-list .name a:hover
	 
	{
		color: #<?php echo $_GET['product_name_text_color_hover']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['body_background_color'] != '') { ?>
	body {
		background: #<?php echo $_GET['body_background_color']; ?>;
	}
	<?php } ?>

	
	<?php if($_GET['top_bar_backgroud'] != '') { ?>
	#top-line, .dropdown_l ul {
		background: #<?php echo $_GET['top_bar_backgroud']; ?>;
	}
	.my-account .dropdown-menu > li > a:hover, .language .dropdown-menu > li > a:hover, .currency .dropdown-menu > li > a:hover {
		color: #<?php echo $_GET['top_bar_backgroud']; ?>;
	}
	<?php } ?>
	<?php if($_GET['top_bar_border'] != '') { ?>
	#top-line, .mini-cart-info td {
		border-bottom: 1px solid #<?php echo $_GET['top_bar_border']; ?>;
	}
	#my-account, #tg-search, #currency, #language{
		border-left: 1px solid #<?php echo $_GET['top_bar_border']; ?>;
	}
	#cart .cart-heading, #my-login {
		border-left: 1px solid #<?php echo $_GET['top_bar_border']; ?>;
		border-right: 1px solid #<?php echo $_GET['top_bar_border']; ?>;
	}
	#tg-search .dropdown-menu, .my-account .dropdown-menu, .language .dropdown-menu, .currency .dropdown-menu, #cart .dropdown-menu, #search input[type="text"]  {
		border: 1px solid #<?php echo $_GET['top_bar_border']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['top_menu_color'] != '') { ?>
	#top-line, #welcome, #currency .arrow, #language .arrow, #my-account .arrow, .my-account a, .language a, .currency a, .my-account, #my-login a, .tg-search, #cart .cart-heading span{
		color: #<?php echo $_GET['top_menu_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['top_menu_links'] != '') { ?>
	#welcome a, .my-account .dropdown-menu > li > a, .language .dropdown-menu > li > a, .currency .dropdown-menu > li > a, #cart .dropdown-menu, #cart .dropdown-menu a, #search input[type="text"], .tg-search .button-search {
		color: #<?php echo $_GET['top_menu_links']; ?>;
	}
	.dropdown_l li a:hover {
		background: #<?php echo $_GET['top_menu_links']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['top_menu_links_hover'] != '') { ?>
	.my-account .dropdown-menu > li > a:hover, .language .dropdown-menu > li > a:hover, .currency .dropdown-menu > li > a:hover {
		color: #<?php echo $_GET['top_menu_links_hover']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['top_search_icon_background'] != '') { ?>
	.search-icon, .tg-search .button-search  {
		color: #<?php echo $_GET['top_search_icon_background']; ?>;
	}	
	<?php } ?>
	
	<?php if($_GET['menu_links'] != '') { ?>
		ul.megamenu > li > a, ul.megamenu li .sub-menu .content .static-menu a.main-menu{
			color: #<?php echo $_GET['menu_links']; ?>;
		}
	<?php } ?>
	
	<?php if($_GET['menu_links_hover'] != '') { ?>
		ul.megamenu > li > a:hover, ul.megamenu > li.active > a, ul.megamenu > li.home > a, ul.megamenu > li:hover > a {
			color: #<?php echo $_GET['menu_links_hover']; ?>;
		}
	<?php } ?>
	
	
	<?php if($_GET['menu_submenu_links'] != '') { ?>
	ul.megamenu li .sub-menu .content .hover-menu a, ul.megamenu li .sub-menu .content a {
		color: #<?php echo $_GET['menu_submenu_links']; ?>;
	}

	
	ul.manufacturer li a {
			border: 1px solid #<?php echo $_GET['menu_submenu_links']; ?>;
		}

	<?php } ?>
	
	
	<?php if($_GET['menu_submenu_links_hover'] != '') { ?>
	ul.megamenu li .sub-menu .content a:hover, ul.megamenu li .sub-menu .content .static-menu a.main-menu:hover {
		color: #<?php echo $_GET['menu_submenu_links_hover']; ?>;
	}
	ul.manufacturer li a:hover {
		border: 1px solid #<?php echo $_GET['menu_submenu_links_hover']; ?>;
	}
	ul.megamenu li .sub-menu .content .hover-menu li > a:hover {
										color: #<?php echo $_GET['menu_submenu_links_hover']; ?>;
									}
	<?php } ?>
	
	<?php if($_GET['menu_border'] != '') { ?>
		ul.megamenu li .sub-menu .content, ul.megamenu .sub-menu .content > .border {
			border: 1px solid #<?php echo $_GET['menu_border']; ?>;
		}
	<?php } ?>
	
	
	
	
	@media (max-width: 767px) {
		<?php if($_GET['mobile_icon_background'] != '') { ?>
			.responsive #megaMenuToggle,  .responsive .tg-search
			{
				background: #<?php echo $_GET['mobile_icon_background']; ?>;
			}
		<?php } ?>
		
		<?php if($_GET['mobile_icon_text'] != '') { ?>
			.responsive #megaMenuToggle,  .responsive .tg-search, .megamenuToogle-wrapper .container-home
			{
				color: #<?php echo $_GET['mobile_icon_text']; ?>;
			}
		<?php } ?>
		
		<?php if($_GET['mobile_menu_links'] != '') { ?>
			.megamenuToogle-wrapper .container-home, .responsive ul.megamenu > li > a, .responsive ul.megamenu > li.click:before, 
			.responsive ul.megamenu > li.hover:before
			{
				color: #<?php echo $_GET['mobile_menu_links']; ?>;
			}

			.megamenuToogle-wrapper .container-home > div span {
				background: #<?php echo $_GET['mobile_menu_links']; ?>;
			}
		<?php } ?>
		
		<?php if($_GET['mobile_menu_links_hover'] != '') { ?>
			.responsive ul.megamenu > li.active .close-menu:before, .responsive ul.megamenu > li > a:hover  
			{
				color: #<?php echo $_GET['mobile_menu_links_hover']; ?>;
			}
		<?php } ?>
		<?php if($_GET['mobile_submenu_links'] != '') { ?>
			.responsive ul.megamenu li .sub-menu .content a {
				color: #<?php echo $_GET['mobile_submenu_links']; ?>;
			}
			
			.responsive ul.manufacturer li a  {
				color: #<?php echo $_GET['mobile_submenu_links']; ?>!important;
			}
			.responsive ul.manufacturer li a  {
				border: 1px solid #<?php echo $_GET['mobile_submenu_links']; ?>!important;
			}
		<?php } ?>	
		
		<?php if($_GET['mobile_submenu_links_hover'] != '') { ?>
			.responsive ul.megamenu li .sub-menu .content a:hover {
				color: #<?php echo $_GET['mobile_submenu_links_hover']; ?>;
			}
			
			.responsive ul.manufacturer li a:hover, ul.megamenu li .sub-menu .content .hover-menu li > a:hover {
				color: #<?php echo $_GET['mobile_submenu_links_hover']; ?>!important;
				
			}
			.responsive ul.manufacturer li a:hover{
				border: 1px solid #<?php echo $_GET['mobile_submenu_links_hover']; ?>!important;
			}
		<?php } ?>
		
		<?php if($_GET['mobile_menu_background'] != '') { ?>
		.responsive ul.megamenu > li > a, .responsive ul.megamenu > li.active .close-menu {
			background: #<?php echo $_GET['mobile_menu_background']; ?>;
		}	
		<?php } ?>
		
		<?php if($_GET['mobile_menu_border'] != '') { ?>
		.responsive ul.megamenu > li {
			border-top: 1px solid #<?php echo $_GET['mobile_menu_border']; ?>;
		}	
		
		.responsive ul.megamenu {
			border: 1px solid #<?php echo $_GET['mobile_menu_border']; ?>;
		}	
		<?php } ?>
		
		
	}
	
	
	<?php if($_GET['slider_bullet_color'] != '') { ?>
	.tp-bullets.simplebullets.round .bullet 
	{
		border: 2px solid #<?php echo $_GET['slider_bullet_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['slider_bullet_hover_color'] != '') { ?>
	.tp-bullets.simplebullets.round .bullet:hover, .tp-bullets.simplebullets .bullet.selected 
	{
		border: 2px solid #<?php echo $_GET['slider_bullet_hover_color']; ?>;
		background: #<?php echo $_GET['slider_bullet_hover_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['column_headlines_color'] != '') { ?>
	#column_left .box .box-heading, #column_right .box .box-heading {
		color: #<?php echo $_GET['column_headlines_color']; ?>;
	}
	
	#column_left .box .heading-border, #column_right .box .heading-border {
		background: #<?php echo $_GET['column_headlines_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['column_text_color'] != '') { ?>
	.col-sm-3 .products .row > div .product .name a, .col-sm-4 .products .row > div .product .name a, .box-category > ul > li a, .box-information > ul > li > a, .box-category > ul > li ul > li > a, 
	.box-category .accordion:before
	{
		color: #<?php echo $_GET['column_text_color']; ?>;
	}
	<?php } ?>
	<?php if($_GET['column_hover_text_color'] != '') { ?>
	.box-category > ul > li ul > li > a:hover,
	.box-information > ul > li > a:hover,
	.box-category > ul > li a.active,
	.box-category > ul > li > a:hover,
	.col-sm-3 .products .row > div .product .name a:hover, .col-sm-4 .products .row > div .product .name a:hover, .box-category > ul > li a.active + .accordion:before, .box-category .accordion:hover:before, 
	.product-grid .product .name-latest a:hover, .name-latest a:hover 
	{
		color: #<?php echo $_GET['column_hover_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['breadcrumb_text_color'] != '') { ?>
	.breadcrumb .container-home ul li a {
		color: #<?php echo $_GET['breadcrumb_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['breadcrumb_hover_text_color'] != '') { ?>
	.breadcrumb .container-home ul li:last-child a, .breadcrumb .container-home ul li a:hover  {
		color: #<?php echo $_GET['breadcrumb_hover_text_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['sale_color_text'] != '') { ?>
		.sale {
			color: #<?php echo $_GET['sale_color_text']; ?>;
		}
	<?php } ?>
	
	<?php if($_GET['sale_background'] != '') { ?>
		.sale {
			background: #<?php echo $_GET['sale_background']; ?>; 
			}
	<?php } ?>
	
	<?php if($_GET['sale_border'] != '') { ?>
		.sale {
			border: 1px solid  #<?php echo $_GET['sale_border']; ?>;
		}
	<?php } ?>
	
	<?php if($_GET['to_top_color_text'] != '') { ?>
		.scrollup {
			color: #<?php echo $_GET['to_top_color_text']; ?>!important;
		}
	<?php } ?>
	
	<?php if($_GET['to_top_background'] != '') { ?>
		.scrollup {
			background: #<?php echo $_GET['to_top_background']; ?>!important; 
		}
	<?php } ?>
	
	<?php if($_GET['ratings_background'] != '') { ?>
	.rating i {
		color: #<?php echo $_GET['ratings_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['ratings_active_background'] != '') { ?>
	.rating i.active {
		color: #<?php echo $_GET['ratings_active_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['buttons_color_text']) { ?>
	.button, .btn.btn-shopping-cart, .product-grid .product .product-icon, .htabs a, .product-info .product-icon, .product-grid .product .image .quickview a   {
		color: #<?php echo $_GET['buttons_color_text']; ?>!important;
	}
	<?php } ?>
	
	<?php if($_GET['buttons_background']) { ?>
	.button, .btn.btn-shopping-cart, .product-grid .product .product-icon, .htabs a, .product-info .product-icon, .product-list .product-icon, .product-grid .product .image .quickview a  {
		background: #<?php echo $_GET['buttons_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['buttons_border']) { ?>
	.button, .btn.btn-shopping-cart, .product-grid .product .product-icon, .htabs a, .product-info .product-icon, .product-list .product-icon, .product-grid .product .image .quickview a  {
		border: 1px solid #<?php echo $_GET['buttons_border']; ?>;
	}
	<?php } ?>
	
	
	
	<?php if($_GET['buttons_hover_color_text']) { ?>
	.button:hover, .btn.btn-shopping-cart:hover, .product-grid .product .product-icon:hover, .htabs a:hover, .htabs a.selected, .product-info .product-icon:hover, .product-list .product-icon:hover,  
	.product-grid .product .image .quickview a:hover 
	{
		color: #<?php echo $_GET['buttons_hover_color_text']; ?>!important;
	}
	<?php } ?>
	
	<?php if($_GET['buttons_hover_background']) { ?>
	.button:hover, .btn.btn-shopping-cart:hover, .product-grid .product .product-icon:hover, .htabs a:hover, .htabs a.selected, .product-info .product-icon:hover, .product-list .product-icon:hover,
	.product-grid .product .image .quickview a:hover 	
	{
		background: #<?php echo $_GET['buttons_hover_background']; ?>;
		border: 1px solid #<?php echo $_GET['buttons_hover_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['buttons_hover_border']) { ?>
	.button:hover, .btn.btn-shopping-cart:hover, .product-grid .product .product-icon:hover, .htabs a:hover, .htabs a.selected, .product-info .product-icon:hover, .product-list .product-icon:hover,
	.tg-border .product-icon:hover, .product-grid .product .image .quickview a:hover 
	{
		border: 1px solid #<?php echo $_GET['buttons_hover_border']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['carousel_bullets_background']) { ?>
	.tab-content .prev-button span, .tab-content .next-button span, 
	.box .prev-button span, .box .next-button span  {
		color: #<?php echo $_GET['carousel_bullets_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['carousel_active_bullets_background']) { ?>
	.tab-content .prev-button:hover, .tab-content .prev-button span:hover, 
	.tab-content .next-button:hover, .tab-content .next-button span:hover 
	.box .prev-button:hover,.box .prev-button span:hover, 
	.box .next-button:hover ,.box .next-button span:hover 
	{
		color: #<?php echo $_GET['carousel_active_bullets_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_color_text'] != '') { ?>
 .footer a, .copyright a, .footer, .copyright {
		color: #<?php echo $_GET['customfooter_color_text']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_hover_color_text'] != '') { ?>
	 .footer a:hover, .copyright a:hover{
		color: #<?php echo $_GET['customfooter_hover_color_text']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_color_heading'] != '') { ?>
	.footer h4, .copyright h4 {
		color: #<?php echo $_GET['customfooter_color_heading']; ?>;
	}
	<?php } ?>
	

	
	<?php if($_GET['customfooter_icon_color'] != '') { ?>
	ul.contact-us li i, .facebook, .twitter, .instagram, .googleplus, .pinterest, .youtube, .flickr, .vimeo, .tumblr {
		color: #<?php echo $_GET['customfooter_icon_color']; ?>!important;
	}
	<?php } ?>
	
	<?php if($_GET['customfooter_border_color'] != '') { ?>
	.copyright .pattern {
		border-top: 1px solid #<?php echo $_GET['customfooter_border_color']; ?>;
	}	
	<?php } ?>
	
	<?php if($_GET['customfooter_background_color'] != '') { ?>
	.footer, .copyright {
		background: #<?php echo $_GET['customfooter_background_color']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['social_icon_background'] != '') { ?>
	.facebook, .twitter, .instagram, .googleplus, .pinterest, .youtube, .flickr, .vimeo, .tumblr {
		background: #<?php echo $_GET['social_icon_background']; ?>;
	}
	<?php } ?>
	
	<?php if($_GET['social_hover_icon_background'] != '') { ?>
	.facebook:hover, .twitter:hover, .instagram:hover, .googleplus:hover, .pinterest:hover, .youtube:hover, .flickr:hover, .vimeo:hover, .tumblr:hover {
		background: #<?php echo $_GET['social_hover_icon_background']; ?>;
	}
	<?php } ?>

	
	<?php if($_GET['social_icon_color'] != '') { ?>
	.facebook, .twitter, .instagram, .googleplus, .pinterest, .youtube, .flickr, .vimeo, .tumblr {
		color: #<?php echo $_GET['social_icon_color']; ?>!important;
	}
	<?php } ?>
	
	<?php if($_GET['social_hover_icon_color'] != '') { ?>
	.facebook:hover, .twitter:hover, .instagram:hover, .googleplus:hover, .pinterest:hover, .youtube:hover, .flickr:hover, .vimeo:hover, .tumblr:hover {
		color: #<?php echo $_GET['social_hover_icon_color']; ?>!important;
	}
	<?php } ?>
	
	<?php if($_GET['social_border_color'] != '') { ?>
	.facebook, .twitter, .instagram, .googleplus, .pinterest, .youtube, .flickr, .vimeo, .tumblr {
		border: 1px solid #<?php echo $_GET['social_border_color']; ?>!important;
	}
	<?php } ?>
	
	<?php if($_GET['social_hover_border_color'] != '') { ?>
	.facebook:hover, .twitter:hover, .instagram:hover, .googleplus:hover, .pinterest:hover, .youtube:hover, .flickr:hover, .vimeo:hover, .tumblr:hover {
		border: 1px solid #<?php echo $_GET['social_hover_border_color']; ?>!important;
	}
	<?php } ?>
	
	<?php if($_GET['widget_facebook_background'] != '') { ?>
	facebook_left .facebook-icon, .facebook_right .facebook-icon {
		background: url("../image/facebook-icon.png") no-repeat scroll 0 0 #<?php echo $_GET['widget_facebook_background']; ?>;
	}
	.facebook_right .facebook-content, .facebook_left .facebook-content {border: 4px solid #<?php echo $_GET['widget_facebook_background']; ?>;}
	<?php } ?>
	
	<?php if($_GET['widget_twitter_background'] != '') { ?>
	.twitter_left .twitter-icon, .twitter_right .twitter-icon {
		background: url("../image/twitter-icon.png") no-repeat scroll 0 0 #<?php echo $_GET['widget_twitter_background']; ?>;
	}
	.twitter_right .twitter-content, .twitter_left .twitter-content {border: 4px solid #<?php echo $_GET['widget_twitter_background']; ?>}
	<?php } ?>
	
	<?php if($_GET['widget_custom_background'] != '') { ?>
	.custom_left .custom-icon, .custom_right .custom-icon {
		background: url("../image/custom-icon.png") no-repeat scroll 0 0 #<?php echo $_GET['widget_custom_background']; ?>;
	}
	.custom_right .custom-content, .custom_left .custom-content {border: 4px solid #<?php echo $_GET['widget_custom_background']; ?>}
	<?php } ?>
	
	
	
	
	

<?php } ?>

<?php if($_GET['font_status'] == '1') { ?>
body {
	font-size: <?php echo $_GET['body_font_px']; ?>px;
	font-weight: <?php echo $_GET['body_font_weight']*100; ?>;
	<?php if(isset($_GET['body_font'])) { ?>
	font-family: <?php echo $_GET['body_font']; ?>;
	<?php } ?>
}

#welcome, #welcome a, .currency, .language, .my-account, .my-account .dropdown-menu > li > a, .language .dropdown-menu > li > a, .currency .dropdown-menu > li > a {
	font-size: <?php echo $_GET['top_header_font_px']; ?>px;
	font-weight: <?php echo $_GET['top_header_font_weight']*100; ?>;
	<?php if(isset($_GET['top_header_font_font'])) { ?>
	font-family: <?php echo $_GET['top_header_font_font']; ?>;
	<?php } ?>
}

ul.megamenu > li > a {
	font-size: <?php echo $_GET['categories_bar_px']; ?>px;
	font-weight: <?php echo $_GET['categories_bar_weight']*100; ?>;
	<?php if(isset($_GET['categories_bar_font'])) { ?>
	font-family: <?php echo $_GET['categories_bar_font']; ?>;
	<?php } ?>
}

ul.megamenu li .sub-menu .content a {
	<?php if(isset($_GET['categories_bar_font'])) { ?>
	font-family: <?php echo $_GET['categories_bar_font']; ?>;
	<?php } ?>
}

.megamenuToogle-wrapper .container-home {
	font-weight: <?php echo $_GET['categories_bar_weight']*100; ?>;
	<?php if(isset($_GET['categories_bar_font'])) { ?>
	font-family: <?php echo $_GET['categories_bar_font']; ?>;
	<?php } ?>
}

.box .box-heading {
	font-size: <?php echo $_GET['headlines_px']; ?>px;
	font-family: <?php echo $_GET['headlines_font']; ?>;
}

#column_left .box .box-heading, #column_right .box .box-heading, h2 {
	font-size: <?php echo $_GET['headlines_px_medium']; ?>px;
	font-weight: <?php echo $_GET['headlines_weight']*100; ?>;
	font-family: <?php echo $_GET['headlines_font']; ?>;
}


 .footer h4, .copyright h4 {
	font-size: <?php echo $_GET['footer_headlines_px']; ?>px;
	font-weight: <?php echo $_GET['footer_headlines_weight']*100; ?>;
	font-family: <?php echo $_GET['footer_headlines_font']; ?>!important;
}

 .footer, .copyright {
	font-size: <?php echo $_GET['footer_column_px']; ?>px;
	font-weight: <?php echo $_GET['footer_column_weight']*100; ?>;
	<?php if(isset($_GET['footer_column_font'])) { ?>
	font-family: <?php echo $_GET['footer_column_font']; ?>;
	<?php } ?>
}

.center-column #title-page {
	font-size: <?php echo $_GET['headlines_px']; ?>px;
	font-weight: <?php echo $_GET['headlines_weight']*100; ?>;
	<?php if(isset($_GET['page_name_font'])) { ?>
	font-family: <?php echo $_GET['page_name_font']; ?>;
	<?php } ?>
}

.button, .btn.btn-shopping-cart {
	font-size: <?php echo $_GET['button_font_px']; ?>px;
	font-weight: <?php echo $_GET['button_font_weight']*100; ?>;
	<?php if(isset($_GET['button_font'])) { ?>
	font-family: <?php echo $_GET['button_font']; ?>;
	<?php } ?>
}

.product-info .product-icon, .product-list .product-icon {
	font-size: <?php echo $_GET['button_font_px']; ?>px;
	font-weight: <?php echo $_GET['button_font_weight']*100; ?>;
}

.product-grid .product .name a, .name a, .product-grid .product .name-latest a, .name-latest a {
	font-size: <?php echo $_GET['product_name_px']; ?>px;
	font-weight: <?php echo $_GET['product_name_weight']*100; ?>;
	<?php if(isset($_GET['product_name_font'])) { ?>
	font-family: <?php echo $_GET['product_name_font']; ?>;
	<?php } ?>
}

ul.megamenu li .product .name a   {
	<?php if(isset($_GET['product_name_font'])) { ?>
	font-family: <?php echo $_GET['product_name_font']; ?>;
	<?php } ?>
}



.col-sm-3 .products .row > div .product .name a, .col-sm-4 .products .row > div .product .name a {
	<?php if(isset($_GET['product_name_font'])) { ?>
	font-family: <?php echo $_GET['product_name_font']; ?>;
	<?php } ?>
	font-weight: <?php echo $_GET['body_font_weight']*100; ?>!important;
}

<?php if(isset($_GET['custom_price_font'])) { ?>
.product-grid .product .price, .product-list .price, .product-info .price .price-new, ul.megamenu li .product .price {
	font-family: <?php echo $_GET['custom_price_font']; ?>;
	font-size: <?php echo $_GET['custom_price_px']; ?>px;
	font-weight: <?php echo $_GET['custom_price_weight']*100; ?>;
}
<?php } ?>



product-grid .product .price .price-old, .price .price-old, .product-list .price .price-old {
	font-size: <?php echo $_GET['custom_price_px_old_price']; ?>px !important;
	font-family: <?php echo $_GET['custom_price_font']; ?>;
}

.col-sm-3 .products .row > div .product .price, .col-sm-4 .products .row > div .product .price {
	font-family: <?php echo $_GET['custom_price_font']; ?>;
}
<?php } ?>