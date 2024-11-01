<?php

if ( ! defined('ABSPATH') ) exit; // Exit if accessed directly

/**
 * File that contains extra functions
 *

/**
 * Initialization of the class
 */
if ( !class_exists( 'SQUARE_sidebars_extra_functions' ) ) {

	class SQUARE_sidebars_extra_functions{
		
		/**
		 * function to check if the current page is a post edit page
		 * 
		 * @author Ohad Raz <admin@bainternet.info>
		 * @access public
		 * @param  string  $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
		 * @return boolean
		 */
		public function SQUARE_is_edit_page($new_edit = null){
			global $pagenow;
			//make sure we are on the backend
			if (!is_admin()) return false;


			if($new_edit == "edit")
				return in_array( $pagenow, array( 'post.php',  ) );
			elseif($new_edit == "new") //check for new post page
				return in_array( $pagenow, array( 'post-new.php' ) );
			else //check for either new or edit
				return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
		}
		
		/**
		 * function to convert a string to an id-like string
		 * 
		 * @access public
		 * @param string $string string to convert
		 * @return string $string string converted
		 */
		public function SQUARE_convert_to_id($string = null){
			if(is_null($string) || empty($string))
				return;
				
			$string = stripslashes($string);
			$string = remove_accents($string);
			// remove ponctuation marks, capital letters and whitespaces and replace them with '-'
			$string = trim(strtolower((preg_replace("/[^a-zA-Z0-9]+/", "-", $string))));
			
			return $string;
		}
	}
}

?>