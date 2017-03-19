<script type="text/javascript"><!--
	// StoreFlex Fashion // 2017/02/11 // copied from theme707

	var poip_product_custom = function(){
		poip_product_default.call(this);
	}
	poip_product_custom.prototype = Object.create(poip_product_default.prototype);
	poip_product_custom.prototype.constructor = poip_product_custom;
	
	
	poip_product_custom.prototype.replace_setVisibleImages = function(images, counter) {
		
		var this_object = this;
		
		if ( $('.ajax-quickview-images').length ) { // quickview
			
			var selector_gallery = '.ajax-quickview-images';
			var gallery = $(selector_gallery);
			
			if ( !$('#poip_images').length ) {
				gallery.before('<div id="poip_images" style="display:none;"></div>');
				gallery.find('ul li img').each(function(){
					$('#poip_images').append( this_object.getElementOuterHTML($(this).parent()) ); // <li>
				});
			}
			
			var images_quick = [];
			for ( var i_images in images ) {
				if ( !images.hasOwnProperty(i_images) ) continue;
				
				var image_popup = images[i_images];
				var poip_image = this_object.getImageBySrc(image_popup, 'popup');
				if ( poip_image ) {
					images_quick.push(poip_image['quick']);
				}
			}
			
			var current_imgs = [];
			gallery.find('ul li img').each( function(){
				current_imgs.push($(this).attr('src'));
			});
			
			if ( current_imgs.toString() == images_quick.toString() ) {
				this_object.set_visible_images_timer_id = false;
				return; // nothing to change
			}
			
			var image_before = '';
			if ( gallery.find('li.active').length ) {
				image_before = gallery.find('li.active img').attr('src');
			}
			
			var html = '';
			for ( var i_images_quick in images_quick ) {
				if ( !images_quick.hasOwnProperty(i_images_quick) ) continue;
				var image_quick = images_quick[i_images_quick];
				var elem_image = $('#poip_images img[src="'+image_quick+'"]:first');
				if ( elem_image.length ) {
					html+= this_object.getElementOuterHTML(elem_image.parent());
				}
			}
			gallery.find('ul').html(html);
			
			gallery.find('ul li').removeClass('active');
			if ( image_before && gallery.find('ul li img[src="'+image_before+'"]').length ) {
				gallery.find('ul li img[src="'+image_before+'"]').parent().addClass('active');
			}
			gallery.find('ul li:first').addClass('active');
			
			
		} else { // product page
		
			var selector_gallery_main = '#productGallery';
			var selector_gallery_mobile = '#productFullGallery';
			var container_gallery_main = $(selector_gallery_main).closest('.image-thumb');
			var container_gallery_mobile = $(selector_gallery_mobile).closest('.image-thumb');
			
			if ( !$('#poip_images').length ) {
				container_gallery_main.before('<div id="poip_images" style="display:none;"></div>');
				this_object.getAdditionalImagesBlock().each(function(){
					$('#poip_images').append( this_object.getElementOuterHTML($(this)) );
				});
			}
			
			// for second gallery (used for mobile devices)
			if ( !$('#poip_images_gallery').length ) {
				container_gallery_mobile.before('<div id="poip_images_gallery" style="display:none;"></div>');
				$(selector_gallery_mobile).find('a').each(function(){
					$('#poip_images_gallery').append( this_object.getElementOuterHTML($(this).parent()) ); // parent - <li>
				});
			}
			
			var current_imgs = [];
			this_object.getAdditionalImagesBlock().find('a').each( function(){
				current_imgs.push($(this).attr('data-image'));
			});
			
			if ( current_imgs.toString() == images.toString() ) {
				this_object.set_visible_images_timer_id = false;
				return; // nothing to change
			}
	
		
			var new_html = '';
			//var shown_imgs = [];
			for ( var i_images in images ) {
				if ( !images.hasOwnProperty(i_images) ) continue;
				//if ( $.inArray(images[i_images], shown_imgs) == -1 ) {
					var poip_image = this_object.getImageBySrc(images[i_images], 'popup');
					if ( poip_image ) {
						var elem_image = $('#poip_images a[data-image="'+poip_image['main']+'"]:first');
						if ( elem_image.length ) {
							new_html+= this_object.getElementOuterHTML(elem_image.parent());
							//shown_imgs.push(images[i_images]);
						}
					}
				//}
			}
			
			/*
			var shown_imgs = [];
			var new_html = '';
			$('#poip_images').find('a').each( function(){
				if ( $.inArray( $(this).attr('data-image'), images_main) != -1 && $.inArray( $(this).attr('data-image'), shown_imgs) == -1) {
					new_html+= this_object.getElementOuterHTML($(this).parent());
					shown_imgs.push($(this).attr('data-image'));
				}
			});
			*/
			
			container_gallery_main.html('<ul id="productGallery" class="image-additional" data-slide-width="<?php echo $image_additional_width; ?>">'+new_html+'</ul>');
			
			var o = $(selector_gallery_main);
			o.bxSlider({
					mode: 'vertical',
					pager: false,
					controls: true,
					slideMargin: 13,
					minSlides: 4,
					maxSlides: 4,
					slideWidth: o.attr('data-slide-width') ? o.attr('data-slide-width') : undefined,
					nextText: '<i class="material-design-drop25"></i>',
					prevText: '<i class="material-design-drop27"></i>',
					infiniteLoop: false,
					adaptiveHeight: true,
					moveSlides: 1
			});
				
			o.find('li:first-child a').addClass('zoomGalleryActive');
	
			$('#productZoom').bind("click", function (e) {
				var imgArr = [];
				o.find('a').each(function () {
					img_src = $(this).data("image");
	
					//put the current image at the start
					if (img_src == $('#productZoom').find('img').attr('src')) {
						imgArr.unshift({
							href: '' + img_src + '',
							title: $(this).find('img').attr("title")
						});
					}
					else {
						imgArr.push({
							href: '' + img_src + '',
							title: $(this).find('img').attr("title")
						});
					}
				});
				$.fancybox(imgArr);
				return false;
			});
	
	
			o.find('[data-image]').click(function (e) {
				e.preventDefault();
				o.find('.active').removeClass('zoomGalleryActive');
				var img = $(this).data('image');
				$(this).addClass('zoomGalleryActive');
				$('#productZoom').find('.inner img').each(function () {
						$(this).attr('src', img);
				});
			});
			
			
			var second_new_html  = '';
			for ( var i_images in images ) {
				if ( !images.hasOwnProperty(i_images) ) continue;
				//if ( $.inArray(images[i_images], second_shown_imgs) == -1 ) {
					var poip_image = this_object.getImageBySrc(images[i_images], 'popup');
					if ( poip_image ) {
						var elem_image = $('#poip_images_gallery a[href="'+poip_image['main']+'"]:first');
						if ( elem_image.length ) {
							second_new_html += this_object.getElementOuterHTML(elem_image.parent());
							//second_shown_imgs.push(images[i_images]);
						}
					}
				//}
			}
			
			container_gallery_mobile.html('<ul id="productFullGallery" class="image-additional" data-slide-width="<?php echo $image_additional_width; ?>">'+second_new_html+'</ul>');
				
			$(selector_gallery_mobile).bxSlider({
				pager:false,
				controls:true,
				minSlides: 1,
				maxSlides: 1,
				infiniteLoop:false,
				moveSlides:1
			});
			
			$(selector_gallery_main).find('a').mouseover(function(){
				this_object.eventAdditionalImageMouseover(this);
			});
		}
		
		this_object.set_visible_images_timer_id = false;
	}
	
	poip_product_custom.prototype.replace_getAdditionalImagesBlock = function() {
		return $('#productGallery li');
	}
	
	// returns result of jQuery call ( $(...) ) or FALSE
	poip_product_custom.prototype.if_getMainImage = function() {
		var this_object = this;
		return $('#productZoom');
	}
	
	poip_product_custom.prototype.if_updateZoomImage = function(img_click) {
		var this_object = this;
		
		if ( $('.ajax-quickview-images').length ) { // quickview - // just make the image active in the carousel
			
			var poim_img = this_object.getImageBySrc(img_click, 'popup');
			if ( poim_img ) {
				var new_active_image_elem = $('.ajax-quickview-images .ajax-quickview-image img[src="'+poim_img['quick']+'"]');
				if ( new_active_image_elem.length ) {
					var new_active_image_container = new_active_image_elem.closest('.ajax-quickview-image');
					new_active_image_container.siblings().removeClass('active');
					new_active_image_container.addClass('active');
				}
			}
		} else {	
			this_object.elevateZoomDirectChange(img_click);
		}
		
		return true;
	}
	

	var poip_product = new poip_product_custom();

//--></script>