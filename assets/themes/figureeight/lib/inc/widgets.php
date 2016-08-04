<?php
/**
 * Connected Class
 */
if(class_exists('MSDConnected')){
class CustomConnected extends MSDConnected {
    function widget( $args, $instance ) {
        extract($args);
        extract($instance);
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
        $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
        echo $before_widget;
        if ( !empty( $title ) ) { print $before_title.$title.$after_title; } 
        if ( !empty( $text )){ print '<div class="connected-text">'.$text.'</div>'; }
        print '<div class="wrap">';
        if(($address||$phone||$tollfree||$fax||$email||$social)&&$form_id > 0){
            print '<div class="col-md-7">';
        }
        if ( $form_id > 0 ){
            print '<div class="connected-form">';
            print do_shortcode('[gravityform id="'.$form_id.'" title="true" description="false" ajax="true"]');
            print '</div>';
            //add_action( 'wp_footer', array(&$this,'tabindex_javascript'), 60);
        }
        if(($address||$phone||$tollfree||$fax||$email||$social)&&$form_id > 0){
            print '</div>';
        }
        if(($address||$phone||$tollfree||$fax||$email||$social)&&$form_id > 0){
            print '<div class="col-md-5 align-right">';
        }
        if ( $address ){
            print '<h3>Address</h3>';
            $bizname = do_shortcode('[msd-bizname]'); 
            if ( $bizname ){
                print '<div class="connected-bizname">'.$bizname.'</div>';
            }
            $address = do_shortcode('[msd-address]'); 
            if ( $address ){
                print '<div class="connected-address">'.$address.'</div>';
            }
        }
        if ( $phone ){
            $phone = '';
            if((get_option('msdsocial_tracking_phone')!='')){
                if(wp_is_mobile()){
                  $phone .= 'Phone: <a href="tel:+1'.get_option('msdsocial_tracking_phone').'">'.get_option('msdsocial_tracking_phone').'</a> ';
                } else {
                  $phone .= 'Phone: <span>'.get_option('msdsocial_tracking_phone').'</span> ';
                }
              $phone .= '<span itemprop="telephone" style="display: none;">'.get_option('msdsocial_phone').'</span> ';
            } else {
                if(wp_is_mobile()){
                  $phone .= (get_option('msdsocial_phone')!='')?'Phone: <a href="tel:+1'.get_option('msdsocial_phone').'" itemprop="telephone">'.get_option('msdsocial_phone').'</a> ':'';
                } else {
                  $phone .= (get_option('msdsocial_phone')!='')?'Phone: <span itemprop="telephone">'.get_option('msdsocial_phone').'</span> ':'';
                }
            }
            if ( $phone ){ print '<div class="connected-phone">'.$phone.'</div>'; }
        }
        if ( $tollfree ){
            $tollfree = '';
            if((get_option('msdsocial_tracking_tollfree')!='')){
                if(wp_is_mobile()){
                  $tollfree .= 'Toll Free: <a href="tel:+1'.get_option('msdsocial_tracking_tollfree').'">'.get_option('msdsocial_tracking_tollfree').'</a> ';
                } else {
                  $tollfree .= 'Toll Free: <span>'.get_option('msdsocial_tracking_tollfree').'</span> ';
                }
              $tollfree .= '<span itemprop="telephone" style="display: none;">'.get_option('msdsocial_tollfree').'</span> ';
            } else {
                if(wp_is_mobile()){
                  $tollfree .= (get_option('msdsocial_tollfree')!='')?'Toll Free: <a href="tel:+1'.get_option('msdsocial_tollfree').'" itemprop="telephone">'.get_option('msdsocial_tollfree').'</a> ':'';
                } else {
                  $tollfree .= (get_option('msdsocial_tollfree')!='')?'Toll Free: <span itemprop="telephone">'.get_option('msdsocial_tollfree').'</span> ':'';
                }
            }
            if ( $tollfree ){ print '<div class="connected-tollfree">'.$tollfree.'</div>'; }
        }
        if ( $fax ){
            $fax = (get_option('msdsocial_fax')!='')?'Fax: <span itemprop="faxNumber">'.get_option('msdsocial_fax').'</span> ':'';
            if ( $fax ){ print '<div class="connected-fax">'.$fax.'</div>'; }
        }
        if ( $email ){
            $email = (get_option('msdsocial_email')!='')?'Email: <span itemprop="email"><a href="mailto:'.antispambot(get_option('msdsocial_email')).'">'.antispambot(get_option('msdsocial_email')).'</a></span> ':'';
            if ( $email ){ print '<div class="connected-email">'.$email.'</div>'; }
        }
        if ( $social ){
            $social = do_shortcode('[msd-social]');
            if( $social ){ print '<div class="connected-social">'.$social.'</div>'; }
        }   
        
        if(($address||$phone||$tollfree||$fax||$email||$social)&&$form_id > 0){
            print '</div>';
        }
        print '</div>';
        
        echo $after_widget;
    }
}

add_action('widgets_init', create_function('', 'return register_widget("CustomConnected");'));
}

