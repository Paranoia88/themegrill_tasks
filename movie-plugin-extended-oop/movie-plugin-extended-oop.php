<?php
/*
Plugin Name: Movie Plugin Extended (OOP)
Description: Registers a top-level menu called "Movie" with submenus "Dashboard" and "Settings", including additional settings which falls under settings-api document.
Version: 1.0
Author: Your Name
*/

class Movie_Plugin_Extended {
    public function __construct() {
        // Hook the menu registration function to the admin_menu action
        add_action('admin_menu', array($this, 'register_menu'));

        // Hook the settings initialization function to the admin_init action
        add_action('admin_init', array($this, 'initialize_settings'));
    }

    // Register the Movie menu and submenus
    public function register_menu() {
        add_menu_page(
            'Movie',              // Page title
            'Movie',              // Menu title
            'manage_options',     // Capability required to access the menu
            'movie_dashboard',    // Menu slug
            array($this, 'dashboard_page') // Callback function to display the menu page
        );

        add_submenu_page(
            'movie_dashboard',    // Parent menu slug
            'Dashboard',          // Page title
            'Dashboard',          // Menu title
            'manage_options',     // Capability required to access the submenu
            'movie_dashboard',    // Menu slug
            array($this, 'dashboard_page') // Callback function to display the submenu page
        );

        add_submenu_page(
            'movie_dashboard',    // Parent menu slug
            'Settings',           // Page title
            'Settings',           // Menu title
            'manage_options',     // Capability required to access the submenu
            'movie_settings',     // Menu slug
            array($this, 'settings_page') // Callback function to display the submenu page
        );
    }

    // Callback function to display the Dashboard menu page
    public function dashboard_page() {
        echo '<h1>Movie Dashboard</h1>';
    }

    // Callback function to display the Settings menu page
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>Movie Settings</h1>

            <form method="post" action="options.php">
                <?php
                settings_fields('movie_settings');
                do_settings_sections('movie_settings');
                submit_button('Save Settings');
                ?>
            </form>
        </div>
        <?php
    }

    // Initialize the settings
    public function initialize_settings() {
        // Register a setting for each input field
        register_setting('movie_settings', 'movie_input_field');
        register_setting('movie_settings', 'movie_radio_button');
        register_setting('movie_settings', 'movie_checkbox');
        register_setting('movie_settings', 'movie_textarea');
        register_setting('movie_settings', 'movie_dropdown');

        // Add a section for the settings
        add_settings_section(
            'movie_settings_section',
            'Movie Settings Section',
            array($this, 'settings_section_callback'),
            'movie_settings'
        );

        // Add fields to the section
        add_settings_field(
            'movie_input_field',
            'Input Field',
            array($this, 'input_field_callback'),
            'movie_settings',
            'movie_settings_section'
        );

        add_settings_field(
            'movie_radio_button',
            'Radio Button',
            array($this, 'radio_button_callback'),
            'movie_settings',
            'movie_settings_section'
        );

        add_settings_field(
            'movie_checkbox',
            'Checkbox',
            array($this, 'checkbox_callback'),
            'movie_settings',
            'movie_settings_section'
        );

        add_settings_field(
            'movie_textarea',
            'Textarea',
            array($this, 'textarea_callback'),
            'movie_settings',
            'movie_settings_section'
        );

        add_settings_field(
            'movie_dropdown',
            'Dropdown',
            array($this, 'dropdown_callback'),
            'movie_settings',
            'movie_settings_section'
        );
    }

    // Callback function to display the settings section description
    public function settings_section_callback() {
        echo 'Customize the Movie plugin settings here.';
    }

    // Callback function to display the input field
    public function input_field_callback() {
        $value = get_option('movie_input_field');
        echo '<input type="text" name="movie_input_field" value="' . esc_attr($value) . '">';
    }

    // Callback function to display the radio button
    public function radio_button_callback() {
        $value = get_option('movie_radio_button');
        $options = array(
            'option1' => 'Option 1',
            'option2' => 'Option 2',
            'option3' => 'Option 3'
        );

        foreach ($options as $key => $label) {
            echo '<label>';
            echo '<input type="radio" name="movie_radio_button" value="' . esc_attr($key) . '" ' . checked($value, $key, false) . '>';
            echo $label;
            echo '</label><br>';
        }
    }

    // Callback function to display the checkbox
    public function checkbox_callback() {
        $value = get_option('movie_checkbox');
        echo '<label>';
        echo '<input type="checkbox" name="movie_checkbox" value="1" ' . checked($value, 1, false) . '>';
        echo 'Enable Checkbox';
        echo '</label>';
    }

    // Callback function to display the textarea
    public function textarea_callback() {
        $value = get_option('movie_textarea');
        echo '<textarea name="movie_textarea" rows="5" cols="50">' . esc_textarea($value) . '</textarea>';
    }

    // Callback function to display the dropdown
    public function dropdown_callback() {
        $value = get_option('movie_dropdown');
        $options = array(
            'option1' => 'Option 1',
            'option2' => 'Option 2',
            'option3' => 'Option 3'
        );

        echo '<select name="movie_dropdown">';
        foreach ($options as $key => $label) {
            echo '<option value="' . esc_attr($key) . '" ' . selected($value, $key, false) . '>' . $label . '</option>';
        }
        echo '</select>';
    }
}

// Instantiate the Movie_Plugin_Extended class
$movie_plugin_extended = new Movie_Plugin_Extended();
