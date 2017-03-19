<script type="text/javascript"><!--

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
		
		if (!counter) counter = 1;
		if (counter == 50) return;
	
		if ( $('#image-additional').length ) {
			
			if ( !$('#poip_images').length ) {
				$('#image-additional').before('<div id="poip_images" style="display:none;"></div>');
				$('#image-additional a').each(function(){
					$('#poip_images').append( $(this).clone() );
				});
			}
			
			var current_carousel = $('#image-additional').data('owlCarousel');
			
			if (!current_carousel || !$('#image-additional .owl-item').length || !$('.zoomContainer').length ) {
				setTimeout(function(){ this_object.replace_setVisibleImages(images, counter+1); }, 100);
				return;
			}
			
			var current_imgs = [];
			$('.image-additional').find('a').each( function(){
				current_imgs.push($(this).attr('data-zoom-image'));
			});
			
			if ( current_imgs.toString() == images.toString() ) {
				this_object.set_visible_images_timer_id = false;
				return; // nothing to change
			}
			
			var shown_imgs = [];
			
			html = '';
			$('#poip_images a').each(function(){
				if ( $.inArray($(this).attr('data-zoom-image'), images) != -1 && $.inArray($(this).attr('data-zoom-image'), shown_imgs) == -1 ) {
					html += '<div>'+ this_object.getElementOuterHTML($(this)) +'</div>';
					shown_imgs.push( $(this).attr('data-zoom-image') );
				}
			});
			
			$('#image-additional').replaceWith('<div class="thumbnails__list-image owl-carousel" id="image-additional">'+html+'</div>');
			
			$('.thumbnails__list-image').owlCarousel({
				loop:true,
				margin:10,
				responsive:{
					0:{
					items:2
					},
					600:{
					items:3
					},
					1000:{
					items:5
					}
				}
			});
			
			// elevateZoom destroy
			$.removeData($("#main-image"), 'elevateZoom');
			$.removeData($("#main-image"), 'zoomImage');
			//$('.zoomWrapper img.zoomed').unwrap();
			$('.zoomContainer').remove();
			
			if (Kuler.image_zoom_type == 'outer_cloud' || Kuler.image_zoom_type == 'inner_cloud') {
				var zoom_params = {
					cursor: 'pointer',
					galleryActiveClass: 'active',
					imageCrossfade: true,
					lensShape: Kuler.lens_zoom_shape == 'rounded' ? 'round' : 'square'
				};
		
				if (Kuler.image_zoom_type == 'outer_cloud') {
					zoom_params.zoomWindowWidth = Kuler.zoom_window_width;
					zoom_params.zoomWindowHeight = Kuler.zoom_window_height;
				}
		
				if (Kuler.image_zoom_type == 'inner_cloud') {
					zoom_params.zoomType = 'inner';
				}
		
				$("#main-image").elevateZoom(zoom_params);
			}
		
			$('#image-additional a').on('click', function (e) {
				e.preventDefault();
		
				var imagePath = $(this).data('zoomImage');
		
				$('#main-image')
					.attr('src', imagePath)
					.attr('data-zoom-image', imagePath)
					.data('zoomImage', imagePath)
					.data('elevateZoom').swaptheimage(imagePath, imagePath);
			});
		
			if (Kuler.image_lightbox) {
				$("#main-image").bind("click", function(e) {
					var $this = $(this);
		
					var items = [{
						src: $this.data('zoomImage') || this.src
					}];
		
					$('.product-image-link').each(function () {
						if (items[0].src != this.href) {
							items.push({
								src: this.href
							});
						}
					});
		
					$.magnificPopup.open({
						items: items,
						gallery: {
							enabled: true
						},
						type: 'image',
						mainClass: 'mfp-fade'
					});
		
					e.preventDefault();
				});
			}
			
			if (poip_settings['img_hover']) {
				$('#image-additional a').mouseover(function(){
					this_object.eventAdditionalImageMouseover(this);
				}); 
			}
		}
	}

	poip_product_custom.prototype.replace_getDocumentReadyState = function() {
		var this_object = this;
		
		// elevateZoom zoomContainer may be not created yet, it may give js css error, so let's wait
		// it may be useful for other themes with elevateZoom
		
		return document.readyState == 'complete' && $('.zoomContainer').length; 
		
	}
	
	poip_product_custom.prototype.if_refreshOptionImagesContainer = function() {
		var this_object = this;
		
		$('#option-images-'+product_option_id).remove();
		if (!$('#option-images-'+product_option_id).length) {
			if ($('#option-'+product_option_id).length) { // OC 1.X style
				$('#option-'+product_option_id).append('<div id="option-images-'+product_option_id+'"></div>');
			} else { // OC 2.0 style
				if ( $(option).parent().is('label') ) { // custom
					$(option).parent().after('<div id="option-images-'+product_option_id+'" style="margin-top: 10px;"></div>');
				} else { // default
					$(option).after('<div id="option-images-'+product_option_id+'" style="margin-top: 10px;"></div>');
				}
			}
		}
		
		return true;
	}
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>