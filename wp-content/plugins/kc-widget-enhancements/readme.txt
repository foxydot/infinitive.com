=== Plugin Name ===
Contributors: kucrut
Donate link: http://kucrut.org/
Tags: widget
Requires at least: 2.8
Tested up to: 3.1
Stable tag: 0.2

Get the most of WordPress widgets

== Description ==

**Important!**
This plugin is being retired. Please install [Widget Attributes](http://kucrut.org/widget-attributes/) instead.

This plugin provides enhancements for widgets, such as the ability to set custom ID and/or classes.

== Installation ==

1. Use standard WordPress plugin installation or upload the `kc-widget-enhancements` directory to your `wp-content/plugins` directory
2. Activate the plugin through the 'Plugins' menu
3. Read the FAQ section on readme.txt if you need to enable only certain components

== Frequently Asked Questions ==

= Can I only activate components I need? =
##### Short answer:
Sure!

##### Long Answer:
By default, all components are enabled. If you have [KC Settings plugin] (http://wordpress.org/extend/plugins/kc-settings/) installed and activated, you'll have the luxury to select the components you need by visiting *Settings* &raquo; *KC Widget Enhancements* in you dashboard.

If you don't want to use KC Setting plugin but still want to enable only certain components, you'll need to this block of code to your theme's `functions.php` file and change each unwanted component's value to `false`:

`
function my_kcwe_options( $options ) {
	$options['general']['components'] = array(
		'custom_id'				=> true,
		'custom_classes'	=> true,
		'shortcode'				=> true
	);

	return $options;
}
add_filter( 'kcwe_options', 'my_kcwe_options' );
`

Options saved by KC Settings will always get the highest priority when the plugin is active.

== Screenshots ==
1. Custom ID/classes inputs on text widget
1. Custom ID/classes inputs on custom menu widget


== Changelog ==

= 0.1 =
* Initial release

