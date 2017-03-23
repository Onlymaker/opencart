<script type="text/javascript"><!--
	// imarket // 2017/03/17

	var poip_product_custom = function(){
		poip_product_default.call(this);
	}
	poip_product_custom.prototype = Object.create(poip_product_default.prototype);
	poip_product_custom.prototype.constructor = poip_product_custom;
	
	poip_product_custom.prototype.custom_init = function(){
		var this_object = this;
		
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
		if (counter == 100) {
			this_object.set_visible_images_timer_id = false;
			return;
		}
		
		var carousel_selector = '#thumbnails';
		var carousel_elem = $(carousel_selector);
	
		if ( carousel_elem.length ) {
			
			if ( !$('#poip_images').length ) {
				carousel_elem.before('<div id="poip_images" style="display:none;"></div>');
				carousel_elem.find('a').each(function(){
					$('#poip_images').append( $(this).clone() );
				});
			}
			
			var current_carousel = carousel_elem.data('owlCarousel');
			
			if ( this_object.set_visible_images_first_call ) {
				if (!current_carousel || !carousel_elem.find('.owl-item').length || document.readyState != "complete" ) {
					this_object.set_visible_images_timer_id = setTimeout(function(){
						this_object.replace_setVisibleImages(images, counter+1);
					}, 100);
					return;
				}
				this_object.set_visible_images_first_call = false;
			} else {
				var current_imgs = [];
				carousel_elem.find('a').each( function(){
					current_imgs.push($(this).attr('href')); // push all elements, even if image is duplicated
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
			//var mfp_items = [];
			
			html = '';
			// correct order of images
			for (var i in images) {
				if ( !images.hasOwnProperty(i) ) continue;
				var elem = $('#poip_images a[href="'+images[i]+'"]:first');
				if (elem.length) {
					// new owlCarousel version
					current_carousel.addItem('<li class="thumb-items">'+ this_object.getElementOuterHTML(elem) + '</li>');
				}
			}
			// new owlCarousel version
			current_carousel.reinit();
	
			carousel_elem.find('li a').off('click');
			carousel_elem.find('li a').on('click', function(e){
				e.preventDefault();
			});
			
			if (poip_settings['img_hover']) {
				carousel_elem.find('a').mouseover(function(){
					this_object.eventAdditionalImageMouseover(this);
				}); 
			}
		}
	
		this_object.set_visible_images_timer_id = false;
	}
	
	// returns result of jQuery call ( $(...) ) or FALSE
	poip_product_custom.prototype.if_getMainImage = function() {
		var this_object = this;
	
		return $('#product-thumb');
	}
	
	poip_product_custom.prototype.if_updateZoomImage = function(img_click) {
		var this_object = this;
		
		this_object.elevateZoomDirectChange(img_click);
		
		return true;
	}
	
	/*
	poip_product_custom.prototype.if_refreshPopupImages = function() {
		var this_object = this;

		if ( $('div.image-additional').length ) { 
			
			if ( typeof($.magnificPopup) != 'undefined' ) {
				$('.thumbnails').magnificPopup({
					type:'image',
					delegate: '.image-additional a:visible',
					gallery: {
						enabled:true
					}
				});
			}
			
			this_object.getMainImage().off('click');
			//this_object.getMainImage().off('click', this_object.eventMainAImgClick);
			this_object.getMainImage().on('click', function(event) { this_object.eventMainAImgClick(event, this); } );
		return true;
		}
	}
	*/
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>