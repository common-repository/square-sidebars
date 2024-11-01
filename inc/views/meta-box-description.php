<textarea onkeyup="countChar(this.value)" id="square_sidebars_description_txtarea" maxlength="1000" name="square_sidebars[description]"><?php if($sidebar_description) echo $sidebar_description; ?></textarea>

<div class="clearfix">
	<p class="description" style="float:left;">
		<?php _e('The description lets you give information about the usage of the sidebar. <u>Maximum: 1,000 characters</u>.','SQUARE_sidebars'); ?>
	</p>
	<p class="description" id="square-sidebars-description-charnum" style="float:right;">
		Count :&nbsp; <span></span>
	</p>
</div>