<?php
class Segment_Widget extends WP_Widget {

    function __construct() {
        add_action('wp_print_styles', array($this,'add_css'));
        add_action('wp_print_scripts', array($this,'add_js'));
        $widget_ops = array('classname' => 'widget_segment', 'description' => __('Highlight a segment'));
        $control_ops = array('width' => 400, 'height' => 350);
        parent::__construct('segment-widget', __('Featured Segment'), $widget_ops, $control_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $text = apply_filters( 'widget_cta', $instance['text'], $instance );
        $url = empty($instance['url']) ? FALSE : $instance['url'];
        $target = $instance['target'] ? ' target="_blank"':'';
        $linktext = apply_filters( 'widget_title', empty($instance['linktext']) ? 'Learn More >' : $instance['linktext'], $instance, $this->id_base);
        echo $before_widget; ?>
        <div class="textwidget">
            <?php if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
            echo '<div>';
            echo $instance['filter'] ? wpautop($text) : $text; 
            echo '</div>';
            if ( !empty( $url ) ) { echo '<div class="link"><a  href="'.$url.'"'.$target.' class="readmore"><span>'.$linktext.'</span></a></div>'; } ?>
        </div>
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);        
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
        $title = strip_tags($instance['title']);
        $text = esc_textarea($instance['text']);
        $url = strip_tags($instance['url']);
        $linktext = strip_tags($instance['linktext']);
?>        
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text (max 50 chars):'); ?></label>
        <textarea class="widefat" maxlength="50" rows="4" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea></p>     
        <p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" /></p>
        <p><input id="<?php echo $this->get_field_id('target'); ?>" name="<?php echo $this->get_field_name('target'); ?>" type="checkbox" <?php checked(isset($instance['target']) ? $instance['target'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e('Open in new window'); ?></label></p>
        <p><label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Link Text:'); ?></label><input class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" name="<?php echo $this->get_field_name('linktext'); ?>" type="text" value="<?php echo esc_attr($linktext); ?>" /></p>
        
<?php
    }
    
    function init() {
        if ( !is_blog_installed() )
            return;
        register_widget('Segment_Widget');
    }
}   
add_action('widgets_init',array('Segment_Widget','init'),15);