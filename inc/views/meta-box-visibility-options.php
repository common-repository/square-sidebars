<div>
	<label>
		<input type="radio" name="square_sidebars[position][replace]" value="Y" <?php if(!$sidebar_position) echo 'checked="checked"'; else checked('Y',$sidebar_position['replace'],true); ?> id="square_sidebars_replace_yes" class="square_sidebars_replace" />&nbsp;&nbsp;<?php _e('Replace a sidebar','SQUARE_sidebars'); ?>
	</label>
	<br />
	<label>
		<input type="radio" name="square_sidebars[position][replace]" value="N" <?php if($sidebar_position) checked('N',$sidebar_position['replace'],true); ?> id="square_sidebars_replace_no" class="square_sidebars_replace" />&nbsp;&nbsp;<?php _e('Do not replace a sidebar','SQUARE_sidebars'); ?>
	</label>
	<br />
	<label>
		<input type="radio" name="square_sidebars[position][replace]" value="NC" <?php if($sidebar_position) checked('NC',$sidebar_position['replace'],true); ?> id="square_sidebars_replace_none" class="square_sidebars_replace" />&nbsp;&nbsp;<?php _e('Do not display the sidebar','SQUARE_sidebars'); ?>
	</label>
</div>
<br />
<div>
	<select name="square_sidebars[position][location]" style="width:80px;display:none;" id="square_sidebars_replace_location">
		<option value="before" <?php if($sidebar_position) selected('before',$sidebar_position['location'],true); ?>><?php _e('Before','SQUARE_sidebars'); ?></option>
		<option value="after" <?php if($sidebar_position) selected('after',$sidebar_position['location'],true); ?>><?php _e('After','SQUARE_sidebars'); ?></option>
	</select>
	<select name="square_sidebars[position][sidebar]" style="width:170px;" id="square_sidebars_replace_sidebar">
		<?php 
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
			// check if $sidebar is not a custom SQR Sidebar, otherwise bail!
			if(is_array($sqr_sidebars) && in_array($sidebar['id'], $sqr_sidebars))
				continue;
		?>
			 <option value="<?php echo $sidebar['id']; ?>" <?php if($sidebar_position) selected($sidebar['id'],$sidebar_position['sidebar'],true); ?>>
					  <?php echo ucwords( $sidebar['name'] ); ?>
			 </option>
		<?php 
		}
		?>
	</select>
</div>