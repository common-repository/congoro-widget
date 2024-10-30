<?php
/*
Plugin Name: Congoro Widget
Plugin URI: http://congoro.com/
Description: wordpress plugin for congoro related posts widget | <a href="./admin.php?page=congoro.php">تنظیمات ویجت</a>
Version: 2.6.5
Author: Congoro
Author URI: http://congoro.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require (dirname(__FILE__). '/'. 'congoroWidgetFunctions.php');
require(dirname(__FILE__) . '/' . 'admin/index.php');
require(dirname(__FILE__) . '/' . 'widget.php');
require(dirname(__FILE__) . '/' . 'uninstall.php');

add_action('the_content', 'congoroWidgetFunctions::loadWidgetInContent');
add_action('widgets_init', 'congoroWidgetFunctions::loadWordpressWidget');
add_action('wp_footer', 'congoroWidgetFunctions::loadFixedWidgets');
