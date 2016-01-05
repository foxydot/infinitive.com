<?php
class MSDSpeakerCPT {
	public function MSDSpeakerCPT(){
		add_action( 'init', array(&$this,'register_cpt_speaker') );
		add_shortcode( 'list-speakers', array(&$this,'list_speakers') );
		add_filter( 'enter_title_here', array(&$this,'msd_change_default_title' ));
		add_action('admin_footer',array(&$this,'subtitle_footer_hook'));
		add_image_size('speaker_headshot',75,75,true);
	}
	
	function register_cpt_speaker() {
	
	    $labels = array( 
	        'name' => _x( 'Speakers', 'speaker' ),
	        'singular_name' => _x( 'Speaker', 'speaker' ),
	        'add_new' => _x( 'Add New', 'speaker' ),
	        'add_new_item' => _x( 'Add New Speaker', 'speaker' ),
	        'edit_item' => _x( 'Edit Speaker', 'speaker' ),
	        'new_item' => _x( 'New Speaker', 'speaker' ),
	        'view_item' => _x( 'View Speaker', 'speaker' ),
	        'search_items' => _x( 'Search Speakers', 'speaker' ),
	        'not_found' => _x( 'No speaker items found', 'speaker' ),
	        'not_found_in_trash' => _x( 'No speaker items found in Trash', 'speaker' ),
	        'parent_item_colon' => _x( 'Parent Speaker:', 'speaker' ),
	        'menu_name' => _x( 'Speakers', 'speaker' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'hierarchical' => false,
	        'description' => 'Speakers',
	        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'page-attributes'),
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
	        'rewrite' => array('slug'=>'speaker-items','with_front'=>false),
	        'capability_type' => 'post'
	    );
	
	    register_post_type( 'msd_speaker', $args );
	    flush_rewrite_rules();
	}
	
	function msd_change_default_title( $title ){
		$screen = get_current_screen();
	
		if  ( 'msd_speaker' == $screen->post_type ) {
			$title = 'Enter Speaker Name';
		}
	
		return $title;
	}

	function subtitle_footer_hook()
	{
		?><script type="text/javascript">
		jQuery('#titlediv').after(jQuery('#_speaker_title_metabox'));
		jQuery('#_speaker_title_metabox').after(jQuery('#_speakers_metabox'));
		</script><?php
	}
		
	function list_speakers( $atts ) {
		extract( shortcode_atts( array(
		), $atts ) );
		global $speaker_title,$speakers;
		$args = array( 'post_type' => 'msd_speaker', 'numberposts' => -1, 'orderby'=> 'menu_order' );

		$items = get_posts($args);
	    foreach($items AS $item){ 
	    	$speaker_title->the_meta($item->ID);
	    	$speakers->the_meta($item->ID);
	    	$image = wp_get_attachment_image_src( get_post_thumbnail_id($item->ID), 'speaker_headshot');
	     	$publication_list .= '
	     	<li>
	     		<div class="speaker-header" style="background-image:url('.$image[0].');">	
	     			<p><strong><a href="'.get_permalink($item->ID).'">'.$item->post_title.'</a></strong><br />
	     			'.$speaker_title->get_the_value('speaker_title').'</p>
	     		</div>
	     		<div class="speaker-body">
	     			<strong>Focus area:</strong> '.$speakers->get_the_value('focus-areas').'
	     		</div>
				<div class="clear"></div>
			</li>';
	
	     }
		
		return '<ul class="speaker-list speaker-items cols-3">'.$publication_list.'</ul><div class="clear"></div>';
	}	
}
$msd_speakers = new MSDSpeakerCPT;

// add a custom meta box
	$speaker_title = new WPAlchemy_MetaBox(array
	(
		'id' => '_speaker_title',
		'title' => 'Position/Title',
		'types' => array('msd_speaker'), 
		'context' => 'normal', 
		'priority' => 'high', 
		'template' => dirname(__FILE__).'/template/speaker_title.php',
		'mode' => WPALCHEMY_MODE_EXTRACT,
		'prefix' => '_msd_'
	));
	$speakers = new WPAlchemy_MetaBox(array
		(
		'id' => '_speakers',
		'title' => 'Speaker Info',
		'types' => array('msd_speaker'), // added only for pages and to custom post type "events"
		'context' => 'normal', // same as above, defaults to "normal"
		'priority' => 'high', // same as above, defaults to "high"
		'template' => dirname(__FILE__).'/template/speaker_info.php',
		'mode' => WPALCHEMY_MODE_EXTRACT,
		'prefix' => '_msd_'
	));
