jQuery.noConflict();

jQuery(document).ready(function(){
	
/**
 * Replace sidebar or not ??
**/
		// When checkbox is checked
	jQuery('input.square_sidebars_replace').each(function(){
		if(jQuery(this).is(':checked')){
			var _this = jQuery(this);
			if(_this.val() == 'Y'){
				jQuery('#square_sidebars_replace_location').fadeOut('fast');
				jQuery('#square_sidebars_replace_sidebar').fadeIn('fast');
			}
			else if(_this.val() == 'N'){
				jQuery('#square_sidebars_replace_location').fadeIn('fast');
				jQuery('#square_sidebars_replace_sidebar').fadeIn('fast');
			}
			else{
				jQuery('#square_sidebars_replace_location').fadeOut('fast');
				jQuery('#square_sidebars_replace_sidebar').fadeOut('fast');
			}
		}
	});
	
		// On status change
	jQuery('input.square_sidebars_replace').on('click',function(){
		if(this.value == 'Y'){
			jQuery('#square_sidebars_replace_location').fadeOut('fast');
			jQuery('#square_sidebars_replace_sidebar').fadeIn('fast');
		}
		else if(this.value == 'N'){
			jQuery('#square_sidebars_replace_location').fadeIn('fast');
			jQuery('#square_sidebars_replace_sidebar').fadeIn('fast');
		}
		else{
			jQuery('#square_sidebars_replace_location').fadeOut('fast');
			jQuery('#square_sidebars_replace_sidebar').fadeOut('fast');
		}
	});
	
	
/**
 * Textarea of description : count number of characters
 * @see : same as function countChar()
**/
	if(jQuery('#square_sidebars_description_txtarea').length){
		var val = jQuery('#square_sidebars_description_txtarea').val();
		// countChar function
		countChar(val);
	}
	
/**
 * Accordion
 * In the display section when creating a sidebar
**/
	jQuery( ".accordion-section > h3.accordion-section-title" ).on('click',function(){
		var _this = jQuery(this);
		
		jQuery('.accordion-section').children('.accordion-section-content').slideUp('fast', function(){
			jQuery(this).parent('li').removeClass('open');
		});
		
		if(!_this.parent('li').hasClass('open')){
			_this.parent('li').children('.accordion-section-content').slideDown('fast',function(){
				jQuery(this).parent('li').addClass('open');
			});
		}
	});
	
	
/**
 * Add and remove items in the display section
 * when creating a sidebar
**/
	// Add
	jQuery( ".square-add-to-sidebar" ).on('click',function(e){
		e.preventDefault();
		
		var _this = jQuery(this);
		
		_this.parents('p.button-controls').prev('div.tabs-panel').find('input[type="checkbox"]').each(function(){
			if(jQuery(this).is(':checked')){
				var _val = jQuery(this).val(),
					_name = jQuery(this).attr('name'),
					_name = _name.replace('nosubmit_',''),
					_label = jQuery(this).next('span').text(),
					_type = jQuery(this).next('span').data('square-type'),
					_type2 = _type.replace(/\-/g,' '),
					_post_type_name = jQuery(this).next('span').data('square-name'),
					_toAppend = '<div class="square-display-items menu-item-handle"><strong class="item-title">'+_label+'</strong><span class="item-controls"><span class="item-type">'+_post_type_name+'</span><span class="dashicons-before dashicons-no square-sidebars-remove"></span></span><input type="hidden" name="'+_name+'" value="'+_val+'" class="square-display-items-hidden" data-square-identifier="'+_type+'-'+_val+'" /></div>';
					
				if(jQuery('input[data-square-identifier='+_type+'-'+_val+']').length === 0){
					jQuery('#square-display-container').append(_toAppend);
				}
				
				// uncheck checkbox
				jQuery(this).prop('checked', false);
			}
		});
	});
	
	// Remove
	jQuery('#square-display-container').on('click', '.square-display-items .square-sidebars-remove',function(){
		jQuery(this).parents('.square-display-items').fadeOut('fast',function(){
			jQuery(this).remove();
		});
	});
	
/**
 * '(Un)Select all' button
**/
	jQuery('.square-sidebars-select-unselect').on('click',function(e){
		// prevent default behavior of link
		e.preventDefault();
		
		// if there is no checkboxes: bail!
		if(!jQuery(this).parents('.button-controls').prev('.tabs-panel').find('input[type="checkbox"]').length)
			return;
		
		if(jQuery(this).attr('data-square-action') == 'check'){
			// check all checkboxes
			jQuery(this).parents('.button-controls').prev('.tabs-panel').find('input[type="checkbox"]').prop('checked', true);
		} else{
			// uncheck all checkboxes
			jQuery(this).parents('.button-controls').prev('.tabs-panel').find('input[type="checkbox"]').prop('checked', false);
		}
		
		// remove inactive class to all
		jQuery(this).parent('.list-controls').children('a').removeClass('inactive');
		// add inactive class to the clicked one
		jQuery(this).addClass('inactive');
	});
	
/**
 * Search through the display options possibilities
**/
	// on change or keyup, do something
	jQuery('.quick-search').on('change input keyup', function(){
		// the search value
		var search_val = jQuery(this).val().toLowerCase().replace('-',' ');
		
		// if search does not have more than 2 characters, bail!
		if(search_val.length < 2){
			jQuery(this).next('ul').children('li').fadeIn('fast');
			return false;
		}
		
		// hide list elements that do not match search
		jQuery(this).next('ul').children('li').each(function(){
			// list element name (normal and id formats)
			var search_data = jQuery(this).children('label').children('span').text().toLowerCase();
			var search_data_id = jQuery(this).children('label').children('span').attr('data-square-title-to-id').replace(/\-/g,' ');
			// if search_data contains search_val, hide
			if(search_data.indexOf(search_val) < 0 && search_data_id.indexOf(search_val) < 0){
				jQuery(this).fadeOut('fast');
			} else{
				jQuery(this).fadeIn('fast');
			}
		});
	});
	
	// on keypress, if is ENTER key, prevent default (prevent sidebar from being sent/updated)
	jQuery('.quick-search').on('keypress', function(e){
		// if is ENTER key
		if (e.which == 13) {
			e.preventDefault();
		}
	});
});


/**
 * Textarea of description : count number of characters function
**/
function countChar(val) {
	if(val){
		// variables
		var len = val.length;
		
		// if length of textarea value is more than 1000, substring it!
		if (len >= 1000) {
		  val = val.substring(0, 1000);
		// if it is less, show count
		} else {
		  jQuery('#square-sidebars-description-charnum > span').text(1000 - len);
		}
	// if it is empty, show count at 1000
	} else{
		jQuery('#square-sidebars-description-charnum > span').text(1000);
	}
};