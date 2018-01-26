<?php
/*
Template Name: Landing Page
*/
add_action('genesis_after_loop',array('MSDLandingPage','landing_page_output'));
add_action('genesis_after_loop','msdlab_landing_sidebar');

function msdlab_landing_sidebar(){
    print '<div class="widget-area landing-widgets">';
    dynamic_sidebar( 'landing' );
    print '</div>';
}
genesis();
