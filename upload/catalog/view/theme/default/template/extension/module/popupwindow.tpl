<script type="text/javascript">
	var isMobile = false; //initiate as false
	var isDesktop = true;

	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {

		isMobile = true;
		isDesktop = false;
	}

	var showSelectorPopup = function (popup_id, content_type, content, href,width,height,animation,prevent_closing, cssSelector, close_after) {
		var overlay_close = true;
		var escape_close = true;
		if(prevent_closing==1) {
			overlay_close = false;
			escape_close = null;
		}
		else {
			overlay_close = true;
			escape_close = [27];
		}
		$(cssSelector).fancybox({
			content: content,
			width: width,
			height: height,
			autoSize: false,
			openEffect : 'fade',
			openSpeed  : 150,
			closeBtn  : true,
			wrapCSS : 'animated '+ animation + ' popup-id-' + popup_id,
			href    : href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
			type       : content_type ==="youtube" ? 'swf' : null,
            swf           : {
                 'wmode'        : 'transparent',
                'allowfullscreen'   : 'true'
            },

			
			helpers : { 
			  overlay : {closeClick: overlay_close}
			},
			keys : {
			    close  : escape_close
			},
			afterShow: function () {
				if (close_after > 0) setTimeout(closePopup.bind(null, close_after*1000));
				$.ajax({
					url: '<?php echo $updateImpressionsURL; ?>',
					type: 'GET',
					data: {popup_id : popup_id},
					dataType: 'json',
					success: function (response) {
						}
				});
			}
		});
	}
	
var closePopup = function(cssSelector='') {
	if (cssSelector == '')
		$.fancybox.close();
	else
		$(cssSelector).fancybox.close();
}

var showPopup = function (popup_id, content_type, content, href, width,height,animation,prevent_closing,auto_size,auto_resize,aspect_ratio,delay,close_after) { 	
		var timeout = 500;
		if(delay>0) {
			timeout += (delay*1000);
		}
		var overlay_close = true;
		var escape_close = true;
		if(prevent_closing==1) {
			overlay_close = false;
			escape_close = null;
		}
		else {
			overlay_close = true;
			escape_close = [27];
		}
		
		setTimeout(function() {
			$.fancybox.open({
				content: content,
				width: width,
				height: height,
				autoSize:false,	
				openEffect : 'fade',
				openSpeed  : 150,
				closeBtn  : true,	
				wrapCSS : 'animated '+ animation + ' popup-id-' + popup_id,
				autoResize: auto_resize === "false" ? false : true,
				aspectRatio: aspect_ratio === "false" ? false : true,
				href       : href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
	            type       : content_type === "youtube" ? 'swf' : null,
	            swf           : {
	                 'wmode'        : 'transparent',
	                'allowfullscreen'   : 'true'
	            },
				
				helpers : { 
				  overlay : {closeClick: overlay_close}
				},
				keys : {
				    close  : escape_close
				},
				afterShow: function () {
					if (close_after > 0) setTimeout(closePopup, close_after*1000);
					$.ajax({
						url: '<?php echo $updateImpressionsURL; ?>',
						type: 'GET',
						data: {popup_id : popup_id},
						dataType: 'json',
						success: function (response) {
							}
					});
				}
			});	
												
		}, timeout);
		
		
	};

	var uri = location.pathname + location.search;
	var documentReady = false;
	var windowLoad = false;
	var isBodyClicked = false;
	
	var isExitEvent = false;
	var alreadyscrolled = false;

		
	$(document).ready(function() {
		documentReady = true;
	});
	
	$(window).load(function() {
		windowLoad = true;
	});
	
	//var exitEvent = function (){
		
