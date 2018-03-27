<?php
//support for landing page template
if(!class_exists('WPAlchemy_MetaBox')){
    include_once WP_CONTENT_DIR.'/wpalchemy/MetaBox.php';
}
global $wpalchemy_media_access;
if(!class_exists('WPAlchemy_MediaAccess')){
    include_once (WP_CONTENT_DIR.'/wpalchemy/MediaAccess.php');
}
class MSDLandingPage{
    /**
         * A reference to an instance of this class.
         */
        private static $instance;


        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                        self::$instance = new MSDLandingPage();
                } 

                return self::$instance;

        } 
        
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
   function __construct() {

        }
        
    function add_metaboxes(){
        global $post,$landing_page_metabox,$wpalchemy_media_access;
        $landing_page_metabox = new WPAlchemy_MetaBox(array
        (
            'id' => '_landing_page',
            'title' => 'Landing Page Feature Blocks',
            'types' => array('page'),
            'context' => 'normal', // same as above, defaults to "normal"
            'priority' => 'high', // same as above, defaults to "high"
            'template' => get_stylesheet_directory() . '/lib/template/metabox-landing-page.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_msdlab_', // defaults to NULL
        ));
    }

    function feature_box_shortcode_callback($atts,$content){
        $feature = (shortcode_atts( array(
            'resource-type' => '',
            'resource-title' => '',
            'link' => '',
            'resource-image' => '',
            'css-classes' => '',
            'count' => '1'
        ), $atts ));
        $image = $feature['resource-image'];
        if(substr($image,0,4)!='http'){
            $feature['resource-image'] = get_site_url() . $image;
        }
        return self::default_output($feature,$feature['count']);
    }
    
    function default_output($feature,$i){
        if($feature['resource-title']=='' || $feature['link']==''){
            return FALSE;
        }
        global $parallax_ids;
        $eo = ($i+1)%2==0?'even':'odd';
        $title = apply_filters('the_title',$feature['resource-title']);
        $slug = sanitize_title_with_dashes(str_replace('/', '-', $title));
        
        $wrapped_title = trim($title) != ''?apply_filters('msdlab_landing_page_output_title','<div class="feature-title">
            <h3 class="wrap">
                '.$title.'
            </h3>
        </div>'):'';
        $link = $feature['link'];
        $type = $feature['resource-type'];
        $attachment_id = get_attachment_id_from_src($feature['resource-image']);
        $featured_image = $attachment_id != ''?self::get_image_html($attachment_id):'';
        $classes = apply_filters('msdlab_landing_page_output_classes',array(
            'feature',
            'feature-'.$slug,
            $feature['css-classes'],
            'feature-'.$eo,
            'clearfix',
        ));
        //think about filtering the classes here
        $ret = '
        <a id="'.$slug.'" class="'.implode(' ', $classes).'" href="'.$link.'">
            <div class="wrapper">
            <div class="feature-img">
                '.$featured_image.'
            </div>
            <div class="feature-type">
                '.$type.'
            </div>
                '.$wrapped_title.'
            </div>
        </a>
        ';
        return $ret;
    }

    function landing_page_output(){
        global $post,$subtitle_metabox,$landing_page_metabox,$nav_ids;
        $i = 0;
        $meta = $landing_page_metabox->the_meta();
        if(is_object($landing_page_metabox)){
        while($landing_page_metabox->have_fields('features')){
            $layout = $landing_page_metabox->get_the_value('layout');
            $features[] = self::default_output($meta['features'][$i],$i);
            $i++;
        }//close while
        print '<div class="landing-page-wrapper">';
        print implode("\n",$features);
        print '</div>';
        }//clsoe if
    }

        function info_footer_hook()
        {
            global $post;
            $postid = is_admin()?$_GET['post']:$post->ID;
            $template_file = get_post_meta($postid,'_wp_page_template',TRUE);
            if($template_file == 'page-landing.php'){
            ?><script type="text/javascript">
                
                </script><?php
            }
        }
        
        function enqueue_admin(){
            $postid = $_GET['post'];
            $template_file = get_post_meta($postid,'_wp_page_template',TRUE);
            if($template_file == 'page-landing.php'){
                //js
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('landing-admin',WP_PLUGIN_URL.'/msd-specialty-pages/lib/js/landing-input.js',array('jquery'));
                //css
                wp_enqueue_style('landing-admin',WP_PLUGIN_URL.'/msd-specialty-pages/lib/css/landing.css');
            }
        }

    /**
     * Render the image html output.
     *
     * @param array $instance
     * @param bool $include_link will only render the link if this is set to true. Otherwise link is ignored.
     * @return string image html
     */
    private function get_image_html( $attachment_id ) {

        $output = '';

        $instance = array();
        $instance['attachment_id'] = $attachment_id;
        $alt = get_post_meta($attachment_id,'_wp_attachment_image_alt');
        $instance['alt'] = $alt[0];
        $instance['title'] = get_the_title($attachment_id);

        $size = array(303,237);
        if ( is_array( $size ) ) {
            $instance['width'] = $size[0];
            $instance['height'] = $size[1];
        }
        $instance['width'] = abs( $instance['width'] );
        $instance['height'] = abs( $instance['height'] );

        $attr = array();
        $attr['alt'] = ( !empty( $instance['alt'] ) ) ? $instance['alt'] : $instance['title'];
        if (is_array($size)) {
            $attr['class'] = 'attachment-'.join('x',$size);
        } else {
            $attr['class'] = 'attachment-'.$size;
        }
        $attr['style'] = '';

        $attr = apply_filters( 'landing_page_feature_image_attributes', $attr, $instance );

        if( abs( $instance['attachment_id'] ) > 0 ) {
            $output .= wp_get_attachment_image($instance['attachment_id'], $size, false, $attr);
        }

        return $output;
    }
}
add_action( 'init', array( 'MSDLandingPage', 'add_metaboxes' ) );
