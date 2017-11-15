<?php
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
require_once( DIR_TEMPLATE.$config->get($config->get('config_theme') . '_directory')."/lib/module.php" );
$modules = new Modules($registry);
?>
<!DOCTYPE html>
<!--[if IE 7]> <html lang="<?php echo $lang; ?>" class="ie7 <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive"> <![endif]-->  
<!--[if IE 8]> <html lang="<?php echo $lang; ?>" class="ie8 <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive"> <![endif]-->  
<!--[if IE 9]> <html lang="<?php echo $lang; ?>" class="ie9 <?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive"> <![endif]-->  
<!--[if !IE]><!--> <html lang="<?php echo $lang; ?>" class="<?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no-'; } ?>responsive"> <!--<![endif]-->  
<head>
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>" />

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php if ($description) { ?>
	<meta name="description" content="<?php echo $description; ?>" />
	<?php } ?>
	<?php if ($keywords) { ?>
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<?php } ?>
	
	<!-- Google Fonts -->
	<link href='//fonts.googleapis.com/css?family=Merriweather:400,300italic,300,400italic,700,700italic,900,900italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Lato:400,300italic,300,700,700italic,900,900italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<?php 
	if( $theme_options->get( 'font_status' ) == '1' ) {
		$lista_fontow = array();
		if( $theme_options->get( 'body_font' ) != '' && $theme_options->get( 'body_font' ) != 'standard' && $theme_options->get( 'body_font' ) != 'Arial' && $theme_options->get( 'body_font' ) != 'Georgia' && $theme_options->get( 'body_font' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'body_font' );
			$lista_fontow[$font] = $font;
		}
		
		if( $theme_options->get( 'top_header_font' ) != '' && $theme_options->get( 'top_header_font' ) != 'standard' && $theme_options->get( 'top_header_font' ) != 'Arial' && $theme_options->get( 'top_header_font' ) != 'Georgia' && $theme_options->get( 'top_header_font' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'top_header_font' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'categories_bar' ) != '' && $theme_options->get( 'categories_bar' ) != 'standard' && $theme_options->get( 'categories_bar' ) != 'Arial' && $theme_options->get( 'categories_bar' ) != 'Georgia' && $theme_options->get( 'categories_bar' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'categories_bar' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'headlines' ) != '' && $theme_options->get( 'headlines' ) != 'standard' && $theme_options->get( 'headlines' ) != 'Arial' && $theme_options->get( 'headlines' ) != 'Georgia' && $theme_options->get( 'headlines' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'headlines' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'footer_headlines' ) != '' && $theme_options->get( 'footer_headlines' ) != 'standard'  && $theme_options->get( 'footer_headlines' ) != 'Arial' && $theme_options->get( 'footer_headlines' ) != 'Georgia' && $theme_options->get( 'footer_headlines' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'footer_headlines' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'page_name' ) != '' && $theme_options->get( 'page_name' ) != 'standard' && $theme_options->get( 'page_name' ) != 'Arial' && $theme_options->get( 'page_name' ) != 'Georgia' && $theme_options->get( 'page_name' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'page_name' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'product_name' ) != '' && $theme_options->get( 'product_name' ) != 'standard' && $theme_options->get( 'product_name' ) != 'Arial' && $theme_options->get( 'product_name' ) != 'Georgia' && $theme_options->get( 'product_name' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'product_name' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'button_font' ) != '' && $theme_options->get( 'button_font' ) != 'standard' && $theme_options->get( 'button_font' ) != 'Arial' && $theme_options->get( 'button_font' ) != 'Georgia' && $theme_options->get( 'button_font' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'button_font' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		if( $theme_options->get( 'custom_price' ) != '' && $theme_options->get( 'custom_price' ) != 'standard' && $theme_options->get( 'custom_price' ) != 'Arial' && $theme_options->get( 'custom_price' ) != 'Georgia' && $theme_options->get( 'custom_price' ) != 'Times New Roman' ) {
			$font = $theme_options->get( 'custom_price' );
			if(!isset($lista_fontow[$font])) {
				$lista_fontow[$font] = $font;
			}
		}
		
		foreach($lista_fontow as $font) {
			echo '<link href="//fonts.googleapis.com/css?family=' . $font . ':700,600,500,400,300" rel="stylesheet" type="text/css">';
			echo "\n";
		}
	}
	?>
	
	<?php $listcssjs = array(
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/bootstrap.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/bootstrap-theme.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/stylesheet.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/responsive.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/slider.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/menu.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/font-awesome.min.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/magnific-popup.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/jquery-ui.css',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/owl.carousel.css'
	); 
		
	if($theme_options->get( 'page_width' ) == 1) {
		$listcssjs[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/wide-grid.css';
	} 
	
	if($theme_options->get( 'page_width' ) == 3) {
		$listcssjs[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/standard-grid.css';
	} 
		
	if($theme_options->get( 'colors_status' ) == 1 || $theme_options->get( 'font_status' ) == 1) {
		$url = false;
		if($theme_options->get( 'colors_status' ) == 1) {
			$array = array(
					'body_font_text',
					'body_font_links',
					'body_font_links_hover',
					'body_price_text',
					'body_price_old_text',
					'headlines_product_strong_text_color',
					'headlines_active_text_color',
					'product_name_text_color',
					'product_name_text_color_hover',
					'body_background_color',
					'bottom_holder_background_color',
					'top_bar_backgroud',
					'top_bar_border',
					'top_menu_color',
					'top_menu_links',
					'top_menu_links_hover',
					'top_search_icon_background',
					'top_cart_block_number_background',
					'top_cart_block_number_color',
					'menu_links_hover',
					'menu_links',
					'menu_submenu_links',
					'menu_submenu_links_hover',
					'menu_border',
					'sale_border',
					'mobile_icon_background',
					'mobile_icon_text',
					'mobile_menu_links',
					'mobile_menu_links_hover',
					'mobile_submenu_links', 
					'mobile_submenu_links_hover',
					'mobile_menu_background',
					'mobile_menu_border',
					'slider_bullet_color',
					'slider_bullet_hover_color',
					'column_headlines_color',
					'column_text_color',
					'column_hover_text_color',
					'breadcrumb_text_color',
					'breadcrumb_hover_text_color',
					'sale_color_text',
					'sale_background',
					'to_top_color_text',
					'to_top_background',
					'ratings_background',
					'ratings_active_background',
					'buttons_color_text',
					'buttons_background',
					'buttons_border',
					'buttons_hover_color_text',
					'buttons_hover_background',
					'buttons_hover_border',
					'carousel_bullets_background',
					'carousel_active_bullets_background',
					'customfooter_color_text',
					'customfooter_hover_color_text',
					'customfooter_color_heading',
					'customfooter_icon_color',
					'customfooter_border_color',
					'customfooter_background_color',
					'social_icon_background',
					'social_icon_color',
					'social_border_color',
					'social_hover_icon_background',
					'social_hover_icon_color',
					'social_hover_border_color',
					'widget_facebook_background',
					'widget_twitter_background',
					'widget_custom_background',
			);
				
			$i = 0;
			foreach($array as $color) {
				if($i != 0) {
					$url .= '&';
				} 
				$url .= $color.'='.str_replace(array('#', ' '), '', $theme_options->get( $color ));
				$i++;
			}
		} else {
			$url = 'color_status=0';
		}
		
		if( $theme_options->get( 'font_status' ) == '1' ) {
			$url .= '&font_status=1';
			if( $theme_options->get( 'body_font' ) != '' && $theme_options->get( 'body_font' ) != 'standard' ) {
				$url .= '&body_font=' . str_replace(" ", "+", $theme_options->get( 'body_font' ));
			}
			
			if( $theme_options->get( 'top_header_font' ) != '' && $theme_options->get( 'top_header_font' ) != 'standard' ) {
				$url .= '&top_header_font_font=' . str_replace(" ", "+", $theme_options->get( 'top_header_font' ));
			}
			
			if( $theme_options->get( 'categories_bar' ) != '' && $theme_options->get( 'categories_bar' ) != 'standard' ) {
				$url .= '&categories_bar_font=' . str_replace(" ", "+", $theme_options->get( 'categories_bar' ));
			}
			
			if( $theme_options->get( 'headlines' ) != '' && $theme_options->get( 'headlines' ) != 'standard' ) {
				$url .= '&headlines_font=' . str_replace(" ", "+", $theme_options->get( 'headlines' ));
			}
			
			if( $theme_options->get( 'footer_headlines' ) != '' && $theme_options->get( 'footer_headlines' ) != 'standard' ) {
				$url .= '&footer_headlines_font=' . str_replace(" ", "+", $theme_options->get( 'footer_headlines' ));
			}
			
			if( $theme_options->get( 'footer_column' ) != '' && $theme_options->get( 'footer_column' ) != 'standard' ) {
				$url .= '&footer_column_font=' . str_replace(" ", "+", $theme_options->get( 'footer_column' ));
			}
			
			if( $theme_options->get( 'page_name' ) != '' && $theme_options->get( 'page_name' ) != 'standard' ) {
				$url .= '&page_name_font=' . str_replace(" ", "+", $theme_options->get( 'page_name' ));
			}
			
			if( $theme_options->get( 'product_name' ) != '' && $theme_options->get( 'product_name' ) != 'standard' ) {
				$url .= '&product_name_font=' . str_replace(" ", "+", $theme_options->get( 'product_name' ));
			}
			
			if( $theme_options->get( 'button_font' ) != '' && $theme_options->get( 'button_font' ) != 'standard' ) {
				$url .= '&button_font=' . str_replace(" ", "+", $theme_options->get( 'button_font' ));
			}
			
			if( $theme_options->get( 'custom_price' ) != '' && $theme_options->get( 'custom_price' ) != 'standard' ) {
				$url .= '&custom_price_font=' . str_replace(" ", "+", $theme_options->get( 'custom_price' ));
			}
			
			$url .= '&body_font_px=' . $theme_options->get( 'body_font_px' );
			$url .= '&body_font_weight=' . $theme_options->get( 'body_font_weight' );
			$url .= '&top_header_font_weight=' . $theme_options->get( 'top_header_font_weight' );
			$url .= '&top_header_font_px=' . $theme_options->get( 'top_header_font_px' );
			$url .= '&categories_bar_weight=' . $theme_options->get( 'categories_bar_weight' );
			$url .= '&categories_bar_px=' . $theme_options->get( 'categories_bar_px' );
			$url .= '&headlines_weight=' . $theme_options->get( 'headlines_weight' );
			$url .= '&headlines_px=' . $theme_options->get( 'headlines_px' );
			$url .= '&headlines_px_medium=' . $theme_options->get( 'headlines_px_medium' );
			$url .= '&footer_headlines_weight=' . $theme_options->get( 'footer_headlines_weight' );
			$url .= '&footer_headlines_px=' . $theme_options->get( 'footer_headlines_px' );
			$url .= '&footer_column_weight=' . $theme_options->get( 'footer_column_weight' );
			$url .= '&footer_column_px=' . $theme_options->get( 'footer_column_px' );
			$url .= '&page_name_weight=' . $theme_options->get( 'page_name_weight' );
			$url .= '&page_name_px=' . $theme_options->get( 'page_name_px' );
			$url .= '&product_name_weight=' . $theme_options->get( 'product_name_weight' );
			$url .= '&product_name_px=' . $theme_options->get( 'product_name_px' );
			$url .= '&button_font_weight=' . $theme_options->get( 'button_font_weight' );
			$url .= '&button_font_px=' . $theme_options->get( 'button_font_px' );
			$url .= '&custom_price_weight=' . $theme_options->get( 'custom_price_weight' );
			$url .= '&custom_price_px=' . $theme_options->get( 'custom_price_px' );
			$url .= '&custom_price_px_old_price=' . $theme_options->get( 'custom_price_px_old_price' );
		}
			
		$listcssjs[] = 'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/css/custom_color.css.php?'.$url;
	} ?>
		
	<?php echo $theme_options->compressorCodeCss( $config->get($config->get('config_theme') . '_directory'), $listcssjs, 0, HTTP_SERVER ); ?>
	
	<?php if($theme_options->get( 'background_status' ) == 1) { ?>
	<style type="text/css">
		<?php if($theme_options->get( 'body_background_background' ) == '1') { ?> 
		body { background-image:none !important; }
		<?php } ?>
		<?php if($theme_options->get( 'body_background_background' ) == '2') { ?> 
		body { background-image:url(image/<?php echo $theme_options->get( 'body_background' ); ?>);background-position:<?php echo $theme_options->get( 'body_background_position' ); ?>;background-repeat:<?php echo $theme_options->get( 'body_background_repeat' ); ?> !important;background-attachment:<?php echo $theme_options->get( 'body_background_attachment' ); ?> !important; }
		<?php } ?>
		

		
	</style>
	<?php } ?>
	
	<?php if($theme_options->get( 'custom_code_css_status' ) == 1) { ?>
	<link rel="stylesheet" href="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/skins/store_<?php echo $theme_options->get( 'store' ); ?>/<?php echo $theme_options->get( 'skin' ); ?>/css/custom_code.css">
	<?php } ?>
	
	<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/css/ie8.css" />
	<![endif]-->
	
	<?php foreach ($styles as $style) { ?>
	<?php if($style['href'] == 'catalog/view/theme/default/stylesheet/slideshow.css') { ?>
	<link rel="<?php echo $style['rel']; ?>" type="text/css" href="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/css/slideshow.css" media="<?php echo $style['media']; ?>" />
	<?php } elseif($style['href'] == 'catalog/view/theme/default/stylesheet/carousel.css') { ?>
	<link rel="<?php echo $style['rel']; ?>" type="text/css" href="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/css/carousel.css" media="<?php echo $style['media']; ?>" />
	<?php } else { ?>
	<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
	<?php } ?>
	<?php } ?>
	
	<?php if($theme_options->get( 'page_width' ) == 2 && $theme_options->get( 'max_width' ) > 900) { ?>
	<style type="text/css">
		.standard-body .full-width .container {
			max-width: <?php echo $theme_options->get( 'max_width' ); ?>px;
			<?php if($theme_options->get( 'responsive_design' ) == '0') { ?>
			width: <?php echo $theme_options->get( 'max_width' ); ?>px;
			<?php } ?>
		}
		
		.standard-body .fixed .background,
		.main-fixed {
			max-width: <?php echo $theme_options->get( 'max_width' )-40; ?>px;
			<?php if($theme_options->get( 'responsive_design' ) == '0') { ?>
			width: <?php echo $theme_options->get( 'max_width' )-40; ?>px;
			<?php } ?>
		}
	</style>
	<?php } ?>
    
    <?php $listcssjs = array(
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.min.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery-migrate-1.2.1.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery-ui-1.10.4.custom.min.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/bootstrap.min.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/twitter-bootstrap-hover-dropdown.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.themepunch.plugins.min.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.themepunch.revolution.min.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/common.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.cookie.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.magnific-popup.min.js',
    		'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/jquery.elevateZoom-3.0.3.min.js',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/modernizr.js',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/notify.js',
			'catalog/view/theme/'.$config->get($config->get('config_theme') . '_directory').'/js/owl.carousel.min.js'
    ); ?>
    	
    <?php echo $theme_options->compressorCodeJs( $config->get($config->get('config_theme') . '_directory'), $listcssjs, 0, HTTP_SERVER ); ?>
	
	<script type="text/javascript">
	var transition = 'slide';
	var animation_time = 300;
	
	var checkout_url = '<?php echo $checkout; ?>';
	var responsive_design = '<?php if($theme_options->get( 'responsive_design' ) == '0') { echo 'no'; } else { echo 'yes'; } ?>';
	</script>
	<?php foreach ($scripts as $script) { ?>
	<?php if($script == 'catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js') { ?>
	<script type="text/javascript" src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/jquery.nivo.slider.pack.js"></script>
	<?php } else { ?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
	<?php } ?>
	<?php } ?>
	<?php if($theme_options->get( 'custom_code_javascript_status' ) == 1) { ?>
	<script type="text/javascript" src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/skins/store_<?php echo $theme_options->get( 'store' ); ?>/<?php echo $theme_options->get( 'skin' ); ?>/js/custom_code.js"></script>
	<?php } ?>
	

	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>

	<?php foreach ($analytics as $analytic) { ?>
	<?php echo $analytic; ?>
	<?php } ?>   
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="catalog/view/theme/<?php echo $config->get($config->get('config_theme') . '_directory'); ?>/js/respond.min.js"></script>
	<![endif]-->
</head>	
<body>

<div id="notification" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="font-family: "Roboto Condensed",sans-serif!important;"><?php if($theme_options->get( 'confirmation_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'confirmation_text', $config->get( 'config_language_id' ) ); } else { echo 'Confirmation'; } ?></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="button modal-left-button"  data-dismiss="modal"><?php if($theme_options->get( 'continue_shopping_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'continue_shopping_text', $config->get( 'config_language_id' ) ); } else { echo 'Continue shopping'; } ?></button>
                <a href="<?php echo $shopping_cart; ?>" class="button modal-right-button"><?php if($theme_options->get( 'checkout_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'checkout_text', $config->get( 'config_language_id' ) ); } else { echo 'View Cart'; } ?></a>
            </div>
        </div>
    </div>
</div>

<?php if($theme_options->get( 'widget_facebook_status' ) == 1) { ?>
<div class="facebook_<?php if($theme_options->get( 'widget_facebook_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="facebook-icon"></div>
	<div class="facebook-content">
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		
		<div class="fb-like-box fb_iframe_widget" profile_id="<?php echo $theme_options->get( 'widget_facebook_id' ); ?>" data-colorscheme="light" data-height="370" data-width="243" data-connections="16" fb-xfbml-state="rendered"></div>
	</div>
	
	<script type="text/javascript">    
	$(function() {  
		$(".facebook_right").hover(function() {            
			$(".facebook_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".facebook_right").stop(true, false).animate({right: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".facebook_left").hover(function() {            
			$(".facebook_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".facebook_left").stop(true, false).animate({left: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
</div>
<?php } ?>

<?php if($theme_options->get( 'widget_twitter_status' ) == 1) { ?>
<div class="twitter_<?php if($theme_options->get( 'widget_twitter_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="twitter-icon"></div>
	<div class="twitter-content">
		<a class="twitter-timeline"  href="https://twitter.com/@<?php echo $theme_options->get( 'widget_twitter_user_name' ); ?>" data-chrome="noborders" data-tweet-limit="<?php echo $theme_options->get( 'widget_twitter_limit' ); ?>"  data-widget-id="<?php echo $theme_options->get( 'widget_twitter_id' ); ?>" data-theme="light" data-related="twitterapi,twitter" data-aria-polite="assertive">Tweets by @<?php echo $theme_options->get( 'widget_twitter_user_name' ); ?></a>
	</div>
	
	<script type="text/javascript">    
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	$(function() {  
		$(".twitter_right").hover(function() {            
			$(".twitter_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".twitter_right").stop(true, false).animate({right: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".twitter_left").hover(function() {            
			$(".twitter_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".twitter_left").stop(true, false).animate({left: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
</div>
<?php } ?>

<?php if($theme_options->get( 'widget_custom_status' ) == 1) { ?>
<div class="custom_<?php if($theme_options->get( 'widget_custom_position' ) == 1) { echo 'left'; } else { echo 'right'; } ?> hidden-xs hidden-sm">
	<div class="custom-icon"></div>
	<div class="custom-content">
		<?php $lang_id = $config->get( 'config_language_id' ); ?>
		<?php $custom_content = $theme_options->get( 'widget_custom_content' ); ?>
		<?php if(isset($custom_content[$lang_id])) echo html_entity_decode($custom_content[$lang_id]); ?>
	</div>
	
	<script type="text/javascript">    
	$(function() {  
		$(".custom_right").hover(function() {            
			$(".custom_right").stop(true, false).animate({right: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".custom_right").stop(true, false).animate({right: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	
		$(".custom_left").hover(function() {            
			$(".custom_left").stop(true, false).animate({left: "0"}, 800, 'easeOutQuint');        
		}, function() {            
			$(".custom_left").stop(true, false).animate({left: "-250"}, 800, 'easeInQuint');        
		}, 1000);    
	});  
	</script>
	
</div>
<?php } ?>


<div id="quickview" class="modal fade bs-example-modal-lg">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Product</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>
    </div>
</div>

<?php if($theme_options->get( 'quick_view' ) == 1) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/magnific/magnific-popup.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js"></script>
<script type="text/javascript">
	$('body').on('click', '.quickview a', function () {
		$('#quickview .modal-header .modal-title').html($(this).attr('title'));
		$('#quickview .modal-body').load($(this).attr('rel') + ' #quickview_product' ,function(result){
		    $('#quickview').modal('show');
		    $('#quickview .popup-gallery').magnificPopup({
		    	delegate: 'a',
		    	type: 'image',
		    	tLoading: 'Loading image #%curr%...',
		    	mainClass: 'mfp-img-mobile',
		    	gallery: {
		    		enabled: true,
		    		navigateByImgClick: true,
		    		preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		    	},
		    	image: {
		    		tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		    		titleSrc: function(item) {
		    			return item.el.attr('title');
		    		}
		    	}
		    });
		});
		return false;
	});
	
	$('#quickview').on('click', '#button-cart', function () {
		$('#quickview').modal('hide');
		cart.add($(this).attr("rel"));
	});
</script>
<?php } ?>
<div class="fixed-body">
		<div id="main" class="main-fixed">

		
		
		<header>
			<div id="top-line">
				<div class="container-home">
					<div class="row">

						
						<div class="col-sm-6 hidden-xs">
							<div id="welcome">
								<?php if($theme_options->get( 'welcome_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'welcome_text', $config->get( 'config_language_id' ) )); } ?>
							</div>
						</div>
				  
						<div class="col-sm-6 col-xs-12 hidden-xs">
							
								<div class="quick-access">
									
								
									<div class="dropdown  my-account tg-account hidden-xs hidden-sm">
										<div id="my-account">
											<div class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
												<?php echo $text_login; ?>
											</div>
											
											<ul class="dropdown-menu"  role="menu">
												<?php if ($logged) { ?>
												<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
												<li><a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a></li>
												<li><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
												<li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
												<li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
												<?php } else { ?>
												<li><a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
												<li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
												<li><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
												<li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
												<?php } ?>
											</ul>	
										</div>	
									</div>
									
									
									<div class="dropdown  my-account currency">
										<?php echo $currency; ?>
									</div>

									<div class="dropdown  my-account language">
										<?php echo $language; ?>
									</div>
									
									<div class="dropdown tg-search hidden-xs">
										<div id="tg-search">
											<div class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
												<span class="fa fa-search search-icon"></span><?php if($theme_options->get( 'search_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'search_text', $config->get( 'config_language_id' ) )); } else { echo 'Search'; } ?>
											</div>
											
											<ul class="dropdown-menu keep_open">
												<li>
												
													
													<div id="search">
														<input type="text" name="search" placeholder="<?php if($theme_options->get( 'search_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'search_text', $config->get( 'config_language_id' ) )); } else { echo 'Search'; } ?>" value="" />
														<span class="button-search fa fa-search"></span>
													
												</li>
											</ul>	
											
											
											
										</div>	
									</div>

									<?php echo $cart; ?>	
	
								</div>		
						</div>
						
						<div class="visible-xs col-xs-12" style="text-align:center;display:inline-block;">
							<div class="my-account"	style="display:inline-block!important;">
										<?php echo $currency; ?>
									</div>
							<div class="my-account"	style="display:inline-block!important;">
										<?php echo $language; ?>
							</div>
							
							<div id="my-login" style="display:inline-block!important;">
								<a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
							</div>	
						</div>
						
						
					</div>
				</div>	
			</div>
			
			<div id="header">	
				<div class="container-home">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 logo-inner">
							<div class="logo-store" >
								<a href="<?php echo $home; ?>">
									<img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
								</a>
							</div>
						</div>
						
						<?php 
							if($registry->has('theme_options') == true) { 
								require_once( DIR_TEMPLATE.$config->get($config->get('config_theme') . '_directory')."/lib/module.php" );
								$modules = new Modules($registry);
								$language_id = $config->get( 'config_language_id' );
								$customfooter = $theme_options->get( 'customfooter' );
						?>
						<?php } ?>	

					<div class="visible-xs col-xs-12" style="text-align:center;display:inline-block; margin-bottom:20px;">
						<div id="megaMenuToggle">
							<div class="megamenuToogle-wrapper">
								<div class="megamenuToogle-pattern">
									<div class="container">
										<span class="fa fa-bars"></span>
									</div>
								</div>
							</div>
						</div>
						
						<a href="<?php echo $shopping_cart; ?>">
						<div class="tg-search" style="display:inline-block;">
							<span class="fa fa-shopping-cart"></span>
						</div>	
						</a>
						<div class="tg-search" style="display:inline-block;">
										<div id="tg-search2">
											<div class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
												<span class="fa fa-search"></span>
											</div>
											
											<ul class="dropdown-menu keep_open">
												<li>
												
												<div id="search">
														<input type="text" name="search2" placeholder="<?php if($theme_options->get( 'search_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'search_text', $config->get( 'config_language_id' ) )); } else { echo 'Search'; } ?>" value="" />
														<span class="button-search2 fa fa-search"></span>
												</li>
											</ul>	
										</div>	
						</div>	
						
					
					</div>	
						
						
						<?php 
					$menu = $modules->getModules('menu');
					if( count($menu) ) {
						foreach ($menu as $module) {
							echo $module;
						}
					} elseif($categories) {
					?>
					<div class="container-megamenu horizontal">
						
						<div class="megamenu-wrapper">
							<div class="megamenu-pattern">
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding-left: 0px; padding-right: 0px;">
										<div class="menu-holder">
											<ul class="megamenu">
												
												<?php foreach ($categories as $category) { ?>
												<?php if ($category['children']) { ?>
												<li class="with-sub-menu hover"><p class="close-menu"></p>
													<a href="<?php echo $category['href'];?>"><span><strong><?php echo $category['name']; ?></strong></span></a>
												<?php } else { ?>
												<li>
													<a href="<?php echo $category['href']; ?>"><span><strong><?php echo $category['name']; ?></strong></span></a>
												<?php } ?>
													<?php if ($category['children']) { ?>
													<?php 
														$width = '100%';
														$row_fluid = 3;
														if($category['column'] == 1) { $width = '220px'; $row_fluid = 12; }
														if($category['column'] == 2) { $width = '500px'; $row_fluid = 6; }
														if($category['column'] == 3) { $width = '700px'; $row_fluid = 4; }
													?>
													<div class="sub-menu" style="width: <?php echo $width; ?>">
														<div class="content">
															<div class="row hover-menu">
																<?php for ($i = 0; $i < count($category['children']);) { ?>
																<div class="col-sm-<?php echo $row_fluid; ?>">
																	<div class="menu">
																		<ul>
																		  <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
																		  <?php for (; $i < $j; $i++) { ?>
																		  <?php if (isset($category['children'][$i])) { ?>
																		  <li><a href="<?php echo $category['children'][$i]['href']; ?>" onclick="window.location = '<?php echo $category['children'][$i]['href']; ?>';"><?php echo $category['children'][$i]['name']; ?></a></li>
																		  <?php } ?>
																		  <?php } ?>
																		</ul>
																	</div>
																</div>
																<?php } ?>
															</div>
														</div>
													</div>
													<?php } ?>
												</li>
												<?php } ?>
											</ul>
										</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					}
					?>
					
					

							
						
						
	
					</div>
				</div>
			</div>	
			
			
			
			
					
		<?php $slideshow = $modules->getModules('slideshow'); ?>
	<?php  if(count($slideshow)) { ?>
	<!-- Slider -->
	<div id="slider" class="full-width slider-bottom">
				<?php foreach($slideshow as $module) { ?>
				<?php echo $module; ?>
				<?php } ?>
	</div>
	<?php } ?>			

	
</header>

<script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '124685028239401');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=124685028239401&ev=PageView&noscript=1"/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
