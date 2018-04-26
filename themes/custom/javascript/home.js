jQuery.noConflict();

(function($) {
	$(document).ready(function() {
		
		/* Instagram feed */
		
		var limit;
		if ($(window).width() > 640) {
			limit = 8;
		}else{ //mobile
			limit = 6;
		}
		var feed = new Instafeed({
			get: 'user',
			userId: 476992292,
			accessToken: '476992292.1677ed0.eafc79c22b52439f8c4eaa30607fe5a9',
			target: 'instagram',
			resolution: 'standard_resolution',
			limit: limit,
			template: '<div class="insta-tile"><div class="hover"><p>{{caption}}</p></div><img src="{{image}}" /></div>'
		});
		feed.run();

	});
	
	$(window).load(function() {
		/* HomePage */
		
	});
	
	$(window).scroll(function(){	
	
		$('.HomePage .fade').each(function() {
			var offset = $(this).offset().top - $(window).scrollTop(); //negative when top of screen is above the viewport
			var atTop = offset - $(window).height(); //negative when the top of the element is a bove the bottom of the viewport
			var atBott = offset + $(this).outerHeight(); //negative when the bottom of element is above the viewport
			
			var viewing = atTop < 0 && atBott > 0; // element between top and bottom of screen
			if (viewing && !$(this).hasClass('doFade')) {
				$(this).addClass('doFade');
				if ($(this).hasClass('hover')) {
					$(this).fadeTo( 2000, 1 );
				}else {
					$(this).fadeTo( 2000, 0.5 );
				}
				
			} else if (!viewing && $(this).hasClass('doFade')){
				$(this).removeClass('doFade');
				$(this).fadeTo( 'fast', 0 );
				
			}
		});
	});	
	
	$( window ).resize(function() {
		//bannerHeightCheck();
	});
	
	function bannerHeightCheck() {
		/* Banner image height - fill screen */
		if ($(window).width() < 640 && $(window).width() > 400) { //mobile
			var height = $(window).height() - 100; //100px is the height of the black header
			$('.banner').height(height);
			$('.banner-image').height(height);
		}else {
			$('.banner').removeAttr( 'style' );
			$('.banner-image').removeAttr( 'style' );
		}
	}
}(jQuery));
