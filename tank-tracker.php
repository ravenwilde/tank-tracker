<?php
/*
Plugin Name: Tank Tracker
Plugin URI: https://github.com/ravenwilde/tank-tracker
Description: A plugin for creating aquarium journals - creates a custom post type for tracking water parameters and a taxonomy for grouping them by specified tank.
Version: 1.0
Author: Jennifer Scroggins
Author URI: http://www.ravenwilde.com/
License: GPLv2
*/

/* Create Tank Journal Taxonomy */

function register_tank_journal_taxonomy() {
    register_taxonomy(
        'tank-journal',
        array( 'journal_entry', 'page'),
        array(
            'public' => true,
            'labels' => array(
                'name' => __( 'Tank Journals' ),
                'singular_name' => __( 'Tank Journal' ),
                'search_items' => __( 'Tank Journals' ),
                'popular_items' => __( 'Popular Tank Journals' ),
                'all_items' => __( 'All Tank Journals' ),
                'parent_item' => __( 'Journal Library' ),
                'parent_item_colon' => __( 'Journal Library:' ),
                'edit_item' => __( 'Edit Tank Journal' ),
                'update_item' => __( 'Update Tank Journal' ),
                'add_new_item' => __( 'Add Tank Journal' ),
                'new_item_name' => __( 'New Tank Journal Name' ),
                ),
            'show_ui'           => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'query_var' => 'tank-journal',
            )

        );
}

/* Journal Entry Custom Post Type */
function create_journal_post_types() {    

    register_post_type( 'journal_entry',
        array(
            'labels' => array(
                'name' => 'Tank Journal Entries',
                'singular_name' => 'Tank Journal Entry',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Tank Journal Entry',
                'edit' => 'Edit',
                'edit_item' => 'Edit Tank Journal Entry',
                'new_item' => 'New Tank Journal Entry',
                'view' => 'View',
                'view_item' => 'View Tank Journal Entry',
                'search_items' => 'Search Tank Journal Entries',
                'not_found' => 'No Tank Journal Entries found',
                'not_found_in_trash' => 'No Tank Journal Entries found in Trash',
                'parent' => 'Parent Tank Journal Entries'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'revisions' ),
            'taxonomies' => array( 'tank-journal' ),
            'has_archive' => true
        )
    );
}

/* setup & call water parameter metaboxes */
include_once 'metaboxes/setup.php';
include_once 'metaboxes/water-params-spec.php';

/* Load Custom CSS */
function register_tank_journal_styles()  
{  
    // Register the style like this for a plugin:  
    wp_register_style( 'tank-journal-style', plugins_url( '/css/tank-journal-style.css', __FILE__ ), array(), '20140103', 'all' );  
    wp_enqueue_style( 'tank-journal-style' );  
}  
  
/* Make everything happen */
add_action( 'init', 'register_tank_journal_taxonomy', 0 );
add_action( 'init', 'create_journal_post_types' );
add_action( 'wp_enqueue_scripts', 'register_tank_journal_styles' );


?>