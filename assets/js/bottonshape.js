jQuery(function(){	
	jQuery(".jd_social_single_selectable").on('click',function() {
		var tabs = jQuery(this).parents(".jd_social_row").find("div.jd_social_single_selectable");
		var inputs = jQuery(this).parents(".jd_social_row").find("input");
		tabs.removeClass( "jd_social_selected" );
		jQuery(this).toggleClass( "jd_social_selected" );
		var selectedtype = jQuery(this).attr("data-type");
		jQuery('.bottonshape').find("input").val(selectedtype);
		
		if(selectedtype == 'circle'){
			jQuery('input:radio[name="jform[params][buttons_format]"]').removeAttr("checked");
			jQuery('label[for="jform_params_buttons_format0"]').trigger('click');
		}
	});
});