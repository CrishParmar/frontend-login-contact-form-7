<?php
/**
 * Plugin Name: Frontend Login - Contact Form 7
 * Plugin URL: http://www.wpbuilderweb.com/product/frontend-login-contact-form-7/
 * Description:  This plugin will convert your Contact form 7 into Login form for WordPress.
 * Version: 2.0
 * Author: David Pokorny
 * Author URI: https://www.wpbuilderweb.com/
 * Developer: Pokorny David
 * Developer E-Mail: pokornydavid4@gmail.com
 * Text Domain: contact-form-7-frlogin
 * Domain Path: /languages
 * 
 * Copyright: © 2009-2015 izept.com.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * 
 * @access      public
 * @since       1.1
 * @return      $content
*/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

define( 'LOGINCF7_VERSION', '2.0' );

define( 'LOGINCF7_PLUGIN', __FILE__ );

define( 'LOGINCF7_PLUGIN_BASENAME', plugin_basename( LOGINCF7_PLUGIN ) );

define( 'LOGINCF7_PLUGIN_NAME', trim( dirname( LOGINCF7_PLUGIN_BASENAME ), '/' ) );

define( 'LOGINCF7_PLUGIN_DIR', untrailingslashit( dirname( LOGINCF7_PLUGIN ) ) );

define( 'LOGINCF7_PLUGIN_CSS_DIR', LOGINCF7_PLUGIN_DIR . '/css' );

define( 'LOGINCF7_PLUGIN_PAGE', get_admin_url().'plugins.php');


require_once (dirname(LOGINCF7_PLUGIN) . '/frontend-login-cf7-update.php');
require_once (dirname(LOGINCF7_PLUGIN) . '/frontend-login-opt-cf7.php');
require_once (dirname(LOGINCF7_PLUGIN) . '/frontend-login-activation-cf7.php');
require_once (dirname(LOGINCF7_PLUGIN) . '/frontend-login-settings-cf7.php');