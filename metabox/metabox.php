<?php
/**
 * 
 * Plugin Name: Metabox Plugin
 * Description: A simple plugin to store, fetch and render information from posts only.
 * Version: 1.0
 * Author: Utsav
 * Author URI:  https://github.com/Paranoia88
 * Text Domain: menu-plugin
 * Need to integrate wp_mail plugin to create a mail system
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class Metabocx {
    public function __construct() {
        $this->init();
    }

    public function init() {
        add_action('add_meta_boxes', array($this, 'add_custom_metabox'));
        add_action('save_post', array($this, 'save_custom_metabox'));
        add_filter('the_content', array($this, 'display_custom_metabox_content'));
    }

    // Add the metabox to the post edit screen
    public function add_custom_metabox() {
        add_meta_box('custom_metabox', 'Custom Metabox', array($this, 'render_custom_metabox'), 'post', 'normal', 'high');
    }

    // Render the metabox fields
    public function render_custom_metabox($post) {
        // Retrieve the existing values
        $custom_text = get_post_meta($post->ID, 'custom_text', true);
        $custom_dropdown = get_post_meta($post->ID, 'custom_dropdown', true);
        $custom_textarea = get_post_meta($post->ID, 'custom_textarea', true);
        
        // Output the fields
        ?>
        <label for="custom_text">Custom Text:</label>
        <input type="text" name="custom_text" value="<?php echo esc_attr($custom_text); ?>">

        <label for="custom_dropdown">Custom Dropdown:</label>
        <select name="custom_dropdown">
            <option value="option1" <?php selected($custom_dropdown, 'option1'); ?>>Option 1</option>
            <option value="option2" <?php selected($custom_dropdown, 'option2'); ?>>Option 2</option>
            <option value="option3" <?php selected($custom_dropdown, 'option3'); ?>>Option 3</option>
        </select>

        <label for="custom_textarea">Custom Textarea:</label>
        <textarea name="custom_textarea"><?php echo esc_textarea($custom_textarea); ?></textarea>
        <?php
    }

    // Save the metabox data
    public function save_custom_metabox($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['custom_text'])) {
            update_post_meta($post_id, 'custom_text', sanitize_text_field($_POST['custom_text']));
        }

        if (isset($_POST['custom_dropdown'])) {
            update_post_meta($post_id, 'custom_dropdown', sanitize_text_field($_POST['custom_dropdown']));
        }

        if (isset($_POST['custom_textarea'])) {
            update_post_meta($post_id, 'custom_textarea', sanitize_textarea_field($_POST['custom_textarea']));
        }
    }

    // Display the metabox content on the front end
    public function display_custom_metabox_content($content) {
        if (is_single()) {
            $custom_text = get_post_meta(get_the_ID(), 'custom_text', true);
            $custom_dropdown = get_post_meta(get_the_ID(), 'custom_dropdown', true);
            $custom_textarea = get_post_meta(get_the_ID(), 'custom_textarea', true);

            ob_start();
            ?>
            <div class="custom-metabox-content">
                <h2>Custom Metabox Content:</h2>
                <p>Custom Text: <?php echo esc_html($custom_text); ?></p>
                <p>Custom Dropdown: <?php echo esc_html($custom_dropdown); ?></p>
                <p>Custom Textarea: <?php echo nl2br(esc_html($custom_textarea)); ?></p>
            </div>
            <?php
            $metabox_content = ob_get_clean();

            $content .= $metabox_content;
        }

        return $content;
    }
    }

    $metabocx = new Metabocx();
