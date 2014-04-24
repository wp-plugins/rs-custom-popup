(function ( $ ) {
	"use strict";

	$(function () {

		// If the user clicks the close button
		$(".rscustompopup-close").click(function(){
			// we need to process our cookie script
			createCookie();
			$(".rscustompopup-overlay").hide();
			$(".rscustompopup-modal").hide();
		});

		// If the user clicks the body
		$("body").click(function(){
			$(".rscustompopup-overlay").hide();
			$(".rscustompopup-modal").hide();
		});

		$(".rscustompopup-image").css({
			"width"	:$(".rscustompopup-image img").width(),
			"margin":"0 auto"
		})
		
		// Lets find out where the close button needs to be
		$(".rscustompopup-close").css({
			"left":$(".rscustompopup-image img").width()
		})

	});

	function createCookie(){
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data:{
				action	: "createCookie"
			}
		});
	}

}(jQuery));