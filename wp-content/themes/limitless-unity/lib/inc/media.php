<?php
/**
 * Add new image sizes
 */
add_image_size('page-header-image', 760, 230, TRUE);
add_image_size('headshot',230,230,TRUE);
add_image_size('mini-headshot',112,125,TRUE);
add_image_size('post-thumb', 225, 160, TRUE);
add_image_size( 'post-image', 760, 230, TRUE ); //image to float at the top of the post. Reversed Out does these a lot.

add_image_size('tiny_thumb', 45, 45, TRUE);
add_image_size('child_full', 730, 380, TRUE);
add_image_size('child_thumbnail', 350, 170, TRUE);

add_image_size('table_press',220,150,FALSE);
/**
 * Manipulate the featured image
 */
function msd_post_image() {
    global $post;
    //setup thumbnail image args to be used with genesis_get_image();
    $size = 'page-header-image'; // Change this to whatever add_image_size you want
    $default_attr = array(
            'class' => "alignnone attachment-$size $size",
            'alt'   => $post->post_title,
            'title' => $post->post_title,
    );

    // This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
    if ( has_post_thumbnail() && is_page() ) {
        //printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
        print genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) );
    }
    if ( has_post_thumbnail() && is_cpt('msd_casestudy') ) {
        printf( '%s', genesis_get_image( array( 'size' => 'post-thumb', 'attr' => array(
            'class' => "alignleft attachment-$size $size",
            'alt'   => $post->post_title,
            'title' => $post->post_title,
    ) ) ) );
    }

}

/**
 * Add new image sizes to the media panel
 */
if(!function_exists('msd_insert_custom_image_sizes')){
function msd_insert_custom_image_sizes( $sizes ) {
	global $_wp_additional_image_sizes;
	if ( empty($_wp_additional_image_sizes) )
		return $sizes;

	foreach ( $_wp_additional_image_sizes as $id => $data ) {
		if ( !isset($sizes[$id]) )
			$sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
	}

	return $sizes;
}
}
add_filter( 'image_size_names_choose', 'msd_insert_custom_image_sizes' );

add_filter( 'genesis_pre_load_favicon', 'sp_favicon_filter' );
function sp_favicon_filter( $favicon_url ) {
    return get_stylesheet_directory_uri().'/lib/img/favicon.ico';
}