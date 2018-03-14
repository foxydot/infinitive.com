<?php
add_shortcode('button','msdlab_button_function');
function msdlab_button_function($atts, $content = null){	
	extract( shortcode_atts( array(
      'url' => null,
	  'target' => '_self'
      ), $atts ) );
      if(strstr($url,'mailto:',0)){
          $parts = explode(':',$url);
          if(is_email($parts[1])){
              $url = $parts[0].':'.antispambot($parts[1]);
          }
      }
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
add_shortcode('calloutbox','msdlab_calloutbox');
function msdlab_calloutbox($atts, $content = null){
    extract( shortcode_atts( array(
    'title' => false,
    ), $atts ) );
    $title = $title?'<h3>'.$title.'</h3>':'';
    $ret = '<div class="calloutbox">'.$title.remove_wpautop($content).'</div>';
    return $ret;
}

add_shortcode('mailto','msdlab_mailto_function');
function msdlab_mailto_function($atts, $content){
    extract( shortcode_atts( array(
    'email' => '',
    ), $atts ) );
    $content = trim($content);
    if($email == '' && preg_match('|[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}|i', $content, $matches)){
        $email = $matches[0];
    }
    $email = antispambot($email);
    return '<a href="mailto:'.$email.'">'.$content.'</a>';
}

add_shortcode('sitemap','msdlab_sitemap');

add_shortcode('sitename','msdlab_sitename');

function msdlab_sitename(){
    return get_option('blogname');
}

add_shortcode('fa','msdlab_fontawesome_shortcodes');
function msdlab_fontawesome_shortcodes($atts){
    $classes[] = 'msd-fa fa';
    foreach($atts AS $att){
        switch($att){
            case "circle":
            case "square":
            case "block":
                $classes[] = $att;
                break;
            default:
                $classes[] = 'fa-'.$att;
                break;
        }
    }
    return '<i class="'.implode(" ",$classes).'"></i>';
}
add_shortcode('icon','msdlab_icon_shortcodes');
function msdlab_icon_shortcodes($atts){
    $classes[] = 'msd-icon icon';
    foreach($atts AS $att){
        switch($att){
            case "circle":
            case "square":
            case "block":
                $classes[] = $att;
                break;
            default:
                $classes[] = 'icon-'.$att;
                break;
        }
    }
    return '<i class="'.implode(" ",$classes).'"></i>';
}

add_shortcode('doodle','msdlab_doodle_shortcodes');
function msdlab_doodle_shortcodes($atts){
    extract( shortcode_atts( array(
    'class' => '',
    'url' => false,
    'title' => false,
    ), $atts ) );
    $classes = explode(' ',$class);
    if(is_array($classes)){
        foreach($classes AS $k=>$v){
            $classes[$k] = 'doodle-'.$v;
        }
    } else {
        $classes[] = 'doodle-'.$class;
    }
    $classes[] = 'msd-doodle doodle';
    $doodle = '<i class="'.implode(" ",$classes).'"></i>';
    if($title){
        $title = '<div class="msd-doodle-title">'.$title.'</div>';
    }
    if($url){
       return '<div class="msd-doodle-wrapper"><a href="'.$url.'" class="msd-doodle-link">'.$doodle.$title.'</a></div>';
    } else {
       return '<div class="msd-doodle-wrapper">'.$doodle.$title.'</div>';
    }
}

//remove_shortcode('msd-social');
//add_shortcode('msd-social','social_media');
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

add_shortcode('career-features','msdlab_career_features_handler');
function msdlab_career_features_handler(){
    return '<img class="aligncenter" src="'.WP_CONTENT_URL.'/uploads/2011/09/ARROWS.png" />';
}

//Bootstrap columns//
add_shortcode('row','bs_row');
add_shortcode('column','bs_column');

  /*--------------------------------------------------------------------------------------
    *
    * bs_row
    *
    * @author Filip Stefansson
    * @since 1.0
    *
    *-------------------------------------------------------------------------------------*/
  function bs_row( $atts, $content = null ) {

    $atts = shortcode_atts( array(
      "xclass" => false,
      "data"   => false
    ), $atts );

    $class  = 'row';      
    $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';
      
    $data_props = parse_data_attributes( $atts['data'] );
      
    return sprintf( 
      '<div class="%s"%s>%s</div>',
      esc_attr( $class ),
      ( $data_props ) ? ' ' . $data_props : '',
      do_shortcode( $content )
    );
  }

  /*--------------------------------------------------------------------------------------
    *
    * bs_column
    *
    * @author Simon Yeldon
    * @since 1.0
    * @todo pull and offset
    *-------------------------------------------------------------------------------------*/
  function bs_column( $atts, $content = null ) {

    $atts = shortcode_atts( array(
      "lg"          => false,
      "md"          => false,
      "sm"          => false,
      "xs"          => false,
      "offset_lg"   => false,
      "offset_md"   => false,
      "offset_sm"   => false,
      "offset_xs"   => false,
      "pull_lg"     => false,
      "pull_md"     => false,
      "pull_sm"     => false,
      "pull_xs"     => false,
      "push_lg"     => false,
      "push_md"     => false,
      "push_sm"     => false,
      "push_xs"     => false,
      "xclass"      => false,
      "data"        => false
    ), $atts );

    $class  = '';
    $class .= ( $atts['lg'] )                                           ? ' col-lg-' . $atts['lg'] : '';
    $class .= ( $atts['md'] )                                           ? ' col-md-' . $atts['md'] : '';
    $class .= ( $atts['sm'] )                                           ? ' col-sm-' . $atts['sm'] : '';
    $class .= ( $atts['xs'] )                                           ? ' col-xs-' . $atts['xs'] : '';
    $class .= ( $atts['offset_lg'] || $atts['offset_lg'] === "0" )      ? ' col-lg-offset-' . $atts['offset_lg'] : '';
    $class .= ( $atts['offset_md'] || $atts['offset_md'] === "0" )      ? ' col-md-offset-' . $atts['offset_md'] : '';
    $class .= ( $atts['offset_sm'] || $atts['offset_sm'] === "0" )      ? ' col-sm-offset-' . $atts['offset_sm'] : '';
    $class .= ( $atts['offset_xs'] || $atts['offset_xs'] === "0" )      ? ' col-xs-offset-' . $atts['offset_xs'] : '';
    $class .= ( $atts['pull_lg']   || $atts['pull_lg'] === "0" )        ? ' col-lg-pull-' . $atts['pull_lg'] : '';
    $class .= ( $atts['pull_md']   || $atts['pull_md'] === "0" )        ? ' col-md-pull-' . $atts['pull_md'] : '';
    $class .= ( $atts['pull_sm']   || $atts['pull_sm'] === "0" )        ? ' col-sm-pull-' . $atts['pull_sm'] : '';
    $class .= ( $atts['pull_xs']   || $atts['pull_xs'] === "0" )        ? ' col-xs-pull-' . $atts['pull_xs'] : '';
    $class .= ( $atts['push_lg']   || $atts['push_lg'] === "0" )        ? ' col-lg-push-' . $atts['push_lg'] : '';
    $class .= ( $atts['push_md']   || $atts['push_md'] === "0" )        ? ' col-md-push-' . $atts['push_md'] : '';
    $class .= ( $atts['push_sm']   || $atts['push_sm'] === "0" )        ? ' col-sm-push-' . $atts['push_sm'] : '';
    $class .= ( $atts['push_xs']   || $atts['push_xs'] === "0" )        ? ' col-xs-push-' . $atts['push_xs'] : '';
    $class .= ( $atts['xclass'] )                                       ? ' ' . $atts['xclass'] : '';
      
    $data_props = parse_data_attributes( $atts['data'] );
      
    return sprintf( 
      '<div class="%s"%s>%s</div>',
      esc_attr( $class ),
      ( $data_props ) ? ' ' . $data_props : '',
      do_shortcode( $content )
    );
  }

    /*--------------------------------------------------------------------------------------
    *
    * Parse data-attributes for shortcodes
    *
    *-------------------------------------------------------------------------------------*/
  function parse_data_attributes( $data ) {

    $data_props = '';

    if( $data ) {
      $data = explode( '|', $data );

      foreach( $data as $d ) {
        $d = explode( ',', $d );
        $data_props .= sprintf( 'data-%s="%s" ', esc_html( $d[0] ), esc_attr( trim( $d[1] ) ) );
      }
    }
    else { 
      $data_props = false;
    }
    return $data_props;
  }
   
   
function column_shortcode($atts, $content = null){
    extract( shortcode_atts( array(
    'cols' => '3',
    'position' => '',
    'class' => ''
    ), $atts ) );
    switch($cols){
        case 5:
            $classes[] = 'one-fifth';
            break;
        case 4:
            $classes[] = 'one-fouth';
            $classes[] = 'col-md-3';
            $classes[] = 'col-xs-12';
            break;
        case 3:
            $classes[] = 'one-third';
            $classes[] = 'col-md-4';
            $classes[] = 'col-xs-12';
            break;
        case 2:
            $classes[] = 'one-half';
            $classes[] = 'col-md-6';
            $classes[] = 'col-xs-12';
            break;
        case 1:
            $classes[] = 'col-md-12';
            $classes[] = 'col-xs-12';
            break;
    }
    switch($position){
        case 'first':
        case '1':
            $classes[] = 'first';
        case 'last':
            $classes[] = 'last';
    }
    $classes[] = $class;
    return '<div class="'.implode(' ',$classes).'">'.$content.'</div>';
}

add_shortcode('columns','column_shortcode');

function row_shortcode($atts, $content = null){
    extract(shortcode_atts( array(
        'bkg' => 'white',
        'align' => 'left',
        'border' => 'orange',
    ), $atts ));
    $style = '';
    if($align == 'center'){$style = ' style="margin-left: auto;margin-right: auto;"';}
    return '<div class="row"'.$style.'>'.do_shortcode($content).'</div>';
}

add_shortcode('row','row_shortcode'); 

add_shortcode('phone-video-display', 'msdlab_phone_wrapped_video');
function msdlab_phone_wrapped_video($atts){
    extract( shortcode_atts( array(
      'video_url' => false,
      'height' => false,
      'width' => 560
      ), $atts ) );
      if(!$video_url){
          return false;
      }
      $video = wp_oembed_get($video_url,array('width'=>$width));
      return '<div class="iphone-wrapper">'.$video.'</div>';
}

add_shortcode('box','msdlab_box_shortcode_output');

function msdlab_box_shortcode_output($atts, $content){
    extract(shortcode_atts( array(
        'bkg' => 'white',
        'align' => 'left',
        'border' => 'orange',
    ), $atts ));
    $content = do_shortcode($content);
    $content = trim_whitespace($content);
    return '<div class="box align-'.$align.' bkg-'.$bkg.' border-'.$border.'">'.$content.'</div>';
}