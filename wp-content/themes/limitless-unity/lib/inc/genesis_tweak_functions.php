<?php
/*** HEADER ***/
/**
 * Add pre-header with social and search
 */
function msdlab_pre_header(){
    print '<div class="pre-header">
        <div class="wrap">';
           do_shortcode('[msd-social]');
           get_search_form();
    print '
        </div>
    </div>';
}

 /**
 * Customize search form input
 */
function msdlab_search_text($text) {
    $text = esc_attr( 'Begin your search here...' );
    $text = 'XXXXXXXXXXXXXX';
    return $text;
}

/*** NAV ***/


/*** SIDEBARS ***/
/**
 * Reversed out style SCS
 * This ensures that the primary sidebar is always to the left.
 */
function msdlab_ro_layout_logic() {
    $site_layout = genesis_site_layout();    
    if ( $site_layout == 'sidebar-content-sidebar' ) {
        // Remove default genesis sidebars
        remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
        remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt');
        // Add layout specific sidebars
        add_action( 'genesis_before_content_sidebar_wrap', 'genesis_get_sidebar' );
        add_action( 'genesis_after_content', 'genesis_get_sidebar_alt');
    }
}

/**
 * Legacy widget areas
 */
function msdlab_add_legacy_sidebars(){
    register_sidebar( array(
            'name' => __( 'Main Homepage Feature Area', 'infinite' ),
            'id' => 'main-feature-area',
            'description' => __( 'The feature area on the homepage. One slideshow is recommended.', 'infinite' ),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        // Area 3, located in the footer. Empty by default.
        register_sidebar( array(
            'name' => __( 'Main Homepage Footer Widget Area', 'infinite' ),
            'id' => 'main-footer-widget-area',
            'description' => __( 'The main homepage footer widget area. Three widgets are recommended.', 'infinite' ),
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h4 class="widget-title">',
            'after_title' => '</h4>',
        ) );register_sidebar( array(
        'name' => __( 'Homepage Footer Widget Area', 'infinite' ),
        'id' => 'homepage-footer-widget-area',
        'description' => __( 'The homepage footer widget area. Three widgets are recommended.', 'infinite' ),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );

    // Area 1, located at the top of the sidebar.
    register_sidebar( array(
        'name' => __( 'Primary Widget Area', 'infinite' ),
        'id' => 'primary-widget-area',
        'description' => __( 'The primary widget area', 'infinite' ),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );

    // Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
    register_sidebar( array(
        'name' => __( 'Secondary Widget Area', 'infinite' ),
        'id' => 'secondary-widget-area',
        'description' => __( 'The secondary widget area', 'infinite' ),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );

    // Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
    register_sidebar( array(
        'name' => __( 'Blog Widget Area', 'infinite' ),
        'id' => 'blog-widget-area',
        'description' => __( 'The blog widget area', 'infinite' ),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
    // Area 3, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'Footer Widget Area', 'infinite' ),
        'id' => 'footer-widget-area',
        'description' => __( 'The footer widget area. Two widgets are recommended.', 'infinite' ),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
}

/*** CONTENT ***/

/**
 * Customize Breadcrumb output
 */
function msdlab_breadcrumb_args($args) {
    $args['labels']['prefix'] = ''; //marks the spot
    $args['sep'] = ' > ';
    return $args;
}

/*** FOOTER ***/

/**
 * Footer replacement with MSDSocial support
 */
function msdlab_do_social_footer(){
    global $msd_social;
    if(has_nav_menu('footer_library_link')){$copyright .= wp_nav_menu( array( 'theme_location' => 'footer_library_link','container_class' => 'ftr-menu','echo' => FALSE ) ).'<br />';}
    if($msd_social){
        $copyright .= '&copy;Copyright '.date('Y').' '.$msd_social->get_bizname().' &middot; All Rights Reserved';
    } else {
        $copyright .= '&copy;Copyright '.date('Y').' '.get_bloginfo('name').' &middot; All Rights Reserved ';
    }
    if(has_nav_menu('footer_menu')){$copyright .= wp_nav_menu( array( 'theme_location' => 'footer_menu','container_class' => 'ftr-menu ftr-links','echo' => FALSE ) );}
    print '<div id="copyright" class="copyright gototop">'.$copyright.'</div><div id="social" class="social creds">';
    if($msd_social){do_shortcode('[msd-social]');}
    print '</div>';
}

/**
 * Menu area for above footer treatment
 */
register_nav_menus( array(
    'footer_menu' => 'Footer Menu'
) );