class MSDLab_Featured_Post extends Genesis_Featured_Post {

    /**
     * Echo the widget content.
     *
     * @since 0.1.8
     *
     * @global WP_Query $wp_query               Query object.
     * @global array    $_genesis_displayed_ids Array of displayed post IDs.
     * @global $integer $more
     *
     * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
     * @param array $instance The settings for the particular instance of the widget
     */
    function widget( $args, $instance ) {

        global $wp_query, $_genesis_displayed_ids;

        //* Merge with defaults
        $instance = wp_parse_args( (array) $instance, $this->defaults );

        echo $args['before_widget'];
        //* Set up the author bio
        if ( ! empty( $instance['title'] ) )
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

        if( ! empty( $instance['posts_cat'] ))
        echo '<h5 class="category-title">Recent '.esc_attr( get_cat_name( $instance['posts_cat'] ) ).' Posts</h5>';
            
        $query_args = array(
            'post_type'           => 'post',
            'cat'                 => $instance['posts_cat'],
            'showposts'           => $instance['posts_num'],
            'offset'              => $instance['posts_offset'],
            'orderby'             => $instance['orderby'],
            'order'               => $instance['order'],
            'ignore_sticky_posts' => $instance['exclude_sticky'],
        );

        //* Exclude displayed IDs from this loop?
        if ( $instance['exclude_displayed'] )
            $query_args['post__not_in'] = (array) $_genesis_displayed_ids;

        $wp_query = new WP_Query( $query_args );

        if ( have_posts() ) : while ( have_posts() ) : the_post();

            $_genesis_displayed_ids[] = get_the_ID();

            genesis_markup( array(
                'html5'   => '<article %s>',
                'xhtml'   => sprintf( '<div class="%s">', implode( ' ', get_post_class() ) ),
                'context' => 'entry',
            ) );

            $image = genesis_get_image( array(
                'format'  => 'html',
                'size'    => $instance['image_size'],
                'context' => 'featured-post-widget',
                'attr'    => genesis_parse_attr( 'entry-image-widget', array ( 'alt' => get_the_title() ) ),
            ) );

            if ( $instance['show_image'] && $image ) {
                $role = empty( $instance['show_title'] ) ? '' : 'aria-hidden="true"';
                printf( '<a href="%s" class="%s" %s>%s</a>', get_permalink(), esc_attr( $instance['image_alignment'] ), $role, $image );
            }

            if ( ! empty( $instance['show_gravatar'] ) ) {
                echo '<span class="' . esc_attr( $instance['gravatar_alignment'] ) . '">';
                echo get_avatar( get_the_author_meta( 'ID' ), $instance['gravatar_size'] );
                echo '</span>';
            }

            if ( $instance['show_title'] )
                echo genesis_html5() ? '<header class="entry-header">' : '';

                if ( ! empty( $instance['show_title'] ) ) {

                    $title = get_the_title() ? get_the_title() : __( '(no title)', 'genesis' );

                    /**
                     * Filter the featured post widget title.
                     *
                     * @since  2.2.0
                     *
                     * @param string $title    Featured post title.
                     * @param array  $instance {
                     *     Widget settings for this instance.
                     *
                     *     @type string $title                   Widget title.
                     *     @type int    $posts_cat               ID of the post category.
                     *     @type int    $posts_num               Number of posts to show.
                     *     @type int    $posts_offset            Number of posts to skip when
                     *                                           retrieving.
                     *     @type string $orderby                 Field to order posts by.
                     *     @type string $order                   ASC fr ascending order, DESC for
                     *                                           descending order of posts.
                     *     @type bool   $exclude_displayed       True if posts shown in main output
                     *                                           should be excluded from this widget
                     *                                           output.
                     *     @type bool   $show_image              True if featured image should be
                     *                                           shown, false otherwise.
                     *     @type string $image_alignment         Image alignment: alignnone,
                     *                                           alignleft, aligncenter or alignright.
                     *     @type string $image_size              Name of the image size.
                     *     @type bool   $show_gravatar           True if author avatar should be
                     *                                           shown, false otherwise.
                     *     @type string $gravatar_alignment      Author avatar alignment: alignnone,
                     *                                           alignleft or aligncenter.
                     *     @type int    $gravatar_size           Dimension of the author avatar.
                     *     @type bool   $show_title              True if featured page title should
                     *                                           be shown, false otherwise.
                     *     @type bool   $show_byline             True if post info should be shown,
                     *                                           false otherwise.
                     *     @type string $post_info               Post info contents to show.
                     *     @type bool   $show_content            True if featured page content
                     *                                           should be shown, false otherwise.
                     *     @type int    $content_limit           Amount of content to show, in
                     *                                           characters.
                     *     @type int    $more_text               Text to use for More link.
                     *     @type int    $extra_num               Number of extra post titles to show.
                     *     @type string $extra_title             Heading for extra posts.
                     *     @type bool   $more_from_category      True if showing category archive
                     *                                           link, false otherwise.
                     *     @type string $more_from_category_text Category archive link text.
                     * }
                     * @param array  $args     {
                     *     Widget display arguments.
                     *
                     *     @type string $before_widget Markup or content to display before the widget.
                     *     @type string $before_title  Markup or content to display before the widget title.
                     *     @type string $after_title   Markup or content to display after the widget title.
                     *     @type string $after_widget  Markup or content to display after the widget.
                     * }
                     */
                    $title = apply_filters( 'genesis_featured_post_title', $title, $instance, $args );
                    $heading = genesis_a11y( 'headings' ) ? 'h4' : 'h2';

                    if ( genesis_html5() )
                        printf( '<%s class="entry-title"><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );
                    else
                        printf( '<%s><a href="%s">%s</a></%s>', $heading, get_permalink(), $title, $heading );

                }

                if ( ! empty( $instance['show_byline'] ) && ! empty( $instance['post_info'] ) )
                    printf( genesis_html5() ? '<p class="entry-meta">%s</p>' : '<p class="byline post-info">%s</p>', do_shortcode( $instance['post_info'] ) );

            if ( $instance['show_title'] )
                echo genesis_html5() ? '</header>' : '';

            if ( ! empty( $instance['show_content'] ) ) {

                echo genesis_html5() ? '<div class="entry-content">' : '';

                if ( 'excerpt' == $instance['show_content'] ) {
                    the_excerpt();
                }
                elseif ( 'content-limit' == $instance['show_content'] ) {
                    the_content_limit( (int) $instance['content_limit'], genesis_a11y_more_link( esc_html( $instance['more_text'] ) ) );
                }
                else {

                    global $more;

                    $orig_more = $more;
                    $more = 0;

                    the_content( genesis_a11y_more_link( esc_html( $instance['more_text'] ) ) );

                    $more = $orig_more;

                }

                echo genesis_html5() ? '</div>' : '';

            }

            genesis_markup( array(
                'html5' => '</article>',
                'xhtml' => '</div>',
            ) );

        endwhile; endif;

        //* Restore original query
        wp_reset_query();

        //* The EXTRA Posts (list)
        if ( ! empty( $instance['extra_num'] ) ) {
            if ( ! empty( $instance['extra_title'] ) )
                echo $args['before_title'] . esc_html( $instance['extra_title'] ) . $args['after_title'];

            $offset = intval( $instance['posts_num'] ) + intval( $instance['posts_offset'] );

            $query_args = array(
                'cat'       => $instance['posts_cat'],
                'showposts' => $instance['extra_num'],
                'offset'    => $offset,
            );

            $wp_query = new WP_Query( $query_args );

            $listitems = '';

            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    $_genesis_displayed_ids[] = get_the_ID();
                    $listitems .= sprintf( '<li><a href="%s">%s</a></li>', get_permalink(), get_the_title() );
                }

                if ( mb_strlen( $listitems ) > 0 )
                    printf( '<ul>%s</ul>', $listitems );
            }

            //* Restore original query
            wp_reset_query();
        }

        if ( ! empty( $instance['more_from_category'] ) && ! empty( $instance['posts_cat'] ) )
            printf(
                '<p class="more-from-category"><a href="%1$s" title="%2$s">%3$s</a></p>',
                esc_url( get_category_link( $instance['posts_cat'] ) ),
                esc_attr( get_cat_name( $instance['posts_cat'] ) ),
                esc_html( $instance['more_from_category_text'] )
            );

        echo $args['after_widget'];

    }
}

add_action('widgets_init', create_function('', 'return register_widget("MSDLab_Featured_Post");'));