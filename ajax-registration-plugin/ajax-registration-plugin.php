<?php
/*
Plugin Name: Ajax Registration Plugin
Description: A plugin for user registration using Ajax.
Author: Utsav
Version: 1.0.0
Text-domain: ajax-registration-plugin
*/

// Enqueue JavaScript file
function ajax_registration_enqueue_scripts() {
    wp_enqueue_script('ajax-registration-script', plugin_dir_url(__FILE__) . '/assets/js/script.js', array('jquery'), '1.0', true);
    wp_localize_script('ajax-registration-script', 'ajax_registration_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'redirect_url' => home_url('/')
    ));
}
add_action('wp_enqueue_scripts', 'ajax_registration_enqueue_scripts');

// Process user registration
function ajax_registration_process() {
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];

        // Create user
        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // User registration successful
            echo 'success';
        } else {
            // User registration failed
            echo $user_id->get_error_message();
        }
    }
    exit();
}
add_action('wp_ajax_ajax_registration', 'ajax_registration_process');
add_action('wp_ajax_nopriv_ajax_registration', 'ajax_registration_process');


// Shortcode for registration form
function ajax_registration_form_shortcode() {
    ob_start();
    ?>
    <h2>User Registration</h2>
    <form id="registrationForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Register">
    </form>
    <div id="message" style="display: none;"></div>
    <?php
    return ob_get_clean();
}
add_shortcode('ajax_registration_form', 'ajax_registration_form_shortcode');
