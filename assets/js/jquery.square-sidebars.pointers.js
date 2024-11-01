/**
 * Javascript that handles the WP pointers
 */
jQuery(document).ready( function() {
	// call function
	square_sidebars_open_pointer(0);
    
	// function the displays the pointer
	function square_sidebars_open_pointer(i) {
        pointer = SQUARE_sidebars_pointers.pointers[i];
        options = jQuery.extend( pointer.options, {
            close: function() {
                jQuery.post( ajaxurl, {
                    pointer: pointer.pointer_id,
                    action: 'dismiss-wp-pointer' // action to call to save in database the dismissed pointer
                });
            }
        });
 
        jQuery(pointer.target).pointer( options ).pointer( 'open' );
    }
});