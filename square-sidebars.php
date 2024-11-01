<?php
/**
 * Plugin Name: SQUARE Sidebars
 * Plugin URI: https://github.com/daniellapides/SQUARE-Sidebars
 * Description: SQUARE Sidebars is a sidebar management plugin for WordPress that allows users to create and manage custom sidebars directly from the WordPress administration. It aims at giving the users the magic wand to create, manage and replace sidebars. The SQUARE Sidebars plugin is made to boost your WordPress website by allowing you to display different contents and calls to action on each pages of your willing. The plugin is shortcode based.
 * Version: 1.6.1
 * Author: Daniel LAPIDES
 * Author URI: http://www.filsdetut.fr/
 * Text Domain: SQUARE_sidebars
 * Domain Path: /languages/
 * License: GPLv2
 
  ------------------------------------------------------------------------
    SQUARE SIDEBARS, Copyright 2014 SQUARE
    
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
	
*/

if ( ! defined('ABSPATH') ) exit; // Exit if accessed directly

/**
 * define constants
 */
global $wpdb, $table_prefix;			
if(!defined('SQUARE_SIDEBARS_DB')) define('SQUARE_SIDEBARS_DB',$wpdb->prefix.'square_sidebars');

if ( !class_exists( 'SQUARE_sidebars' ) ) {

	class SQUARE_sidebars{
		
		public $SQUARE_version = '1.6.1';		// Current version of plugin
		public $custom_post_type = null;		// Custom post type class
		public $build_sidebars = null;			// Build sidebars class
		public $extra_functions = null;			// Extra functions class
		public $shortcodes = null;				// shortcodes class
		
		public function __construct(){
			// Activation
			register_activation_hook( __FILE__, array($this,'activate') );
			// Deactivation
			register_deactivation_hook( __FILE__, array($this,'deactivate') );
			// Register post type
			add_action('init', array( $this, 'SQUARE_custom_post_type' ) );
			// Load plugin textdomain.
			add_action( 'plugins_loaded', array($this,'SQUARE_load_textdomain') );
			// Include required files
			add_action('plugins_loaded', array($this, 'includes'));
			// Initialize all classes
			add_action('plugins_loaded', array($this, 'SQUARE_init_classes'));
			// enqueue admin scripts and styles
			add_action('admin_enqueue_scripts', array( $this, 'SQUARE_admin_scripts' ) );
			// add WP pointers
			add_filter( 'SQUARE_sidebars_pointers-dashboard', array( $this, 'SQUARE_sidebars_pointers' ) );
			add_filter( 'SQUARE_sidebars_pointers-edit-square_sidebar', array( $this, 'SQUARE_sidebars_pointers' ) );
			add_filter( 'SQUARE_sidebars_pointers-square_sidebar', array( $this, 'SQUARE_sidebars_pointers' ) );
			// Init shortcodes
			add_action( 'init', array( $this, 'SQUARE_shortcodes' ) );
		}
		
		/**
		 * activate function.
		 *
		 * @access public
		 * @return void
		 */
		public function activate( $network_wide ){
			if ( ! current_user_can( 'activate_plugins' ) )
				return;

			if ( is_multisite() && $network_wide ) { // See if being activated on the entire network or one blog
				global $wpdb;
		 
				// Get this so we can switch back to it later
				$current_blog = $wpdb->blogid;
				// For storing the list of activated blogs
				$activated = array();
		 
				// Get all blogs in the network and activate plugin on each one
				$sql = "SELECT blog_id FROM $wpdb->blogs";
				$b1og_ids = $wpdb->get_co1($wpdb->prepare($sql));
				foreach ($blog_ids as $blog_id) {
					switch_to_blog($blog_id);
					$activated[] = $blog_id;
				}
		 
				// Switch back to the current blog
				switch_to_b1og($current_blog);
		 
				// Store the array for a later function
				update_site_option('SQUARE_sidebars_activated', $activated);
			}
		}
	
		/**
		 * deactivate function.
		 *
		 * @access public
		 * @return void
		 */
		public function deactivate( $network_wide ){
			if ( ! current_user_can( 'activate_plugins' ) )
				return;

			if ( is_multisite() && $network_wide ) { // See if being activated on the entire network or one blog
				global $wpdb;
		 
				// Store the array for a later function
				delete_site_option('SQUARE_sidebars_activated');
			}
		}
		
		/**
		 * language function.
		 *
		 * @access public
		 * @return void
		 */
		public function SQUARE_load_textdomain() {
			load_plugin_textdomain( 'SQUARE_sidebars', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
			
			/**
			 * Plugin headers translation
			 * /!\ Needs the "Text Domain" and "Domain Path" headers to work !! /!\
			 */
			 __( 'SQUARE Sidebars is a sidebar management plugin for WordPress that allows users to create and manage custom sidebars directly from the WordPress administration. It aims at giving the users the magic wand to create, manage and replace sidebars. The SQUARE Sidebars plugin is made to boost your WordPress website by allowing you to display different contents and calls to action on each pages of your willing. The plugin is shortcode based.', 'SQUARE_sidebars' );
		}
		
		/**
		 * On plugin initialization
		 * register custom post type : square_sidebars
		 *
		 * @access public
		 * @return void
		 */
		public function SQUARE_custom_post_type(){
			// include custom post type
			require 'inc/class-square-post-type.php';
			// init class
			$this->custom_post_type = new SQUARE_sidebars_post_type();
		}
		
		/**
		 * includes function.
		 *
		 * @access public
		 * @return void
		 */
		public function includes(){
			require_once 'inc/class-square-sidebars-build.php'; 		// building the sidebars
			require_once 'inc/class-square-extra-functions.php';		// extra functions
			require_once 'inc/class-square-shortcodes.php';				// shortcodes
		}
		
		/**
		 * all classes initialization function.
		 *
		 * @access public
		 * @return void
		 */
		public function SQUARE_init_classes(){
			$this->build_sidebars = new SQUARE_sidebars_build();				// build the sidebars
			$this->extra_functions = new SQUARE_sidebars_extra_functions();		// extra functions
		}
		
		/**
		 * Initialize assets
		 */
		public function SQUARE_admin_scripts( $hook_suffix ){
			if(get_post_type() == 'square_sidebar'){
				wp_enqueue_style('square-square-sidebars-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
				wp_enqueue_script('square-square-sidebars-select-text-js', plugin_dir_url(__FILE__) . 'assets/js/jquery.square-sidebars.select-text.js', array('jquery'), $this->SQUARE_version, true);
				
				// if is edit or new post and is on square_sidebar post type : process ; otherwise : bail!
				if($this->extra_functions->SQUARE_is_edit_page('new') || $this->extra_functions->SQUARE_is_edit_page('edit'))
					wp_enqueue_script('square-square-sidebars-js', plugin_dir_url(__FILE__) . 'assets/js/jquery.square-sidebars.js', array('jquery'), $this->SQUARE_version, true);
			}
			
			// add WP_pointer tooltip
			// Don't run on WP < 3.3
			if ( get_bloginfo( 'version' ) < '3.3' )
				return;
		 
			$screen = get_current_screen();
			$screen_id = $screen->id;
		 
			// Get pointers for this screen
			$pointers = apply_filters( 'SQUARE_sidebars_pointers-' . $screen_id, array() );
		 
			if ( ! $pointers || ! is_array( $pointers ) )
				return;
		 
			// Get dismissed pointers
			$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
			$valid_pointers = array();
		 
			// Check pointers and remove dismissed ones.
			foreach ( $pointers as $pointer_id => $pointer ) {
		 
				// Sanity check
				if ( in_array( $pointer_id, $dismissed ) || empty( $pointer )  || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) )
					continue;
		 
				$pointer['pointer_id'] = $pointer_id;
		 
				// Add the pointer to $valid_pointers array
				$valid_pointers['pointers'][] =  $pointer;
			}
		 
			// No valid pointers? Stop here.
			if ( empty( $valid_pointers ) )
				return;
		 
			// Add pointers style to queue.
			wp_enqueue_style( 'wp-pointer' );
		 
			// Add pointers script to queue. Add custom script.
			wp_enqueue_script('square-sidebars-pointers', plugins_url( 'assets/js/jquery.square-sidebars.pointers.js', __FILE__ ), array( 'wp-pointer' ), $this->SQUARE_version, true);
		 
			// Add pointer options to script.
			wp_localize_script( 'square-sidebars-pointers', 'SQUARE_sidebars_pointers', $valid_pointers );
		}
		
		/**
		 * display a pointer on dashboard for the new version of the plugin
		 *
		 * @return void
		 */
		public function SQUARE_sidebars_pointers( $p ) {
			// create pointer
			$p['square_sidebars_pointers_1_6_0'] = array(
				'target' => '#menu-posts-square_sidebar',
				'options' => array(
					'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
						__( 'SQUARE Sidebars' ,'SQUARE_sidebars'),
						__( '<p>The new version of the SQUARE Sidebars plugin now uses WordPress\' default tables in the database.</p><p>Thus, for this new version to work effectively, it is recommended that you <b><u>update all of your custom sidebars</u></b> (by simply clicking on <i>Update</i>).</p>','SQUARE_sidebars')
					),
					'position' => array( 'edge' => 'left', 'align' => 'center' )
				)
			);
			
			return $p;
		}
		
		/**
		 * initialize shortcodes
		 */
		public function SQUARE_shortcodes(){
			$this->shortcodes = new SQUARE_sidebars_shortcodes();
		}
	}
		
	$GLOBALS['SQUARE_sidebars'] = new SQUARE_sidebars();
}

?>
