<script type="text/javascript"><!--
	// 2016/07/25 // 2016/10/29

	var poip_product_custom = function(){
		poip_product_default.call(this);
	}
	poip_product_custom.prototype = Object.create(poip_product_default.prototype);
	poip_product_custom.prototype.constructor = poip_product_custom;
	
	poip_product_custom.prototype.custom_init = function(){
		
	}
	
	// << ITS OWN FUNCTIONS
	// >> ITS OWN FUNCTIONS
	
	// << ADDITIONAL FUNCTIONS
	// without replacing or stopping original script execution, just addition

	// >> ADDITIONAL FUNCTIONS 
	
	// << REPLACING FUNCTIONS
	// to be called from standard function, to work instead of standard algorithm (prefixes replace_ and if_)

	
	poip_product_custom.prototype.replace_setVisibleImages = function(images, counter) {
		var this_object = this;
		
		clearTimeout(this_object.set_visible_images_timer_id);
		if (!counter) counter = 1;
		if (counter == 100) {
			this_object.set_visible_images_timer_id = false;
			return;
		}
	
		<?php if ( !empty($images_slider) ) { ?>
	
			var carousel_selector = '#owl-images';
			var carousel_elem = $(carousel_selector);
		
			if ( carousel_elem.length ) {
				
				if ( !$('#poip_images').length ) {
					carousel_elem.before('<div id="poip_images" style="display:none;"></div>');
					carousel_elem.find('a').each(function(){
						$('#poip_images').append( $(this).clone() );
					});
				}
				
				var current_carousel = carousel_elem.data('owlCarousel');
				
				var it_was_first_call = false;
				if ( this_object.set_visible_images_first_call ) {
					if (!current_carousel || !carousel_elem.find('.owl-item').length || document.readyState != "complete" ) {
						this_object.set_visible_images_timer_id = setTimeout(function(){ this_object.replace_setVisibleImages(images, counter+1); }, 100);
						return;
					}
					this_object.set_visible_images_first_call = false;
					it_was_first_call = true;
				}
				
				if (!it_was_first_call) {
					var current_imgs = [];
					carousel_elem.find('a').each( function(){
						//if ( $.inArray($(this).attr('href'), current_imgs) == -1) {
							current_imgs.push($(this).attr('href'));
						//}
					});
					
					if ( current_imgs.toString() == images.toString() ) {
						this_object.set_visible_images_timer_id = false;
						return; // nothing to change
					}
				}
				
				// for new owlCarousel version
				var elems_cnt = current_carousel.itemsAmount;
				for (var i = 1; i<=elems_cnt; i++ ) {
					current_carousel.removeItem();
				}
	
				var shown_imgs = [];
				var mfp_items = [];
				
				html = '';
				// correct order of images
				for (var i in images) {
					if ( !images.hasOwnProperty(i) ) continue;
					var elem = $('#poip_images a[href="'+images[i]+'"]:first');
					if (elem.length) {
						
						mfp_items.push({src: elem.attr('href')});
						
						// new owlCarousel version
						current_carousel.addItem('<div class="item">'+ this_object.getElementOuterHTML(elem) + '</div>');
					}
				}
				// new owlCarousel version
				current_carousel.reinit();
		
				$('.images-additional img').off('click');
				<?php if (!empty($zoom)) { ?>
					$('.images-additional img').click(function(){
						var oldsrc = $(this).attr('src');
						newsrc = $(this).parent().attr('id');
						newhref = $(this).parent().attr('href');
						number = $(this).attr('data-number');
						
						$('#imageWrap img').attr('src', newsrc);
						
						$('.main-image img').attr('src', newsrc);
						$('.main-image').attr('href', newhref);
						$('.main-image').attr('data-number', number);
						$('.cloud-zoom').CloudZoom();
						return false;
					});
				<?php } else { ?>
				
					//  gallery: { enabled: true, preload: [0,2] },
					$('.thumbnails .main-image').magnificPopup({
						items: mfp_items,
						type:'image',
						callbacks: {
						open: function() {
								$('body').addClass('razmiv2');
								$('#pagefader2').fadeIn(70);
								if (document.body.scrollHeight > document.body.offsetHeight) {
									$('#top3').css('right', '8.5px');
								}
							}, 
						close: function() {
								$('body').removeClass('razmiv2');
								$('#pagefader2').fadeOut(70);
								$('#top3').css('right', 'initial');
							}
						}
					});
				<?php } ?>
				
				if (poip_settings['img_hover']) {
					carousel_elem.find('a').mouseover(function(){
						this_object.eventAdditionalImageMouseover(this);
					}); 
				}
			}
		<?php } else { ?>
			var shown_img = [];
			this_object.getAdditionalImagesBlock().find('a').each( function(){
				if ( $.inArray( $(this).attr('href'), images) != -1 && $.inArray( $(this).attr('href'), shown_img) == -1) {
					$(this).show();
					$(this).attr('data-poip-visible', true);
					shown_img.push($(this).attr('href'));
				} else {
					$(this).hide();
					$(this).removeAttr('data-poip-visible');
				}
			});
			
			if ( $('.thumbnails .images-additional').data('magnificPopup') ) {
				$('.thumbnails .images-additional').data('magnificPopup').delegate = 'a[data-poip-visible]';
			}
		<?php } ?>
		
		this_object.set_visible_images_timer_id = false;
	}

	poip_product_custom.prototype.if_updateZoomImage = function(img_click) {
		var this_object = this;
		
		<?php if ( !empty($images_slider) ) { ?>
			$('#owl-images a[href="'+img_click+'"] img:first').each(function(){
				var oldsrc = $(this).attr('src');
				newsrc = $(this).parent().attr('id');
				newhref = $(this).parent().attr('href');
				number = $(this).attr('data-number');
				
				$('#imageWrap img').attr('src', newsrc);
				
				$('.main-image img').attr('src', newsrc);
				$('.main-image').attr('href', newhref);
				$('.main-image').attr('data-number', number);
				<?php if (!empty($zoom)) { ?>
					$('.cloud-zoom').CloudZoom();
				<?php } ?>
			});
		<?php } ?>	
		
		return true;
	}
	
	poip_product_custom.prototype.if_getAdditionalImagesBlock = function() {
		var this_object = this;
		
		<?php if ( empty($images_slider) ) { ?>
			return $('div.images-additional');
		<?php } ?>
		
		return false;
	}
	
	// returns result of jQuery call ( $(...) ) or FALSE
	poip_product_custom.prototype.if_getMainImage = function() {
		var this_object = this;
		
		<?php if ( empty($images_slider) ) { ?>
			return $('.main_img_box a.main-image img');
		<?php } ?>
		
		return false;
	}
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>