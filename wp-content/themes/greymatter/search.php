<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage infinite
 * @since infinite 3.1
 */

get_header(); ?>
<?php get_sidebar('breadcrumbs'); ?>
<?php get_sidebar('logo'); ?>
<div id="page-content-wrapper" class="page-content-wrapper">
<?php get_sidebar('nav'); ?>
<div id="container" class="content">
<div id="content" role="main">
<?php if ( have_posts() ) : ?>
				<h1><?php printf( __( 'Search Results for: %s', 'infinite' ), '' . get_search_query() . '' ); ?></h1>
				<?php
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2><?php _e( 'Nothing Found', 'infinite' ); ?></h2>
					
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'infinite' ); ?></p>
						<?php get_search_form(); ?>
					
				</div><!-- #post-0 -->
<?php endif; ?>
</div></div>
<div class="clear"></div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
