<?php
/**
 * Frontend Login - Contact Form 7 Settings File
 *
 *
 * @access      public
 * @since       1.0 
 * @return      $content
*/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
function cf7login_admin_log_additional_settings_login( $cf7 )
{
	
	$post_id = sanitize_text_field($_GET['post']);
	$tags = $cf7->form_scan_shortcode();
	$enable = get_post_meta($post_id, "_cf7fr_enable_login", true);
	$cf7frloginun = get_post_meta($post_id, "_cf7frloginun_", true);
	
	if ($enable == "1") { $checked = "CHECKED"; } else { $checked = ""; }
	
	$selected = "";
	$admin_cm_output = "";
	
	$admin_cm_output .= "<div id='additionalsettings-login' class='meta-box'><div id='additionalsettingsdiv'>";
	$admin_cm_output .= "<div class='handlediv' title='Click to toggle'></div><h2 class='hndle ui-sortable-handle'><span>Frontend Login Settings</span></h2>";
	$admin_cm_output .= "<div class='inside'>";
	
	$admin_cm_output .= "<div class='mail-field pretty p-switch p-fill'>";
	$admin_cm_output .= "<input name='enable' value='1' type='checkbox' $checked>";
	$admin_cm_output .= "<div class='state'><label>Enable Login on this form</label></div>";
	$admin_cm_output .= "</div>";

	$admin_cm_output .= "<br /><table>";
	
	$admin_cm_output .= "<tr><td>Selected Field Name For User Name :</td></tr>";
	$admin_cm_output .= "<tr><td><select name='_cf7frloginun_'>";
	$admin_cm_output .= "<option value=''>Select Field</option>";
	foreach ($tags as $key => $value) {
		if($cf7frloginun==$value['name']){$selected='selected=selected';}else{$selected = "";}		
		if($value['name']!="" && $value['name']!="user-pass")	:
		$admin_cm_output .= "<option ".$selected." value='".$value['name']."'>".$value['name']."</option>";
		endif;
	}
	$admin_cm_output .= "</select>";
	$admin_cm_output .= "</td></tr>";

	$admin_cm_output .= "<tr><td>Copy Below Shotcode for Password field :</td></tr>";
	$admin_cm_output .= "<tr><td>";
	$admin_cm_output .= "<strong>[text* user-pass]</strong>";
	$admin_cm_output .= "</td></tr>";

	$admin_cm_output .= "<tr><td>Copy Below Shotcode for Nonce field :</td></tr>";
	$admin_cm_output .= "<tr><td>";
	$admin_cm_output .= "<strong>[wpnonce]</strong>";
	$admin_cm_output .= "</td></tr>";
	$admin_cm_output .= "<tr><td>";

	$admin_cm_output .= "<tr><td>You can user CF7 addition setting options for redirect url after successfull login.</td></tr>";
	$admin_cm_output .= "<tr><td>";
	$admin_cm_output .= "<a target='_blank' href='http://contactform7.com/redirecting-to-another-url-after-submissions/'>Click Here </a> for more info.";
	$admin_cm_output .= "</td></tr>";
	$admin_cm_output .= "<tr><td>";
	
	
	$admin_cm_output .= "<input type='hidden' name='post' value='$post_id'>";
	
	$admin_cm_output .= "</td></tr></table>";
	$admin_cm_output .= "</div>";
	$admin_cm_output .= "</div>";
	$admin_cm_output .= "</div>";

	echo $admin_cm_output;
	
}

// hook into contact form 7 admin form save
add_action('wpcf7_save_contact_form', 'cf7login_save_log_contact_form');
function cf7login_save_log_contact_form( $cf7 ) {

		$tags = $cf7->form_scan_shortcode();
	
		echo $post_id = sanitize_text_field($_POST['post']);
		
		if (!empty($_POST['enable'])) {
			$enable = sanitize_text_field($_POST['enable']);
			update_post_meta($post_id, "_cf7login_enable_login", $enable);
		} else {
			update_post_meta($post_id, "_cf7login_enable_login", 0);
		}

	$key = "_cf7frloginun_";
	$vals = sanitize_text_field($_POST[$key]);
	update_post_meta($post_id, $key, $vals);
}


add_action( 'wpcf7_init', 'custom_add_shortcode_nonce' );
 
function custom_add_shortcode_nonce() {
    wpcf7_add_shortcode( 'wpnonce', 'custom_nonce_shortcode_handler' ); // "nonce" is the type of the form-tag
}
 
function custom_nonce_shortcode_handler( $tag ) {
	if ( function_exists( 'wp_nonce_field' ) ) 
		return 	wp_nonce_field( 'rs_user_login_action', 'rs_user_login_nonce' );
}