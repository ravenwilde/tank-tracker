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

/* Meta Boxes for Journal Entry Post Type */
function journal_entry_meta_setup() {
    add_action( 'add_meta_boxes', 'journal_entry_add_water_params_box' );
    add_action( 'save_post', 'journal_entry_save_water_params_box', 10, 2 );
}

    /* Create Water Params Meta Box */
    function journal_entry_add_water_params_box() {
        add_meta_box(
            'water-parameters', //Unique ID
            esc_html( 'Water Parameters', 'example' ), //Box Title
            'journal_entry_water_params_box', //Callback function
            'journal_entry', //Post Type
            'normal', //Context
            'high' //Priority
        );
    }

    /* Water Parameters Meta Box Display */
    function journal_entry_water_params_box( $object, $box) { ?>

        <?php wp_nonce_field( basename( __FILE__ ), 'journal_entry_water_params_nonce' ); ?>
        <p>
            <label for="water-parameters"><?php _e( "Water Parameters", 'example' ); ?></label>
            <br />
            <input class="widefat" type="text" name="water-parameters" id="water-parameters" value="<?php echo esc_attr( get_post_meta( $object->ID, 'water_parameters', true ) ); ?>" size="30" />
        </p>
    <?php }

    /* Save Water Params Meta Box */
    function journal_entry_save_water_params_box( $post_id, $post ) {

        /* Verify the nonce before proceeding. */
        if ( !isset( $_POST['journal_entry_water_params_nonce'] ) || !wp_verify_nonce( $_POST['journal_entry_water_params_nonce'], basename( __FILE__ ) ) )
            return $post_id;

        /* Get the post type object. */
        $post_type = get_post_type_object( $post->post_type );

        /* Check if the current user has permission to edit the post. */
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;

        /* Get the posted data and sanitize it for use as an HTML class. */
        $new_meta_value = ( isset( $_POST['water-parameters'] ) ? sanitize_html_class( $_POST['water-parameters'] ) : '' );

        /* Get the meta key. */
        $meta_key = 'water_parameters';

        /* Get the meta value of the custom field key. */
        $meta_value = get_post_meta( $post_id, $meta_key, true );

        /* If a new meta value was added and there was no previous value, add it. */
        if ( $new_meta_value && '' == $meta_value )
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );

        /* If the new meta value does not match the old value, update it. */
        elseif ( $new_meta_value && $new_meta_value != $meta_value )
            update_post_meta( $post_id, $meta_key, $new_meta_value );

        /* If there is no new meta value but an old value exists, delete it. */
        elseif ( '' == $new_meta_value && $meta_value )
            delete_post_meta( $post_id, $meta_key, $meta_value );
    }

/* Make everything happen */
add_action( 'init', 'register_tank_journal_taxonomy', 0 );
add_action( 'init', 'create_journal_post_types' );
add_action( 'admin_init', 'journal_entry_meta_setup' );

?>