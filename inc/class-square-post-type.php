<?php

if ( ! defined('ABSPATH') ) exit; // Exit if accessed directly

/**
 * Initialization of the class
 */
if ( !class_exists( 'SQUARE_sidebars_post_type' ) ) {

	class SQUARE_sidebars_post_type{
		
		public function __construct(){
			// register post type
			$this->SQUARE_post_type();
			
			// add meta boxes
			add_action( 'add_meta_boxes', array( $this , 'SQUARE_add_meta_box' ) );	
			// save post
			add_action('save_post', array( $this, 'SQUARE_save_in_db' ) );
			// add custom columns
			add_filter('manage_square_sidebar_posts_columns' , array( $this, 'SQUARE_add_custom_columns' ));
			add_action( 'manage_square_sidebar_posts_custom_column' , array( $this, 'SQUARE_manage_custom_columns' ), 10, 2 );
		}
		
		/**
		 * Register the square_sidebar post type
		 */
		public function SQUARE_post_type(){
			
			$labels = array(
				'name'               => _x( 'SQUARE Sidebars', 'post type general name', 'SQUARE_sidebars' ),
				'singular_name'      => _x( 'SQUARE Sidebar', 'post type singular name', 'SQUARE_sidebars' ),
				'menu_name'          => _x( 'SQR Sidebars', 'admin menu', 'SQUARE_sidebars' ),
				'name_admin_bar'     => _x( 'SQR Sidebar', 'add new on admin bar', 'SQUARE_sidebars' ),
				'add_new'            => __( 'Add New', 'SQUARE_sidebars' ),
				'add_new_item'       => __( 'Add New SQR Sidebar', 'SQUARE_sidebars' ),
				'new_item'           => __( 'New SQR Sidebar', 'SQUARE_sidebars' ),
				'edit_item'          => __( 'Edit SQR Sidebar', 'SQUARE_sidebars' ),
				'view_item'          => __( 'View SQR Sidebar', 'SQUARE_sidebars' ),
				'all_items'          => __( 'All SQR Sidebars', 'SQUARE_sidebars' ),
				'search_items'       => __( 'Search SQR Sidebar', 'SQUARE_sidebars' ),
				'parent_item_colon'  => __( 'Parent SQR Sidebar:', 'SQUARE_sidebars' ),
				'not_found'          => __( 'No SQR Sidebars found.', 'SQUARE_sidebars' ),
				'not_found_in_trash' => __( 'No SQR Sidebars found in Trash.', 'SQUARE_sidebars' ),
			);

			$args = array(
				'labels'             	=> $labels,
				'public'             	=> true,
				'publicly_queryable' 	=> true,
				'show_ui'            	=> true,
				'show_in_menu'       	=> true,
				'query_var'          	=> true,
				'rewrite'            	=> array( 'slug' => 'square_sidebar' ),
				'capability_type'    	=> 'post',
				'has_archive'        	=> true,
				'hierarchical'       	=> false,
				'menu_position'      	=> null,
				'supports'           	=> array( 'title' ),
				'menu_icon'				=> 'dashicons-schedule'
			);

			register_post_type( 'square_sidebar', $args );
			
		}
		
		/**
		 * Add meta boxes
		 * 
		 * 1- Description
		 * 2- Display options
		 * 3- Shortcode
		 * 4- Visibility options
		 * 5- Advanced options
		 */
		public function SQUARE_add_meta_box() {
			
			// Description meta box
			add_meta_box(
				'square_sidebars_description',
				__( 'Description', 'SQUARE_sidebars' ),
				array( $this , 'SQUARE_sidebars_description_inner_custom_box' ),
				'square_sidebar',
				'normal',
				'high'
			);
			
			// Display meta box
			add_meta_box(
				'square_sidebars_display',
				__( 'Display options', 'SQUARE_sidebars' ),
				array( $this , 'SQUARE_sidebars_display_inner_custom_box' ),
				'square_sidebar',
				'advanced',
				'high'
			);
			
			// Shortcode meta box
			add_meta_box(
				'square_sidebars_shortcode',
				__( "Shortcode", 'SQUARE_sidebars' ),
				array( $this , 'SQUARE_sidebars_shortcode_inner_custom_box' ),
				'square_sidebar',
				'side',
				'high'
			);
			
			// Visibility options meta box
			add_meta_box(
				'square_sidebars_visibility_options',
				__( "Visibility options", 'SQUARE_sidebars' ),
				array( $this , 'SQUARE_sidebars_visibility_options_inner_custom_box' ),
				'square_sidebar',
				'side',
				'default'
			);
			
			// Advanced meta box
			add_meta_box(
				'square_sidebars_advanced_options',
				__( "Advanced options", 'SQUARE_sidebars' ),
				array( $this , 'SQUARE_sidebars_advanced_options_inner_custom_box' ),
				'square_sidebar',
				'side',
				'default'
			);
			
		}
		
		/**
		 * Description meta box
		 */
		public function SQUARE_sidebars_description_inner_custom_box($post){
			
			global $wpdb;
			
			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'SQUARE_sidebars_description_inner_custom_box', 'SQUARE_sidebars_description_nonce' );
			
			if(isset($_GET['post'])){
				// description
				$sidebar_meta = get_post_meta($post->ID, 'SQUARE_sidebars_sidebar', true);
				
				if(!isset($sidebar_meta) || empty($sidebar_meta)){
					$sidebar_description = $wpdb->get_var($wpdb->prepare("SELECT description_square_sidebars FROM " . SQUARE_SIDEBARS_DB . " WHERE id_square_sidebars=%d",$post->ID));
				} else{
					$sidebar_meta = unserialize(base64_decode($sidebar_meta));
					$sidebar_description = $sidebar_meta['description'];
				}
			} else{
				$sidebar_description = '';
			}
			
			// Get the view
			include 'views/meta-box-description.php';
		}
		
		/**
		 * Display meta box
		 */
		public function SQUARE_sidebars_display_inner_custom_box($post){
			
			global $wpdb;
			
			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'SQUARE_sidebars_display_inner_custom_box', 'SQUARE_sidebars_display_nonce' );
			
			if(isset($_GET['post'])){
				// display
				$sidebar_meta = get_post_meta($post->ID, 'SQUARE_sidebars_sidebar', true);
				
				if(!isset($sidebar_meta) || empty($sidebar_meta)){
					$sidebar_display = $wpdb->get_var($wpdb->prepare("SELECT display_square_sidebars FROM " . SQUARE_SIDEBARS_DB . " WHERE id_square_sidebars=%d",$post->ID));
					$sidebar_display = unserialize($sidebar_display);
				} else{
					$sidebar_meta = unserialize(base64_decode($sidebar_meta));	
					$sidebar_display = $sidebar_meta['display'];
				}
			} else{
				$sidebar_display = '';
			}
			
			// Get the view
			include 'views/meta-box-display.php';
		}
		
		/**
		 * Shortcode meta box
		 */
		public function SQUARE_sidebars_shortcode_inner_custom_box($post){
			
			global $wpdb;
			
			// Get the view
			include 'views/meta-box-shortcode.php';
		}
		
		/**
		 * Visibility options meta box
		 */
		public function SQUARE_sidebars_visibility_options_inner_custom_box($post){
			
			global $wpdb;
			
			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'SQUARE_sidebars_visibility_options_inner_custom_box', 'SQUARE_sidebars_visibility_options_nonce' );
			
			if(isset($_GET['post'])){
				// position
				$sidebar_meta = get_post_meta($post->ID, 'SQUARE_sidebars_sidebar', true);
				
				if(!isset($sidebar_meta) || empty($sidebar_meta)){
					$sidebar_position = $wpdb->get_var($wpdb->prepare("SELECT position_square_sidebars FROM " . SQUARE_SIDEBARS_DB . " WHERE id_square_sidebars=%d",$post->ID));
					$sidebar_position = unserialize($sidebar_position);
				} else{
					$sidebar_meta = unserialize(base64_decode($sidebar_meta));
					$sidebar_position = $sidebar_meta['position'];
				}
			} else{
				$sidebar_position = false;
			}
			
			// get SQUARE sidebars
			$square_sidebars_list = get_posts(array('post_type' => 'square_sidebar','post_per_page' => -1, 'suppress_filters' => true));
			$sqr_sidebars = array();
			foreach($square_sidebars_list as $sqr_sidebar){
				$sqr_sidebars[] = $sqr_sidebar->post_name;
			}
			
			// Get the view
			include 'views/meta-box-visibility-options.php';
		}
		
		/**
		 * Advanced options meta box
		 */
		public function SQUARE_sidebars_advanced_options_inner_custom_box($post){
			
			global $wpdb;
			
			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'SQUARE_sidebars_advanced_options_inner_custom_box', 'SQUARE_sidebars_advanced_options_nonce' );
			
			if(isset($_GET['post'])){
				// position
				$sidebar_meta = get_post_meta($post->ID, 'SQUARE_sidebars_sidebar', true);
				
				if(!isset($sidebar_meta) || empty($sidebar_meta)){
					$sidebar_advanced = false;
				} else{
					$sidebar_meta = unserialize(base64_decode($sidebar_meta));
					$sidebar_advanced = isset($sidebar_meta['advanced']) ? $sidebar_meta['advanced'] : false;
				}
			} else{
				$sidebar_advanced = false;
			}
			
			// Get the view
			include 'views/meta-box-advanced-options.php';
		}
		
		/**
		 * Saving data in database 
		 */
		public function SQUARE_save_in_db($post_id) {
			
			global $wpdb;
			
			// Verify if this is an auto save routine. 
			// If it is our form has not been submitted, so we don't want to do anything
			if ( (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) || !isset($_POST['SQUARE_sidebars_description_nonce']) || !isset($_POST['SQUARE_sidebars_display_nonce']) || !isset($_POST['SQUARE_sidebars_visibility_options_nonce']) || !isset($_POST['SQUARE_sidebars_advanced_options_nonce']) || !isset($_POST['square_sidebars']) ) 
				return $post_id;
				
			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times
			if ( !isset($_POST['SQUARE_sidebars_description_nonce']) && !wp_verify_nonce( $_POST['SQUARE_sidebars_description_nonce'], 'SQUARE_sidebars_description_inner_custom_box' ) )
				return $post_id;
				
			if ( !isset($_POST['SQUARE_sidebars_display_nonce']) && !wp_verify_nonce( $_POST['SQUARE_sidebars_display_nonce'], 'SQUARE_sidebars_display_inner_custom_box' ) )
				return $post_id;
				
			if ( !isset($_POST['SQUARE_sidebars_visibility_options_nonce']) && !wp_verify_nonce( $_POST['SQUARE_sidebars_visibility_options_nonce'], 'SQUARE_sidebars_visibility_options_inner_custom_box' ) )
				return $post_id;
				
			if ( !isset($_POST['SQUARE_sidebars_advanced_options_nonce']) && !wp_verify_nonce( $_POST['SQUARE_sidebars_advanced_options_nonce'], 'SQUARE_sidebars_advanced_options_inner_custom_box' ) )
				return $post_id;
			
			// Check permissions
			if ( !current_user_can( 'administrator', $post_id ) )
				return $post_id;
			
			// OK, we're authenticated: we need to find and save the data
	  
			// Saving the datas in the db
			$square_sidebars = $_POST['square_sidebars'];
			// variables
			foreach($square_sidebars as $key => $val){
				if($key == 'description') $desc = stripslashes(trim($val));
				elseif($key == 'display') $display = $val;
				elseif($key == 'position') $position = $val;
				elseif($key == 'advanced') $advanced = $val;
			}
			
			// create array of data
			$sidebar = array(
				'description'		=> $desc,
				'display'			=> $display,
				'position'			=> $position,
				'advanced'			=> $advanced
			);
			// serialize data
			$sidebar = base64_encode(serialize($sidebar));
			
			update_post_meta( $post_id, 'SQUARE_sidebars_sidebar', $sidebar );
		}
		
		/**
		 * add columns to square_sidebar post type
		 *
		 * @access public
		 * @return void
		 */
		public function SQUARE_add_custom_columns( $columns ) {
			// unset column 'Date'
			unset($columns['date']);
			// add columns
			$columns['square_sidebar_shortcode'] = __( 'Shortcode', 'SQUARE_sidebars' );
			// return columns
			return $columns;
		}
		
		/**
		 * manage columns of square_sidebar post type
		 *
		 * @access public
		 * @return void
		 */
		public function SQUARE_manage_custom_columns( $column, $post_id ) {
			switch ( $column ) {
				case 'square_sidebar_shortcode' :
					echo '<span class="square-shortcode"><code>[square_sidebars id="'. $post_id .'"]</code></span>'; 
					break;
			}
		}
	}	
}

?>