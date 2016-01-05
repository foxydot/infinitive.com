<?php
add_action('init','deregister_infinitive_cpts',99);
function deregister_infinitive_cpts(){
	unregister_post_type('msd_publication');
	unregister_post_type('msd_casestudy');
	unregister_post_type('msd_news');
}

if ( ! function_exists( 'unregister_post_type' ) ) :
function unregister_post_type( $post_type ) {
	global $wp_post_types;
	if ( isset( $wp_post_types[ $post_type ] ) ) {
		unset( $wp_post_types[ $post_type ] );
		return true;
	}
	return false;
}
endif;