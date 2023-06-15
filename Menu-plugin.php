<?php
/**
 * 
 * Plugin Name: Menu Plugin
 * Description: A simple plugin to display Menu and submenu for emails.
 * Version: 1.0
 * Author: Utsav
 * Author URI:  https://github.com/Paranoia88
 * Text Domain: menu-plugin
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class EmailPlugin{
    public function __construct(){
        $this->init();
        
    }
    public function init(){
        //Hooked into admin_menu to create menu and submenu page
        add_action( 'admin_menu', array($this, 'my_plugin_menu'));
         //HOoked into admin_init for settings that are saved after subbmitted
        add_action( 'admin_init', array($this, 'savesetting') );
        // add_action('response_msg', array($this, 'EmailFilter'), 11, 1);
        add_filter('email_message_updates', array($this, 'EmailFilter'), 10, 1);
        add_action('mp_send_email', array($this, 'sendMyemail'), 10, 3);
    }


       //for adding a menu and submenu
      public function my_plugin_menu() {
    add_menu_page(
        'Test Email',
        'Test Email',
        'manage_options',
        'test-email',
        array($this, 'test_email_page'),
        'dashicons-admin-plugins',
        6
    );

    add_submenu_page(
        'test-email',
        'Send Email',
        'Send Email',
        'manage_options',
        'my-plugin-test-email-submenu',
         array($this, 'Send_email_submenu_page'),
    );
    }


    // to display in parent menu
   public function test_email_page() {
    ?>
     <div>
            <h1><?php echo "Hello Welcome to the Email Plugin"; ?></h1>
        </div>
    <?php
     }



     //to display in submenu

    public function Send_email_submenu_page(){
    ?>
    <div>
            <form method="POST">
                <div class="row">
                    <label for=""><?php esc_html_e('Email Subject'); ?></label>
                    <input type="text" name="email-subject" placeholder="Enter your Email Subject">
                </div>
                <br>
                <br>
                <div class="row">
                    <label for=""><?php esc_html_e('Email-content'); ?></label>
                    <textarea name="email-content" id="" cols="30" rows="10"></textarea>

                </div>
                <div class="row">
                    <label for=""><?php esc_html_e('Send To'); ?></label>
                    <input name="send-to" type = 'text' placeholder = "Enter whom to send mail to"></textarea>
                </div>
                <input type="submit" name="submit" value="Submit">

                <?php 
                $avalue = array("Thank you for visiting.");
                do_action('response_msg', $avalue);?>
            </form>
        </div>
  <?php
  }



   public function savesetting()
   {
    //if submit has value 1
    if (isset($_POST['submit'])) {
        $emailSubject
            = apply_filters('email_message_updates', sanitize_text_field($_POST['email-subject']));
        $emailContent =
            apply_filters('email_message_updates', sanitize_textarea_field($_POST['email-content']));
        $emailSendto =
            apply_filters('email_message_updates', sanitize_text_field( $_POST['send-to'] ));

       
        // echo '<br><br>';
        // echo $emailContent;
        // echo '<br><br>';
        // echo $emailSendto;
        do_action('mp_send_email', $emailSubject, $emailContent, $emailSendto);
    }

    }

    
    public function EmailFilter( $content)
    {
        //Content that can be overwrited through filter hook. Emailfilter is inside array so that it passes without an error
        // $content = 'Thank you for visiting.';
        return $content;
    }

    public function EmailAction(){

    }
    
    public function sendMyEmail($emailSubject, $emailContent, $emailTo)
    {
        //Sending mail to clients( Need proper setup config for this)
       
        wp_mail(
            $emailTo,
            $emailSubject,
            $emailContent
        );
        
    }
    // public function func_response_msg(){
        
    // }
}

//Instanciating an object from class EMailPlugin.
$emailPlugin = new EmailPlugin();

