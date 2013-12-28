<?php global $wpalchemy_media_access; ?>
<div class="my_meta_control gform_wrapper">
<ul class='gform_fields top_label description_below'>
<?php $mb->the_field('youtube'); ?>
<li class='gfield' ><label class='gfield_label'>YouTube URL</label>
<div class='ginput_container'><input name='<?php $mb->the_name(); ?>' type='text' value='<?php $mb->the_value(); ?>' class='medium'  tabindex='3'  /></div></li>
</ul>
</div>