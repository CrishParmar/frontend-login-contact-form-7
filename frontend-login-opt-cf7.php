<?php
/* @access      public
 * @since       1.1 
 * @return      $content
*/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}


function user_validation_filter_func( $result, $tag ) 
{
    $post_id = sanitize_text_field($_POST['_wpcf7']);
    $cf7frloginun = get_post_meta($post_id, "_cf7frloginun_", true);
    
    $enable = get_post_meta($post_id,'_cf7fr_enable_login');
    if($enable[0]!=0)
    {

        global $wpdb;
    
        $json = array();
        
        $error = '';
        $success = '';
        $nonce = $_POST['rs_user_login_nonce'];


        $tag = new WPCF7_Shortcode( $tag );

        $type = $tag->type;
        $name = $tag->name;

        global $wpdb;

        if(isset($_POST[$cf7frloginun]) && $_POST[$cf7frloginun]!="")
        {
            if ( ! wp_verify_nonce( $nonce, 'rs_user_login_action' ) )
            {
               
                $result->invalidate($tag, "Security checked!, Cheatn huh?");
            }
            else
            {

                $username = $_POST[$cf7frloginun];
                
                $username = $wpdb->escape($username);
                $password = $wpdb->escape($_POST['user-pass']);

                $user_data = array();
                $user_data['user_login'] = $username;
                $user_data['user_password'] = $password;
                
                $user = wp_signon( $user_data, false );


                if($name == $cf7frloginun)
                {

                    if( is_wp_error($user) )
                    {

                      
                        if($user->errors['invalid_username'])
                        {
                            $result->invalidate($tag, "Invalid username.");
                            
                        }
                    }
                                     
                
                }
                if($name == "user-pass")
                {

                    if( is_wp_error($user) )
                    {

                       if($user->errors['incorrect_password'])
                        {
                            $result->invalidate($tag, "The password you entered for the username is incorrect.");
                        }
                       
                    }
                                     
                
                }
                
            }
            
        }
    }
    return $result;
 }
    
add_filter( 'wpcf7_validate_text*', 'user_validation_filter_func', 20, 2 );

function frlogin_plugin_url( $path = '' ) {

    $url = plugins_url( $path, LOGINCF7_PLUGIN );
    if ( is_ssl()
    and 'http:' == substr( $url, 0, 5 ) ) {
        $url = 'https:' . substr( $url, 5 );
    }
    return $url;
}

/*add_action( 'wpcf7_mail_sent', 'your_wpcf7_mail_sent_function1' );
function your_wpcf7_mail_sent_function1( $contact_form ) {
    $user_login = 'testing.mnoss@gmail.com';
     
    $user_data = get_user_by( 'email', trim( $user_login ) );
    
    wp_set_password( $_POST['user-pass'], $user_data->ID );

}*/

//This function prints the JavaScript to the footer
function frlogincf7_footer_script(){ ?>
<script>
document.addEventListener( 'wpcf7mailsent', function( event ) {
    location = '<?php echo get_home_url(); ?>';
}, false );
</script>
<?php } 
  add_action('wp_footer', 'frlogincf7_footer_script');
?>