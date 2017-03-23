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
		
		// make images list copy
		if ( !$('#image-additional-copy').length ) {
			$('div.image-additional').after("<div id=\"image-additional-copy\" style=\"display: none;\">"+$('div.image-additional div.overview').html()+"</div>");
		}
		
		var shown_img = [];
		var new_items = '';
		$('#image-additional-copy a').each(function(){
			if (($.inArray( this.href, images) != -1 || $.inArray(decodeURIComponent(this.href), images) != -1) && $.inArray( this.href, shown_img) == -1) {
				new_items+= '<div class="item">'+this_object.getElementOuterHTML($(this))+'</div>';
				shown_img.push(this.href);
			}
		});
		
		$('div.image-additional div.overview').html(new_items);
	
		$('.image-scroll').tinycarousel({ 
			axis: 'x', // vertical or horizontal scroller? ( x || y ).
			interval: true,
			rewind: false, 
		});
	
		$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
	}
	
	poip_product_custom.prototype.if_triggerAfterColorboxReinit = function() {
		var this_object = this;
		
		$('#plus').click(function(event){
			event.preventDefault();
			var poip_colorbox = $('a.poip_colorbox[href!="#"]');
			for (var i=0; i<poip_colorbox.length; i++) {
				if ($(this).parent().attr('href') == poip_colorbox[i].href || $(this).parent().attr('href') == decodeURIComponent(poip_colorbox[i].href)) {
					$(poip_colorbox[i]).trigger('click');
					break;
				}
			}
		});
		return true;
	}
	
	
	// >> REPLACING FUNCTIONS	

	var poip_product = new poip_product_custom();

//--></script>