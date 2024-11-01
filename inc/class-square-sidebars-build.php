<?php

if ( ! defined('ABSPATH') ) exit; // Exit if accessed directly

/**
 * Initialization of the class
 */
if ( !class_exists( 'SQUARE_sidebars_build' ) ) {

	class SQUARE_sidebars_build{
		
		public function __construct(){
			// build sidebars
			add_action( 'admin_init', array( $this, 'build_sidebars' ) );
			add_action( 'widgets_init', array( $this, 'build_sidebars' ) );
			// add sidebars to widgets page
			add_filter( 'sidebars_widgets', array( $this, 'sidebars_hide_show' ) );
		}
		
		/* Making the sidebars appear in the "Widgets" section */
		public function build_sidebars(){
			global $wpdb;

			/* Extract the sidebars */
			if ( function_exists('register_sidebars') ){
				
				// getting all the activated sidebars
				$sidebars = $this->get_all_sidebars();
				
				foreach($sidebars as $sidebar){
					$sidebar_title = stripslashes($sidebar->post_title);
					$sidebar_name = $sidebar->post_name;
					
					// get sidebar meta
					$sidebar_meta = get_post_meta($sidebar->ID, 'SQUARE_sidebars_sidebar', true);
					
					// if sidebar_meta is empty, thus does not exist, check in custom table (former version)
					if(!isset($sidebar_meta) || empty($sidebar_meta)){
						$sidebar_description = $wpdb->get_var($wpdb->prepare("SELECT description_square_sidebars FROM ". SQUARE_SIDEBARS_DB ." WHERE id_square_sidebars=%d",$sidebar->ID));
						$sidebar_advanced = false;
					} else{
						$sidebar_meta = unserialize(base64_decode($sidebar_meta));	
						$sidebar_description = stripslashes($sidebar_meta['description']);
						$sidebar_advanced = (isset($sidebar_meta['advanced']) && !empty($sidebar_meta['advanced'])) ? $sidebar_meta['advanced'] : '';
					}
					
					register_sidebar(array(
						'name'				=> $sidebar_title,
						'id'				=> $sidebar_name,
						'description'		=> $sidebar_description,
						'before_widget'		=> (!$sidebar_advanced) ? '<li id="%1$s" class="widget %2$s">' : stripslashes(wp_filter_post_kses($sidebar_advanced['before_widget'])),
						'after_widget'  	=> (!$sidebar_advanced) ? '</li>' : stripslashes(wp_filter_post_kses($sidebar_advanced['after_widget'])),
						'before_title'  	=> (!$sidebar_advanced) ? '<h3 class="widgettitle">' : stripslashes(wp_filter_post_kses($sidebar_advanced['before_title'])),
						'after_title'   	=> (!$sidebar_advanced) ? '</h3>' : stripslashes(wp_filter_post_kses($sidebar_advanced['after_title'])),
					));
				}
			}
		}

		/**
		 * Let us display the sidebars content and remove the unneeded sidebars 
		 */
		public function sidebars_hide_show($all_sidebars=array()){		
			
			if( did_action( 'sidebars_widgets' ) == 1 )
				return $all_sidebars;
			
			global $wpdb, $wp_registered_widgets, $wp_registered_sidebars, $_wp_sidebars_widgets, $post;
			
			// getting variables
			// categories
			$curr_post_c = array();
			$taxonomies = get_taxonomies('','objects'); 
			
			foreach ($taxonomies as $taxonomy ) {
				if(isset($post)){
					$curr_post_categories = get_the_terms( $post->ID, $taxonomy->name );
					if(!empty($curr_post_categories)){
						foreach($curr_post_categories as $curr_post_cat){
							$curr_post_c[] = $curr_post_cat->term_id;
						}
					}
				}
			}
			
			// template pages
			if(is_singular() && basename(get_page_template())){
				$curr_page_template = basename(get_page_template());
				// get a list of all page templates
				$templates_arr = wp_get_theme()->get_page_templates();				
				
				foreach($templates_arr as $template_filename => $template_name){
					// get only the last element (after the last '/')
					$template_filename = basename($template_filename);
					// if the current page template is a page template theme, grab its name (not its filename)
					if($curr_page_template == $template_filename){
						global $SQUARE_sidebars;
						$curr_page_template = $SQUARE_sidebars->extra_functions->SQUARE_convert_to_id($template_name);
					}
				}
			}
			
			// post types
			if(isset($post))
				$curr_post_type = get_post_type( $post->ID );
			
			$post_types = get_post_types('','names');
			$post_t = array();
			
			foreach($post_types as $post_type){
				$post_t[] = $post_type;
			}
			
			// getting all the activated sidebars
			$sidebars = $this->get_all_sidebars();
			
			if(!isset($sidebars) || empty($sidebars))
				return;
			
			foreach($sidebars as $sidebar){
			
				$sidebar_id = $sidebar->post_name;
				
				// get sidebar meta
				$sidebar_meta = get_post_meta($sidebar->ID, 'SQUARE_sidebars_sidebar', true);
				
				// if sidebar_meta is empty, thus does not exist, check in custom table (former version)
				if(!isset($sidebar_meta) || empty($sidebar_meta)){
					$sidebar_meta = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". SQUARE_SIDEBARS_DB ." WHERE id_square_sidebars=%d",$sidebar->ID));
					$sidebar_position = unserialize($sidebar_meta->position_square_sidebars);
					$sidebar_display = unserialize($sidebar_meta->display_square_sidebars);
				} else{
					$sidebar_meta = unserialize(base64_decode($sidebar_meta));	
					$sidebar_position = $sidebar_meta['position'];
					$sidebar_display = $sidebar_meta['display'];
				}
				
				
				if(!isset($sidebar_position) || empty($sidebar_position)){
					$sidebar_replace = 'Y';
					$sidebar_sidebar = '';
					
				} else{
					foreach($sidebar_position as $key => $val){
						if($key == 'replace'){
							$sidebar_replace = $val;
						}
						elseif($key == 'location'){
							if($val == 'before'){
								$sidebar_location = true;
							}else{
								$sidebar_location = false;
							}
						}
						elseif($key == 'sidebar'){
							$sidebar_sidebar = $val;
						}
					}
				}
				
				$sidebar_title = apply_filters( 'page-sidebar-title' , $sidebar_sidebar );
				
				// $sidebar_display is an array with the type of the 'page' (article, page, category, etc.) and an array of ids' page/post/category/etc.
				if(!empty($sidebar_display)){
					
					$all_sidebars_arr = array();
					
					foreach($sidebar_display as $type => $id){
						
						if($sidebar_display[$type] && ((isset($curr_post_type) && in_array($curr_post_type,$sidebar_display[$type])) || (isset($curr_page_template) && in_array($curr_page_template,$sidebar_display[$type])) || (isset($post) && in_array($post->ID,$sidebar_display[$type])) || ($sidebar_display[$type] && isset($curr_post_c) && count(array_intersect($curr_post_c,$sidebar_display[$type])) > 0))){
							$sidebar_term = $sidebar_id;
							$sidebars_widgets = $_wp_sidebars_widgets;
							
							if( !array_key_exists( $sidebar_term, $sidebars_widgets) || count($_wp_sidebars_widgets[$sidebar_term]) < 1 ){
								return $all_sidebars; 
							
							}else{
								
								if( $sidebars_widgets['array_version'] != 3  )
									return $all_sidebars;
								
								// if we do not want to replace a sidebar but still want to display it
								if($sidebar_replace == 'N'){
									$add_sidebar = (array)$all_sidebars[$sidebar_title];
									if( is_array( $_wp_sidebars_widgets[$sidebar_term] ) ){
										$all_sidebars[$sidebar_title] = ( $sidebar_location )
											? array_merge( $_wp_sidebars_widgets[$sidebar_term], $add_sidebar )
											: array_merge( $add_sidebar, $_wp_sidebars_widgets[$sidebar_term] );
									}else{
										$all_sidebars[$sidebar_title] = $add_sidebar;
									}
								
								// if we do want to replace a sidebar									
								} elseif($sidebar_replace == 'Y'){
									$all_sidebars[$sidebar_title] = $_wp_sidebars_widgets[$sidebar_term];
								}
							}
						}
						else{
							// return $all_sidebars;
							continue;
						}
						
					} // end foreach $sidebar_display

				} // end if !empty $sidebar_display
				else{
					return $all_sidebars;
				}
			} // end foreach
			
			return $all_sidebars;
		}
		
		public function get_all_sidebars(){
			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'square_sidebar',
				'post_status'      => 'publish',
				'suppress_filters' => true 
			);
			
			$sidebars = get_posts( $args );
				
			return $sidebars;
		}
	}
}

?>