<?php
global $speaker_title,$speakers,$tracks,$timeslots;
	$args = array( 'post_type' => 'msd_speaker', 'numberposts' => -1, 'orderby'=> 'menu_order' );
	$speakers = get_posts($args); 
	?>
<div class="my_meta_control">
 		<p><label>Speaker(s)</label>
 		<div style="-moz-column-count: 3;
        -moz-column-gap: 20px;
        -webkit-column-count: 3;
        -webkit-column-gap: 20px;
        column-count: 3;
		column-gap: 20px;">
			<?php 
    foreach($speakers AS $speaker){ 
		$mb->the_field('speaker',WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI);
     	 print '
     	<input type="checkbox" name="'.$mb->get_the_name().'" value="'.$speaker->ID.'" '.$mb->get_the_checkbox_state($speaker->ID).'> '.$speaker->post_title.'<br />'; 
     }
			?>
			</div>
		</p>
 		<p><label>Moderator(s)</label>
 		<div style="-moz-column-count: 3;
        -moz-column-gap: 20px;
        -webkit-column-count: 3;
        -webkit-column-gap: 20px;
        column-count: 3;
		column-gap: 20px;">
			<?php 
    foreach($speakers AS $speaker){
		$mb->the_field('moderator',WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI); 
     	 print '
     	<input type="checkbox" name="'.$mb->get_the_name().'" value="'.$speaker->ID.'" '.$mb->get_the_checkbox_state($speaker->ID).'> '.$speaker->post_title.'<br />';
     }
			?>
			</div>
		</p>
		<?php $mb->the_field('track'); ?>
 		<p><label>Track</label>
		<select name="<?php $mb->the_name(); ?>">
			<option>Select Track</option>
			<option value='all'<?php selected('all',$mb->get_the_value()) ?>>All</option>
			<?php 
    foreach($tracks AS $k=>$v){ 
     	 print '
     	<option value="'.$k.'"'.selected($k,$mb->get_the_value()).'>'.$v.'</option>';
     }
			?>
		</select></p>
		<?php $mb->the_field('timeslot'); ?>
 		<p><label>Timeslot</label>
		<select name="<?php $mb->the_name(); ?>">
			<option>Select Timeslot</option>
			<?php 
    foreach($timeslots AS $k=>$v){ 
     	 print '
     	<option value="'.$k.'"'.selected($k,$mb->get_the_value()).'>'.$v.'</option>';
     }
			?>
		</select></p>
 </div>