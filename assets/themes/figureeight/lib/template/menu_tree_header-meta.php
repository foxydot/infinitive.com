<?php global $wpalchemy_media_access; ?>
<div class="my_meta_control" id="menu_tree_header_metabox">
	<p>
		<?php $mb->the_field('menu_tree_header'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" />
	</p>
</div>