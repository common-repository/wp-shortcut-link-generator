(function( $ ) {
	var img_loader = $('<img id="mwb_loader_image">');
	img_loader.attr('src',wp_shortcut_link_generator.baseurl+'images/loader.gif');

	var img_loader_add = $('<img id="mwb_loader_image_add">');
	img_loader_add.attr('src',wp_shortcut_link_generator.baseurl+'images/loader.gif');

	$(document).ready(function(){	

		$('a').draggable({ revert: true, helper: "clone" , scroll: false, appendTo: 'body',
			start: function(e, ui){
			  $(ui.helper).css({'background':'black','z-index':'99999'});			 
			
		 	}
 		});

	    $( "#dropable" ).droppable({
	      	drop: function( event, ui ) {
		      	var draggable = ui.draggable;
				var shortcut_url = draggable.attr("href");
				var shortcut_name=draggable.text();
				shortcut_name=shortcut_name.split(' ');				
				var shortcut_name_last_value=shortcut_name[shortcut_name.length-1];
				if($.isNumeric(shortcut_name_last_value)||shortcut_name_last_value[0]=='('){				
					
					shortcut_name.splice((shortcut_name.length-1),1);
				}				
				$('#mwb_shortlink_show_area').removeClass('empty');
				$('#mwb_empty_drophere').hide();	
				$('#mwb_drophere_note').html(img_loader_add);	
				
					
				$.ajax({
			        method: "POST",
		 	        url: ajaxurl,

		 	        data: { 'action': 'mwb_WSLC_add_shortcut_link', 'shortcut_url':shortcut_url,'shortcut_name':shortcut_name },
			        dataType:'json'
		      	 }).done(function(data){
		     	 	
		      	 	mwb_WLSC_display_shrotlink(data);
		      	 	
		     	 });
				
		    }
	    });		    	
		$('#checkbox_Input').click(function(){
			var checkbox_status;
			if ($(this).is(':checked')) {
				checkbox_status='true';
				$('.mwb_shortlink_area').show();
			}
			else{
				checkbox_status='false';
				$('.mwb_shortlink_area').hide();
				
			}
			$.ajax({
		        method: "POST",
		        url: ajaxurl,
		        data: { 'action': 'mwb_WSLC_checkbox_status', 'mwb_WSLC_checkbox_status':checkbox_status }
		     	 })
	    });
		$('#mwb_shortlink_show_tab').click(function(){
			if($(this).hasClass('show')){				
				 	$(this).removeClass('show').addClass('hide');
				
				 	$('.mwb_shortlink_area').removeClass('mwb_div_hide').addClass('mwb_div_show');

			}	
			else{				
				$(this).removeClass('hide').addClass('show');		
		
				$('.mwb_shortlink_area').removeClass('mwb_div_show').addClass('mwb_div_hide');
				
			}
		});

		

	});

	$(document).on('click','.remove_shortlink',function(){
		$(this).html(img_loader);	
		
		var remove_shortlink_url=$(this).prev().attr('href');
		var remove_shortlink_name=$(this).prev().text();
	
		$.ajax({
		        method: "POST",
		        url: ajaxurl,
		        data: { 'action': 'mwb_WSLC_remove_shortcut_link', 'remove_shortcut_url':remove_shortlink_url,'remove_shortcut_name':remove_shortlink_name },
		        dataType:'json'
	     	 }).done(function(data){
	     	 	mwb_WLSC_display_shrotlink(data);
	     	 	
	    });
		
	});


	function mwb_WLSC_display_shrotlink(data){


			var result='<ul>';
		
			for(var link in data){

		
				result+='<li><a href="'+data[link]["url"]+'" class="shortlink">'+data[link]['name']+'</a> <a href="JavaScript:;" class="remove_shortlink" >X</a></li>';
			}
			result+='<li id="mwb_drophere_note"><p>'+wp_shortcut_link_generator.Drop_Here+'</p></li></ul>';
		 	$('#mwb_display_shortlink').html(result);

		 	if(data==''){
				$('#mwb_empty_drophere').show();
				$('#mwb_drophere_note').css('display','none');
				$('#mwb_shortlink_show_area').addClass('empty');


			}

		
		
	}

})( jQuery );
