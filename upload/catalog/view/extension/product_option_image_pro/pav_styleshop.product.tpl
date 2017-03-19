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
	
	poip_product_custom.prototype.additional_useOldOCStyleInit = function() {
		return true;
	}
	
	// >> ADDITIONAL FUNCTIONS 
	
	// << REPLACING FUNCTIONS
	// to be called from standard function, to work instead of standard algorithm (prefixes replace_ and if_)

	poip_product_custom.prototype.replace_setVisibleImages = function(images, counter) {
		var this_object = this;
		
		if (!counter) counter = 1;
		if (counter == 50) return;
	
		if ( $('#image-additional').length ) {
		
			// first time - copy all images to hidden element
			if ( !$('#poip_images').length ) {
			
				// count elements per item
				var images_per_item = Math.max(4, $('#image-additional').find('.item:first').find('a').length);
			
				$('#image-additional').before('<div id="poip_images" style="display:none;" data-images-per-item="'+images_per_item+'"></div>');
				$('#image-additional-carousel a').each(function(){
					$('#poip_images').append( $(this).clone() );
				});
			};
			
			var current_imgs = [];
			$('.image-additional').find('a').each( function(){
				current_imgs.push($(this).attr('data-image'));
			});
			
			if ( current_imgs.toString() == images.toString() ) {
				this_object.set_visible_images_timer_id = false;
				return; // nothing to change
			}
			
			// add visible images to carousel
			var pg_html = "";
			var shown_imgs = [];
			var anchors_cnt = 0;
			var images_per_item = $('#poip_images').attr('data-images-per-item');
			$('#poip_images a').each(function(){
				
				if ($.inArray( $(this).attr('data-image'), images) != -1 && $.inArray($(this).attr('data-zoom-image'), shown_imgs) == -1 ) {
				
					if (anchors_cnt%images_per_item==0) {
						if (anchors_cnt>0) pg_html = pg_html + "</div>";
						pg_html = pg_html + '<div class="item clearfix gallery_01">';
					}
				
					// show
					pg_html = pg_html + this_object.getElementOuterHTML($(this))+' ';
					shown_imgs.push(this.href);
					
					anchors_cnt++;
				}
			});
			if (pg_html != "") {
				pg_html = pg_html + "</div>";
			}
			
			if (pg_html != $('#image-additional-carousel').html()) {
			
				$('#image-additional-carousel').html(pg_html);
				
				if ($('#image-additional-carousel').find('.item').length>1) {
					$('#image-additional').find(".carousel-control").show();
				} else {
					$('#image-additional').find(".carousel-control").hide();
				}
				
				$('#image-additional .item:first').addClass('active');
				
				if (poip_settings['img_hover']) {
					$('#image-additional-carousel a').mouseover(function(){
						this_object.eventAdditionalImageMouseover(this);
					});
				}
				
			}
		}
		this_object.set_visible_images_timer_id = false;
	}
	
	poip_product_custom.prototype.replace_updateZoomImage = function(img_click) {
		var this_object = this;
		
		var image_click_a = $('#image-additional-carousel a[data-image="'+img_click+'"]');
		if ( image_click_a.length ) {
		
			if ( poip_elevate_zoom_object ) { // global
				var big_img = image_click_a.attr('data-zoom-image');
				
				poip_elevate_zoom_object.swaptheimage(img_click, big_img);
				
				poip_elevate_zoom_object.$elem.unbind("click");
				poip_elevate_zoom_object.$elem.bind("click", function(e) {
					$.magnificPopup.open({
						items: {
							src:  big_img
						},
						type: 'image'
					}); return false; 
				}); 
			}
		}
	}
	
	poip_product_custom.prototype.if_beforeColorboxReinit = function() {
		// for quickview
		$('.pav-colorbox').colorbox({
				width: '980px', 
				height: '80%',
				overlayClose: true,
				opacity: 0.5,
				iframe: true, 
		});
		
		// if used zoom, colorbox for images not used
		if ($('#image-additional').find('a[data-zoom-image][data-image]').length && $('.zoomWindowContainer').find('div').length) {
			$('#image-additional').find('a[data-zoom-image][data-image]').click(function (event) {
				event.preventDefault();
			});
			return true;
		}
		return false;
	}
	
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>