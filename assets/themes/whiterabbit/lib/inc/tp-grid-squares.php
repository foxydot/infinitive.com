<?php
add_shortcode('tp-grid','msdlab_tpgrid_shortcode_handler');
add_shortcode('tp-square','msdlab_tpsquare_shortcode_handler');
add_shortcode('tp-col','msdlab_tpcolumn_shortcode_handler');
function msdlab_tpgrid_shortcode_handler($atts,$content){
    extract( shortcode_atts( array(
        'classes' => '',
        'recent' => false,
        'channel' => false,
        'link' => false,
        'style' => 'display',
        'cat' => false
    ), $atts ) );
    if(!$recent){
        $ret = '
        <div class="tp-grid" class="'.$classes.'">
            '.do_shortcode(remove_wpautop($content)).'
        </div>';
    } else {
        switch($channel){
            case 'quarterly':
                $icon = 'quadrants';
                $title = 'Quarterly Insights';
                $more = 'Quarterly Insights';
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $recent,
                    'cat' => 42
                );
                $link = !$link?'/category/quarterly-insight/':$link;
                break;
            case 'events':
                $icon = 'calendar';
                $title = 'Events';
                $more = 'Events';
                $args = array(
                    'post_type' => 'event',
                    'posts_per_page' => $recent,
                    'meta_query' => array(
                        array(
                            'key' => '_date_event_end_datestamp',
                            'value' => time()-86400,
                            'compare' => '>'
                        ),
                        array(
                            'key' => '_date_event_end_datestamp',
                            'value' => mktime(0, 0, 0, date("m")+12, date("d"), date("Y")),
                            'compare' => '<'
                        )
                    ),
                    'meta_key' => '_date_event_end_datestamp',
                    'orderby'=>'meta_value_num',
                    'order'=>'ASC',
                );

                $args2 = array(
                    'post_type' => 'event',
                    'meta_query' => array(
                        array(
                            'key' => '_date_event_end_datestamp',
                            'value' => time()-86400,
                            'compare' => '<='
                        ),
                    ),
                    'meta_key' => '_date_event_end_datestamp',
                    'orderby'=>'meta_value_num',
                    'order'=>'DESC',
                );
                $link = !$link?'/resources/events/':$link;
                break;
            case 'press':
                $icon = 'topicbubble';
                $title = 'Press Releases';
                $more = 'Press Releases';
                $args = array(
                    'post_type' => 'press',
                    'posts_per_page' => $recent,
                );
                $link = !$link?'/resources/press-release/':$link;
                break;
            case 'news':
                $icon = 'arrow';
                $title = 'In The News';
                $more = 'News';
                $args = array(
                    'post_type' => 'news',
                    'posts_per_page' => $recent,
                );
                $link = !$link?'/resources/news/':$link;
                break;
            case 'viewpoints':
            default:
                $icon = 'logo';
                $title = 'Viewpoints';
                $more = 'Viewpoints';
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $recent,
                );
                if($cat){
                    $args['cat'] = $cat;
                }
                $link = !$link?'/resources/truepoint-viewpoint/':$link;
                break;
        }
        $ret = '<div class="grid-hdr row">
            <div class="col-xs-12">
                <h3><i class="icon icon-'.$icon.'"></i> '.$title.'</h3>
            </div>';
        $ret .= '
        </div>';
        $loop = new WP_Query($args);

        if($loop->have_posts()){
            $ctr = 0;
            $ret .= '
        <div class="tp-grid" class="'.$classes.'">';
            while($loop->have_posts()){
                $ctr++;
                $loop->the_post();
                $ret .= '
                <div class="tp-square" id="'.$post->post_name.'">
                    <div class="off">
                        <div class="icon-holder">
                            <h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
                        </div>';
                if(wp_is_mobile() || $style == 'display'){
                    $ret .= '
                            <div class="content-holder excerpt">'.msdlab_get_excerpt($post->ID,30,'').'</div>
                            <div class="link-holder excerpt"><a href="'.get_the_permalink().'" class="morelink">more ></a></div>';
                }
                $ret .= '
                        <div class="title-holder">';
                if($args['post_type']=='post'){
                    $ret .= '
                            <div class="author">'.msdlab_post_author_bio().'</div>';
                }
                $ret .= '
                            <div class="date">'.get_the_date().'</div>
                        </div>';
                if(!wp_is_mobile() && $style != 'display'){
                    $ret .= '
                        <div class="on">
                            <div class="icon-holder">
                                <i class="icon icon-'.$icon.'"></i>
                            </div>
                            <div class="content-holder">'.msdlab_get_excerpt($post->ID,30,'').'</div>
                            <div class="link-holder"><a href="'.get_the_permalink().'" class="morelink">more ></a></div>
                        </div>';
                }
                $ret .= '
                    </div>
                </div>';
            }

            if($ctr<3 && $channel == 'events'){
                //do second query to get recent but past events.
                $args2['posts_per_page'] = $recent - $ctr;
                $loop2 = new WP_Query($args2);
                if($loop2->have_posts()){
                    while($loop2->have_posts()){
                        $loop2->the_post();
                        $ret .= '
                    <div class="tp-square" id="'.$post->post_name.'">
                        <div class="off">
                            <div class="icon-holder">
                                <h3>Past Event: '.get_the_title().'</h3>
                            </div>
                            <div class="title-holder">
                                <div class="date">'.get_the_date().'</div>
                            </div>
                            <div class="on">
                                <div class="icon-holder">
                                    <i class="icon icon-'.$icon.'"></i>
                                </div>
                                <div class="content-holder">'.msdlab_get_excerpt($post->ID,30,'').'</div>
                                <div class="link-holder"><a href="'.get_the_permalink().'" class="morelink">more ></a></div>
                            </div>
                        </div>
                    </div>';
                    }
                }
            }

            $ret .= '<div class="grid-ftr">';
            if($link){
                $ret .= '<div class="col-xs-12">
                <a href="'.$link.'" class="more">More '.$more.'</a>
            </div>';
            }
            $ret .= '
        </div>';
            $ret .= '
        </div>';
            wp_reset_postdata();
        }
        $ret = '<div class="tp-grid-channel">'.$ret.'</div>';
    }
    return $ret;
}
function msdlab_tpsquare_shortcode_handler($atts,$content){
    extract( shortcode_atts( array(
        'id' => FALSE,
        'url' => FALSE,
        'title' => '',
        'icon' => '',
    ), $atts ) );
    if(!$id){$id = sanitize_title_with_dashes($title);}
    $ret = '
    <div class="tp-square" id="'.$id.'">
        <div class="off">
            <div class="icon-holder">
                <i class="icon icon-'.$icon.'"></i>
            </div>';
    if(wp_is_mobile()){
        $ret .= '<div class="content-holder">'.do_shortcode(remove_wpautop($content)).'</div>';
        if($url){
            $ret .= '<div class="link-holder"><a href="'.$url.'" class="morelink">more ></a></div>';
        }
    }
    $ret .= '
            <div class="title-holder">
                <h3>'.$title.'</h3>
            </div>';
    if(!wp_is_mobile()){
        $ret .= '<div class="on">
                <div class="icon-holder">
                    <i class="icon icon-'.$icon.'"></i>
                </div>
                <div class="title-holder">
                    <h3>'.$title.'</h3>
                </div>
                <div class="content-holder">'.do_shortcode(remove_wpautop($content)).'</div>';
        if($url){
            $ret .= '<div class="link-holder"><a href="'.$url.'" class="morelink">more ></a></div>';
        }
        $ret .= '
            </div>';
    }
    $ret .= '
        </div>
    </div>';
    return $ret;
}

function msdlab_tpcolumn_shortcode_handler($atts,$content){
    extract( shortcode_atts( array(
        'id' => FALSE,
        'url' => FALSE,
        'title' => '',
        'subtitle' => '',
        'icon' => '',
        'color' => 'blue'
    ), $atts ) );
    if(!$id){$id = sanitize_title_with_dashes($title);}
    $ret = '
    <div class="tp-column" id="'.$id.'">
        <div class="top border-'.$color.'">
            <div class="inner">
                <div class="icon-holder">
                    <i class="icon icon-'.$icon.'"></i>
                </div>';
    $ret .= '
                <div class="title-holder">
                    <h3>'.$title.'</h3>
                    <h4>'.$subtitle.'</h4>
                </div>
            </div>
        </div>
        <div class="bottom border-'.$color.'">
            <div class="inner">'.do_shortcode(remove_wpautop($content)).'</div>
        </div>
    </div>';
    return $ret;
}