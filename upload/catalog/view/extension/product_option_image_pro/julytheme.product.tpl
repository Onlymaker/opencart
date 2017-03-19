<script type="text/javascript"><!--
	// 2016/12/01

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
		
		var carousel_selector = '#image-additional';
		var carousel_elem = $(carousel_selector);
		var carousel_items = $('#image-additional-carousel');
		
		if ( carousel_elem.length && carousel_items.length ) {
			
			if ( !$('#poip_images').length ) {
				carousel_elem.before('<div id="poip_images" style="display:none;"></div>');
				carousel_items.find('a').each(function(){
					$('#poip_images').append( $(this).clone() );
				});
			}
			
			var current_carousel = carousel_elem.data('bs.carousel'); // bootstrap carousel ?
			
			if ( this_object.set_visible_images_first_call ) {
				if (!current_carousel || document.readyState != "complete" ) {
					this_object.set_visible_images_timer_id = setTimeout(function(){ this_object.replace_setVisibleImages(images, counter+1); }, 100);
					return;
				}
				this_object.set_visible_images_first_call = false;
			} else {
				var current_imgs = [];
				carousel_items.find('a').each( function(){
					current_imgs.push($(this).attr('data-zoom-image'));
				});
				
				if ( current_imgs.toString() == images.toString() ) {
					this_object.set_visible_images_timer_id = false;
					return; // nothing to change
				}
			}
			
			var shown_imgs = [];
			var html = '';
			var item_images_limit = <?php echo $numbimg2; ?>;
			var item_images_cnt = 0;
			var items_cnt = 0;
			
			// correct order of images
			for (var i in images) {
				if ( !images.hasOwnProperty(i) ) continue;
				var elem = $('#poip_images a[data-zoom-image="'+images[i]+'"]:first');
				if (elem.length) {
					
					if ( item_images_cnt == 0 ) {
						if ( items_cnt == 0 ) {
							html += '<div class="item active">';
						} else {
							html += '<div class="item">';
						}
					}
					
					html += ' <div data-index="'+item_images_cnt+'" '+(items_cnt==0&&item_images_cnt==0 ? ' class="active" ' : '')+'>'+ this_object.getElementOuterHTML(elem) +'</div>';
					
					item_images_cnt++;
					if ( item_images_cnt > item_images_limit ) {
						html += '</div> ';
						item_images_cnt = 0;
						items_cnt++;
					}
				}
			}
			if ( item_images_cnt == 0 ) {
				html += '</div> ';
			}
			
			carousel_items.html(html);
			carousel_items.find('a').each(function(index){
				//$(this).parent().attr('data-index', index);
			});
			
			//carousel_items.find('.item:first').addClass("Active");
			//carousel_items.find('.item:first div:first').addClass("Active");
			
			// zoom	
			$("#main-image").elevateZoom({
				gallery:'image-additional-carousel', 
				cursor: 'pointer',
				galleryActiveClass: 'active',
			});	
			
			//popup
			$('.thumbnails .thumbnail').magnificPopup({
				items: [
				
					<?php if ($thumb) { ?>
					{src: '<?php echo $popup; ?>'},
					<?php } ?>
					<?php if ($images) { ?>
					<?php foreach ($images as $image) { ?>
					{src: '<?php echo $image['popup']; ?>'},
					<?php } ?>
				<?php } ?>
				],
				gallery: { enabled: true, preload: [0,2] },
				type: 'image',
				mainClass: 'mfp-fade',
				 <?php if ($images) { ?>
				callbacks: {
					open: function() {
						var activeIndex = parseInt($('.image-additional .item div.active').attr('data-index'));
						var magnificPopup = $.magnificPopup.instance;
						magnificPopup.goTo(activeIndex);
					}
				}
				<?php } ?>
			});
			
			if (poip_settings['img_hover']) {
				carousel_items.find('a').mouseover(function(){
					this_object.eventAdditionalImageMouseover(this);
				}); 
			}
			
		}
		
		this_object.set_visible_images_timer_id = false;
	}
	
	poip_product_custom.prototype.if_setMainImage = function(main, popup) {
		var this_object = this;
		return true;
	}
	
	poip_product_custom.prototype.replace_useMainImageUpdatingOnMouseover = function() {
		return false;
	}
	
	// returns result of jQuery call ( $(...) ) or FALSE
	poip_product_custom.prototype.if_getMainImage = function() {
		var this_object = this;
		
		if ($('#main-image').length) {
				return $('#main-image');
			}
	
		return false;
	}
	
	poip_product_custom.prototype.replace_getAdditionalImageMouseoverHref = function(image_a) {
		return $(image_a).attr('data-zoom-image') ;
	}
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>