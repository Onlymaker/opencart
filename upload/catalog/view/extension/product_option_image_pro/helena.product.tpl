<script type="text/javascript"><!--
	// 2016/12/08

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
		if (counter == 100) {
			this_object.set_visible_images_timer_id = false;
			return;
		}
		
		var carousel_selector = '[data-call="bxslider"]';
		var carousel_elem = $(carousel_selector);
	
		if ( carousel_elem.length && carousel_elem.closest('.thumb-slider').length ) {
		
			if ( !$('#poip_images').length ) {
				carousel_elem.closest('.thumb-slider').before('<div id="poip_images" style="display:none;"></div>');
				carousel_elem.find('li a').each(function(){
					$('#poip_images').append( this_object.getElementOuterHTML( $(this).parent() ) );
				});
			}
			
			if ( this_object.set_visible_images_first_call ) {
				if ( document.readyState != "complete" ) {
					this_object.set_visible_images_timer_id = setTimeout(function(){ this_object.replace_setVisibleImages(images, counter+1); }, 100);
					return;
				}
				this_object.set_visible_images_first_call = false;
			} else {
				var current_imgs = [];
				carousel_elem.find('a').each( function(){
					current_imgs.push($(this).attr('href'));
				});
				
				if ( current_imgs.toString() == images.toString() ) {
					this_object.set_visible_images_timer_id = false;
					return; // nothing to change
				}
			}
			
			var html = '';
			for (var i in images) {
				if ( !images.hasOwnProperty(i) ) continue;
				
				var elem = $('#poip_images a[href="'+images[i]+'"]:first');
				if (elem.length) {
					html += this_object.getElementOuterHTML(elem);
				}
			}
			
			html = '<ul class="thumb-pager" class="bxslider" data-call="bxslider">'+html+'</ul>';
			
			carousel_elem.closest('.thumb-slider').html(html);
			
			carousel_elem = $(carousel_selector);
			carousel_elem.bxSlider( {pager:false, slides:4, slideMargin:10} );
			
			carousel_elem.find("a[data-gal^='prettyPhoto']:not(.bx-clone):not(.main-image):visible").prettyPhoto({hook:'data-gal', overlay_gallery:false, social_tools:false});
			
			$('.main-image').off('click');
			$('.main-image').click( function() {
				carousel_elem.find('a[href="'+$(this).attr('href')+'"]:not(.bx-clone)').click();
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
	
		return $('.main-image:first img:first');
	}
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>