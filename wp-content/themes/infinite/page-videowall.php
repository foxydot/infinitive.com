<?php
/*
Template Name: Video Wall Page
*/

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage infinite
 * @since infinite 3.1
 */
global $slug;
global $content_width;
$content_width = 320;
function add_video_wrapper($atts){
	extract( shortcode_atts( array(
	'title' => '&nbsp;',
	'url' => '',
	'site' => '',
	), $atts ) );
	return '<div class="video '.strtolower($site).'"><h5>'.$title.'</h5>'.wp_oembed_get($url).'</div>';
}
add_shortcode('video','add_video_wrapper');
remove_filter( 'the_content', 'wpautop' );
wp_enqueue_style('videowall-css',get_stylesheet_directory_uri().'/css/videowall.css');
get_header(); ?>
<?php get_sidebar('breadcrumbs'); ?>
<div id="page-content-wrapper" class="page-content-wrapper">
<?php get_sidebar('nav'); ?>
<?php
/* Run the loop to output the page.
 * If you want to overload this in a child theme then include a file
 * called loop-page.php and that will be used instead.
 */
get_template_part( 'loop', 'wide' );
?>
<div class="clear"></div>
</div>

<?php get_footer(); ?>

$content_width = 470;