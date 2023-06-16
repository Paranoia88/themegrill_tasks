<?php
/**
 * 
 * Plugin Name:  Activa user registration plugin
 * Description: A simple plugin to get user data and store it in database
 * Version: 1.0
 * Author: Utsav
 * Author URI:  https://github.com/Paranoia88
 * Text Domain: menu-plugin
 */

 function enqueue_style() {
    wp_enqueue_style( 'style', plugins_url( 'assets/css/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_style' );


class activaplugin{
    public function __construct(){
        $this->init();
    }
    public function init(){
        //must use array ($this) if called at the time of instantiation
        add_shortcode('ac_custom_template', array( $this ,'ac_custom_template_function' ));
    }
    
    function ac_custom_template_function($atts) {
        // error_log(print_r('Hello'));
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'redirect_after_registration' => ''
        ), $atts);
    
        ob_start(); // Start output buffering
    
       
        // Include the template file
        $file = ABSPATH."wp-content/plugins/activa-user-registration/shortcode-form-template.php";

        include_once($file);

        if (isset($_POST['submit'])) {

            // Process the form submission and perform registration logic here
            // Redirect after registration, if provided
       
            if (isset($_POST['submit'])) {
                // Retrieve form data
                $email = $_POST['email'];
                $password = $_POST['password'];
                $username = $_POST['username'];
                $display_name = $_POST['display_name'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $role = $_POST['role'];
              
                // Create the user in wp_users table
                $user_id = wp_create_user($username, $password, $email);
              
                // Set user's display name
                wp_update_user(array('ID' => $user_id, 'display_name' => $display_name));
              
                // Set user's first and last name in wp_usermeta table
                update_user_meta($user_id, 'first_name', $first_name);
                update_user_meta($user_id, 'last_name', $last_name);
              
                // Set user's role
                $user = new WP_User($user_id);
                $user->set_role($role);
              
                // Redirect to a success page or perform any additional actions
                if (!empty($atts['redirect_after_registration'])) {

                    error_log(print_r($atts['redirect_after_registration']));
                     
                    wp_redirect($atts['redirect_after_registration'], 302);
                    exit;
                }
                exit;
              }
              
        }
        // Redirect after registration, if provided
         // Check if the form is submitted
   
        return ob_get_clean(); // Return the buffered content
    }
    
}
$activateplugin = new activaplugin();



?>

