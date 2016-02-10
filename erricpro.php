<?php
/**
 * Plugin Name: Erric Pro
 * Plugin URI: http://www.wpbeginner.com/beginners-guide/what-why-and-how-tos-of-creating-a-site-specific-wordpress-plugin/
 * Description: Erric Playground for Function Testing
 * Version: 0.1
 * Author: erricgunawan
 * Author URI: http://erricgunawan.com
 *
 */

if ( !function_exists( 'plugin_dir_path' ) ) { die( 'no direct access allowed' ); }

// CONSTANT
define( 'ERRIC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'ERRIC_PLUGIN_URL', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
define( 'ERRIC_INCLUDE', ERRIC_PLUGIN_PATH . '/includes/' );


// require_once ERRIC_INCLUDE . 'shortcode_searchform.php';
// require_once ERRIC_INCLUDE . 'post_slug.php';
// require_once ERRIC_INCLUDE . 'posttype_random_quote.php';
// require_once ERRIC_INCLUDE . 'register_message.php';
// require_once ERRIC_INCLUDE . 'custom_admin.php';
// require_once ERRIC_INCLUDE . 'shortcode_lastupdated_posts.php';
// require_once ERRIC_INCLUDE . 'widget_custom.php';
// require_once ERRIC_INCLUDE . 'redirect_users.php';
// require_once ERRIC_INCLUDE . 'tabber_widget.php';
// require_once ERRIC_INCLUDE . 'flexible_widget_titles.php';
// require_once ERRIC_INCLUDE . 'recently_registered_users.php';
// require_once ERRIC_INCLUDE . 'singlecolumn_dashboard.php';
// require_once ERRIC_INCLUDE . 'custom_logintitle.php';
// require_once ERRIC_INCLUDE . 'custom_header_avatar.php';
// require_once ERRIC_INCLUDE . 'hide_media_button.php';
// require_once ERRIC_INCLUDE . 'browser_os_class.php';
// require_once ERRIC_INCLUDE . 'company_info.php';
// require_once ERRIC_INCLUDE . 'term_meta_th.php';
require_once ERRIC_INCLUDE . 'term_meta_sm.php';