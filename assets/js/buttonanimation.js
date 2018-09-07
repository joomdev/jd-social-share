jQuery(function(){	
	jQuery(".jd_social_animation_type_").on('click',function() {
		var tabs = jQuery(this).parents(".jd_social_row").find("div.jd_social_animation_type_");
		var inputs = jQuery(this).parents(".jd_social_row").find("input");
		tabs.removeClass( "jd_social_selected" );
		jQuery(this).toggleClass( "jd_social_selected" );
		var selectedtype = jQuery(this).attr("data-type");
		jQuery('.buttonanimation').find("input").val(selectedtype); 
		
	});
});