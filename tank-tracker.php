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

add_action( 'init', 'create_journal_entry' );

function create_journal_entry() {
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
            'show_ui' => true,
            'publicly_queryable' => false,
			'exclude_from_search' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'revisions' ),
            'taxonomies' => array( 'tank_journal' ),
            'has_archive' => true
        )
    );
}



?>