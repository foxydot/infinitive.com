<?php

/**
 * Remove unwanted characters from custom classes
 *
 * @param string $input Classes string to process
 * @return string Sanitized html classes
 */
function kc_sanitize_html_classes( $input ) {
	if ( strpos($input, ' ') )
		$_classes = explode( ' ', $input );
	else
		$_classes = array( $input );

	$classes = array();
	foreach ( $_classes as $c )
		$classes[] = sanitize_html_class( $c );

	return join( ' ', $classes );
}


?>