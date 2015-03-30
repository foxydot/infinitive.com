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


remove_shortcode('msd-social');
add_shortcode('msd-social','social_media');
function social_media($atts = array()){
    extract( shortcode_atts( array(
            ), $atts ) );
    $ret = '<div id="social-media" class="social-media">';   
    if(get_option('msdsocial_contact_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_contact_link').'" class="contact" title="Contact Us" target="_blank">CONTACT</a>';
    }    
    if(get_option('msdsocial_facebook_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_facebook_link').'" class="fa fa-facebook" title="Join Us on Facebook!" target="_blank"></a>';
    }    
    if(get_option('msdsocial_twitter_user')!=""){
        $ret .= '<a href="http://www.twitter.com/'.get_option('msdsocial_twitter_user').'" class="fa fa-twitter" title="Follow Us on Twitter!" target="_blank"></a>';
    }    
    if(get_option('msdsocial_pinterest_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_pinterest_link').'" class="fa fa-pinterest" title="Pinterest" target="_blank"></a>';
    }    
    if(get_option('msdsocial_google_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_google_link').'" class="fa fa-google-plus" title="Google+" target="_blank"></a>';
    }    
    if(get_option('msdsocial_linkedin_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_linkedin_link').'" class="fa fa-linkedin" title="LinkedIn" target="_blank"></a>';
    }    
    if(get_option('msdsocial_instagram_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_instagram_link').'" class="fa fa-instagram" title="Instagram" target="_blank"></a>';
    }    
    if(get_option('msdsocial_tumblr_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_tumblr_link').'" class="fa fa-tumblr" title="Tumblr" target="_blank"></a>';
    }    
    if(get_option('msdsocial_reddit_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_reddit_link').'" class="fa fa-reddit" title="Reddit" target="_blank"></a>';
    }    
    if(get_option('msdsocial_flickr_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_flickr_link').'" class="fa fa-flickr" title="Flickr" target="_blank"></a>';
    }    
    if(get_option('msdsocial_youtube_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_youtube_link').'" class="fa fa-youtube" title="YouTube" target="_blank"></a>';
    }    
    if(get_option('msdsocial_vimeo_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_vimeo_link').'" class="fa fa-vimeo-square" title="Vimeo" target="_blank"></a>';
    }    
    if(get_option('msdsocial_vine_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_vine_link').'" class="fa fa-vine" title="Vine" target="_blank"></a>';
    }    
    if(get_option('msdsocial_sharethis_link')!=""){
        $ret .= '<a href="'.get_option('msdsocial_sharethis_link').'" class="fa fa-share-alt" title="ShareThis" target="_blank"></a>';
    } 
    if(get_option('msdsocial_show_feed')!=""){
        $ret .= '<a href="'.get_bloginfo('rss2_url').'" class="fa fa-rss" title="RSS Feed" target="_blank"></a>';
    }
    $ret .= '</div>';
    return $ret;
}