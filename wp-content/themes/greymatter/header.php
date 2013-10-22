<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage infinite
 * @since infinite 3.1
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta HTTP-EQUIV="Content-type" CONTENT="text/html; charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'infinite' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/<?php print strtolower(get_bloginfo('name')); ?>.ico" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

		
<body <?php body_class(); ?>>
	<div id="body-wrapper" class="body-wrapper">
		<div id="header" class="header">
			<<?php print is_front_page()?'h1':'h2'; ?> class="logo">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				<div class="description"><?php bloginfo( 'description' ); ?></div>
			</<?php print is_front_page()?'h1':'h2'; ?>>
			<div id="header-nav"><?php dynamic_sidebar('header-right'); ?>
				<?php wp_nav_menu( array( 'container_class' => 'hdrNav', 'theme_location' => 'header' ) ); ?>
			</div>
			<div class="clear"></div>
		</div>
		<div id="primary-nav">
			<?php wp_nav_menu( array( 'container_class' => 'mainNav', 'theme_location' => 'primary' ) ); ?>
		</div>
		<div class="clear"></div>
		
		<div id="content-wrapper" class="content-wrapper">