//	};	
										
	
	$.ajax({
		url: '<?php echo $url; ?>',
		type: 'GET',
		data: {'uri' : uri},
		dataType: 'json',
		success: function (response) {

			for(entry in response) {
				// Check if the current popup should be visible on mobile devices
				if(response[entry].show_on_mobile == '0' && isMobile) {
					continue;
				}

				if(response[entry].show_on_desktop == '0' && isDesktop) {
					continue;
				}

				if(response[entry].match) {
					repeat = response[entry].repeat;
					popup_id = response[entry].id;

					if(response[entry].event == 0) { // Document ready event  		
						if (documentReady) {					
							showPopup(response[entry].popup_id, response[entry].content_type, response[entry].content,response[entry].video_href, response[entry].width, response[entry].height, response[entry].animation, response[entry].prevent_closing,response[entry].auto_size, response[entry].auto_resize,response[entry].aspect_ratio,response[entry].seconds,response[entry].close_after);
						} else {
							$(document).ready(function(){   
								showPopup(response[entry].popup_id, response[entry].content_type, response[entry].content,response[entry].video_href, response[entry].width, response[entry].height, response[entry].animation, response[entry].prevent_closing,response[entry].auto_size, response[entry].auto_resize,response[entry].aspect_ratio,response[entry].seconds,response[entry].close_after);
							});
						}
					}
					
					
					if(response[entry].event == 1) { // Window load event
						if(windowLoad) {
							showPopup(response[entry].popup_id, response[entry].content_type, response[entry].content,response[entry].video_href, response[entry].width, response[entry].height, response[entry].animation, response[entry].prevent_closing,response[entry].auto_size, response[entry].auto_resize,response[entry].aspect_ratio,response[entry].seconds,response[entry].close_after);
						}
						else {
							$(window).load(function() {

								showPopup(response[entry].popup_id, response[entry].content_type, response[entry].content,response[entry].video_href, response[entry].width, response[entry].height, response[entry].animation, response[entry].prevent_closing,response[entry].auto_size, response[entry].auto_resize,response[entry].aspect_ratio,response[entry].seconds,response[entry].close_after);
							});
						}
					 
					}
				 
					if(response[entry].event == 2) { // Body click event
						$('body').click(function() {
							if(isBodyClicked == false) {
								showPopup(response[entry].popup_id, response[entry].content_type, response[entry].content,response[entry].video_href, response[entry].width, response[entry].height, response[entry].animation, response[entry].prevent_closing,response[entry].auto_size, response[entry].auto_resize,response[entry].aspect_ratio,response[entry].seconds,response[entry].close_after);
								isBodyClicked = true;
							}	
						});
					}
					
					if(response[entry].event == 3) { // Exit intent
						 var p_id = response[entry].popup_id;
						 var p_content = response[entry].content;
						 var p_width = response[entry].width;
						 var p_height = response[entry].height;
						 var p_animation = response[entry].animation;
						 var p_prevent_closing = response[entry].prevent_closing;
						 var p_auto_size = response[entry].auto_size;
						 var p_auto_resize = response[entry].auto_resize;
						 var p_aspect_ratio = response[entry].aspect_ratio;
						 var p_content_type = response[entry].content_type;
						 var p_video_href = response[entry].video_href;

						 var bootstrap_enabled = (typeof $().modal == 'function');
							
						 if (!bootstrap_enabled) {
						 	$('head').append('<link rel="stylesheet" type="text/css" href="catalog/view/javascript/popupwindow/modal/dol_bootstrap.min.css" />');
						 	$('head').append('<script type="text/javascript" src="catalog/view/javascript/popupwindow/modal/dol_bootstrap.min.js"><'+'/script>');
						 }
	
						 var prevY = -1;
	
						 $(document).bind("mouseout", function(e) {
						 	e.preventDefault();
						 	e.stopPropagation();
						 	if(prevY == -1) {
						 		prevY = e.pageY;
						 		
						 		return;    
						 	}
						 	if (!isExitEvent && (e.pageY<prevY) && (e.pageY - $(window).scrollTop() <= 1)) {  						
								
						 		prevY = -1;
								showPopup(p_id, p_content_type ,p_content, p_video_href, p_width, p_height, p_animation, p_prevent_closing, p_auto_size, p_auto_resize, p_aspect_ratio,response[entry].seconds,response[entry].close_after);
								isExitEvent = true;
						 		//showPopup(response[entry].popup_id, response[entry].content, response[entry].width, response[entry].height, response[entry].animation, response[entry].prevent_closing);
						 	} else {
						 		prevY = e.pageY;
						 	}
						 });
										
					}		
					
					if(response[entry].event == 4) { // Scroll from top event
						$(window).scroll(function() {	
							
							//variables to be used				
							
							var startDistance = 0;
							var percentageValue = response[entry].percentage_value;
							var scrollAmount = $(window).scrollTop();
							var documentHeight = $(window).height();
						 
							// calculate the percentage the user has scrolled down the page
							var scrollPercent = (scrollAmount / documentHeight) * 100;	
							
							// detecting the percentage scrolled and calling the pop up	
							if (!alreadyscrolled && scrollPercent > percentageValue && scrollPercent < percentageValue + 1) {
							   showPopup(response[entry].popup_id, response[entry].content_type, response[entry].content,response[entry].video_href, response[entry].width, response[entry].height, response[entry].animation, response[entry].prevent_closing,response[entry].auto_size, response[entry].auto_resize,response[entry].aspect_ratio,response[entry].seconds,response[entry].close_after);
							   alreadyscrolled=true;

							}				    

						});
					}						
					

					if(response[entry].event == 5) { // CSS Selector

						$(response[entry].css_selector).addClass('fancybox');
						$(response[entry].css_selector).addClass('fancybox.iframe');
						showSelectorPopup(response[entry].popup_id,response[entry].content_type, response[entry].content, response[entry].video_href, response[entry].width, response[entry].height, response[entry].animation, response[entry].prevent_closing, response[entry].css_selector, response[entry].close_after);
							
					}

			  	}

			}
			
		}
	});
</script>
<style>
	<?php echo $custom_css; ?>
</style>




	