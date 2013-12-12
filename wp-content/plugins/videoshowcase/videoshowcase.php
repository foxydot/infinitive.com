<?php

/**
 *
 * Plugin Name: Video Showcase
 * Plugin URI: http://ithemes.com/purchase/displaybuddy/
 * Description: DisplayBuddy Series - Embed thickbox videos with image links.
 * Version: 1.1.57
 * Author: iThemes.com
 * Author URI: http://ithemes.com/
 * iThemes Package: videoshowcase
 *
 *
 * Installation:
 *
 * 1. Download and unzip the latest release zip file.
 * 2. If you use the WordPress plugin uploader to install this plugin skip to step 4.
 * 3. Upload the entire plugin directory to your `/wp-content/plugins/` directory.
 * 4. Activate the plugin through the 'Plugins' menu in WordPress Administration.
 *
 * Usage:
 *
 * 1. Navigate to the DisplayBuddy menu in the Wordpress Administration Panel.
 * 2. Go to the Video Showcase section.
 * 3. Create a group.
 * 4. Click on a group to change group settings and add videos.
 * 5. Display Video Showcase by adding to widget areas or use shortcode.
 *
 */


if (!class_exists("PluginBuddyVideoShowcase")) {
	class PluginBuddyVideoShowcase {
		var $_wp_minimum = '3.2.1';
		var $_var = 'pluginbuddy-videoshowcase'; // Format: pluginbuddy-pluginnamehere. All lowecase, no dashes.
		var $_name = 'Video Showcase'; // front end plugin name.
		var $_series = 'DisplayBuddy'; // Series name if applicable.
		var $url = 'http://ithemes.com/purchase/displaybuddy/';
		var $_timeformat = '%b %e, %Y, %l:%i%p';	// Mysql time format.
		var $_timestamp = 'M j, Y, g:iA';		// PHP timestamp format.
		var $_defaults = array(
			'groups'	=>	array(),
			'access'	=>	'activate_plugins',
		);
		var $_groupdefaults = array(
			'videos'		=>	array(),
			'order'			=>	array(),
			'background-color'	=>	'FFFFFF',
			'transparent'		=>	'0',
			'tlink'			=>	'none',
			'related'		=>	'false'
		);
		var $_instance = '';
		// Default constructor. This is run when the plugin first runs.
		function PluginBuddyVideoShowcase() {
			$this->_pluginPath = dirname( __FILE__ );
			$this->_pluginRelativePath = ltrim( str_replace( '\\', '/', str_replace( rtrim( ABSPATH, '\\\/' ), '', $this->_pluginPath ) ), '\\\/' );
			$this->_pluginURL = site_url() . '/' . $this->_pluginRelativePath;
			if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) { $this->_pluginURL = str_replace( 'http://', 'https://', $this->_pluginURL ); }
			$selflinkvar = explode( '?', $_SERVER['REQUEST_URI'] );
			$this->_selfLink = array_shift( $selflinkvar ) . '?page=' . $this->_var;
			
			require_once( dirname( __FILE__ ) . '/classes/widget.php' );
			// load image group sizes
			$this->load();
			$gpath = $this->_options['groups'];
			foreach($this->_options['groups'] as $id => $gar) {
				add_image_size('pb_videoshowcase_' . $gpath[$id]['width'] . 'x' . $gpath[$id]['height'], $gpath[$id]['width'], $gpath[$id]['height'], true);
			}
			add_image_size('default_thumb', 120, 90, true);
			
			if ( is_admin() ) { // Runs when an admin is in the dashboard.
				require_once( $this->_pluginPath . '/lib/medialibrary/load.php' );
				add_action( 'init', array( &$this, 'init_medialibrary' ) );
				require_once( $this->_pluginPath . '/classes/admin.php' );
				register_activation_hook( $this->_pluginPath, array( &$this, 'activate' ) );
			} else { // Runs when in non-dashboard parts of the site.
				add_shortcode( 'pb_videoshowcase', array( &$this, 'shortcode' ) );
				add_action( $this->_var . '-widget', array( &$this, 'widget' ), 10, 2 ); // Add action to run widget function.
			}
			add_action('wp_ajax_vscdoom', array(&$this, 'vscdoom') );
			add_action('wp_ajax_nopriv_vscdoom', array(&$this, 'vscdoom') );
		}
		
		// Run some code when plugin is activated in dashboard.
		// Require custom media uploader
		function init_medialibrary() {
			global $wp_version;
			// Check for Wordpress Version for media library.
			if ( version_compare( $wp_version, $this->_wp_minimum, '<=' ) ) {
				$media_lib_version =  array(
						'select_button_text'			=>			'Select this Image',
						'tabs'					=>			array( 'pb_uploader' => 'Upload Images to Media Library', 'library' => 'Select from Media Library' ),
						'show_input-image_alt_text'		=>			false,
						'show_input-url'			=>			false,
						'show_input-image_align'		=>			false,
						'show_input-image_size'			=>			false,
						'show_input-description'		=>			true,
						'custom_help-caption'			=>			'Overlaying text to be displayed if captions are enabled.',
						'custom_help-description'		=>			'Optional URL for this image to link to.',
						'custom_label-description'		=>			'Link URL',
						'use_textarea-caption'			=>			true,
						'use_textarea-description'		=>			false,
					);
			}
			else {
				$media_lib_version =  array(
						'select_button_text'			=>			'Select this Image',
						'tabs'					=>			array( 'type' => 'Upload Images to Media Library', 'library' => 'Select from Media Library' ),
						'show_input-image_alt_text'		=>			false,
						'show_input-url'			=>			false,
						'show_input-image_align'		=>			false,
						'show_input-image_size'			=>			false,
						'show_input-description'		=>			true,
						'custom_help-caption'			=>			'Overlaying text to be displayed if captions are enabled.',
						'custom_help-description'		=>			'Optional URL for this image to link to.',
						'custom_label-description'		=>			'Link URL',
						'use_textarea-caption'			=>			true,
						'use_textarea-description'		=>			false,
					);
			}
			$this->_medialibrary = new IT_Media_Library( $this, $media_lib_version );
		}
		
		// FUNCTIONS TO CALL FRONT END SCRIPTS & STYLES
		function vsc_scripts() {
		
			if ( !wp_script_is( 'videoshowcase_script' ) ) {
				wp_enqueue_script( 'videoshowcase_script', $this->_pluginURL . "/js/jquery.pbvideosc.js", array('jquery'));
				wp_print_scripts( 'videoshowcase_script' );
			}
			
		}
		
		function vsc_styles() {
		
			if ( !wp_style_is( 'videoshowcase_style' ) ) {
				wp_enqueue_style('videoshowcase_style', $this->_pluginURL . "/css/vsc.css");
				wp_print_styles( 'videoshowcase_style' );
			}
			
		}
		
		
		/**
		 *	alert()
		 *
		 *	Displays a message to the user at the top of the page when in the dashboard.
		 *
		 *	$message		string		Message you want to display to the user.
		 *	$error			boolean		OPTIONAL! true indicates this alert is an error and displays as red. Default: false
		 *	$error_code		int			OPTIONAL! Error code number to use in linking in the wiki for easy reference.
		 */
		function alert( $message, $error = false, $error_code = '' ) {
			echo '<div id="message" class="';
			if ( $error == false ) {
				echo 'updated fade';
			} else {
				echo 'error';
			}
			if ( $error_code != '' ) {
				$message .= '<p><a href="http://ithemes.com/codex/page/' . $this->_name . ':_Error_Codes#' . $error_code . '" target="_new"><i>' . $this->_name . ' Error Code ' . $error_code . ' - Click for more details.</i></a></p>';
				$this->log( $message . ' Error Code: ' . $error_code, true );
			}
			echo '"><p><strong>'.$message.'</strong></p></div>';
		}
		
		/**
		 * TOOLTIP FUNCTION
		 * Displays a message to the user when they hover over the question mark.
		**/
		function tip( $message, $title = '', $echo_tip = true ) {
			$tip = ' <a class="pluginbuddy_tip" title="' . $title . ' - ' . $message . '"><img src="' . $this->_pluginURL . '/images/pluginbuddy_tip.png" alt="(?)" /></a>';
			if ( $echo_tip === true ) {
				echo $tip;
			} else {
				return $tip;
			}
		}
		
		
		/**
		 * activate()
		 *
		 * Run on plugin activation. Useful for setting up initial stuff.
		 *
		 */
		function activate() {
		}
		
		
		// FRONT END DISPLAY //////////////////////
		
		function shortcode($atts) {
			$group = $atts['group'];
			
			// Set Args
			$max   = isset( $atts['max'] ) ? $atts['max'] : 'all';
			$align = isset( $atts['align'] ) ? $atts['align'] : 'center';
			$order = isset( $atts['order'] ) ? 'random': 'ordered';
			$theme = isset( $atts['theme'] ) ? $atts['theme'] : 'default';
			
			return $this->_display_showbox($group, $align, $max, $order, $theme);
		}
		
		function widget($instance) {
			$group = $instance['group'];
			$align = $instance['align'];
			$max   = $instance['max'];
			$order = $instance['order'];
			$theme = $instance['theme'];
			
			echo $this->_display_showbox($group, $align, $max, $order, $theme);
		}
		
		
		function _display_showbox($group, $align, $max, $order, $theme) {
			$this->load();
			
			$this->_instance++;
			
			$this->vsc_scripts();
			
			$this->vsc_styles();
			
			$gpath = $this->_options['groups'][$group];
			
			if($max == 'all') {
				$max = count($gpath['videos']);
			} else if ( $max > ( count( $gpath['videos'] ) ) ) {
				$max = count($gpath['videos']);		
			} else {
				$max = $max;
			}
			
			$return = '';
			
			// ORDER FILTER
			if ( $order === 'random' ) {
				$preorder = (array)( array_rand( (array) $gpath['order'], $max ) );
				for($i=0; $i<$max; $i++){
					$neworder[$i] = $gpath['order'][$preorder[$i]];
				}
				shuffle( $neworder );
			} else {
				$neworder = array_values((array)$gpath['order']);
			}
			
			// HORIZONTAL ALIGNMENT
			$alignment = ( 'none' === $align ) ? '': ' style="text-align:' . $align . ';"';

			// CSS VARS
			$alignment = ( 'none' === $align ) ? '' : 'text-align: ' . esc_attr( $align ) . ';';
			$height    = 'height: ' . esc_attr( $gpath['height'] ) . 'px;';
			$width     = 'width: ' . esc_attr( $gpath['width'] ) . 'px;';
			$tvert     = 'vertical-align: top;';

			if ( isset( $gpath['tlink'] ) ) {
				if( $gpath['tlink'] == 'above' ) {
					$tvert = 'vertical-align: bottom;';
				} else if( $gpath['tlink'] == 'both' ) {
					$tvert = 'vertical-align: middle;';
				} else {
					$tvert = 'vertical-align: top;';
				}
			}

			// Print CSS
			$return .= '<style type="text/css">';
			$return .=     '#videoshowcaseid-' . esc_attr( $this->_instance ) . ' {';
			$return .=          $alignment;
			$return .=     '}';
			$return .=     '#videoshowcaseid-' . esc_attr( $this->_instance ) . ' .vsc-video-container {';
			$return .=          $width;
			$return .=          $tvert;
			$return .=     '}';
			$return .=     '#videoshowcaseid-' . esc_attr( $this->_instance ) . ' .vsc-video-container a,';
			$return .=     '#videoshowcaseid-' . esc_attr( $this->_instance ) . ' .vsc-video-container a img {';
			$return .=          $width;
			$return .=          $height;
			$return .=     '}';
			$return .= '</style>';
			
			// START CONTAINER
			$return .= '<div id="videoshowcaseid-' . $this->_instance . '" class="videoshowcase">';

	
				// TEST CORRECT CALL WITH MAX ADDED IN
				for($i=0; $i<$max; $i++){
					$vidnum    = $neworder[$i];
					$video     = $gpath['videos'][$vidnum];
					$vimage    = empty( $video['vimage'] ) ? false : $video['vimage'];
					$imagedata = wp_get_attachment_image_src( $vimage, 'pb_videoshowcase_' . $gpath['width'] . 'x' . $gpath['height'] );
					
					$return .= '<div id="vsc-video' . $this->_instance . '-' . $i . '" class="vsc-video-container">';
					$hiderelated = null;
					if ($video['vsourc'] == 'youtube') {
					if ($gpath['related'] == 'true') {
					$hiderelated = '?rel=0';
					} else {
					$hiderelated = '?rel=1';
					}
					}
					if (isset($gpath['tlink'])) {
						if(($gpath['tlink'] == 'above') || ($gpath['tlink'] == 'both')) {
							if ($video['vsourc'] == 'custom') {
								$return .= '<a href="' . admin_url('admin-ajax.php') . '?action=vscdoom&movie=' . $video['vurl'] . '" rel="' . $this->_var . "-" . $this->_instance . '" title="' . stripslashes($video['vtitle']) . '">' . stripslashes($video['vtitle']) . '</a><br/>';
							} else {
								
								$return .= '<a href="' . $video['vurl'] . '" rel="' . $this->_var . "-" . $this->_instance . '" title="' . stripslashes($video['vtitle']) . '">' . stripslashes($video['vtitle']) . '</a><br/>';
							}
						}
					}
					if ($video['vsourc'] == 'custom' || $video['vsourc'] == 'youtube' || $video['vsourc'] == 'quick') {
						$return .= '<a href="' . admin_url('admin-ajax.php') . '?action=vscdoom&movie=' . $video['vurl'] . $hiderelated . '" rel="' . $this->_var . "-" . $this->_instance . '" title="' . stripslashes($video['vtitle']) . '"><img src="' . $imagedata['0'] . '" alt="' . stripslashes($video['vtitle']) . '" /></a>';
					}
					else {

						$video_url = preg_replace( '/http:\/\/(.)+\//i', 'http://player.vimeo.com/video/', $video['vurl'] );
						
						$return .= '<a href="' . $video_url . '" rel="' . $this->_var . "-" . $this->_instance . '" title="' . stripslashes($video['vtitle']) . '"><img src="' . $imagedata['0'] . '" alt="' . stripslashes($video['vtitle']) . '" /></a>';
					}
					if (isset($gpath['tlink'])) {
						if(($gpath['tlink'] == 'below') || ($gpath['tlink'] == 'both')) {
							if ($video['vsourc'] == 'custom') {
								$return .= '<br/><a href="' . admin_url('admin-ajax.php') . '?action=vscdoom&movie=' . $video['vurl'] . '" rel="' . $this->_var . "-" . $this->_instance . '" title="' . stripslashes($video['vtitle']) . '">' . stripslashes($video['vtitle']) . '</a>';
							} else {
								$return .= '<br/><a href="' . $video['vurl'] . '" rel="' . $this->_var . "-" . $this->_instance . '" title="' . stripslashes($video['vtitle']) . '">' . stripslashes($video['vtitle']) . '</a>';
							}
						}
					}
					$return .= '</div>';
				}
				
			$return .= '</div>';
			
			// INSTANCE JAVASCRIPT VARIABLES
			$vsctheme = "'" . $theme . "'";
			$marker = "'" . $this->_var . "-" . $this->_instance . "'";
			$related = "'false'";
			if( isset($gpath['related']) ) {
				$related = "'" . $gpath['related'] . "'";
			}
			$pluginpath = "'" . $this->_pluginURL . "'";
			
			$return .= '
				<script type="text/javascript" charset="utf-8">
					jQuery(document).ready(function(){
						jQuery("a[rel^=' . $marker . ']").pbvideosc({
							theme: ' . $vsctheme . ',
							norelated: ' . $related . ',
							pluginpath: ' . $pluginpath . '
						});
					});
				</script>
			';

			
			return $return;
			
		}
		
		// Ajax custom video iframe
		function vscdoom() {
			?>
			<html>
			<body style="padding:0,margin:0">
			<?php
			$pluginpath = "'" . $this->_pluginURL . "'";
			$height     = isset( $_GET['height'] ) ? $_GET['height'] : '';
			$width      = isset( $_GET['width'] ) ? $_GET['width'] : '';
			$url        = empty( $_GET['movie'] ) ? '' : $_GET['movie'];
			$url        = str_replace( parse_url( $url, PHP_URL_PATH ), rawurlencode( parse_url( $url, PHP_URL_PATH ) ), $url );
			$url        = str_replace( parse_url( $url, PHP_URL_QUERY ), rawurlencode( parse_url( $url, PHP_URL_QUERY ) ), $url );
			$test = '<script type="text/javascript" src="' . $this->_pluginURL . '/js/swfobject.js"></script>
				<script type="text/javascript">
					var flashvars = {
						src: "' . esc_url( $url ) . '",
						autostart: "true",
						themeColor: "0395d3",
						mode: "sidebyside",
						scaleMode: "fit",
						frameColor: "333333",
						fontColor: "cccccc",
						link: "",embed: ""
					};
					var params = {allowFullScreen: "true"};
					var attributes = {id: "myPlayer",name: "myPlayer"};
					swfobject.embedSWF("' . $this->_pluginURL . '/js/AkamaiFlashPlayer.swf","myPlayerGoesHere","' . htmlentities($width) . '","' . htmlentities($height) . '","9.0.0","' . $this->_pluginURL . '/js/expressInstall.swf",flashvars,params,attributes);
				</script>
				<div id="myPlayerGoesHere">
					<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>
				</div>';
			echo $test;
			?>
			</body>
			</html>
			<?php
			die();
		}
		

		// OPTIONS STORAGE //////////////////////
		
		
		function save() {
			add_option($this->_var, $this->_options, '', 'no'); // 'No' prevents autoload if we wont always need the data loaded.
			update_option($this->_var, $this->_options);
			return true;
		}
		
		
		function load() {
			$this->_options=get_option($this->_var);
			$options = array_merge( $this->_defaults, (array)$this->_options );

			if ( $options !== $this->_options ) {
				// Defaults existed that werent already in the options so we need to update their settings to include some new options.
				$this->_options = $options;
				$this->save();
			}

			return true;
		}
	} // End class

	$PluginBuddyVideoShowcase = new PluginBuddyVideoShowcase(); // Create instance
	//require_once( dirname( __FILE__ ) . '/classes/widget.php');
}


