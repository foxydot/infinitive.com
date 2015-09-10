<?php
/*
Template Name: Showcase Page
*/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action('genesis_before_entry','msd_post_image');
add_action('genesis_after_header','msd_showcase_post_image');
add_shortcode('box','msdlab_box_shortcode_output');
add_filter('the_content','strip_empty_tags', 9999);

function msd_showcase_post_image(){
    global $post;
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
    $background = $featured_image[0];
    $ret = '<div class="banner" style="background-image:url('.$background.')"></div>';
    print $ret;
}

function msdlab_box_shortcode_output($args, $content){
    $content = do_shortcode($content);
    $content = trim_whitespace($content);
    return '<div class="box">'.$content.'</div>';
}
genesis();
