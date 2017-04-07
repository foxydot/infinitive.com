<?php
/**
 * @package MSD Publication CPT
 * @version 0.1
 */

class MSDNewsCPT {
    
    public $cpt;

	/**
    * PHP 4 Compatible Constructor
    */
    public function MSDNewsCPT(){$this->__construct();}

    /**
     * PHP 5 Constructor
     */
    function __construct(){
        global $current_screen;
        //"Constants" setup
        $this->cpt = 'msd_news';
        $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
        $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
        
        //Actions
        add_action( 'init', array(&$this,'register_cpt_news') );
        add_action( 'template_redirect', array(&$this,'hide_single_news') );
        
        //Filters
        
        //Shortcodes
        add_shortcode( 'news-items', array(&$this,'list_news_stories') );
        add_shortcode( 'news-display', array(&$this,'display_news_stories') );
        
        add_filter('post_type_link',array(&$this,'do_news_url'));
    }
        
	
	function register_cpt_news() {
	
	    $labels = array( 
	        'name' => _x( 'News Items', 'news' ),
	        'singular_name' => _x( 'News Item', 'news' ),
	        'add_new' => _x( 'Add New', 'news' ),
	        'add_new_item' => _x( 'Add New News Item', 'news' ),
	        'edit_item' => _x( 'Edit News Item', 'news' ),
	        'new_item' => _x( 'New News Item', 'news' ),
	        'view_item' => _x( 'View News Item', 'news' ),
	        'search_items' => _x( 'Search News Items', 'news' ),
	        'not_found' => _x( 'No news items found', 'news' ),
	        'not_found_in_trash' => _x( 'No news items found in Trash', 'news' ),
	        'parent_item_colon' => _x( 'Parent News Item:', 'news' ),
	        'menu_name' => _x( 'News Items', 'news' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'hierarchical' => false,
	        'description' => 'Customer News Items',
	        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'genesis-cpt-archives-settings'),
	        'taxonomies' => array( 'genre' ),
	        'public' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'menu_position' => 20,
	        
	        'show_in_nav_menus' => false,
	        'publicly_queryable' => true,
	        'exclude_from_search' => true,
	        'has_archive' => true,
	        'query_var' => true,
	        'can_export' => true,
	        'rewrite' => array('slug'=>'about/press','with_front'=>false),
	        'capability_type' => 'post'
	    );
	
	    register_post_type( 'msd_news', $args );
	    flush_rewrite_rules();
	}
		
	function list_news_stories( $atts ) {
		extract( shortcode_atts( array(
		), $atts ) );
		
		$args = array( 'post_type' => 'msd_news', 'numberposts' => 0, );

		$items = get_posts($args);
	    foreach($items AS $item){ 
	    	$excerpt = $item->post_excerpt?$item->post_excerpt:msd_trim_headline($item->post_content);
	     	$publication_list .= '
	     	<li>
				'.date('F j, Y',strtotime($item->post_date)).'
	     		<h3><a href="'.get_permalink($item->ID).'">'.$item->post_title.' ></a></h3>
				<div class="clear"></div>
			</li>';
	
	     }
		
		return '<ul class="publication-list news-items">'.$publication_list.'</ul><div class="clear"></div>';
	}	

    function display_news_stories( $atts ) {
        extract( shortcode_atts( array(
        ), $atts ) );
        
        $args = array( 'post_type' => 'msd_news', 'numberposts' => 0, );

        $items = get_posts($args);
        foreach($items AS $item){ 
            $url = get_post_meta($item->ID,'_news_newsurl',1);
            $excerpt = $item->post_excerpt?$item->post_excerpt:msd_trim_headline($item->post_content);
            $link = strlen($url)>4?msdlab_http_sanity_check($url):get_permalink($item->ID);
            $background = msdlab_get_thumbnail_url($item->ID,'medium');
            $publication_list .= '
            <li>
                <div class="col-sm-8">
                    <div class="news-info">
                    <h3><a href="'.$link.'">'.$item->post_title.' ></a></h3>
                        <div>
                            '.date('F j, Y',strtotime($item->post_date)).'
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
    
         }
        
        return '<ul class="publication-list news-display">'.$publication_list.'</ul>';
    }   

        function get_news_items_for_team_member($team_id){
            global $news;
            $args = array( 
                'post_type' => 'msd_news', 
                'numberposts' => -1,
                'order' => 'DESC',
                'orderby' => 'post_date',
                'meta_query' => array(
                   array(
                       'key' => '_news_team_members',
                       'value' => '"'.$team_id.'"',
                       'compare' => 'LIKE',
                   )
               )
            );
            $the_news = get_posts($args);
            return($the_news);
        }

 
        function do_news_url($url) {
            global $post;
            if($post->post_type == 'msd_news'){
                global $news;
                $news->the_meta($post->ID);
                $newsurl = $news->get_the_value('newsurl');
                if ( strlen( $newsurl ) == 0 ){
                    return $url;
                } else {
                    return msdlab_http_sanity_check($newsurl);
                }
            }
            return $url;
        } 
        function do_news_url_display(){
            global $news, $post;$news->the_meta();
            $newsurl = $newsurl_metabox->get_the_value('newsurl');
            if ( strlen( $newsurl ) == 0 || !is_single())
                return;
        
            $newsurl = sprintf( '<a class="entry-newsurl" href="%s">View Article</a>', msdlab_http_sanity_check($newsurl) );
            echo $newsurl . "\n";
        }  
        
        function hide_single_news(){
            if(!is_single())
                return;
            if(get_query_var('post_type') == $this->cpt){
                global $wp_query;
                wp_redirect(get_post_meta($wp_query->post->ID,'_news_newsurl',true));
                return;
            } else {
                return;
            }
        }
}