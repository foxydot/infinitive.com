<?php

class Inf_CTA_widget extends MSD_Widget_Text {

    function __construct() {
        add_action('wp_print_styles', array($this,'add_css'));
        add_action('wp_print_scripts', array($this,'add_js'));
        $widget_ops = array('classname' => 'widget_text', 'description' => __('Arbitrary text or HTML with optional URL'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('cta-widget', __('Call To Action'), $widget_ops, $control_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $text = apply_filters( 'widget_text', $instance['text'], $instance );
        $url = empty($instance['url']) ? FALSE : $instance['url'];
        $target = $instance['target'] ? ' target="_blank"':'';
        $linktext = apply_filters( 'widget_title', empty($instance['linktext']) ? 'Read More' : $instance['linktext'], $instance, $this->id_base);
        echo $before_widget; ?>
        <div class="textwidget">
            <?php if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
            echo $instance['filter'] ? wpautop($text) : $text; 
            if ( !empty( $url ) ) { echo '<div class="readmore"><span>'.$linktext.'</span></div>'; } ?>
        </div>
        <?php
        
        print $url?'<a href="'.$url.'"'.$target.' class="inf-widget-cta"></a>':'';
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
        $instance['url'] = strip_tags($new_instance['url']);
        $instance['target'] = isset($new_instance['target']);
        $instance['linktext'] = strip_tags($new_instance['linktext']);
        
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
        $text = esc_textarea($instance['text']);
        $url = strip_tags($instance['url']);
        $linktext = strip_tags($instance['linktext']);
?>
        <textarea class="widefat" maxlength="50" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>        
        <p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" /></p>
        <p><input id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" type="checkbox" <?php checked(isset($instance['target']) ? $instance['target'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e('Open in new window'); ?></label></p>
        <p><label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Link Text:'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" name="<?php echo $this->get_field_name('linktext'); ?>" type="text" value="<?php echo esc_attr($linktext); ?>" /></p>
        
<?php
    }
    
    function init() {
        if ( !is_blog_installed() )
            return;
        register_widget('Inf_CTA_widget');
    }
    
    function add_css(){
        if(!is_admin()){
            wp_enqueue_style('inf-widget-cta',plugin_dir_url(__FILE__).'/css/inf-widget-cta.css');
        }
    }
    function add_js(){
        if(!is_admin()){
            wp_enqueue_script('inf-widget-cta',plugin_dir_url(__FILE__).'/js/inf-widget-cta.js','jquery','0.4',TRUE);
        }
    }
}   
    add_action('widgets_init',array('Inf_CTA_widget','init'),10);
?>