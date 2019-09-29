<?php
/**
 * Plugin Name: WRabbitC 0.7
 * Plugin URI: https://github.com/pasmimmo/WRabbitC
 * Description: Wordpress RabbitMQ Connector
 * Author: Domenico Pascucci
 * Author URI: https://github.com/pasmimmo
 * Version: 0.5.2
 * Text Domain: alpha version of RabbitMQ Connector for WP
 *
 * Copyright: (c) 2018-2020 Domenico Pascucci (pasmimmo@gmail.com)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @author    Domenico Pascucci
 * @copyright Copyright (c) 2018-2020, Domenico Pascucci
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 *
 */
//Prevent direct access to file
if ( ! defined( 'ABSPATH' ) ){
    exit;
}
//include dependencies
include_once( 'wrabbitc_settings.php' );
if(is_admin()) {
    $wrabbitc_settings = new WrabbitcSettings();
    //Add links from plugins page to wrabbitc settings page 
    add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($wrabbitc_settings,'wrabbitc_settings_link'));
}
include_once( 'framework/wrabbitc_shortcodes.php' );
$wrabbitc_shortcodes = new ShortCodes();
include_once ('framework/wrabbitc_messages_sender.php');