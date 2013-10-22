<?php
/**
 * @package MSD Publication CPT
 * @version 0.1
 */

class MSDCaseStudyCPT {

	public function MSDCaseStudyCPT(){}
	
    public function register_taxonomy_practice_area() {
    
        $labels = array( 
            'name' => _x( 'Practice areas', 'case-study' ),
            'singular_name' => _x( 'Practice area', 'case-study' ),
            'search_items' => _x( 'Search Practice areas', 'case-study' ),
            'popular_items' => _x( 'Popular Practice areas', 'case-study' ),
            'all_items' => _x( 'All Practice areas', 'case-study' ),
            'parent_item' => _x( 'Parent Practice area', 'case-study' ),
            'parent_item_colon' => _x( 'Parent Practice area:', 'case-study' ),
            'edit_item' => _x( 'Edit Practice area', 'case-study' ),
            'update_item' => _x( 'Update Practice area', 'case-study' ),
            'add_new_item' => _x( 'Add New Practice area', 'case-study' ),
            'new_item_name' => _x( 'New Practice area Name', 'case-study' ),
            'separate_items_with_commas' => _x( 'Separate Pratice areas with commas', 'case-study' ),
            'add_or_remove_items' => _x( 'Add or remove Pratice areas', 'case-study' ),
            'choose_from_most_used' => _x( 'Choose from the most used Pratice areas', 'case-study' ),
            'menu_name' => _x( 'Practice areas', 'case-study' ),
        );
    
        $args = array( 
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
    
            'rewrite' => array('slug'=>'infinitive-case-studies','with_front'=>false),
            'query_var' => true
        );
    
        register_taxonomy( 'msd_practice-area', array('msd_casestudy'), $args );
        flush_rewrite_rules();
    }
    
	function register_cpt_casestudy() {
	
	    $labels = array( 
	        'name' => _x( 'Case Studies', 'case-study' ),
	        'singular_name' => _x( 'Case Study', 'case-study' ),
	        'add_new' => _x( 'Add New', 'case-study' ),
	        'add_new_item' => _x( 'Add New Case Study', 'case-study' ),
	        'edit_item' => _x( 'Edit Case Study', 'case-study' ),
	        'new_item' => _x( 'New Case Study', 'case-study' ),
	        'view_item' => _x( 'View Case Study', 'case-study' ),
	        'search_items' => _x( 'Search Case Studies', 'case-study' ),
	        'not_found' => _x( 'No case studies found', 'case-study' ),
	        'not_found_in_trash' => _x( 'No case studies found in Trash', 'case-study' ),
	        'parent_item_colon' => _x( 'Parent Case Study:', 'case-study' ),
	        'menu_name' => _x( 'Case Studies', 'case-study' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'hierarchical' => false,
	        'description' => 'Case Studies',
	        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail'),
	        'taxonomies' => array( 'genre' ),
	        'public' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'menu_position' => 20,
	        
	        'show_in_nav_menus' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => false,
	        'has_archive' => true,
	        'query_var' => true,
	        'can_export' => true,
	        'rewrite' => array('slug'=>'infinitive-case-study','with_front'=>false),
	        'capability_type' => 'post'
	    );
	
	    register_post_type( 'msd_casestudy', $args );
	    flush_rewrite_rules();
	}
		
	function list_case_studies( $atts ) {
		global $subtitle,$documents;
		extract( shortcode_atts( array(
		), $atts ) );
		
		$args = array( 'post_type' => 'msd_casestudy', 'numberposts' => 0, );

		$items = get_posts($args);
	    foreach($items AS $item){ 
	    	$subtitle->the_meta($item->ID);
            $documents->the_meta($item->ID);
	    	$excerpt = $item->post_excerpt?$item->post_excerpt:msd_trim_headline($item->post_content);
	     	$publication_list .= '
	     	<li>
				<strong><a href="'.get_permalink($item->ID).'">'.$item->post_title.'</a>:</strong> '.$subtitle->get_the_value('subtitle').'
				<div class="clear"></div>
			</li>';
	
	     }
		
		return '<ul class="publication-list case-studies">'.$publication_list.'</ul><div class="clear"></div>';
	}	
}

	

    add_action( 'init', array('MSDCaseStudyCPT','register_taxonomy_practice_area') );
    add_action( 'init', array('MSDCaseStudyCPT','register_cpt_casestudy') );
	add_shortcode( 'case-studies', array('MSDCaseStudyCPT','list_case_studies') );