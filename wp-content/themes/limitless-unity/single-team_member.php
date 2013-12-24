<?php
remove_action('genesis_entry_header','genesis_post_info',12);
remove_action('genesis_entry_footer','genesis_post_meta');

add_action('genesis_before_sidebar_widget_area','msd_add_team_headshot');
function msd_add_team_headshot(){
    global $post;
    //setup thumbnail image args to be used with genesis_get_image();
    $size = 'headshot'; // Change this to whatever add_image_size you want
    $default_attr = array(
            'class' => "alignnone attachment-$size $size",
            'alt'   => $post->post_title,
            'title' => $post->post_title,
    );

    // This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
    if ( has_post_thumbnail() ) {
        printf( '%s', genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
    }
}
add_action('genesis_before_entry_content','msd_team_contact_info');
function msd_team_contact_info(){
    global $post,$contact_info;
    $fields = array(
            'phone' => 'phone',
            'mobile' => 'mobile-phone',
            'linkedin' => 'linkedin-sign',
            'vcard' => 'download-alt',
            'email' => 'envelope-alt',
    );
    ?>
    <ul class="team-contact-info">
        <?php $contact_info->the_field('_team_phone'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="phone"><i class="icon-phone icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'phone'); ?></li>
        <?php } ?>
        
        <?php $contact_info->the_field('_team_mobile'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="mobile"><i class="icon-mobile-phone icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'phone'); ?></li>
        <?php } ?>
        
        <?php $contact_info->the_field('_team_linked_in'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="linkedin"><a href="<?php print $contact_info->get_the_value(); ?>"><i class="icon-linkedin-sign icon-large"></i> Connect</a></li>
        <?php } ?>
        
        <?php $contact_info->the_field('_team_bio_sheet'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="vcard"><a href="<?php print $contact_info->get_the_value(); ?>"><i class="icon-download-alt icon-large"></i> Download Bio</a></li>
        <?php } ?>
        
        <?php $contact_info->the_field('_team_email'); ?>
        <?php if($contact_info->get_the_value() != ''){ ?>
            <li class="email"><i class="icon-envelope-alt icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'email'); ?></li>
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
    <h3 class="toggle">More Info<span class="expand">Expand <i class="icon-angle-down"></i></span><span class="collapse">Collapse <i class="icon-angle-up"></i></span></h3>
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
function font_awesome_lists($str){
    $str = strip_tags($str,'<a><li><ul><h3><b><strong><i>');
    $str = preg_replace('/<ul(.*?)>/i','<ul class="icons-ul"\1>',$str);
    $str = preg_replace('/<li>/i','<li><i class="icon-li icon-caret-right"></i>',$str);
    return $str;
}
remove_action('genesis_sidebar','genesis_do_sidebar');
add_action('genesis_sidebar','msd_team_sidebar');
function msd_team_sidebar(){
    global $post,$primary_practice_area;
    $terms = wp_get_post_terms($post->ID,'practice_area');
    $ppa = $primary_practice_area->get_the_value('primary_practice_area');
    print '<div class="sidebar-content">';
    if(count($terms)>0){
        print '<div class="widget">
            <div class="widget-wrap">
            <h4 class="widget-title widgettitle">Practice Areas</h4>
            <ul>';
        foreach($terms AS $term){
            if($term->slug == $ppa){
                if($test = get_page_by_path('/practice-areas/'.$term->slug)){
                 $ret = '<li><a href="/practice-areas/'.$term->slug.'">'.$term->name.'</a></li>'.$ret;
                } else {
                 $ret = '<li>'.$term->name.'</li>'.$ret;
                }
            } else {
                if($test = get_page_by_path('/practice-areas/'.$term->slug)){
                 $ret .= '<li><a href="/practice-areas/'.$term->slug.'">'.$term->name.'</a></li>';
                } else {
                 $ret .= '<li>'.$term->name.'</li>';
                }
            }
        }
        print $ret;
        print '</ul>
        </div>
        </div>';
    }
    dynamic_sidebar('team-sidebar');
    print '</div>';
}
genesis();