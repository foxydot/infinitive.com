<?php
add_shortcode('button','msdlab_button_function');
function msdlab_button_function($atts, $content = null){	
	extract( shortcode_atts( array(
      'url' => null,
	  'target' => '_self'
      ), $atts ) );
	$ret = '<div class="button-wrapper">
<a class="button" href="'.$url.'" target="'.$target.'">'.remove_wpautop($content).'</a>
</div>';
	return $ret;
}
add_shortcode('hero','msdlab_landing_page_hero');
function msdlab_landing_page_hero($atts, $content = null){
	$ret = '<div class="hero">'.remove_wpautop($content).'</div>';
	return $ret;
}
add_shortcode('callout','msdlab_landing_page_callout');
function msdlab_landing_page_callout($atts, $content = null){
	$ret = '<div class="callout">'.remove_wpautop($content).'</div>';
	return $ret;
}
function column_shortcode($atts, $content = null){
	extract( shortcode_atts( array(
	'cols' => '3',
	'position' => '',
	), $atts ) );
	switch($cols){
		case 5:
			$classes[] = 'one-fifth';
			break;
		case 4:
			$classes[] = 'one-fouth';
			break;
		case 3:
			$classes[] = 'one-third';
			break;
		case 2:
			$classes[] = 'one-half';
			break;
	}
	switch($position){
		case 'first':
		case '1':
			$classes[] = 'first';
		case 'last':
			$classes[] = 'last';
	}
	return '<div class="'.implode(' ',$classes).'">'.$content.'</div>';
}

add_shortcode('columns','column_shortcode');

/**
 * 404 Sitemap
 * @author Bill Erickson 
 */
function be_sitemap() {
    ?>
            <div class="archive-page col-sm-6">

                <h4><?php _e( 'Pages:', 'genesis' ); ?></h4>
                <ul>
                    <?php wp_list_pages( 'title_li=' ); ?>
                </ul>

                <h4><?php _e( 'Categories:', 'genesis' ); ?></h4>
                <ul>
                    <?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
                </ul>

            </div><!-- end .archive-page-->

            <div class="archive-page col-sm-6">

                <h4><?php _e( 'Authors:', 'genesis' ); ?></h4>
                <ul>
                    <?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
                </ul>

                <h4><?php _e( 'Monthly:', 'genesis' ); ?></h4>
                <ul>
                    <?php wp_get_archives( 'type=monthly' ); ?>
                </ul>

                <h4><?php _e( 'Recent Posts:', 'genesis' ); ?></h4>
                <ul>
                    <?php wp_get_archives( 'type=postbypost&limit=10' ); ?>
                </ul>

            </div><!-- end .archive-page-->

    <?php
}
add_shortcode('sitemap','be_sitemap');
