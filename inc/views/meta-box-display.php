<?php
	global $SQUARE_sidebars; // for accessing extra functions
?>

<div class="manage-menus">
	<span class="add-edit-menu-action dashicons-before dashicons-info">
		<?php _e('Choose the pages on which the sidebar should be displayed.','SQUARE_sidebars'); ?>		
	</span>
</div>
<table class="form-table square-display-wrapper">
	<tbody>
		<tr valign="top">
			<td>
				<div id="nav-menus-frame">
					<div id="menu-settings-column" class="metabox-holder">
						<div id="nav-menu-meta">
							<div id="side-sortables" class="accordion-container">
								<ul class="outer-border">
									<?php
										/*******************************************************
										****************** ALL POSTS BY POST TYPE **************
										********************************************************/
									?>
									<?php
										
									$post_types = get_post_types('','names');
									$i = 0;
									
									foreach($post_types as $p){
										if($p != 'revision' && $p != 'nav_menu_item' && $p != 'square_sidebar'){
										
											$post_type_obj = get_post_type_object($p);
										
									?>
										<li class="control-section accordion-section <?php if($i == 0) echo "open"; ?> add-<?php echo $p; ?> top" id="add-<?php echo $p; ?>">
											<h3 class="accordion-section-title hndle" tabindex="0" title="<?php echo $post_type_obj->labels->singular_name; ?>"><?php echo $post_type_obj->labels->singular_name; ?></h3>
											<div class="accordion-section-content ">
												<div class="inside">
													<div id="posttype-<?php echo $p; ?>" class="posttypediv">
														<div id="tabs-panel-posttype-<?php echo $p; ?>-most-recent" class="tabs-panel tabs-panel-active">
															<input type="search" class="quick-search input-with-default-title" title="Recherche" placeholder="<?php _e('Search', 'SQUARE_sidebars'); ?>" value="" name="quick-search-posttype-<?php echo $p; ?>" autocomplete="off">
															<ul id="<?php echo $p; ?>checklist" class="categorychecklist form-no-clear">
																<?php 
																	$posts_arr = get_posts(array('orderby'=>'title','order'=>'ASC','post_type'=>$p,'posts_per_page'=>-1));
																	
																	foreach($posts_arr as $post){
																?>
																<li>
																	<label>
																		<input type="checkbox" name="nosubmit_square_sidebars[display][<?php echo $p; ?>][]" value="<?php echo $post->ID; ?>" /> &nbsp;<span data-square-type="<?php echo $p; ?>" data-square-name="<?php echo $post_type_obj->labels->singular_name;?>" data-square-title-to-id="<?php echo $SQUARE_sidebars->extra_functions->SQUARE_convert_to_id($post->post_title); ?>"><?php echo $post->post_title; ?></span>
																	</label>
																</li>
																<?php } ?>
															</ul>
														</div>
														<p class="button-controls">
															<span class="list-controls">
																<a href="#" class="square-sidebars-select-unselect square-sidebars-select-all" data-square-action="check"><?php _e('Select all','SQUARE_sidebars'); ?></a>
																<a href="#" class="square-sidebars-select-unselect square-sidebars-unselect-all inactive" data-square-action="uncheck"><?php _e('Unselect all','SQUARE_sidebars'); ?></a>
															</span>
															<span class="add-to-menu">
																<input type="button" class="button-secondary submit-add-to-menu right square-add-to-sidebar" value="<?php _e('Add','SQUARE_sidebars'); ?>" name="add-<?php echo $p; ?>-type-menu-item" id="square-submit-<?php echo $p; ?>">
																<span class="spinner"></span>
															</span>
														</p>
													</div><!-- /.posttypediv -->
												</div><!-- .inside -->
											</div><!-- .accordion-section-content -->
										</li><!-- .accordion-section -->
									<?php
										} // end if $p
										
										$i++;
										
									} // end foreach $post_types as $p
									?>
									<?php
										/*******************************************************
										****************** POST TYPES **************************
										********************************************************/
									?>
									<li class="control-section accordion-section add-category" id="add-post-types">
										<h3 class="accordion-section-title hndle" tabindex="0" title="Types de post"><?php _e('Post types','SQUARE_sidebars'); ?></h3>
										<div class="accordion-section-content ">
											<div class="inside">
													<div id="posttype-post-type" class="posttypediv">
														<div id="tabs-panel-posttype-post-type" class="tabs-panel">
															<input type="search" class="quick-search input-with-default-title" title="Recherche" placeholder="<?php _e('Search', 'SQUARE_sidebars'); ?>" value="" name="quick-search-posttype-post-type" autocomplete="off">
															<ul id="posttypechecklist" class="categorychecklist form-no-clear">
																<?php 
																	$post_types = get_post_types('','names');
																	
																	foreach($post_types as $p){
																		if($p != 'revision' && $p != 'nav_menu_item' && $p != 'square_sidebar'){
																		
																			$post_type_obj = get_post_type_object($p);
																?>
																<li>
																	<label>
																		<input type="checkbox" name="nosubmit_square_sidebars[display][post-types][]" value="<?php echo $p; ?>" /> &nbsp;<span data-square-type="post-type" data-square-name="<?php _e('Post type','SQUARE_sidebars'); ?>" data-square-title-to-id="<?php echo $SQUARE_sidebars->extra_functions->SQUARE_convert_to_id($post_type_obj->labels->singular_name); ?>"><?php echo $post_type_obj->labels->singular_name; ?></span>
																	</label>
																</li>
																<?php } } ?>
															</ul>
														</div>
														<p class="button-controls">
														<span class="list-controls">
															<a href="#" class="square-sidebars-select-unselect square-sidebars-select-all" data-square-action="check"><?php _e('Select all','SQUARE_sidebars'); ?></a>
															<a href="#" class="square-sidebars-select-unselect square-sidebars-unselect-all inactive" data-square-action="uncheck"><?php _e('Unselect all','SQUARE_sidebars'); ?></a>
														</span>
														<span class="add-to-menu">
															<input type="button" class="button-secondary submit-add-to-menu right square-add-to-sidebar" value="<?php _e('Add','SQUARE_sidebars'); ?>" name="add-post-type-menu-item" id="submit-posttype-post-type">
															<span class="spinner"></span>
														</span>
													</p>
												</div><!-- /.posttypediv -->
											</div><!-- .inside -->
										</div><!-- .accordion-section-content -->
									</li><!-- .accordion-section -->
									<?php
										/*******************************************************
										****************** TAXONOMIES **************************
										********************************************************/
									?>
									<?php
										$taxonomies = get_taxonomies('','objects'); 
										foreach ($taxonomies as $taxonomy ) {
									?>
										<li class="control-section accordion-section add-<?php echo $taxonomy->name; ?>" id="add-<?php echo $taxonomy->name; ?>">
											<h3 class="accordion-section-title hndle" tabindex="0" title="<?php echo $taxonomy->labels->singular_name; ?>"><?php echo $taxonomy->labels->singular_name; ?></h3>
											<div class="accordion-section-content ">
												<div class="inside">
														<div id="taxonomy-<?php echo $taxonomy->name; ?>" class="posttypediv">
															<div id="tabs-panel-taxonomy-<?php echo $taxonomy->name; ?>" class="tabs-panel">
																<input type="search" class="quick-search input-with-default-title" title="Recherche" placeholder="<?php _e('Search', 'SQUARE_sidebars'); ?>" value="" name="quick-search-posttype-<?php echo $taxonomy->name; ?>" autocomplete="off">
																<ul id="taxonomychecklist-<?php echo $taxonomy->name; ?>" class="categorychecklist form-no-clear">
																	<?php 
																		$terms = get_terms($taxonomy->name, array('hide_empty'=>0));
																		foreach($terms as $c){
																	?>
																			<li>
																				<label>
																					<input type="checkbox" name="nosubmit_square_sidebars[display][<?php echo $taxonomy->name; ?>][]" value="<?php echo $c->term_id; ?>" /> &nbsp;<span data-square-type="<?php echo $taxonomy->name; ?>" data-square-name="<?php echo $taxonomy->labels->singular_name; ?>" data-square-title-to-id="<?php echo $SQUARE_sidebars->extra_functions->SQUARE_convert_to_id($c->name); ?>"><?php echo $c->name; ?></span>
																				</label>
																			</li>
																	<?php } ?>
																</ul>
															</div>
															<p class="button-controls">
															<span class="list-controls">
																<a href="#" class="square-sidebars-select-unselect square-sidebars-select-all" data-square-action="check"><?php _e('Select all','SQUARE_sidebars'); ?></a>
																<a href="#" class="square-sidebars-select-unselect square-sidebars-unselect-all inactive" data-square-action="uncheck"><?php _e('Unselect all','SQUARE_sidebars'); ?></a>
															</span>
															<span class="add-to-menu">
																<input type="button" class="button-secondary submit-add-to-menu right square-add-to-sidebar" value="<?php _e('Add','SQUARE_sidebars'); ?>" name="add-post-type-menu-item" id="submit-posttype-category">
																<span class="spinner"></span>
															</span>
														</p>
													</div><!-- /.posttypediv -->
												</div><!-- .inside -->
											</div><!-- .accordion-section-content -->
										</li><!-- .accordion-section -->
									<?php
										} // end foreach $taxonomies as $taxonomy
									?>
									<?php
										/*******************************************************
										****************** PAGE TEMPLATES **********************
										********************************************************/
									?>
									<li class="control-section accordion-section add-category" id="add-test">
										<h3 class="accordion-section-title hndle" tabindex="0" title="Templates de page"><?php _e('Page templates','SQUARE_sidebars'); ?></h3>
										<div class="accordion-section-content ">
											<div class="inside">
													<div id="posttype-page-template" class="posttypediv">
														<div id="tabs-panel-posttype-page-template" class="tabs-panel">
															<input type="search" class="quick-search input-with-default-title" title="Recherche" placeholder="<?php _e('Search', 'SQUARE_sidebars'); ?>" value="" name="quick-search-posttype-page-template" autocomplete="off">
															<ul id="pagetemplatechecklist" class="categorychecklist form-no-clear">
																<?php 
																	// get a list of all page templates
																	$templates_arr = wp_get_theme()->get_page_templates();
																	
																	foreach($templates_arr as $template_filename => $template_name){
																		$template_name_id = $SQUARE_sidebars->extra_functions->SQUARE_convert_to_id($template_name);
																?>
																<li>
																	<label>
																		<input type="checkbox" name="nosubmit_square_sidebars[display][page-templates][]" value="<?php echo $template_name_id; ?>" />&nbsp;<span data-square-type="page-templates" data-square-name="<?php _e('Page template','SQUARE_sidebars'); ?>" data-square-title-to-id="<?php echo $SQUARE_sidebars->extra_functions->SQUARE_convert_to_id($template_name); ?>"><?php echo $template_name; ?></span>
																	</label>
																</li>
																<?php } ?>
															</ul>
														</div>
														<p class="button-controls">
														<span class="list-controls">
															<a href="#" class="square-sidebars-select-unselect square-sidebars-select-all" data-square-action="check"><?php _e('Select all','SQUARE_sidebars'); ?></a>
															<a href="#" class="square-sidebars-select-unselect square-sidebars-unselect-all inactive" data-square-action="uncheck"><?php _e('Unselect all','SQUARE_sidebars'); ?></a>
														</span>
														<span class="add-to-menu">
															<input type="button" class="button-secondary submit-add-to-menu right square-add-to-sidebar" value="<?php _e('Add','SQUARE_sidebars'); ?>" name="add-post-type-menu-item" id="submit-posttype-page-template">
															<span class="spinner"></span>
														</span>
													</p>
												</div><!-- /.posttypediv -->
											</div><!-- .inside -->
										</div><!-- .accordion-section-content -->
									</li><!-- .accordion-section -->
								</ul><!-- .outer-border -->
							</div>
						</div>
					</div>
				</div>
			</td>
			<td>
				<div class="metabox-holder">
					<div class="postbox">
						<div class="group">
							<h3><?php _e('Display', 'SQUARE_sidebars'); ?></h3>
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<td id="square-display-container" class="menu-item-bar">
											<?php
												if(isset($sidebar_display) && !empty($sidebar_display)){
													foreach($sidebar_display as $type => $array){
														foreach($array as $key => $val){
															
															if($type == 'post-types'){
																$type_nice = __('Post type','SQUARE_sidebars');
																$type_identifier = 'Type-de-post';
																$label = ucfirst($val);
															} // end if post-type
															
															elseif($type == 'page-templates'){
																$type_nice = __('Page template','SQUARE_sidebars');
																
																foreach($templates_arr as $template_filename => $template_name){
																	$template_name_id = $SQUARE_sidebars->extra_functions->SQUARE_convert_to_id($template_name);
																	if($val == $template_name_id)
																		$label = $template_name;
																}
															}
															
															else{
															
																$post_types = get_post_types('','names');
																		
																foreach($post_types as $p){
																	if($p != 'revision' && $p != 'nav_menu_item' && $p != 'square_sidebars'){
																	
																		$post_type_obj = get_post_type_object($p);
															
																		if($type == $p){
																			$type_nice = $post_type_obj->labels->singular_name;
																			$sq_post = get_post($val);
																			$label = $sq_post->post_title;
																		}
																	}
																} // end foreach post types
																
																$taxonomies = get_taxonomies('','objects'); 
																foreach ($taxonomies as $taxonomy ) {
																	
																	if($type == $taxonomy->name){
																		$type_nice = $taxonomy->labels->singular_name;
																		$sq_cat = get_term($val,$taxonomy->name);
																		$label = $sq_cat->name;
																	}
																	
																} // end foreach $taxonomies
																
															}
															
											?>
											<div class="square-display-items menu-item-handle">
												<strong class="item-title"><?php echo $label; ?></strong>
												<span class="item-controls">
													<span class="item-type"><?php echo $type_nice; ?></span>
													<span class="dashicons-before dashicons-no square-sidebars-remove"></span>
												</span>
												<input type="hidden" name="square_sidebars[display][<?php echo $type; ?>][]" value="<?php echo $val; ?>" class="square-display-items-hidden" data-square-identifier="<?php echo str_replace(' ','-',$type); ?>-<?php echo $val; ?>" />
											</div>
											<?php
														}
													}
												}
											?>
											<!-- display all the pages the sidebar should appear in -->
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</tbody>
</table>