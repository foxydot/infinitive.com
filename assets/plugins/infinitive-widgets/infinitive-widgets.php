<?php
/**
 * @package Infinitive Widgets
 * @version 0.1
 */
/*
Plugin Name: Infinitive Widgets
Description: Widgets for Infinitive
Author: Catherine OBrien
Version: 0.1
Author URI: http://madsciencedept.com
*/

$msd_wgt_path = plugin_dir_path(__FILE__);
$msd_wgt_url = plugin_dir_url(__FILE__);

//Include utility functions
include_once('includes/infinitive_functions.php');

//Include widget files
include_once('includes/cta-widget.php');
include_once('includes/segment-widget.php');
//include_once('includes/feature_block_widget.php');
include_once('includes/infinitive_custom_req.php');
