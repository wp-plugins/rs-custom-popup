(function ( $ ) {
	"use strict";

	$(function () {

		getPopup();
		var upload_button;

		$("#back-color").ColorPicker({
			color:"#000",
			onChange:function(hsb, hex, rgb){
				$("#back-color").val('#'+hex);
			}
		});

		$("#front-color").ColorPicker({
			color:"#CC0000",
			onChange:function(hsb, hex, rgb){
				$("#front-color").val('#'+hex);
			}
		});

		$('#upload_button').click(function(e) {
 
	        e.preventDefault();
	 
	        //If the uploader object has already been created, reopen the dialog
	        if (upload_button) {
	            upload_button.open();
	            return;
	        }
	 
	        //Extend the wp.media object
	        upload_button = wp.media.frames.file_frame = wp.media({
	            title: 'Choose Image',
	            button: {
	                text: 'Choose Image'
	            },
	            multiple: false
	        });
	 
	        //When a file is selected, grab the URL and set it as the text field's value
	        upload_button.on('select', function() {
	            var attachment = upload_button.state().get('selection').first().toJSON();
	            $('#upload_image').val(attachment.url);
	        });
	 
	        //Open the uploader dialog
	        upload_button.open();
	 
	    });

	    $("#delete_popup").live("click",function(){
	    	$.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				data: {
					action : "deletePopup"
				},
				beforeSend:function(){
					$(".updated").not('.facebook').hide(),
					$(".error").hide();
				},
				success:function(data){
					$(".updated").show().html('<p>The popup has been deleted</p>');
					getPopup();
				},
				error:function(e){
					console.log(e);
					$(".error").show().html('<p>There has been a problem: '+e.statusText+'</p>');
				}
			});
	    });	

	    $("#add_popup").click(function(){
	    	// User has asked to add a post to the top post table
			if($("#upload_image").val() == "" || $("#upload_image").val() == "http://"){
				$(".updated").hide();
				$(".error").show().html('<p>Please select an image</p>');
			}else if($("#pages").val() == ""){
			}else{
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					dataType: 'json',
					data: {
						action 				: "createPopup",
						"post_image" 		: $("#upload_image").val(),
						"post_image_url"	: $("#image_title").val(),
						"post_pages_id"		: $("#pages").val(),
						"post_back_color"	: $("#back-color").val(),
						"post_front_color"	: $("#front-color").val(),
						"post_cookie"		: $('input[name=cookie]:checked').val()

					},
					beforeSend:function(){
						$(".updated").not('.facebook').hide(),
						$(".error").hide();
					},
					success:function(data){
						$(".updated").show().html('<p>The popup has been created</p>');
						getPopup();
						$("#upload_image").val('http://');
						$("#image_title").val('');
					},
					error:function(e){
						console.log(e);
						$(".error").show().html('<p>There has been a problem: '+e.statusText+'</p>');
					}
				});	
			}
	    });

	});

	function getPopup(){
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			dataType: 'json',
			data:{
				action : "getPopup"
			},
			beforeSend:function(){
				// $(".updated").hide(),
				// $(".error").hide();
				$(".popupTable").html('');
			},
			success:function(data){
				$.each(data, function(index, val) {
					 /* iterate through array or object */
					 if(data[index].rscustompup_use_cookie == 1){
					 	var cookieText = "Yes";
					 }else{
					 	var cookieText = "No";
					 }
					 $(".popupTable").append('<tr><td><img src="'+data[index].rscustompopup_image+'" style="max-width:150px;" /></td><td>'+data[index].rscustompopup_url+'</td><td><span class="preview-color" style="background:'+data[index].rscustompopup_background_colour+';"></span></td><td><span class="preview-color" style="background:'+data[index].rscustompopup_text_colour+';"></span></td><td>'+cookieText+'</td><td><input class="button-primary" type="button" name="add_popup" value="Delete Popup" id="delete_popup"></td></tr>');
				});
			},
			error:function(e){
				$(".error").show().html('<p>There has been a problem loading current popup: '+e.statusText+'</p>');
			}
		});
	}

}(jQuery));