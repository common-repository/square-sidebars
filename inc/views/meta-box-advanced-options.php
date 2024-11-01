<div>
	<label>
		<h4><code><?php _e('before_widget','SQUARE_sidebars'); ?></code></h4>
		<textarea name="square_sidebars[advanced][before_widget]" id="square-sidebars-before-widget" class="square-sidebars-advanced"><?php 
			if(!$sidebar_advanced) 
				echo stripslashes(wp_filter_post_kses('<li id="%1$s" class="widget %2$s">')); 
			else 
				echo stripslashes(wp_filter_post_kses($sidebar_advanced['before_widget']));
		?></textarea>
	</label>
	<br />
	<label>
		<h4><code><?php _e('after_widget','SQUARE_sidebars'); ?></code></h4>
		<textarea name="square_sidebars[advanced][after_widget]" id="square-sidebars-after-widget" class="square-sidebars-advanced"><?php 
			if(!$sidebar_advanced) 
				echo stripslashes(wp_filter_post_kses('</li>')); 
			else 
				echo stripslashes(wp_filter_post_kses($sidebar_advanced['after_widget']));
		?></textarea>
	</label>
	<br />
	<label>
		<h4><code><?php _e('before_title','SQUARE_sidebars'); ?></code></h4>
		<textarea name="square_sidebars[advanced][before_title]" id="square-sidebars-before-title" class="square-sidebars-advanced"><?php 
			if(!$sidebar_advanced) 
				echo stripslashes(wp_filter_post_kses('<h3 class="widgettitle">')); 
			else 
				echo stripslashes(wp_filter_post_kses($sidebar_advanced['before_title']));
		?></textarea>
	</label>
	<br />
	<label>
		<h4><code><?php _e('after_title','SQUARE_sidebars'); ?></code></h4>
		<textarea name="square_sidebars[advanced][after_title]" id="square-sidebars-after-title" class="square-sidebars-advanced"><?php 
			if(!$sidebar_advanced) 
				echo stripslashes(wp_filter_post_kses('</h3>')); 
			else 
				echo stripslashes(wp_filter_post_kses($sidebar_advanced['after_title']));
		?></textarea>
	</label>
	<br />
</div>