<?php

class kcWidgetCustoms {
	function __construct( $customs ) {
		$this->customs = $customs;
		$this->actions_n_filters();
	}


	/**
	 * Add input field to widget configuration form
	 *
	 */
	function widget_form( $instance, $widget ) {
		$row = '';
		foreach ( $this->customs as $c => $v ) {
			if ( !isset($instance[$c]) )
				$instance[$c] = '';

			$row .= "<p>\n";
			$row .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-{$c}'>{$v['label']}</label>\n";
			$row .= "\t<input type='text' name='widget-{$widget->id_base}[{$widget->number}][{$c}]' id='widget-{$widget->id_base}-{$widget->number}-{$c}' class='widefat' value='{$instance[$c]}'/>\n";
			$row .= "</p>\n";
		}

		echo $row;
		return $instance;
	}


	/**
	 * Add custom classes to widget options
	 *
	 */
	function widget_update( $instance, $new_instance ) {
		foreach ( $this->customs as $c => $v  ) {
			# 0. Add/Update
			if ( $new_instance[$c] != '' )
				$instance[$c] = trim( apply_filters( "kcwe_sanitize_{$c}", $new_instance[$c] ) );

			# 2. Delete
			else
				unset( $instance[$c] );
		}

		return $instance;
	}


	/**
	 * Modify widget markup to add custom ID/classes
	 *
	 */
	function dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;
		$widget_id	= $params[0]['widget_id'];
		$widget_obj	= $wp_registered_widgets[$widget_id];

		if ( !isset($widget_obj['callback'][0]) || !is_object($widget_obj['callback'][0]) )
			return $params;

		$widget_opt	= get_option($widget_obj['callback'][0]->option_name);
		$widget_num	= $widget_obj['params'][0]['number'];

		# 0. Custom ID
		if ( isset($this->customs['custom_id']) && isset($widget_opt[$widget_num]['custom_id']) )
			$params[0]['before_widget'] = preg_replace( '/id=".*?"/', "id=\"{$widget_opt[$widget_num]['custom_id']}\"", $params[0]['before_widget'], 1 );

		# 1. Custom Classes
		if ( isset($this->customs['custom_classes']) && isset($widget_opt[$widget_num]['custom_classes']) )
			$params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['custom_classes']} ", $params[0]['before_widget'], 1 );

		return $params;
	}


	/**
	 * WordPress Magic
	 *
	 */
	function actions_n_filters() {
		# Add necessary input on widget configuration form
		add_filter( 'widget_form_callback', array(&$this, 'widget_form'), 10, 2 );

		# Update widget with our custom options
		add_filter( 'widget_update_callback', array(&$this, 'widget_update'), 10, 2 );

		# Modify widget markup
		add_filter( 'dynamic_sidebar_params', array(&$this, 'dynamic_sidebar_params') );

		# Sanitize ID & classes
		add_filter( 'kcwe_sanitize_custom_id', 'sanitize_html_class' );
		add_filter( 'kcwe_sanitize_custom_classes', 'kc_sanitize_html_classes' );
	}
}
?>