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