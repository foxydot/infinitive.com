<?php
class MSDSessionCPT {
	public function MSDSessionCPT(){
		add_action( 'init', array(&$this,'register_cpt_session') );
		add_shortcode( 'list-sessions', array(&$this,'list_sessions') );
		add_filter( 'enter_title_here', array(&$this,'msd_change_default_title' ));
		add_action('admin_footer',array(&$this,'subtitle_footer_hook'));
		add_image_size('session_headshot',75,75,true);
	}
	
	function register_cpt_session() {
	
	    $labels = array( 
	        'name' => _x( 'Sessions', 'session' ),
	        'singular_name' => _x( 'Session', 'session' ),
	        'add_new' => _x( 'Add New', 'session' ),
	        'add_new_item' => _x( 'Add New Session', 'session' ),
	        'edit_item' => _x( 'Edit Session', 'session' ),
	        'new_item' => _x( 'New Session', 'session' ),
	        'view_item' => _x( 'View Session', 'session' ),
	        'search_items' => _x( 'Search Sessions', 'session' ),
	        'not_found' => _x( 'No session items found', 'session' ),
	        'not_found_in_trash' => _x( 'No session items found in Trash', 'session' ),
	        'parent_item_colon' => _x( 'Parent Session:', 'session' ),
	        'menu_name' => _x( 'Sessions', 'session' ),
	    );
	
	    $args = array( 
	        'labels' => $labels,
	        'hierarchical' => false,
	        'description' => 'Sessions',
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
	        'rewrite' => array('slug'=>'session-items','with_front'=>false),
	        'capability_type' => 'post'
	    );
	
	    register_post_type( 'msd_session', $args );
	    flush_rewrite_rules();
	}
	
	function msd_change_default_title( $title ){
		$screen = get_current_screen();
	
		if  ( 'msd_session' == $screen->post_type ) {
			$title = 'Enter Session Title';
		}
	
		return $title;
	}
	
	function subtitle_footer_hook()
	{
		?><script type="text/javascript">
		jQuery('#titlediv').after(jQuery('#_session_info_metabox'));
		</script><?php
	}
		
	function list_sessions( $atts ) {
		extract( shortcode_atts( array(
		), $atts ) );
		global $session_info,$tracks,$timeslots;
		$num_tracks = count($tracks);
		$num_timeslots = count($timeslots);
		
		$args = array( 'post_type' => 'msd_session', 'numberposts' => -1, 'orderby'=> 'menu_order' );		
		$items = get_posts($args);
		$session_data = array();
	    foreach($items AS $item){
	    	$session_info->the_meta($item->ID);
	    	$session_data[$session_info->get_the_value('timeslot')][$session_info->get_the_value('track')]['speaker'] = get_post($session_info->get_the_value('speaker'));
	    	$session_data[$session_info->get_the_value('timeslot')][$session_info->get_the_value('track')]['post'] = $item;
	     }
		//structure table
		//table header
		$headerrow = '<tr><th></th>';
		foreach($tracks AS $track){
			$headerrow .= '<th class="track">'.$track.'</th>';
		}
		$headerrow .= '</tr>';
		foreach($timeslots AS $timekey => $timeslot){
			$table .= '<tr>
	        		<th class="time">'.$timeslot.'</th>';
				foreach($tracks AS $trackkey=>$track){
					if($session_data[$timekey]['all']){
						$table .= '<td colspan="'.$num_tracks.'"><a href="'.get_permalink($session_data[$timekey]['all']['post']->ID).'">'.$session_data[$timekey]['all']['post']->post_title.'</a></td>';
						break 1;
					} else {
						$table .= '<td><a href="'.get_permalink($session_data[$timekey][$trackkey]['post']->ID).'">'.$session_data[$timekey][$trackkey]['post']->post_title.'</a></td>';
					}
				}
	        $table .= '</tr>';
	        if($timekey == 1){
				$table .= $headerrow;
			}
		}
		$width = (100-$num_tracks)/($num_tracks+1);
		$style = '<style>table.agenda th.track{width:'.$width.'%;}</style>';
	    //return
		return '<table class="agenda">'.$table.'</table><div class="clear"></div>'.$style;
	}	
}
$msd_sessions = new MSDSessionCPT;


// add a custom meta box
	$session_info = new WPAlchemy_MetaBox(array
	(
		'id' => '_session_info',
		'title' => 'Session Information',
		'types' => array('msd_session'), 
		'context' => 'normal', 
		'priority' => 'high', 
		'template' => dirname(__FILE__).'/template/session_info.php',
		'mode' => WPALCHEMY_MODE_EXTRACT,
		'prefix' => '_msd_'
	));

$tracks = array('Business Intelligence and Big Data','Digital Analytics','Digital Advertising Solutions','Digital CRM','Risk Management');
$timeslots = array('7:30AM - 8:45AM','8:45AM - 9:30AM','9:40AM - 10:40AM','11:00AM - 12:00PM','12:00PM - 1:20PM','1:35PM - 2:50PM','3:00PM - 4:00PM');