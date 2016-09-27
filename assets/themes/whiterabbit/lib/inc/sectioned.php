<?php
/*
 * Extends: MSD Specialty Pages
 * Last updated with Version: 0.2.6
 * Author: MSDLAB
 * Author URI: http://msdlab.com
 * */
if(class_exists('MSDSectionedPage')){
    class CustomSectionedPage extends MSDSectionedPage{
    function default_output($section,$i){
        //ts_data($section);
        global $parallax_ids;
        $eo = ($i+1)%2==0?'even':'odd';
        $title = apply_filters('the_title',$section['content-area-title']);
        $section_name = $section['section-name']!=''?$section['section-name']:$title;
        $slug = sanitize_title_with_dashes(str_replace('/', '-', $section_name));
        $background = '';
        if($section['background-color'] || $section['background-image']){
            if($section['background-color'] && $section['background-image']){
               $background = 'style="background-image: url('.$section['background-image'].');background-color: '.$section['background-color'].';"';
            } elseif($section['background-image']){
               $background = 'style="background-image: url('.$section['background-image'].');"';
            } else{
               $background = 'style="background-color: '.$section['background-color'].';"';
            }
            if($section['background-image'] && $section['background-image-parallax']){
                $parallax_ids[] = $slug;
            }
        }
        $wrapped_title = trim($title) != ''?apply_filters('msdlab_sectioned_page_output_title','<div class="section-title">
            <h3 class="wrap">
                '.$title.'
            </h3>
        </div>'):'';
        $subtitle = $section['content-area-subtitle'] !=''?apply_filters('msdlab_sectioned_page_output_subtitle','<h4 class="section-subtitle">'.$section['content-area-subtitle'].'</h4>'):'';
        $header = apply_filters('the_content',$section['header-area-content']);
        $content = apply_filters('the_content',$section['content-area-content']);
        $footer = apply_filters('the_content',$section['footer-area-content']);
                $float = $section['feature-image-float']!='none'?' class="align'.$section['feature-image-float'].'"':'';
        $featured_image = $section['content-area-image'] !=''?'<img src="'.$section['content-area-image'].'"'.$float.' />':'';
        $classes = apply_filters('msdlab_sectioned_page_output_classes',array(
            'section',
            'section-'.$slug,
            $section['css-classes'],
            'section-'.$eo,
            'clearfix',
        ));
        //think about filtering the classes here
        $ret = '
        <div id="'.$slug.'" class="'.implode(' ', $classes).'"'.$background.'>
        
                '.$wrapped_title.'
            <div class="section-body">
                <div class="wrap">
                    '.$featured_image.'
                    '.$subtitle.'
                    '.$header.'
                    '.$content.'
                    '.$footer.'
                </div>
            </div>
        </div>
        ';
        return $ret;
    }

    function sectioned_page_output(){
        wp_enqueue_script('sticky',WP_PLUGIN_URL.'/'.plugin_dir_path('msd-specialty-pages/msd-specialty-pages.php'). '/lib/js/jquery.sticky.js',array('jquery'),FALSE,TRUE);
        global $post,$subtitle_metabox,$sectioned_page_metabox,$nav_ids;
        $i = 0;
        $meta = $sectioned_page_metabox->the_meta();
        if(is_object($sectioned_page_metabox)){
        while($sectioned_page_metabox->have_fields('sections')){
            $layout = $sectioned_page_metabox->get_the_value('layout');
            switch($layout){
                case "four-col":
                    $sections[] = self::column_output($meta['sections'][$i],$i);
                    break;
                case "three-col":
                    $sections[] = self::column_output($meta['sections'][$i],$i);
                    break;
                case "two-col":
                    $sections[] = self::column_output($meta['sections'][$i],$i);
                    break;
                default:
                    $sections[] = self::default_output($meta['sections'][$i],$i);
                    break;
            }
            $i++;
        }//close while
        print '<div class="sectioned-page-wrapper">';
        print implode("\n",$sections);
        print '</div>';
        }//clsoe if
    }
  }
}