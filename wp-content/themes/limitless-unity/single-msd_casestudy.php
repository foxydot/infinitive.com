<?php
function msdlab_custom_case_study_header(){
    print '<div class="section-header"><h3>Case Studies</h3></div>';
}
add_action('genesis_before_loop','msdlab_custom_case_study_header');

add_filter('body_class','practice_area_body_class');
function practice_area_body_class($classes) {
    global $post;
    $terms = wp_get_post_terms( $post->ID, 'msd_practice-area' );
    $classes[] = $terms[0]->slug;
    return $classes;
}
add_filter('genesis_post_title_text','msdlab_case_study_title');
function msdlab_case_study_title($content){
    global $post;
    $terms = wp_get_post_terms( $post->ID, 'msd_practice-area' );
    $content = '<span class="icon-'.$terms[0]->slug.'"><i></i></span> '.$content;
    return $content;
}
genesis();