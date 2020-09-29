<?php
/**
 * Frontend Login - Contact Form 7 Pro Activation File
 *
 *
 * @access      public
 * @since       1.0 
 * @return      $content
*/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

// check to make sure contact form 7 is installed and active
register_activation_hook (__FILE__, 'cf7fr_submit_activation_check');
if (function_exists('is_plugin_active')) {
    if ( !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) { 
        // give warning if contact form 7 is not active
        wp_die( __( '<b>Warning</b> : Install/Activate <a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">Contact Form 7</a> to activate "Contact Form 7 - Frontend Registration" plugin. <a href='.LOGINCF7_PLUGIN_PAGE.'>Back</a>', 'contact-form-7' ) );   
    }
}

register_activation_hook( LOGINCF7_PLUGIN , 'my_activation_func' ); 
function my_activation_func() {
    file_put_contents( LOGINCF7_PLUGIN_DIR .'/my_loggg.txt', ob_get_contents());
}

add_action('admin_enqueue_scripts', 'callback_frlogin_setting_up_scripts');
function callback_frlogin_setting_up_scripts() {
    if($_GET['page']=='wpcf7'){
        wp_enqueue_style('frlogincss', frlogin_plugin_url('/css/style.css'), array(), LOGINCF7_VERSION,'all');
    }
}

add_action( 'init', 'activate_frlogin' );
function activate_frlogin()
{
    $plugin_current_version = '2.0';
    $plugin_remote_path = 'http://www.wpbuilderweb.com/plugin/updates/cf7login.php'; 
    $plugin_slug = LOGINCF7_PLUGIN_BASENAME;
    new WP_login_AutoUpdate( $plugin_current_version, $plugin_remote_path, $plugin_slug );    
}

function cf7login_editor_panels_login ( $panels ) {
	$new_page_login = array(
		'Login' => array(
			'title' => __( 'Login Settings', 'contact-form-7' ),
			'callback' => 'cf7login_admin_log_additional_settings_login'
		)
	);
	
	$panels = array_merge($panels, $new_page_login);
	
	return $panels;
	
}
add_filter( 'wpcf7_editor_panels', 'cf7login_editor_panels_login' );

function frlogin_init() {
  	wp_enqueue_script('frlogin_js', plugins_url('/js/script.js',LOGINCF7_PLUGIN), array('jquery'), '', true  ); 
}
add_action('init', 'frlogin_init',99);