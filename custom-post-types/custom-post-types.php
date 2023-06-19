<?php
/**
 * Plugin Name: Movie Custom Post Type
 * Description: Creates a custom post type for Movies with custom metaboxes.
 * Version: 1.0
 * Author: Utsav
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Movie Custom Post Type Class
class Movie_Custom_Post_Type {
    public function __construct() {
        add_action( 'init', array( $this, 'register_movie_post_type' ) );
        add_action( 'add_meta_boxes_movie', array( $this, 'add_movie_metaboxes' ) );
        add_action( 'save_post_movie', array( $this, 'save_movie_details' ) );
    }

    // Register the Movie custom post type
    public function register_movie_post_type() {
        $labels = array(
            'name'               => 'Movies',
            'singular_name'      => 'Movie',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Movie',
            'edit_item'          => 'Edit Movie',
            'new_item'           => 'New Movie',
            'view_item'          => 'View Movie',
            'search_items'       => 'Search Movies',
            'not_found'          => 'No movies found',
            'not_found_in_trash' => 'No movies found in Trash',
            'parent_item_colon'  => 'Parent Movie:',
            'menu_name'          => 'Movies',
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'movie' ),
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => array( 'title', 'editor', 'thumbnail' ),
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-video-alt2',
            'register_meta_box_cb' => array( $this, 'add_movie_metaboxes' ),
        );

        register_post_type( 'movie', $args );
    }

    // Add custom metaboxes for Movie details
    public function add_movie_metaboxes() {
        add_meta_box(
            'movie_details',
            'Movie Details',
            array( $this, 'movie_details_callback' ),
            'movie',
            'normal',
            'default'
        );
    }

    // Callback function for Movie details metabox
    public function movie_details_callback( $post ) {
        // Retrieve the current values of the movie details
        $release_date = get_post_meta( $post->ID, 'release_date', true );
        $director = get_post_meta( $post->ID, 'director', true );
        $casts = get_post_meta( $post->ID, 'casts', true );

        // Output the metabox HTML
        ?>
        <label for="release_date">Release Date:</label>
        <input type="text" name="release_date" id="release_date" value="<?php echo esc_attr( $release_date ); ?>" />

        <label for="director">Director:</label>
        <input type="text" name="director" id="director" value="<?php echo esc_attr( $director ); ?>" />

        <label for="casts">Casts:</label>
        <input type="text" name="casts" id="casts" value="<?php echo esc_attr( $casts ); ?>" />
        <?php
    }

    // Save Movie details when the post is saved
    public function save_movie_details( $post_id ) {
        if ( isset( $_POST['release_date'] ) ) {
            update_post_meta( $post_id, 'release_date', sanitize_text_field( $_POST['release_date'] ) );
        }

        if ( isset( $_POST['director'] ) ) {
            update_post_meta( $post_id, 'director', sanitize_text_field( $_POST['director'] ) );
        }

        if ( isset( $_POST['casts'] ) ) {
            update_post_meta( $post_id, 'casts', sanitize_text_field( $_POST['casts'] ) );
        }
    }
}

// Instantiate the Movie_Custom_Post_Type class
$movie_custom_post_type = new Movie_Custom_Post_Type();
