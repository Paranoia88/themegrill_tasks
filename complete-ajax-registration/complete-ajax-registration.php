<?php
/*
Plugin Name: Complete Ajax Registration Plugin
Description: Register users with AJAX. Internationalization, localization, sanitization, escaping and nonces are used.
Version: 1.0
Author: Utsav
Text Domain: my-registration-plugin
*/


// Load plugin text domain for localization
function my_registration_plugin_load_textdomain() {
    load_plugin_textdomain( 'my-registration-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'my_registration_plugin_load_textdomain' );

// Enqueue scripts and styles securely
function my_registration_plugin_enqueue_scripts() {
    wp_enqueue_script( 'registration-script', plugin_dir_url( __FILE__ ) . '/assets/js/script.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'registration-script', 'registration_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'registration_ajax_nonce' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_registration_plugin_enqueue_scripts' );

// AJAX user registration
function my_registration_plugin_register_user() {
    check_ajax_referer( 'registration_ajax_nonce', 'security' );
  
    
    $username = sanitize_user( $_POST['username'] );
    $email = sanitize_email( $_POST['email'] );
    $password = $_POST['password'];

    // Perform data validation

    if ( empty( $username ) || empty( $email ) || empty( $password ) ) {
        wp_send_json_error( esc_html__( 'All fields are required.', 'my-registration-plugin' ) );
    }

    if ( ! is_email( $email ) ) {
        wp_send_json_error( esc_html__( 'Invalid email address.', 'my-registration-plugin' ) );
    }

    // Additional data validation and sanitization

    // User registration
    $user_id = wp_create_user( $username, $password, $email );

    if ( is_wp_error( $user_id ) ) {
        wp_send_json_error( esc_html__( 'Error occurred while registering user.', 'my-registration-plugin' ) );
    } else {
        wp_send_json_success( esc_html__( 'User registered successfully!', 'my-registration-plugin' ) );
    }
}
add_action( 'wp_ajax_registration', 'my_registration_plugin_register_user' );
add_action( 'wp_ajax_nopriv_registration', 'my_registration_plugin_register_user' );

// Render the registration form
function my_registration_plugin_render_form() {
    ob_start();
    
     // Include the template file
        $file = ABSPATH."wp-content/plugins/complete-ajax-registration/ajax-form.php";

        include_once($file);
    
    return ob_get_clean();
}

// Shortcode for displaying the registration form
function my_registration_plugin_registration_shortcode() {
    $form = my_registration_plugin_render_form();
    return $form;
}
add_shortcode( 'complete_ajx_registration_form', 'my_registration_plugin_registration_shortcode' );
