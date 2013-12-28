<?php 
global $project_info,$location_info,$client_info,$additional_files,$contact_info,$additional_info,$primary_practice_area;
global $subtitle,$documents,$video;

$video = new WPAlchemy_MetaBox(array
    (
        'id' => '_video',
        'title' => 'Video Information',
        'types' => array('msd_video'),
        'context' => 'normal',
        'priority' => 'high',
        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/video-information.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_video_' // defaults to NULL
    ));

$subtitle = new WPAlchemy_MetaBox(array
    (
        'id' => '_subtitle',
        'title' => 'Subtitle',
        'types' => array('post','page','msd_casestudy','msd_news'), 
        'context' => 'normal', 
        'priority' => 'high', 
        'template' => $msd_cpt_path.'/template/subtitle.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_subtitle_' // defaults to NULL
    ));

$documents = new WPAlchemy_MetaBox(array
    (
        'id' => '_documents',
        'title' => 'Documents',
        'types' => array('msd_publication','msd_casestudy','msd_news'), // added only for pages and to custom post type "events"
        'context' => 'normal', // same as above, defaults to "normal"
        'priority' => 'high', // same as above, defaults to "high"
        'template' => $msd_cpt_path.'/template/attach_file.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_docs_' // defaults to NULL
    ));

$project_info = new WPAlchemy_MetaBox(array
    (
        'id' => '_project_information',
        'title' => 'Project Information',
        'types' => array('project'),
        'context' => 'normal',
        'priority' => 'high',
        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/project-information.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_project_' // defaults to NULL
    ));
    
$client_info = new WPAlchemy_MetaBox(array
    (
        'id' => '_Client_information',
        'title' => 'Client Information',
        'types' => array('project'),
        'context' => 'normal',
        'priority' => 'high',
        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/client-information.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_client_' // defaults to NULL
    ));
    
$location_info = new WPAlchemy_MetaBox(array
	(
		'id' => '_location_information',
		'title' => 'Location Information',
		'types' => array('location','project'),
		'context' => 'normal',
		'priority' => 'high',
		'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/location-information.php',
		'autosave' => TRUE,
		'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
		'prefix' => '_location_' // defaults to NULL
	));
    
$additional_files = new WPAlchemy_MetaBox(array
    (
        'id' => '_additional_files',
        'title' => 'Additional Files',
        'types' => array('project'),
        'context' => 'normal',
        'priority' => 'high',
        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/additional-files.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_files_' // defaults to NULL
    ));
    
$contact_info = new WPAlchemy_MetaBox(array
    (
        'id' => '_contact_info',
        'title' => 'Contact Info',
        'types' => array('location','team_member'), // added only for pages and to custom post type "events"
        'context' => 'normal', // same as above, defaults to "normal"
        'priority' => 'high', // same as above, defaults to "high"
        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/contact-info.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_team_member_' // defaults to NULL
    ));

$additional_info = new WPAlchemy_MetaBox(array
    (
        'id' => '_additional_information',
        'title' => 'Additional Information',
        'types' => array('team_member'),
        'context' => 'normal',
        'priority' => 'high',
        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/additional-information.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_team_member_' // defaults to NULL
    ));
        
$primary_practice_area = new WPAlchemy_MetaBox(array
    (
        'id' => '_primary_practice_area',
        'title' => 'Primary Practice Area',
        'types' => array('team_member'),
        'context' => 'side',
        'priority' => 'low',
        'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/primary-practice-area.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_team_member_' // defaults to NULL
    ));