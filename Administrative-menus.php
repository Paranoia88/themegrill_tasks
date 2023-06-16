<?php
/**
 * 
 * Plugin Name: Administrative Menu Plugin
 * Description: A simple plugin to display Menu and submenu.
 * Version: 1.0
 * Author: Utsav
 * Author URI:  https://github.com/Paranoia88
 * Text Domain: menu-plugin
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class AdministrativeMenu{
    public function __construct(){
        add_action( 'admin_menu', array($this, 'my_plugin_menu'));
    }
    
       //for adding a menu and submenu
    public function my_plugin_menu() {
        
    add_menu_page(
        'Movie options',
        'Movie',
        'manage_options',
        'movie-watch',
        array($this,'call_for_movie'),
        'dashicons-admin-plugins',
        6
    );
  

    add_submenu_page(
        'movie-watch',
        'Dashboard options',
        'Dashboard',
        'manage_options',
        'dashboard-view',
        array($this,'call_for_dashboard'),
    );
    add_submenu_page(
        'movie-watch',
        'Settings options',
        'Settings',
        'manage_options',
        'settings-edit',
        array($this,'call_for_settings'),
    );
    
    }
    public function call_for_movie(){
        
    }
    public function call_for_dashboard(){

    }
    public function call_for_settings(){

    }
      //Hooked into admin_menu to create menu and submenu page
}

$adminmenu = new AdministrativeMenu();

