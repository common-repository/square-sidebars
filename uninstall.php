<?php

/**
 * Delete file
 *
 * When plugin is being completely deleted from WP, then the WP_UNINSTALL_PLUGIN constant is defined.
 * This will lead to trigger what's in the if condition.
 */

if( !defined('WP_UNINSTALL_PLUGIN') ) exit;

global $wpdb;

//delete options, tables or anything else
$sql = 'DROP TABLE ' . $wpdb->prefix.'square_sidebars';

if ( !is_multisite() ){
	$wpdb->query($sql);
	delete_option('SQUARE_sidebars_sidebar');
} else{
	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	$original_blog_id = get_current_blog_id();

	foreach ( $blog_ids as $blog_id ){
		switch_to_blog( $blog_id );
		$wpdb->query($sql);
		delete_option('SQUARE_sidebars_sidebar');
	}
	switch_to_blog( $original_blog_id );
}

?>