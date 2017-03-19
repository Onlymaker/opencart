<script type="text/javascript"><!--
	// Minoan // 2017-02-18

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
	
	// by click sometimes does not work
	poip_product_custom.prototype.additional_afterElevateZoomClickImage = function(img_click) {
		var this_object = this;
		
		
		this_object.elevateZoomDirectChange(img_click);
		
	}	

	// >> ADDITIONAL FUNCTIONS 
	
	// << REPLACING FUNCTIONS
	// to be called from standard function, to work instead of standard algorithm (prefixes replace_ and if_)

	
	poip_product_custom.prototype.replace_setVisibleImages = function(images, counter) {
		var this_object = this;
		
		if (!counter) counter = 1;
		if (counter == 100) {
			this_object.set_visible_images_timer_id = false;
			return;
		}
	
		if ( $('.image-additional').length ) {
			
			if ( !$('#poip_images').length ) {
				$('.image-additional').before('<div id="poip_images" style="display:none;"></div>');
				$('.image-additional a').each(function(){
					$('#poip_images').append( $(this).clone() );
				});
			}
			
			var current_carousel = $('.image-additional.owl-carousel').data('owlCarousel');
			if ( this_object.set_visible_images_first_call ) {
				if (!current_carousel || !$('.image-additional.owl-carousel .owl-item').length || !$('.zoomContainer').length ) {
					this_object.set_visible_images_timer_id = setTimeout(function(){ this_object.replace_setVisibleImages(images, counter+1); }, 100);
					return;
				}
				this_object.set_visible_images_first_call = false;
			} else {
			
				var current_imgs = [];
				$('.image-additional').find('a').each( function(){
					current_imgs.push($(this).attr('data-zoom-image'));
				});
				
				if ( current_imgs.toString() == images.toString() ) {
					this_object.set_visible_images_timer_id = false;
					return; // nothing to change
				}
			}
				
			var elems_cnt = current_carousel.itemsAmount;
			for (var i = 1; i<=elems_cnt; i++ ) {
				current_carousel.removeItem();
			}
			
			var shown_imgs = [];
			
			html = '';
			for ( var i_images in images ) {
				if ( !images.hasOwnProperty(i_images) ) continue;
				var img_elem = $('#poip_images a[data-zoom-image="'+images[i_images]+'"]:first');
				if ( img_elem.length ) {
					html += '<div>'+ this_object.getElementOuterHTML(img_elem) +'</div>';
				}
			}
			
			current_carousel.addItem(html);
			current_carousel.reinit();
			
			// elevateZoom destroy
			$.removeData($(".thumbnails-image img"), 'elevateZoom');
			$('.zoomContainer').remove();
			$(".thumbnails-image img").elevateZoom({
				zoomType : "window",
				cursor: "crosshair",
				gallery:'gallery_01', 
				cursor: 'crosshair', 
				galleryActiveClass: "active", 
				imageCrossfade: true,
				zoomWindowFadeIn: 500, 
				zoomWindowFadeOut: 500, 
				lensFadeIn: 500, 
				lensFadeOut: 500,
				zoomWindowHeight: 350,
				zoomWindowWidth: 350,
				borderSize: 1,
			});

			
			if (poip_settings['img_hover']) {
				$('.image-additional a').mouseover(function(){
					this_object.eventAdditionalImageMouseover(this);
				}); 
			}
			
		}
		
		this_object.set_visible_images_timer_id = false;
	}
	
	poip_product_custom.prototype.if_getAdditionalImageMouseoverHref = function(image_a) {
		return $(image_a).attr('data-zoom-image');
	}
	
	
	
	
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>