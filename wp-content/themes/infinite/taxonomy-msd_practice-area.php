<?php
//what about grabbing the posts via a stack of rss feeds, then sorting the result? simply replace main loop with this?

global $wp_query;
$my_vars = $wp_query->query_vars;
$orig_blog = get_current_blog_id();
$all_posts = array();
for($i=1;$i<5;$i++){
    switch_to_blog($i);
    $blog_posts = get_posts($my_vars);
    $all_posts = array_merge($all_posts,$blog_posts);
}
switch_to_blog($orig_blog);
 ?>
<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
<?php foreach($all_posts AS $post) : setup_postdata($post); ?>

<?php $subtitle->the_meta(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php msdlab_permalink($post->guid) ?>
            <h1 class="entry-title"><a href="<?php print msdlab_permalink($post->guid) ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'infinite' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <?php if($subtitle->get_the_value('subtitle')!=''): ?>
            <h2><?php $subtitle->the_value('subtitle'); ?></h2>
            <?php endif; ?>
            <div class="entry-content"><?php print msd_case_study_excerpt($post); ?><a href="<?php print msdlab_permalink($post->guid) ?>">Continue Reading &rarr;</a></div>
        </div><!-- #post-## -->


<?php endforeach; // End the loop. Whew. ?>
</div></div>
<div class="clear"></div>
</div>
<?php get_sidebar('blog'); ?>

<?php get_footer(); ?>
