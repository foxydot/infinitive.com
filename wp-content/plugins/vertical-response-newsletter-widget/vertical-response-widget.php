<?php
/*
Plugin Name: VerticalResponse Widget
Plugin URI: http://seodenver.com/vertical-response-widget/
Description: Adds a VerticalResponse signup form to your sidebar without touching code.
Author: Katz Web Services, Inc.
Version: 1.6
Author URI: http://www.katzwebservices.com
*/

/*
Copyright 2012 Katz Web Services, Inc.  (email: info@katzwebservices.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

add_action('plugins_loaded', 'kwd_vr_plugins_loaded');

function kwd_vr_plugins_loaded() {
	global $kws_vr_version; $kws_vr_version = '1.6';
	
	add_action('widgets_init', 'vr_widget_init');
	add_shortcode('verticalresponse', 'kwd_vr_shortcode');
	add_shortcode('VerticalResponse', 'kwd_vr_shortcode');
}

function vr_widget_init() {
	if(!function_exists('register_widget_control')) { return; }
	wp_register_sidebar_widget('vertical-response', 'VerticalResponse', 'widget_vr', array('description' => 'Add a VerticalResponse signup form.'));
	wp_register_widget_control('vertical-response', 'VerticalResponse', 'widget_vr_options', array('width' => 500));
}
  
if(!function_exists('widget_vr')) {
// Vertical Response Plugin WIDGET
function widget_vr($args = false, $echo = true, $atts = false) {
		global $kws_vr_version, $number_of_vr_widgets;

		$output = '';
		$number_of_vr_widgets++;

		$defaults = apply_filters('vr_widget_defaults', array(
			'title' => 'Sign up for our Newsletter',
			'email_input_size' => 20,
			'email_default_value' => 'Enter your email address',
			'name_input_size' => 15,
			'div_class' => 'widget_vr',
			'form_class' => 'vr_form',
			'form_id' => ($number_of_vr_widgets === 1) ? 'vr_form' : 'vr_form_'.$number_of_vr_widgets,
			'showname' => 'full',
			'bg_color' => 'dddddd',
			'border_color' => '000000',
			'font_color' => '333333',
			'label_color' => '000000',
			'button_bg_color' => '333333',
			'button_border_color' => '999999',
			'button_font_color' => '000000',
			'border_width' => 1,
			'preface' => '',
			'wrap' => 'p',
			'button' => 'Subscribe',
			'code' => '',
			'defaultstyle' => 'yes',
			'credit' => 'yes',
			'show_vr_code' => 'yes',
			'last_name_label' => 'Last Name:',
			'first_name_label' => 'First Name:',
			'email_label' => 'Email:', 
		));
		
		$options = wp_parse_args(get_option('widget_vr'), $defaults);
		
		// Change defaults for shortcodes & widgets with a filter.
		$args = wp_parse_args($args, apply_filters('vr_widget_args', array(
			'before_widget' => '<div class="widget '.$class.'">', 
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		)));
		
		// Let the shortcode overwrite these, too
		if($atts) { $args = wp_parse_args($atts, $args); }
		
		extract($args);
		
		if(!$atts) {
			extract($options);
		} else {
			extract(shortcode_atts($options, $atts), EXTR_PREFIX_SAME, 'vr_');
		}
		
		$title = htmlspecialchars(stripslashes($title));
		if(empty($title) && !empty($vr_title)) { 
			$title = htmlspecialchars(stripslashes($vr_title));	
		}
		
		$bg_color = kwd_process_color($bg_color, $options['bg_color']);
		$border_color = kwd_process_color($border_color, $options['border_color']);
		$font_color = kwd_process_color($font_color, $options['font_color']);
		$label_color = kwd_process_color($label_color, $options['label_color']);
		$button_bg_color = kwd_process_color($button_bg_color, $options['button_bg_color']);
		$button_border_color = kwd_process_color($button_border_color, $options['button_border_color']);
		$button_font_color = kwd_process_color($button_font_color, $options['button_font_color']);
		$border_width = (int)$border_width.'px';
		
		if(!empty($before_widget)) {
			$output .= $before_widget;
		}
			
		if(!empty($title)) {
			$output .=  $before_title."\n".$title."\n".$after_title;
		}
		
			$output .=  '
<form method="post" action="http://oi.vresp.com?fid='.$code.'" target="vr_optin_popup" onsubmit="window.open( \'http://www.verticalresponse.com\', \'vr_optin_popup\', \'scrollbars=yes,width=600,height=450\' ); return true;" id="'.$form_id.'" class="'.$form_class.'">';
	$style= false; $required = false;
	if($required != 'no') { $required = true;}
	$output .=  ' <div class="vr_wrapper"';
	if($defaultstyle != 'no') { $style= true;
	 $output .=  ' style="font-family: verdana; font-size: 11px; width: 160px; padding: 10px; border: '.$border_width.' solid #'.$border_color.'; background: #'.$bg_color.';"';
	}
	$output .=  '>';
	if($preface != '') {
		$output .=  '<'.$wrap;
		if($style) { $output .=  ' style="padding:0 0 0.5em 0; margin:0; color: #'.$font_color.'; line-height:1.2;"'; } $output .=  ' class="vr_preface">'.htmlspecialchars(stripslashes($preface)).'</'.$wrap.'>';
	}
$output .=  '
<fieldset'; 
	if($style) { $output .=  ' style="border:none;"'; }
	$output .=  '>';


#if(htmlspecialchars(stripslashes($options['legend'])) != '') { $output .=  '<legend>'.htmlspecialchars(stripslashes($options['legend'])).'</legend>'; };

if($showname == 'full' ||$showname == 'email') { 
$output .=  '
<label for="email_address"';
if($style) { $output .=  ' style="color: #'.$label_color.'; clear:both; width:100%; float:left;"';}
$output .=  ' id="email_address_label">'.$email_label;
if($required) { $output .=  ' <em id="vr_email_required"'; if($style) { $output .=  ' style="font-style:normal;"';} $output .=  '><span'; if($style) { $output .=  ' style="color:red;"';} else { $output .=  ' class="red"';} $output .=  '>*</span> Required</em>';}
$output .= '
</label> 
<input type="text" id="email_address" name="email_address" size="'.$email_input_size.'" value="'.$email_default_value.'"  onfocus="if (this.value == \'Enter your email address\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'Enter your email address\';}"';
	if($style) { 
		$output .=  ' style="margin-top: 5px; margin-bottom: 5px; color:#666; border: 1px solid #999; padding: 3px; width:auto;"';
	}
$output .=  '/>';

if($style) { $output .=  '<div style="width:100%;"></div>';}
}
if($showname == 'full') { 
	$output .=  '
	<label for="first_name"';
	if($style) { $output .=  ' style="color: #'.$label_color.';"';}
	$output .=  ' id="first_name_label">'.$first_name_label.'</label> 
	<input type="text" id="first_name" name="first_name" size="'.$name_input_size.'" value=""';
		if($style) { 
			$output .=  ' style="margin-top: 5px; margin-bottom: 5px; border: 1px solid #999; padding: 3px;"';
		} 
	$output .=  ' />';
	if($style) { $output .=  '<div style="width:100%;"></div>';}
	$output .=  '
	<label for="last_name"';
	if($style) { $output .=  ' style="color: #'.$label_color.';"';}
	$output .=  ' id="last_name_label">'.$last_name_label.'</label> 
	<input type="text" id="last_name" name="last_name" size="'.$name_input_size.'" value=""';
		if($style) { 
			$output .=  ' style="margin-top: 5px; margin-bottom: 5px; border: 1px solid #999; padding: 3px;"';
		} 
	$output .=  ' />';

}
$output .=  '<input type="hidden" name="vr_widget_version" value="'.$kws_vr_version.'" />';
$output .=  '<input type="submit" value="'.htmlspecialchars(stripslashes_deep($button)).'"';
if($style) { 
 $output .=  ' style="margin-top: 5px; border: 1px solid #'.$button_border_color.'; background-color:#'.$button_bg_color.'; color:#'.$button_font_color.'; padding: 3px;"';
}
$output .= ' id="vr_submit" />';

if($show_vr_code == 'yes' || $show_vr_code == '') {
	if($style) { $output .=  '<br />'; }
	$output .=  '<span'; 
	if($style) { $output .=  ' style="color: #'.$font_color.'; line-height:1.1; display:block; padding-top:.5em;"'; } 
	$output .=  ' class="vr_link vrLink"><a href="http://katz.si/vr" title="Email Marketing by VerticalResponse">Email Marketing</a> by VerticalResponse</span>';
}

$output .=  '
</fieldset>
</div>
</form>'."\n";
	
	$output .=  $after_widget;
	
	// If you have chosen to show the attribution link, add the link
	if($credit != 'no') {
		if(function_exists('add_action') && function_exists('vr_attr')) { add_action('wp_footer', 'vr_attr'); }
	} else {
		if(function_exists('add_action') && function_exists('vr_attr')) { add_action('wp_footer', 'get_vr_attr'); }
	} // End Credit
		
	$output = apply_filters('vr_widget_form', $output);
	if($echo) {
		echo $output;
	} else {
		return $output;
	}			
}
}

if(!function_exists('widget_vr_options')) {
// VR Plugin OPTIONS
function widget_vr_options() {
	global $kws_vr_version;
	$options = get_option('widget_vr');
	if (!is_array($options)) {
		$options = array(
			'title' => __('VerticalResponse', 'vertical-response'), 
			'code' => '', 
			'button' => 'Subscribe', 
			'wrap' => 'p', 
			'showname' => 'full', 
			'show_vr_code' => 'yes', 
			'credit' => 'yes', 
			'border_color'=>'#999999', 
			'bg_color'=>'#dddddd', 
			'font_color'=>'black', 
			'label_color'=>'#333333', 
			'button_border_color'=>'#999999',
			'button_bg_color'=>'#c0c0c0',
			'button_font_color'=>'#333333',
			'border_width'=>'1',
#			'legend' => '',
		);
		
	}
	if ($_POST['vr_form_submit']) {
		$options['title']=strip_tags($_POST["vr_form_title"]);
		$options['code']=strip_tags($_POST["vr_form_code"]);
#		$options['legend']=strip_tags(stripslashes($_POST["vr_form_legend"]));
		$options['showlegend']=strip_tags($_POST["vr_display_legend"]);
		$options['preface']=strip_tags($_POST["vr_form_preface"]);
		$options['button']=strip_tags($_POST["vr_form_button"]);
		$options['wrap']=strip_tags($_POST["vr_form_wrap"]);
		$options['defaultstyle'] = strip_tags($_POST["vr_defaultstyle"]);
		$options['showname'] = strip_tags($_POST["vr_showname"]);
		$options['required'] = strip_tags($_POST["vr_required"]);
		$options['show_vr_code'] = strip_tags($_POST["vr_show_vr_code"]);
		$options['credit'] = strip_tags(stripslashes($_POST["vr_credit"]));
		$options['border_color'] = strip_tags(stripslashes($_POST["vr_border_color"]));
		$options['bg_color'] = strip_tags(stripslashes($_POST["vr_bg_color"]));
		$options['font_color'] = strip_tags(stripslashes($_POST["vr_font_color"]));
		$options['label_color'] = strip_tags(stripslashes($_POST["vr_label_color"]));
		$options['button_bg_color'] = strip_tags(stripslashes($_POST["vr_button_bg_color"]));
		$options['button_font_color'] = strip_tags(stripslashes($_POST["vr_button_font_color"]));
		$options['button_border_color'] = strip_tags(stripslashes($_POST["vr_button_border_color"]));
		$options['border_width'] = strip_tags(stripslashes($_POST["vr_border_width"]));
		update_option('widget_vr', $options);
	}

?>
	
	<div style="-webkit-border-radius: 3px; margin: 5px 0; color: #333; border-radius: 3px; border-width: 1px; border-style: solid; background-color: lightYellow; border-color: #E6DB55; padding:10px;">
		<p style="padding:0; margin:0; line-height:1.3;">A VerticalResponse account is required to use this plugin. <strong><a href="http://katz.si/vr" target="_blank">Get a free trial now</a></strong>.</p>
	</div>
	
	<h2>Required Settings</h2>
	<div><p>
		 <strong>If you have an account:</strong></p>
		 <ul style="list-style:disc outside; margin-left:2em;">
		 	<li>Get your code here: <a href="https://app.verticalresponse.com/app/optin_form/list" target="_blank">Lists &gt; Opt-In Forms</a> and create a form.</li>
		 	<li>Go to the "Publish!" tab</li>
		 	<li>Find the Form ID Code can be found by looking for <code>&lt;form method=&quot;post&quot; action=&quot;http://oi.vresp.com?fid=<strong>ab1c2def3g</strong>&quot;</code>&hellip;, where <code><strong>ab1c2def3g</strong></code> is the code you want to enter below.</li>
		 	<li>Enter the code below</li>
		 </ul>
	
		<p><label for="vr_form_code">
		<strong> <?php _e('Unique Form ID Code:'); ?></strong>
		<br /><small><em>This is required for the widget to work.</em></small>
		 <input style="width: 100%;" id="vr_form_code" name="vr_form_code" type="text" value="<?php echo $options['code']; ?>" /></label>
	</p>
	</div>
	<hr />
	<h2>Text Settings</h2>
	 <p>
		 <label for="vr_form_title">
		  <strong><?php _e('Title:'); ?></strong>
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_form_title" name="vr_form_title" type="text" value="<?php echo htmlspecialchars(stripslashes($options['title'])); ?>" />
		  
		 <label for="vr_form_preface">
		  <strong><?php _e('Text:'); ?></strong>
		  <br />Displayed below the Title
		</label><br />
		  <textarea style="width: 100%; margin-bottom:1em;" id="vr_form_preface" name="vr_form_preface" rows="5"><?php echo htmlspecialchars(stripslashes($options['preface'])); ?></textarea>
		 
		 <label for="vr_form_wrap">
		  <strong><?php _e('Wrap Text in:'); ?></strong><br />
		  By default, the text will be wrapped in a paragraph (<code>&lt;p&gt;</code>). <em>Note: Do not include brackets</em>.
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_form_wrap" name="vr_form_wrap" type="text" value="<?php echo htmlspecialchars(stripslashes($options['wrap'])); ?>" /> 


<!--
		 <label for="vr_form_legend">
		  <strong><?php _e('Form Name'); ?></strong><br />
		  Leave empty to hide. Otherwise, it will be a form <code>&lt;legend&gt;</code>
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_form_legend" name="vr_form_legend" type="text" value="<?php echo htmlspecialchars(stripslashes($options['legend'])); ?>" />			 
-->
		 
		<label for="vr_form_button">
		  <strong><?php _e('Submit Button Text:'); ?></strong>
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_form_button" name="vr_form_button" type="text" value="<?php echo htmlspecialchars(stripslashes($options['button'])); ?>" />
		<hr />  
		<h2>Style Settings</h2>
		  <strong><?php _e('Show Widget Style:'); ?></strong><br />
		  The default style is a gray box. You can customize the colors using the options below (<em>Recommended for basic users</em>), or if you want to customize using your own external CSS, choose <code>No</code>.<br />
		
		<label for="vr_style_yes">Yes
		</label>
		  <input type="radio" id="vr_defaultstyle_yes" name="vr_defaultstyle" value="yes" <?php if(htmlspecialchars(stripslashes($options['defaultstyle'])) == 'yes' || htmlspecialchars(stripslashes($options['defaultstyle'])) == '') { echo 'checked="checked"';}; ?> />
		<label for="vr_style_no">No
		</label>
		  <input type="radio" id="vr_style_no" name="vr_defaultstyle" value="no" <?php if(htmlspecialchars(stripslashes($options['defaultstyle'])) == 'no') { echo 'checked="checked"';}; ?> />
		<br />
	<br />
		<fieldset>
		<legend><strong style="font-size:110%">Form Style &amp; Colors</strong></legend>
		If you know the <a href="http://en.wikipedia.org/wiki/List_of_colors" target="_blank" title="Go to a Wikipedia article with a list of colors. Opens in new window.">HEX value</a> or <a href="http://en.wikipedia.org/wiki/X11_color_names#Color_names_identical_between_X11_and_HTML.2FCSS" title="Go to a Wikipedia article with a list of X11 colors. Opens in new window.">X11 value</a> for the colors you want your widget to be, enter them below. Ex: <code>#3a3a3a</code>, <code>F4C2C2</code>, <code>blue</code> or <code>darkblue</code>.
		<br />
		<label for="vr_bg_color"><strong><?php _e('Background Color:'); ?></strong><br />
		  Change the widget's background color.
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_bg_color" name="vr_bg_color" type="text" value="<?php echo htmlspecialchars(stripslashes($options['bg_color'])); ?>" />
		   <br /> 
		 <label for="vr_border_color"><strong><?php _e('Border Color:'); ?></strong><br />
		  Change the widget's border color.
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_border_color" name="vr_border_color" type="text" value="<?php echo htmlspecialchars(stripslashes($options['border_color'])); ?>" />
		  			<br />
		
		<label for="vr_border_width">Widget Border Width</label>
			<div class="input"><select id="vr_border_width" name="vr_border_width">
			  <option value="0">No Border</option>
			  <option value="1" selected="selected">1 px</option>
			  <option value="2">2 px</option>
			  <option value="3">3 px</option>
			  <option value="4">4 px</option>
			  <option value="5">5 px</option>
			  <option value="6">6 px</option>
			  <option value="7">7 px</option>
			  <option value="8">8 px</option>
			  <option value="9">9 px</option>
			  <option value="10">10 px</option>
			  <option value="11">11 px</option>
			  <option value="12">12 px</option>
			  <option value="13">13 px</option>
			  <option value="14">14 px</option>
			  <option value="15">15 px</option>
			  <option value="16">16 px</option>
			  <option value="17">17 px</option>
			  <option value="18">18 px</option>
			  <option value="19">19 px</option>
			  <option value="20">20 px</option>
			</select></div>
		  <br /> 
		 <label for="vr_font_color"><strong><?php _e('Text Color:'); ?></strong><br />
		  Change the color of widget text.
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_font_color" name="vr_font_color" type="text" value="<?php echo htmlspecialchars(stripslashes($options['font_color'])); ?>" />
		
		  <br /> 
		 <label for="vr_label_color"><strong><?php _e('Form Label Color:'); ?></strong><br />
		  Change the color of widget labels (next to input fields).
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_label_color" name="vr_label_color" type="text" value="<?php echo htmlspecialchars(stripslashes($options['label_color'])); ?>" />
		  
		  <br /> 
		 <label for="vr_button_bg_color"><strong><?php _e('Button Color:'); ?></strong><br />
		 Change the color of the button's background.
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_button_bg_color" name="vr_button_bg_color" type="text" value="<?php echo htmlspecialchars(stripslashes($options['button_bg_color'])); ?>" />
		  
		  <br /> 
		 <label for="vr_button_font_color"><strong><?php _e('Button Text Color:'); ?></strong><br />
		  Change the color for the button's text.
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_button_font_color" name="vr_button_font_color" type="text" value="<?php echo htmlspecialchars(stripslashes($options['button_font_color'])); ?>" />
		  
		   <br /> 
		 <label for="vr_button_border_color"><strong><?php _e('Button Border Color:'); ?></strong><br />
		  Change the color of the button's border.
		</label>
		  <input style="width: 100%; margin-bottom:1em;" id="vr_button_border_color" name="vr_button_border_color" type="text" value="<?php echo htmlspecialchars(stripslashes($options['button_border_color'])); ?>" />
		</fieldset>
		
		<hr />
		<h2>Additional Settings</h2>
		  <h3><?php _e('Type of Form:'); ?></h3>


		  <input type="radio" id="vr_showname_yes" name="vr_showname" value="full" <?php if(htmlspecialchars(stripslashes($options['showname'])) == 'full' || htmlspecialchars(stripslashes($options['showname'])) == '') { echo 'checked="checked"';}; ?> />
		  <label for="vr_showname_yes"><strong>Full Optin</strong> <span class="howto">(will display First Name, Last Name, Email, and subscribe button)</span></label>
		
		<br />
		  <input type="radio" id="vr_showname_email" name="vr_showname" value="email" <?php if(htmlspecialchars(stripslashes($options['showname'])) == 'email') { echo 'checked="checked"';}; ?> />
		  <label for="vr_showname_email"><strong>Only Email</strong> <span class="howto">(will show Email &amp; subscribe button)</span>
		</label>
		<br />
		  <input type="radio" id="vr_showname_button" name="vr_showname" value="button" <?php if(htmlspecialchars(stripslashes($options['showname'])) == 'button') { echo 'checked="checked"';}; ?> />
		  <label for="vr_showname_button"><strong>Only Subscribe</strong> <span class="howto">(will only show the subscribe button)</span></label>
		<br />
		  <strong><?php _e('Show "Required <span style="color:red;">*</span>":'); ?></strong><span class="howto">
		  Let users know the email is required. Even if the email input is empty, they'll be able to enter it after submitting the form.</span>
		<label for="vr_required_yes">Yes
		</label>
		  <input type="radio" id="vr_required_yes" name="vr_required" value="yes" <?php if(htmlspecialchars(stripslashes($options['required'])) == 'yes' || htmlspecialchars(stripslashes($options['required'])) == '') { echo 'checked="checked"';}; ?> />
		<label for="vr_style_no">No
		</label>
		  <input type="radio" id="vr_required_no" name="vr_required" value="no" <?php if(htmlspecialchars(stripslashes($options['required'])) == 'no') { echo 'checked="checked"';}; ?> />
		
		<br />
		<br />
		  <strong><?php _e('Show VerticalResponse Link:'); ?></strong><br />
		<label for="vr_show_vr_code_yes">Yes
		</label>
		  <input type="radio" id="vr_show_vr_code_yes" name="vr_show_vr_code" value="yes" <?php if(htmlspecialchars(stripslashes($options['show_vr_code'])) == 'yes' || htmlspecialchars(stripslashes($options['show_vr_code'])) == '') { echo 'checked="checked"';}; ?> />
		<label for="vr_show_vr_code_no">No
		</label>
		  <input type="radio" id="vr_show_vr_code_no" name="vr_show_vr_code" value="no" <?php if(htmlspecialchars(stripslashes($options['show_vr_code'])) == 'no') { echo 'checked="checked"';}; ?> />
		  
		<br />
		<br />
		  <strong><?php _e('Give Author Credit:'); ?></strong><span class="howto">Thank the widget author with a text link on your website's footer. It's much appreciated!</span>
		
		<label for="vr_credit_yes">Yes
		</label>
		  <input type="radio" id="vr_credit_yes" name="vr_credit" value="yes" <?php if(htmlspecialchars(stripslashes($options['credit'])) == 'yes' || htmlspecialchars(stripslashes($options['credit'])) == '' || !$options['credit']) { echo 'checked="checked"';}; ?> />
		<label for="vr_credit_no">No
		</label>
		  <input type="radio" id="vr_credit_no" name="vr_credit" value="no" <?php if(htmlspecialchars(stripslashes($options['credit'])) == 'no') { echo 'checked="checked"';}; ?> />
	</p>
	<p> <input type="hidden" name="vr_form_submit" value="Submit" /></p>
		
<?php		
}
}


if(!function_exists('kwd_vr_shortcode')) {
function kwd_vr_shortcode($atts, $content = '') {
	if(!is_admin()) { return widget_vr(false, false, $atts); }
}
}

if(!function_exists('in_multi_array')) {
function in_multi_array($needle, $haystack)
 {
  foreach($haystack as $pos => $val)
  {
   if (is_array($val))
   {
    if (in_multi_array($needle, $val))
     return 1;
   } else
    if ($val == $needle)
     return 1;
  }
 }
}

if(!function_exists('vr_default_string')) {
function vr_default_string($saved,$default) {
    if ( empty($saved) )
        return __($default);
    else
        return $saved;
}
}
if(!function_exists('kwd_process_color')) {
function kwd_process_color($colors, $default = '') {
	if(isset($colors) && !empty($colors)) {
		if(substr($colors, 0, 1) == '#') {
			$color = strtolower(substr($colors, 1));
		} else {
			$color = $colors;
		}
	} else {
		$color = $default;
	}

	return $color;
}
}

if(!function_exists('get_vr_attr')) {
	function get_vr_attr() { 
			global $post, $kws_vr_version;// prevents calling before <HTML>
			if($post && !is_admin()) {
				$site = 'http://www.katzwebservices.com/development/attribution.php?site='.htmlentities(substr(get_bloginfo('url'), 7)).'&from=vr_widget&version='.$kws_vr_version;
				$output = kwd_rss_output($site, $default);
				return $output;
			}
	}
}
// This simply tells the widget author where the widget has been installed.
if(!function_exists('kwd_rss_output')){
function kwd_rss_output($rss = '', $default = '') {
		include_once(ABSPATH . WPINC . '/feed.php');
		
		$rss = fetch_feed($rss);
		
		if(!$rss || empty($rss) || is_wp_error( $rss )) { return $default; }
		
		$rss_items = $rss->get_items(0, 1); 
		
		foreach ( $rss_items as $item ) {
			return $item->get_description();
		}
		
} // end kwd_rss_output
}

if(!function_exists('vr_attr')) {
	function vr_attr() { 
		global $post, $kws_vr_version; // prevents calling before <HTML>
		echo get_vr_attr();
	}
}

?>