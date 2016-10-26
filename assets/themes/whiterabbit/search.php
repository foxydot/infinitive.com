<?php
/**
 */

add_action( 'genesis_before_loop', 'genesis_do_search_title' );
/**
 * Echo the title with the search term.
 *
 * @since 1.9.0
 */
function genesis_do_search_title() {

	$title = sprintf( '<div class="archive-description"><h1 class="archive-title">%s %s</h1></div>', apply_filters( 'genesis_search_title_text', __( 'Search Results for:', 'genesis' ) ), get_search_query() );

	echo apply_filters( 'genesis_search_title_output', $title ) . "\n";

}


/* Modify post titles to add Relevanssi permalink */
// help from http://adamcap.com/code/filter-genesis-h1-post-titles-to-add-for-styling/
add_filter( 'genesis_post_title_output', 'child_post_title_output', 15 );
function child_post_title_output( $title ) {
    // change h2 to h1 depending if you have a search page title or not
    if ( function_exists( 'relevanssi_get_permalink' ) ) {
        $title = sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">%s</a></h2>', esc_url( relevanssi_get_permalink() ), apply_filters( 'genesis_post_title_text', get_the_title() ) );
    }
    return $title;
}
// Modify content to add Featured Images and Relevanssi permalink
remove_all_actions( 'genesis_entry_content' );
add_action( 'genesis_entry_content', 'child_do_post_excerpt' );
function child_do_post_excerpt() {

    // Get excerpt rather than the_content() so Relevanssi can grab a snippet and highlight search terms
    the_excerpt();
 
    // Get 'Read More' link with Relevanssi permalink
    if ( function_exists( 'relevanssi_get_permalink' ) ) {
        echo '<a class="read-more-link" href="' . esc_url( relevanssi_get_permalink() ) . '">View more »</a>';
    }
}
genesis();
