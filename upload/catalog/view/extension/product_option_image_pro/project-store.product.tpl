<script type="text/javascript"><!--
	// 2016/08/31 // 2016/10/2016

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
	
	poip_product_custom.prototype.additional_useAddInitialMainImageToPoipImages = function(images) {
		return images;
	}
	
	poip_product_custom.prototype.replace_refreshPopupImages = function() {
		// nothing
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
		
		var images_container_selector = '.thumbnails .images';
		var images_container = $(images_container_selector);
		if ( images_container.length ) {
			
			if ( !$('#poip_images').length ) {
				images_container.before('<div id="poip_images" style="display:none;"></div>');
				var added_img = [];
				images_container.find('a').each(function(){
					if ( $.inArray($(this).attr('href'), added_img) == -1 ) {
						$('#poip_images').append( $(this).parent().clone() ); // <li>
						added_img.push($(this).attr('href'));
					}
				});
				$('#poip_images a').removeAttr('data-lightbox-gallery');
				
			}
			
			var its_first_call = false;
			if ( this_object.set_visible_images_first_call ) {
				if ( document.readyState != "complete" ) {
					this_object.set_visible_images_timer_id = setTimeout(function(){ this_object.replace_setVisibleImages(images, counter+1); }, 100);
					return;
				}
				its_first_call = true;
				this_object.set_visible_images_first_call = false;
			}
			
			if (its_first_call) {
				var current_imgs = [];
				images_container.find('a').each( function(){
					current_imgs.push($(this).attr('href'));
				});
				
				if ( current_imgs.toString() == images.toString() ) {
					this_object.set_visible_images_timer_id = false;
					return; // nothing to change
				}
			}
			
			var shown_imgs = [];
			
			var html = '';
			for (var images_i in images) {
				var image_elem = $('#poip_images a[href="'+images[images_i]+'"]:first');
				if (image_elem.length) {
					html += ''+ this_object.getElementOuterHTML( image_elem.parent() ) +'';
				}
			}
			
			images_container.find('ul').html(html);
			
			// to remove all slider objects and data
			$('.thumbnails').html( $('.thumbnails').html() );
			var images_container = $(images_container_selector);
			
			images_container.find('a').attr('data-lightbox-gallery', 'gallery');
			images_container.find('a.lightbox').nivoLightbox({
				effect:'fadeScale',
				theme:'pjstore'
			});
			
			
			$('.thumbnails .thumb a').off('click');
			$('.thumbnails .thumb a').click(function(e){
				e.preventDefault();
				var href = $(this).attr('href');
				images_container.find('a[href="'+href+'"]:first').click();
			});

			if (poip_settings['img_hover']) {
				images_container.find('a').mouseover(function(){
					this_object.eventAdditionalImageMouseover(this);
				}); 
			}
		}	
		this_object.set_visible_images_timer_id = false;
	}
	
	poip_product_custom.prototype.replace_getMainImage = function() {
		return $('.thumbnails .thumb a img');
	}
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>