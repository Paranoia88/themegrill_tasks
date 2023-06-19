<?php
/*
Plugin Name: Fruits Taxonomy
Description: Creates a custom taxonomy for fruits.
Version: 1.0
Author: Utsav
*/

// Register the custom taxonomy
function fruits_taxonomy() {
    $labels = array(
        'name'              => 'Fruits',
        'singular_name'     => 'Fruit',
        'search_items'      => 'Search Fruits',
        'all_items'         => 'All Fruits',
        'parent_item'       => 'Parent Fruit',
        'parent_item_colon' => 'Parent Fruit:',
        'edit_item'         => 'Edit Fruit',
        'update_item'       => 'Update Fruit',
        'add_new_item'      => 'Add New Fruit',
        'new_item_name'     => 'New Fruit Name',
        'menu_name'         => 'Fruits',
    );

    $args = array(
        'hierarchical'      => false,
        'labels'            => $labels,
        'public'            => true,
        'show_ui'           => true,
        'show_in_nav_menus' => false,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'fruits' ),
        'capabilities' => array(
            'manage_terms' => 'edit_posts',
            'edit_terms'   => 'edit_posts',
            'delete_terms' => 'edit_posts',
            'assign_terms' => 'edit_posts',
        ),
    );
    

    register_taxonomy( 'fruits', 'post', $args );
}
add_action( 'init', 'fruits_taxonomy');

// Flush rewrite rules on activation
function fruits_taxonomy_activation() {
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'fruits_taxonomy_activation' );

// Flush rewrite rules on deactivation
function fruits_taxonomy_deactivation() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'fruits_taxonomy_deactivation' );
