<?php

/*
Plugin name: KC Widget Enhancements
Plugin URI: http://kucrut.org/2011/04/kc-widget-enhancements/
Description: Get the most of WordPress Widgets.
Version: 0.2
Author: Dzikri Aziz
Author URI: http://kucrut.org/
License: GPL v2
*/

class kcWidgetEnhancements {
	var $options = array();
	var $prefix = 'kc-widget-enhancements';


	function __construct() {
		# i18n
		load_plugin_textdomain( $this->prefix, false, $this->prefix . '/languages' );

		# Load helpers
		require_once( dirname(__FILE__) . '/helpers.php' );

		add_filter( 'kc_plugin_settings', array(&$this, 'settings') );
		add_action( 'init', array(&$this, 'init'), 13 );
	}


	function init() {
		$this->options();
		$this->magick();

		//add_action( 'admin_footer', array(&$this, 'dev') );
	}


	function components() {
		$components = array(
			'custom_id' => array(
				'o_lbl'	=> __('Custom widget ID', $this->prefix),
				'f_lbl'	=> __('Custom ID', $this->prefix)
			),
			'custom_classes' => array(
				'o_lbl'	=> __('Custom widget classes', $this->prefix),
				'f_lbl'	=> __('Additional Classes <small>(separate with spaces)</small>', $this->prefix)
			),
			'shortcode' => array(
				'o_lbl'	=> __('Enable shortcode on text widgets', $this->prefix)
			)
		);

		return $components;
	}


	function options() {
		if ( function_exists('kc_get_option') ) {
			$this->options = kc_get_option( $this->prefix );
		}
		else {
			$components = array();
			foreach ( array_keys( $this->components() ) as $c )
				$components[$c] = true;

			$options = array(
				'general' => array(
					'components' => $components
				)
			);

			$this->options = apply_filters( 'kcwe_options', $options );
		}
	}


	function settings( $groups ) {
		$components = array();
		foreach ( $this->components() as $c => $labels )
			$components[$c] = $labels['o_lbl'];

		$groups[] = array(
			'prefix'				=> $this->prefix,
			'menu_title'		=> __('KC Widget Enhancements', $this->prefix),
			'page_title'		=> __('KC Widget Enhancements Settings', $this->prefix),
			'options'				=> array(
				'general'		=> array(
					'id'			=> 'general',
					'title'		=> __('General', $this->prefix),
					'fields'	=> array(
						array(
							'id'			=> 'components',
							'title'		=> __('Components', $this->prefix),
							'type'		=> 'checkbox',
							'options'	=> $components
						)
					)
				)
			)
		);

		return $groups;
	}


	function magick() {
		$enhancements = $this->options['general']['components'];

		# 0. Enable shortcode on built-in text widgets
		if ( isset($enhancements['shortcode']) && $enhancements['shortcode'] )
			add_filter( 'widget_text', 'do_shortcode' );

		# 1. Custom widget ID / classes
		$customs = array();
		$components = $this->components();
		foreach ( array('custom_id', 'custom_classes') as $c ) {
			if ( isset($enhancements[$c]) && $enhancements[$c] )
				$customs[$c] = array( 'label' => $components[$c]['f_lbl'] );
		}

		if ( !empty($customs) ) {
			require_once( dirname(__FILE__) . '/custom_id_classes.php' );
			$enhance = new kcWidgetCustoms( $customs );
		}
	}


	function dev() {
		echo '<pre>';
		print_r( $this->options );
		echo '</pre>';
	}
}

$kcWidgetEnhancements = new kcWidgetEnhancements;

?>
