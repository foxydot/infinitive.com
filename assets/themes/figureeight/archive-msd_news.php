<?php
function msdlab_press_special_loop(){
    global $post;
    if ( have_posts() ) :
        do_action( 'genesis_before_while' );
    print '<ul class="publication-list news-display">';
        while ( have_posts() ) : the_post();
    $url = get_post_meta($post->ID,'_news_newsurl',1);
    $excerpt = $post->post_excerpt?$post->post_excerpt:msd_trim_headline($post->post_content);
    $link = strlen($url)>4?msdlab_http_sanity_check($url):get_permalink($post->ID);
    $background = msdlab_get_thumbnail_url($post->ID,'medium');
    print '
    <li>
        <div class="col-sm-8">
            <div class="news-info">
            <h3><a href="'.$link.'">'.$post->post_title.' ></a></h3>
                <div>
                    '.date('F j, Y',strtotime($post->post_date)).'
                    <div class="excerpt">'.$excerpt.'</div>
                    '.do_shortcode('[button url="'.$link.'"]Read More[/button]').'
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="news-logo">
                <a href="'.$link.'" style="background-image:url('.$background.')">&nbsp;
                </a>
            </div>
        </div>
    </li>';
        endwhile;
    print '</ul>';
        do_action( 'genesis_after_endwhile' );
    endif;
}

remove_action('genesis_loop','genesis_do_loop');
add_action('genesis_loop','msdlab_press_special_loop');
genesis();