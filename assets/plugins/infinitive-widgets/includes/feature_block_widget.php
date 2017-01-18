<?php
class Feature_Block_Widget extends WP_Widget {
    const VERSION = '0.1.0';

    function __construct() {
        $widget_ops = array('classname' => 'widget_feature_block', 'description' => __('Create a feature block'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('feature-block-widget', __('Feature Block','feature_block'), $widget_ops, $control_ops);
        add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );
        add_action( 'admin_head-widgets.php', array( $this, 'admin_head' ) );
    }
    
    /**
     * Enqueue all the javascript.
     */
    public function admin_setup() {
        wp_enqueue_media();
        wp_enqueue_script( 'tribe-image-widget', plugins_url('js/image-widget.js', __FILE__), array( 'jquery', 'media-upload', 'media-views' ), self::VERSION );

        wp_localize_script( 'feature-block-widget', 'Feature_Block_Widget', array(
            'frame_title' => __( 'Select an Image', 'feature_block' ),
            'button_title' => __( 'Insert Into Widget', 'feature_block' ),
        ) );
    }
     /**
     * Admin header css
     *
     * @author Modern Tribe, Inc.
     */
    public function admin_head() {
        ?>
    <style type="text/css">
        .uploader input.button {
            width: 100%;
            height: 34px;
            line-height: 33px;
            margin-top: 15px;
        }
        .tribe_preview .aligncenter {
            display: block;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        .tribe_preview {
            overflow: hidden;
            max-height: 300px;
        }
        .tribe_preview img {
            margin: 10px 0;
            height: auto;
        }
    </style>
    <?php
    }
    
    
    /**
     * Render the image html output.
     *
     * @param array $instance
     * @param bool $include_link will only render the link if this is set to true. Otherwise link is ignored.
     * @return string image html
     */
    private function get_image_html( $instance, $include_link = 0 ) {

        $output = '';

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
        
        $attr = apply_filters( 'image_widget_image_attributes', $attr, $instance );

        if( abs( $instance['attachment_id'] ) > 0 ) {
            $output .= wp_get_attachment_image($instance['attachment_id'], $size, false, $attr);
        }
        
        return $output;
    }


    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters('widget_title',$instance['title']);
        $slug = sanitize_title_with_dashes(str_replace('/', '-', $title));
        $wrapped_title = trim($title) != ''?apply_filters('msdlab_landing_page_output_title','<div class="feature-title widget-title">
            <h3 class="wrap">
                '.$title.'
            </h3>
        </div>'):'';
        $link = $instance['link'];
        $link_text = trim($instance['link_text']);
        $readmore = $link_text != ''?'<div class="readmore">'.$link_text.'</div>':'';
        $type = $instance['resource_type'];
        $image = $instance['attachment_id'] !=''?$this->get_image_html($instance):'';
        $classes = apply_filters('msdlab_landing_page_output_classes',array(
            'feature',
            'feature-'.$slug,
            $instance['css-classes'],
            'feature-'.$eo,
            'clearfix',
        ));
        //think about filtering the classes here
        $ret = $before_widget.
        '<div class="feature-block-widget">
        <a id="'.$slug.'" class="'.implode(' ', $classes).'" href="'.$link.'">
            <div class="wrapper">
                    '.$wrapped_title.'
                <div class="feature-type">
                    '.$type.'
                </div>
                <div class="feature-img">
                    '.$image.'
                </div>
                    '.$readmore.'
            </div>
        </a>
        </div>
        '.$after_widget;
        print $ret;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        error_log(print_r($instance,1));
        $instance['title'] = strip_tags($new_instance['title']);        
        $instance['resource_type'] = strip_tags($new_instance['resource_type']);        
        $instance['attachment_id'] = abs( $new_instance['attachment_id'] );
        $instance['link'] = strip_tags($new_instance['link']);     
        $instance['link_text'] = strip_tags($new_instance['link_text']);    
        $instance['inline_css'] = strip_tags($new_instance['inline_css']);    
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = strip_tags($instance['title']);
        $resource_type = strip_tags($instance['resource_type']);
        $feature_image = $instance['feature_image'];
        $link = strip_tags($instance['link']);
        $link_text = strip_tags($instance['link_text']);
        $inline_css = $instance['inline_css'];
        $id_prefix = $this->get_field_id('');
?>        
    <div class="cell">
        <label for="<?php echo $this->get_field_id('resource_type'); ?>"><?php _e('Resource Type:'); ?></label>            
        <div class="input_container">
            <select id="<?php echo $this->get_field_id('resource_type'); ?>" name="<?php echo $this->get_field_name('resource_type'); ?>" class="resource-type">
                <option value="CASE STUDY"<?php selected( $resource_type, 'CASE STUDY' ); ?>>Case Study</option>
                <option value="CHECK LIST"<?php selected( $resource_type, 'CHECK LIST' ); ?>>Check List</option>
                <option value="eBOOK"<?php selected( $resource_type, 'eBOOK' ); ?>>eBook</option>
                <option value="FACT SHEET"<?php selected( $resource_type, 'FACT SHEET' ); ?>>Fact Sheet</option>
                <option value="INFOGRAPHIC"<?php selected( $resource_type, 'INFOGRAPHIC' ); ?>>Infographic</option>
                <option value="NEWS"<?php selected( $resource_type, 'NEWS' ); ?>>News</option>
                <option value="VIDEO"<?php selected( $resource_type, 'VIDEO' ); ?>>Video</option>
            </select>
        </div>
    </div>
    <div class="cell">
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>            
        <div class="input_container">
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" maxlength="90" />
        </div>
    </div>
    <div class="uploader">
        <input type="submit" class="button" name="<?php echo $this->get_field_name('uploader_button'); ?>" id="<?php echo $this->get_field_id('uploader_button'); ?>" value="<?php _e('Select an Image', 'feature_block'); ?>" onclick="imageWidget.uploader( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' ); return false;" />
        <div class="tribe_preview" id="<?php echo $this->get_field_id('preview'); ?>">
            <?php echo $this->get_image_html($instance, false); ?>
        </div>
        <input type="hidden" id="<?php echo $this->get_field_id('attachment_id'); ?>" name="<?php echo $this->get_field_name('attachment_id'); ?>" value="<?php echo abs($instance['attachment_id']); ?>" />
        <input type="hidden" id="<?php echo $this->get_field_id('imageurl'); ?>" name="<?php echo $this->get_field_name('imageurl'); ?>" value="<?php echo $instance['imageurl']; ?>" />
    </div>
    <div class="cell">
        <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:'); ?></label>            
        <div class="input_container">
            <input placeholder="http://" class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
        </div>
    </div>  
    <div class="cell">
        <label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link Text:'); ?></label>            
        <div class="input_container">
            <input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo esc_attr($link_text); ?>" />
        </div>
    </div>   
    <div class="cell">
        <label for="<?php echo $this->get_field_id('inline_css'); ?>"><?php _e('Inline CSS:'); ?></label>            
        <div class="input_container">
            <input class="widefat" id="<?php echo $this->get_field_id('inline_css'); ?>" name="<?php echo $this->get_field_name('inline_css'); ?>" type="text" value="<?php echo esc_attr($inline_css); ?>" />
        </div>
    </div>  
<?php
    }
    
    function init() {
        if ( !is_blog_installed() )
            return;
        register_widget('Feature_Block_Widget');
    }
}   
add_action('widgets_init',array('Feature_Block_Widget','init'),15);