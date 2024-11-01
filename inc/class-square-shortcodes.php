<?php

if ( ! defined('ABSPATH') ) exit; // Exit if accessed directly

/**
 * Initialization of the class
 */
if ( !class_exists( 'SQUARE_sidebars_shortcodes' ) ) {

	class SQUARE_sidebars_shortcodes{
		
		public function __construct(){
			// SQUARE_display_sidebar shortcode
			add_shortcode('square_display_sidebar', array( $this,'SQUARE_sidebars_display' ));
			add_shortcode('square_sidebars', array( $this,'SQUARE_sidebars_display' ));
		}
		
		/** 
		 * shortcode for displaying a sidebar.
		 *
		 * @access public
		 * @return $ouput content of a sidebar
		 *
		 * usage : [square_display_sidebar id="sidebar_id"][/square_display_sidebar]
		 * usage : [square_sidebars id="sidebar_id"][/square_sidebars]
		 */
		public function SQUARE_sidebars_display($atts) {
			
			global $SQUARE_sidebars;
			
			// register sidebars before calling 'dynamic_sidebar' for it to work
			$SQUARE_sidebars->build_sidebars->build_sidebars();
			
			extract( shortcode_atts( array(
				  'id' => ''
			), $atts ) );
			
			global $wpdb;
			
			// get the sidebar with id = $id
			$sidebar_info = get_post($id);
			
			// store 'dynamic_sidebar' in a var for output
			ob_start();
			dynamic_sidebar($sidebar_info->post_name);
			$dynamic_sidebar = ob_get_contents();
			ob_end_clean();
			
			$output = '<div>' . $dynamic_sidebar . '</div>';
			
			return $output;
		}
		
	}
}

?>