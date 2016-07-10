<?php

add_action('template_redirect','msdlab_blog_grid');
add_action('genesis_before_loop','msd_add_blog_header');
 
 /**
 * Custom blog loop
 */
 
// Setup Grid Loop
function msdlab_blog_grid(){
    global $loop_counter;
    if(!isset($loop_counter)){$loop_counter=0;}
    add_action('genesis_after_entry','msd_add_loop_counter_to_html5_loop',1);
    if(is_home()){
        remove_action( 'genesis_loop', 'genesis_do_loop' );
        add_action( 'genesis_loop', 'msdlab_grid_loop_helper' );
        add_action('genesis_before_entry', 'msdlab_switch_content');
        remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
        add_filter('genesis_grid_loop_post_class', 'msdlab_grid_add_bootstrap');
        add_filter( 'pre_get_posts', 'be_archive_query' ,20);
    }
}
function msdlab_grid_loop_helper() {
    if ( function_exists( 'genesis_grid_loop' ) ) {                
        genesis_grid_loop( array(
        'features' => 1,
        'features_on_all'       => false,
        'feature_image_size'    => 'child_full',
        'feature_image_class'   => 'alignnone post-image child_full',
        'feature_content_limit' => 0,
        'grid_image_size'       => 'child_thumbnail',
        'grid_image_class'      => 'alignnone post-image child_thumbnail',
        'grid_content_limit'    => 0,
        'more' => __( '[Continue reading...]', 'adaptation' ),
        ) );
    } else {
        genesis_standard_loop();
    }
}

/**
 * Archive Query
 *
 * Sets all archives to 27 per page
 * @since 1.0.0
 * @link http://www.billerickson.net/customize-the-wordpress-query/
 *
 * @param object $query
 */
 
function be_archive_query( $query ) {
    if( $query->is_main_query() && $query->is_home() ){
        $mainppp = 7;
        if(!($query->is_paged())){
            $query->set( 'posts_per_page', $mainppp );
        } else {
            $ppp = $query->query_vars['posts_per_page']!=''?$query->query_vars['posts_per_page']:get_option( 'posts_per_page' );
            $offset = (($query->query_vars['paged']-1)*$ppp)-($ppp-$mainppp);
            $query->set( 'offset', $offset);
        }
    }
}

add_action ( 'genesis_before_entry', 'msdlab_add_pagination');
function msdlab_add_pagination() {
    if ( is_single() && is_cpt('post') ) {
        add_action( 'genesis_entry_footer', 'msdlab_post_navigation_links' );
    }
}

function msdlab_post_navigation_links() {
    previous_post_link('<div class="prev-link alignleft page-nav"><i class="fa fa-arrow-left"></i> %link</div>', 'Previous'); 
    next_post_link('<div class="next-link alignright page-nav">%link <i class="fa fa-arrow-right"></i></div>', 'Next');
}

// Customize Grid Loop Content
function msdlab_switch_content() {
    remove_action('genesis_entry_content', 'genesis_grid_loop_content');
    remove_action( 'genesis_entry_header', 'msdlab_do_post_subtitle', 13);
    add_action('genesis_entry_content', 'msdlab_grid_loop_content');
    add_action('genesis_after_entry', 'msdlab_grid_divider');
    add_action('genesis_entry_header', 'msdlab_grid_loop_image', 4);
}

function msdlab_grid_loop_content() {

    global $_genesis_loop_args;
    if ( in_array( 'genesis-feature', get_post_class() ) ) {
        if ( $_genesis_loop_args['feature_image_size'] ) {
           printf( '<a href="%s" title="%s" class="featured_image_wrapper">%s</a>', get_permalink(), the_title_attribute('echo=0'), genesis_get_image( array( 'size' => $_genesis_loop_args['feature_image_size'], 'attr' => array( 'class' => esc_attr( $_genesis_loop_args['feature_image_class'] ) ) ) ) );
        }
        the_excerpt();  
        printf( '<a href="%s" title="%s" class="readmore-button alignright">%s</a>', get_permalink(), the_title_attribute('echo=0'), 'Continue Reading >' );
           
    }
    else {
        return false;
    }

}

function msdlab_grid_loop_image() {
    global $_genesis_loop_args;
    if ( in_array( 'genesis-grid', get_post_class() ) ) {
        global $post;
        $img = genesis_get_image( array( 'size' => $_genesis_loop_args['grid_image_size'], 'attr' => array( 'class' => esc_attr( $_genesis_loop_args['grid_image_class'] ) ) ) );
        //ts_data($img);
        //echo '<p class="thumbnail"><a href="'.get_permalink().'">'.$img.'</a></p>';
    }
}

function msd_add_loop_counter_to_html5_loop(){
    global $loop_counter;
    $loop_counter++;
}

function msdlab_grid_divider() {
    global $loop_counter, $paged;
    if($loop_counter == 1 && $paged == 0){print '<div class="section-header"><h3 class="recent-posts-header">Recent Posts</h3></div>';}
    /*if(is_paged()){
        if ((($loop_counter) % 2 == 0) && !($paged == 0 && $loop_counter < 2)) echo '<hr class="grid-separator" />';
    } else {
        if ((($loop_counter + 1) % 2 == 0) && !($paged == 0 && $loop_counter < 2)) echo '<hr class="grid-separator" />';
    }*/
    
}
 function msdlab_grid_add_bootstrap($classes){
     if(in_array('genesis-grid',$classes)){
         $classes[] = 'col-md-6';
     }
     return $classes;
 }
function msdlab_get_comments_number(){ //not used
    $num_comments = get_comments_number();
    if ($num_comments == '1') $comments = $num_comments.' ' . __( 'comment', 'adaptation' );
    else $comments = $num_comments.' ' . __( 'comments', 'adaptation' );
    return '<a class="comments" href="'.get_permalink().'/#comments">'.$comments.'</a>';
}

/*** Blog Header ***/
function msd_add_blog_header(){
    global $post;
    if(get_post_type() == 'post' || get_section()=='blog'){
        $header = '
        <div id="blog-header" class="blog-header">
            <h3><a href="'.get_permalink( get_option( 'page_for_posts' ) ).'">Infinitive Difference Blog</a></h3>
            <p>Get in the know and keep current with big-picture thinking and actionable insights.</p>
        </div>';
    }
    print $header;
}