<?php
/* Product Option Image PRO module  */ 
if ( !empty($poip_installed) ) {  ?>
	<script  type = "text/javascript" ><!--
		
		var poip_list_default = function() {
			this.wait_server_call = false;
			this.image_cache = {};
			this.url_get_images = 'index.php?route=module/product_option_image_pro/get_products_list_images';
			this.init();
		};
		
		poip_list_default.prototype.init = function() {
			var this_object = this;
			
			this_object.poip_jquery_timer = setInterval( function(){
				if (typeof($) != 'undefined' && typeof(this_object.readyRun) == 'function' ) {
					clearInterval(this_object.poip_jquery_timer);
					this_object.readyRun();
				}
			},100);
			
		}
		
		poip_list_default.prototype.showThumb = function(elem) {
			var this_object = this;
			
			if ( typeof(this_object.replace_showThumb) == 'function' ) {
				return this_object.replace_showThumb();
			}
			
			if ($(elem).attr('data-thumb') && $(elem).attr('data-image_id')) {
				var main_img = $('img[data-poip_id="image_'+$(elem).attr('data-image_id')+'"]');
				if (main_img.length == 0) {
					main_img = $('img[data-poip_id="'+$(elem).attr('data-image_id')+'"]');
				}
				main_img.attr('src', $(elem).attr('data-thumb'));
				main_img.closest('a').attr('href', $(elem).attr('href'));
			}
		}
		
		poip_list_default.prototype.getProductListImages = function(poip_products_ids) {
			var this_object = this;
			
			if (!this_object.wait_server_call) {
				this_object.wait_server_call = true;
			
				var params = {products_ids: poip_products_ids};
				$.ajax({
					type: 'POST',
					url: this_object.url_get_images,
					data: params,
					dataType: 'json',
					//dataType: 'text',
					beforeSend: function() {},
					complete: function() {},
					success: function(json) {
						if (json && typeof(json['products'])!='undefined' && json['products']) {
							this_object.showProductListImages(json);
							// move to call of function afterOptionImagesShow
							if (typeof(this_object.afterOptionImagesShowing) == 'function') {
								this_object.afterOptionImagesShowing();
							}
							this_object.wait_server_call = false; // global
						}
					},
					error: function(error) {
						console.log(error);
						this_object.wait_server_call = false; // global
					}
				});
			}
		}
		poip_list_default.prototype.getProductIdFromPOIPId = function(poip_id) {
			if ( poip_id != 'poip_img' ) {
				var parts = poip_id.split('_');
				if (parts.length) {
					return parts[parts.length-1];
				}
			}
		}
		
		poip_list_default.prototype.readyRun = function() {
			var this_object = this;
			
			$(document).ready(function(){
			
				this_object.checkProductListImages();
				setInterval( function(){ // page could be reloaded partially (using ajax by a filter extension or something like this)
					this_object.checkProductListImages();
				}, 300);	
			});
		}
		
		poip_list_default.prototype.checkProductListImages = function() {
			var this_object = this;
			
			var poip_products_ids = [];
			var images_from_cache = {};
			
			$('[data-poip_id]:not([data-poip-loaded])').each(function(){
				var poip_product_id = this_object.getProductIdFromPOIPId( $(this).attr('data-poip_id') );
				
				if ( typeof(this_object.image_cache[poip_product_id]) != 'undefined' ) {
					images_from_cache[poip_product_id] = this_object.image_cache[poip_product_id];
				} else if (poip_product_id && $.inArray(poip_product_id,poip_products_ids)==-1) {
					poip_products_ids.push(poip_product_id);
				}
			});
			
			if ( Object.keys(images_from_cache).length ) {
				this_object.showProductListImages(images_from_cache);
			}
			
			if (poip_products_ids.length) {
				this_object.getProductListImages(poip_products_ids);
			}
		}
		
		poip_list_default.prototype.showProductListImages = function(p_products) {
			var this_object = this;
			
			// both variants for better compatibility with old adaptation scripts
			if ( typeof(p_products['products']) != 'undefined' ) { // json
				products = p_products['products'];
			} else {
				products = p_products;
			}
		
			for (var poip_product_id in products) {
				
				var poip_data = products[poip_product_id];
				
				if ( typeof(this_object.image_cache[poip_product_id]) == 'undefined' ) {
					this_object.image_cache[poip_product_id] = poip_data;
				}
				
				$('[data-poip_id$="_'+poip_product_id+'"]:not([data-poip-loaded])').each(function(){
					if (poip_data) {
						if ( poip_data && !$.isEmptyObject(poip_data) ) {
							this_object.showOneProductImages($(this), poip_data);
						}
					}
					$(this).attr('data-poip-loaded', 'loaded'); // even if a product does not have option images
				});
			}
			
			if ( typeof(this_object.after_showProductListImages) == 'function' ) {
				this_object.after_showProductListImages( {'products': products} );
			}
			
		}
		
	//--></script>
<?php } ?>