function ithemes_videoshowcase_updater_register( $updater ) {
	$updater->register( 'videoshowcase', __FILE__ );
}

add_action( 'ithemes_updater_register', 'ithemes_videoshowcase_updater_register' );

require( dirname( __FILE__ ) . '/lib/updater/load.php' );


// Custom image resize code by iThemes.com Dustin Bolton - Iteration 20 - 3/24/11
if ( !function_exists( 'ithemes_filter_image_downsize' ) ) {
	add_filter( 'image_downsize', 'ithemes_filter_image_downsize', 10, 3 ); // Latch in when a custom image size is called.
	add_filter( 'intermediate_image_sizes_advanced', 'ithemes_filter_image_downsize_blockextra', 10, 3 ); // Custom image size blocker to block generation of thumbs for sizes other sizes except when called.
	function ithemes_filter_image_downsize( $result, $id, $size ) {
		global $_ithemes_temp_downsize_size;
		if ( is_array( $size ) ) { // Dont bother with non-named sizes. Let them proceed normally. We need to set something to block the blocker though.
			$_ithemes_temp_downsize_size = 'array_size';
			return;
		}
		
		// Store current meta information and size data.
		global $_ithemes_temp_downsize_meta;
		$_ithemes_temp_downsize_size = $size;
		$_ithemes_temp_downsize_meta = wp_get_attachment_metadata( $id );
		
		if ( !is_array( $_ithemes_temp_downsize_meta ) ) { return $result; }
		if ( !is_array( $size ) && !empty( $_ithemes_temp_downsize_meta['sizes'][$size] ) ) {
			$data = $_ithemes_temp_downsize_meta['sizes'][$size];
			// Some handling if the size defined for this size name has changed.
			global $_wp_additional_image_sizes;
			if ( empty( $_wp_additional_image_sizes[$size] ) ) { // Not a custom size so return data as is.
				$img_url = wp_get_attachment_url( $id );
				$img_url = path_join( dirname( $img_url ), $data['file'] );
				return array( $img_url, $data['width'], $data['height'], true );
			} else { // Custom size so only return if current image file dimensions match the defined ones.
				$img_url = wp_get_attachment_url( $id );
				$img_url = path_join( dirname( $img_url ), $data['file'] );
				return array( $img_url, $data['width'], $data['height'], true );
			}
		}
		
		require_once( ABSPATH . '/wp-admin/includes/image.php' );
		$uploads = wp_upload_dir();
		if ( !is_array( $uploads ) || ( false !== $uploads['error'] ) ) { return $result; }
		$file_path = "{$uploads['basedir']}/{$_ithemes_temp_downsize_meta['file']}";
		
		// Image is resized within the function in the following line.
		$temp_meta_information = wp_generate_attachment_metadata( $id, $file_path ); // triggers filter_image_downsize_blockextra() function via filter within. generate images. returns new meta data for image (only includes the just-generated image size).
		$meta_information = $_ithemes_temp_downsize_meta; // Get the old original meta information.
		
		if ( !empty( $temp_meta_information['sizes'][$_ithemes_temp_downsize_size] ) ) { // This named size returned size dimensions in the size array key so copy it.
			$meta_information['sizes'][$_ithemes_temp_downsize_size] = $temp_meta_information['sizes'][$_ithemes_temp_downsize_size]; // Merge old meta back in.
			wp_update_attachment_metadata( $id, $meta_information ); // Update image meta data.
		}
		
		unset( $_ithemes_temp_downsize_size ); // Cleanup.
		unset( $_ithemes_temp_downsize_meta );
		
		return $result;
	}
	/* Prevents image resizer from resizing ALL images; just the currently requested size. */
	function ithemes_filter_image_downsize_blockextra( $sizes ) {
		//return $sizes;
		global $_ithemes_temp_downsize_size;
		if ( empty( $_ithemes_temp_downsize_size ) || ( $_ithemes_temp_downsize_size == 'array_size' ) ) { // Dont bother with non-named sizes. Let them proceed normally.
			return $sizes;
		}
		if ( !empty( $sizes[$_ithemes_temp_downsize_size] ) ) { // unavailable size so don't set.
			$sizes = array( $_ithemes_temp_downsize_size => $sizes[$_ithemes_temp_downsize_size] ); // Strip out all extra meta data so only the requested size will be generated.
		}
		return $sizes;
	}
}
?>
