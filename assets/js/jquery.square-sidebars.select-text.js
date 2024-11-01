jQuery.noConflict();

jQuery(document).ready(function(){

/**
 * On click on shortcode, select all
**/
	jQuery('.square-shortcode').on('click','code',function(){
		jQuery(this).selectText();
	});
});

/**
 * Select text function to select a text inside a div on a single left click
**/
jQuery.fn.selectText = function(){
	var doc = document;
	var element = this[0];
	
	if (doc.body.createTextRange) {
		var range = document.body.createTextRange();
		range.moveToElementText(element);
		range.select();
	} else if (window.getSelection) {
		var selection = window.getSelection();        
		var range = document.createRange();
		range.selectNodeContents(element);
		selection.removeAllRanges();
		selection.addRange(range);
	}
};