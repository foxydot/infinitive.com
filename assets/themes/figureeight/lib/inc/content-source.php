<?php
if(!class_exists('MSDContentSource')){
    class MSDContentSource{
        protected static $instance = NULL;
        function __construct(){
            global $current_screen;
            //Actions
            add_action( 'init', array(&$this,'register_taxonomy_content_source') );
            add_action( 'wp_print_styles', array(&$this,'add_css') );
            
            //Filters
            add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'body_class', array(&$this,'watermark_content') );
        }
        
        public static function init() {
           NULL === self::$instance and self::$instance = new self;
           return self::$instance;
        }
        
        function register_taxonomy_content_source(){
            
            $labels = array( 
                'name' => _x( 'Content Sources', 'content-source' ),
                'singular_name' => _x( 'Content Source', 'content-source' ),
                'search_items' => _x( 'Search Content Sources', 'content-source' ),
                'popular_items' => _x( 'Popular Content Sources', 'content-source' ),
                'all_items' => _x( 'All Content Sources', 'content-source' ),
                'parent_item' => _x( 'Parent Content Source', 'content-source' ),
                'parent_item_colon' => _x( 'Parent Content Source:', 'content-source' ),
                'edit_item' => _x( 'Edit Content Source', 'content-source' ),
                'update_item' => _x( 'Update Content Source', 'content-source' ),
                'add_new_item' => _x( 'Add new Content Source', 'content-source' ),
                'new_item_name' => _x( 'New Content Source name', 'content-source' ),
                'separate_items_with_commas' => _x( 'Separate Content Sources with commas', 'content-source' ),
                'add_or_remove_items' => _x( 'Add or remove Content Sources', 'content-source' ),
                'choose_from_most_used' => _x( 'Choose from the most used Content Sources', 'content-source' ),
                'menu_name' => _x( 'Content Sources', 'content-source' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true, 
                'show_in_quick_edit' => true,
                'show_admin_column' => true,
                'rewrite' => array('slug'=>'content-source','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'content_source', array('page','post','msd_casestudy','location','msd_news','project','team_member','msd_video'), $args );
        }
        
        function watermark_content($classes){
            global $post;
            if(!has_term('approved-content','content_source',$post)){
                $classes[] = "watermark";
            }
            return $classes;
        }
        
        function add_css(){
            $css = '
                <style>
                    body.watermark main {
                        position: relative;
                    }
                    body.watermark main:before {
                        display: block;
                        content: "FPO";
                        color: red;
                        font-size: 20vw;
                        opacity: 0.1;
                        position: absolute;
                        top: 0;
                        left: 0;
                        text-align: center;
                        -moz-transform: rotate(-30deg);
                        -webkit-transform: rotate(-30deg);
                        -o-transform: rotate(-30deg);
                        -ms-transform: rotate(-30deg);
                        transform: rotate(-30deg);
                        line-height: 1;
                        width: 100%;
                        z-index: -1;
                    }
                </style>
            ';
            print $css;
        }
    }
}
$content_source = new MSDContentSource;