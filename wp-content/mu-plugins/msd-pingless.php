<?php
/*
Plugin Name: MSD Pingless
Description: Blocks selfpings
Version: 0.1
Author: Catherine M OBrien Sandrick (CMOS)
Author URI: http://msdlab.com/biological-assets/catherine-obrien-sandrick/
License: GPL v2
*/

add_action( 'pre_ping' , 'msdlab_no_self_ping' );
    
function msdlab_no_self_ping( $links ) {
    foreach ( $links as $link_count => $link ) {
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset( $links[$link_count] );
    }
}