<?php 
class Infinitive_Solutions_Walker extends Walker_Nav_Menu
{

	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= '<div class="image"></div>';
		$item_output .= '<div class="text">';		
		$item_output .= $item->description?"\n<div class=\"description\">" . $item->description . "</div>\n":'';
		$item_output .= '<div class="link_title">'.$args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after.' ></div>';
		$item_output .= '</div>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el(&$output, $item, $depth) {
		$output .= "</li>\n";
	}
}
?>
<div class="value_statement">
    The consultancy for the new digital world, Infinitive helps our clients build and improve their capabilities in customer intelligence, digital ad solutions and enterprise risk management.
</div>
<div class="featured-header-area">
	<?php dynamic_sidebar( 'main-feature-area' ); ?>
</div>
<div id="container" class="content">
	<div id="content" role="main">
		<?php //Wide Widgets ?>
		<div id="wide" class="widget-area">				
			<?php $walker = new Infinitive_Solutions_Walker; ?>
			<?php wp_nav_menu( array( 'menu' => 'Homepage Section Menu','container' => '','walker' => $walker ) ); ?>
			<?php /* ?>
			<ul>
				<?php print infinitive_highlights(1,array(1), array('post_type' => 'page', 'tax_query' => array(array('taxonomy' => 'msd_special', 'field' => 'slug', 'terms' => 'main')), 'number_posts' => 1)); ?>			
				<?php print infinitive_highlights(1,array(4), array('post_type' => 'page', 'tax_query' => array(array('taxonomy' => 'msd_special', 'field' => 'slug', 'terms' => 'main')), 'number_posts' => 1)); ?>			
				<?php print infinitive_highlights(1,array(3), array('post_type' => 'page', 'tax_query' => array(array('taxonomy' => 'msd_special', 'field' => 'slug', 'terms' => 'main')), 'number_posts' => 1)); ?>			
				<?php print infinitive_highlights(1,array(2), array('post_type' => 'page', 'tax_query' => array(array('taxonomy' => 'msd_special', 'field' => 'slug', 'terms' => 'main')), 'number_posts' => 1)); ?>			
			</ul>
			<ul>
				<li class="solutions-link infinitive">Infinitive <a href="<?php print get_site_url(1); ?>/infinitive-solutions">Learn More ></a></li>
				<li class="solutions-link analytics">Infinitive Analytics <a href="<?php print get_site_url(4); ?>">Learn More ></a></li>
				<li class="solutions-link insight">Infinitive Insight <a href="<?php print get_site_url(3); ?>">Learn More ></a></li>
				<li class="solutions-link federal">Infinitive Federal <a href="<?php print get_site_url(2); ?>">Learn More ></a></li>
			</ul>
			<?php */ ?>
		<div class="clear"></div>
		</div><!-- #fourth .widget-area -->		
		<div class="clear"></div>
		<?php //three footer widgets ?>
		<?php if ( is_active_sidebar( 'main-footer-widget-area' ) ) : ?>
				<div id="footer" class="widget-area">
					<ul>
						<?php dynamic_sidebar( 'main-footer-widget-area' ); ?>
					</ul>
		<div class="clear"></div>
				</div><!-- #fourth .widget-area -->
<?php endif; ?>
		<div class="clear"></div>
	</div>
</div>