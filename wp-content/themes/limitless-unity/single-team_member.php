<?php
remove_action('genesis_entry_header','genesis_post_info',12);
remove_action('genesis_entry_footer','genesis_post_meta');
add_action('genesis_entry_header','msd_add_team_title',5);
function msd_add_team_title(){
    global $post,$contact_info;
    if($contact_info->get_the_value('_team_position')=='true'){
        $title = 'Leadership';
    } else {
        $title = 'Experts';
    }
    print '<div class="section-header first-child odd">
        <h3>'.$title.'</h3>
        </div>';
}

add_action('genesis_entry_header','msd_add_team_headshot', 5);
function msd_add_team_headshot(){
    global $post;
    //setup thumbnail image args to be used with genesis_get_image();
    $size = 'headshot'; // Change this to whatever add_image_size you want
    $default_attr = array(
            'class' => "alignleft attachment-$size $size",
            'alt'   => $post->post_title,
            'title' => $post->post_title,
    );

    // This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
    if ( has_post_thumbnail() ) {
        printf( '%s', genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
    }
}

add_action('genesis_entry_header','msd_team_contact_info',12);
function msd_team_contact_info(){
    global $post,$contact_info;
    ?>
    <?php $contact_info->the_field('_team_title'); ?>
    <?php if($contact_info->get_the_value() != ''){ ?>
        <h4 class="team-title"><?php print $contact_info->get_the_value(); ?></h4>
    <?php } ?>
    <ul class="team-contact-info">
        <?php $contact_info->the_field('_team_phone'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="phone"><i class="icon-phone icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'phone'); ?></li>
        <?php } ?>
        <?php $contact_info->the_field('_team_mobile'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="mobile"><i class="icon-mobile-phone icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'phone'); ?></li>
        <?php } ?>
        <?php $contact_info->the_field('_team_email'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="email"><i class="icon-envelope-alt icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'email'); ?></li>
        <?php } ?>
    </ul>
    <ul class="team-social-media">
        <?php $contact_info->the_field('_team_twitter'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="twitter"><a href="<?php print $contact_info->get_the_value(); ?>"><i class="fa fa-twitter-square fa-2x"></i> Follow</a></li>
        <?php } ?>
        <?php $contact_info->the_field('_team_linked_in'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="linkedin"><a href="<?php print $contact_info->get_the_value(); ?>"><i class="fa fa-linkedin-square fa-2x"></i> Connect</a></li>
        <?php } ?>
    </ul>
    <?php
}

add_action('genesis_after_entry_content','msd_team_additional_info');
function msd_team_additional_info(){
    global $post,$additional_info;
    $fields = array(
            'experience' => 'Experience',
            'decisions' => 'Notable Decisions',
            'honors' => 'Honors/Distinctions',
            'admissions' => 'Admissions',
            'affiliations' => 'Professional Affiliations',
            'community' => 'Community Involvement',
            'presentations' => 'Presentations',
            'publications' => 'Publications',
            'education' => 'Education',
    );
    $i = 0; ?>
    <ul class="team-additional-info">
    <?php
    foreach($fields AS $k=>$v){
    ?>
        <?php $additional_info->the_field('_team_'.$k); ?>
        <?php if($additional_info->get_the_value() != ''){ ?>
            <li>
                <h3><?php print $v; ?></h3>
                <?php print font_awesome_lists(apply_filters('the_content',$additional_info->get_the_value())); ?>
            </li>
        <?php 
        $i++;
        }
    } ?>
    </ul>
    <?php
}

add_action('genesis_after_entry_content','msd_team_insights');
function msd_team_insights(){
    global $post,$contact_info;
    $titlearray = explode(" ",$post->post_title);
    $firstname = $titlearray[0];
    $firstname = (substr($firstname, -1) == 's')?$firstname."'":$firstname."'s";
    print '<h3 class="insights-header" id="insights">'.$firstname.' Insights</h3>';
    if($contact_info->get_the_value('_team_user_id')!=0){
        $args = array(
            'author' => $contact_info->get_the_value('_team_user_id'),
            'posts_per_page' => '4',
        );
        $blogs = get_posts($args);
        if($blogs){
            print '<div class="insights-blogs">';
            print '<h3 class="insights-header">Blog Posts</h3>';
            $i = 0;
            foreach($blogs AS $blog){
                if($i%2==0){
                    print '<hr class="grid-separator">';
                }
                team_display_blog($blog,$i);
                $i++;
            }
            print '</div>';
        }
    }
}

function team_display_blog($blog,$count = 0){
    $thumbnail = get_the_post_thumbnail($blog->ID,'thumbnail',array('class' => 'aligncenter'));
    $classes = $count%2==0?'odd':'even';
    print '<article class="'.$classes.'">
        <a href="'.get_permalink($blog->ID).'">'.$thumbnail.'</a>
        <h4><a href="'.get_permalink($blog->ID).'">'.$blog->post_title.'</a></h4>
        <div class="meta">Posted by <br>
        '.mysql2date('F j, Y', $blog->post_date).'</div>
    </article>';
}
add_action('genesis_after_entry_content','msd_team_videos');
function msd_team_videos(){
    global $post;
    $video = new MSDVideoCPT;
    $videos = $video->get_video_items_for_team_member($post->ID);
    $i = 1;
    if(count($videos)>0){
        print'<div class="insights-blogs odd">
<h3 class="insights-header">Videos</h3>
<hr class="grid-separator">';
        foreach($videos AS $vid){
            $class = $i%2==0?'even':'odd';
            print '<article class="'.$class.'">';
            print wp_oembed_get($vid->youtube_url);
            print '<h4>
<a href="'.get_permalink($vid->ID).'">'.$vid->post_title.'</a>
</h4>';
            print '</article>';
            if($i%2==0){
                print '<hr class="grid-separator">';
            }
            $i++;
        }
        print '</div>';
    }
}
add_action('genesis_after_entry_content','msd_team_news');
function msd_team_news(){
    global $post;
    $news = new MSDNewsCPT;
    $newses = $news->get_news_items_for_team_member($post->ID);
    $i = 1;
    if(count($newses)>0){
        print'<div class="insights-blogs odd">
<h3 class="insights-header">Press</h3>
<hr class="grid-separator">';
        foreach($newses AS $press){
            $class = $i%2==0?'even':'odd';
            print '<article class="'.$class.'">';
            print '<h4>
<a href="'.get_permalink($press->ID).'">'.$press->post_title.'</a>
</h4>';
            print '</article>';
            if($i%2==0){
                print '<hr class="grid-separator">';
            }
            $i++;
        }
        print '</div>';
    }
}

function font_awesome_lists($str){
    $str = strip_tags($str,'<a><li><ul><h3><b><strong><i>');
    $str = preg_replace('/<ul(.*?)>/i','<ul class="icons-ul"\1>',$str);
    $str = preg_replace('/<li>/i','<li><i class="icon-li icon-caret-right"></i>',$str);
    return $str;
}

genesis();