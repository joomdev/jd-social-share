jQuery( document ).ready( function() {
	jQuery(document).on( 'click','.jd_social_deletenetwork', function(){
		$this_el = jQuery(this);	
		$network = $this_el.parent().parent();
		$network_to_deselect = '.jd_social_' + $network.data( 'name');			
		jQuery( '.social_icons_container.' + $network.data('area')).find( $network_to_deselect ).removeClass( 'jd_social_selectednetwork' ).addClass( 'jd_social_nonselectednetwork' );	
		$this_el.closest('.jd_social_network').remove(); 		
	});	
	jQuery(document).on( 'click','.select_networkpop', function(){
		jQuery('#networks_container').modal();
	});
	jQuery( 'body' ).on( 'click', '.jd_social_nonselectednetwork', function(){
		jQuery( this ).removeClass( 'jd_social_nonselectednetwork' ).addClass( 'jd_social_selectednetwork' );
		return false;
	});
	jQuery( 'body' ).on( 'click', '.jd_social_selectednetwork', function(){
		jQuery( this ).removeClass( 'jd_social_selectednetwork' ).addClass( 'jd_social_nonselectednetwork jd_social_deselected' );
		return false;
	});
	jQuery( 'body' ).on( 'click', '.jd_social_apply', function(){
		$this_el = jQuery( this );
		$network_container = jQuery( this ).parent().parent();
		$networks = $network_container.find( '.jd_social_selectednetwork' ).parent();
		$section = jQuery( '.jd_social_sortable.' + $this_el.data( 'area' ) );
		$need_recalculation = false;
		
		$network_container.find( '.jd_social_deselected' ).parent().each( function(){
			$network_deselected = jQuery( this );
			$network_in_list = $section.find( '.jd_social_' + $network_deselected.data( 'name' ) );
			if ( $network_in_list.length ) {
				$network_in_list.parent().remove();
				$need_recalculation = true;
			}
		});

		jsonObj = [];	
		$current_id = $section.find( '.jd_social_network' ).length;		
		$network_container.find( '.jd_social_selectednetwork' ).parent().each( function(){
			$network = jQuery( this );
			$add_class = '';
			$input_cid = '';
			$additional_name = '';
			if ( ! $section.find( '.jd_social_' + $network.data( 'name' ) ).length ) {
				$is_follow_window = $network_container.find( '.social_icons_container' ).hasClass( 'follow_networks_networks_sorting' ) ? true : false;
				$input_counts = ( false != $network.data( 'counts' ) && $is_follow_window ) ? '<input class="input_count" type="text" placeholder="0" name="jd_social[' + $this_el.data( 'area' ) + '][count][' + $current_id + ']">' : '';
				$username = ( false != $network.data( 'username' ) ) ? '<input class="input_name" type="text" placeholder="' + $network.data( 'placeholder' ) + '" name="jd_social[' + $this_el.data( 'area' ) + '][username][' + $current_id + ']">' : '';
				$check_mark_holder = ( undefined != $network.data( 'api_support' ) && true == $network.data( 'api_support' ) && $is_follow_window ) ? '<p class="jd_social_checkmark_holder"></p>' : '';

				if ( undefined != $network.data( 'client_id_placeholder' ) && '' != $network.data( 'client_id_placeholder' ) && $is_follow_window  ) {
					$add_class = ( undefined != $network.data( 'client_name_placeholder' ) && '' != $network.data( 'client_name_placeholder' ) ) ? 'jd_social_5_fields' : 'jd_social_4_fields';
					$input_cid = '<input type="text" class="input_cid" placeholder="' + $network.data( 'client_id_placeholder' ) + '" name="jd_social[' + $this_el.data( 'area' ) + '][client_id][' + $current_id + ']">';
					$additional_name = ( undefined != $network.data( 'client_name_placeholder' ) && '' != $network.data( 'client_name_placeholder' ) ) ? '<input type="text" class="input_client_name" placeholder="' + $network.data( 'client_name_placeholder' ) + '" name="jd_social[' + $this_el.data( 'area' ) + '][client_name][' + $current_id + ']">' : '';
				}

				$network_to_add = '<div class="tosave jd_social_network jd_social_icon ui-sortable-handle ' + $add_class + '" data-name="' + $network.data( 'name' ) +'" data-area="' + $this_el.data( 'area' ) +'" ><i class="icon-move large-icon"></i><span class="jd_social_' + $network.data( 'name' ) + '" ><a href="javascript:void(0);" class="jd_social_deletenetwork"></a></span><input class="input_label" type="text" placeholder="' + $network.data( 'label' ) +'" value="' + $network.data( 'label' ) +'" name="jd_social[' + $this_el.data( 'area' ) + '][label][' + $current_id + ']">' + $username + $additional_name + $input_cid + $check_mark_holder + $input_counts + '</div>';
				jQuery('.jd_social_sortable.' + $this_el.data( 'area' ) ).append( $network_to_add );
				$current_id++;
				
				var selectedname = $network.data('name');
				var label = $network.data('label');
				tosave = {}
				tosave['network'] = selectedname;
				tosave['label'] = label;
				jsonObj.push(tosave);	 
			}
		}); 
		
		jsonString = JSON.stringify(jsonObj);
		jQuery('#jform_params_select_networks').val(jsonString); 
		jQuery('#networks_container').modal('hide');
		return false;
	}); 
	
	Joomla.submitbutton = function(task)
	{
		if(task == 'plugin.apply' || task == 'plugin.save'){
			if(jQuery('.tosave').length > 0){
				jsonObj = [];
				jQuery('.tosave').each( function(){
					var selectedname = jQuery(this).attr('data-name');
					var label = jQuery(this).find('input').val();
					tosave = {}
					tosave['network'] = selectedname;
					tosave['label'] = label;
					jsonObj.push(tosave);			
				});
				jsonString = JSON.stringify(jsonObj);
				jQuery('#jform_params_select_networks').val(jsonString);
			}else{
				jQuery('#jform_params_select_networks').val(''); 
			} 
		}		
		Joomla.submitform(task, document.getElementById('style-form'));
		return true;
	}
	var ul_sortable = jQuery('.ui-sortable');
    ul_sortable.sortable({
        revert: 100,
        placeholder: 'placeholder'
    });
    ul_sortable.disableSelection(); 
	
	jQuery('#jform_params_buttons_format1').on('click',function(){
		var selectedtype = jQuery('.jd_social_selected').attr('data-type');
		if(selectedtype == 'circle'){
			jQuery('input:radio[name="jform[params][buttons_format]"]').removeAttr("checked");
			jQuery('label[for="jform_params_buttons_format0"]').trigger('click');
		}
	})
});