
    register_post_type('tank_journal',
        array(
            'public' => true,
            'menu_position' => 10,
            'hierarchical' => true,
            'labels' => array( 
                'name' => 'Tank Journals', 
                'singular_name' => 'Tank Journal' 
                )
        )
    );

/* Taxonomy to Post Type Redirect */

    function my_term_to_type( $link, $term, $taxonomy ) {

        if ( 'tank-journal' == $taxonomy ) {
            $post_id = my_get_post_id_by_slug( $term->slug, 'tank_journal' );

            if ( !empty( $post_id ) )
                return get_permalink( $post_id );
        }

        return $link;
    }

    function my_get_post_id_by_slug( $slug, $post_type ) {
        global $wpdb;

        $slug = rawurlencode( urldecode( $slug ) );
        $slug = sanitize_title( basename( $slug ) );

        $post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type = %s", $slug, $post_type ) );

        if ( is_array( $post_id ) )
            return $post_id[0];
        elseif ( !empty( $post_id ) );
            return $post_id;

        return false;
    }

/* Tank Journal Custom Template */

function include_tank_journal_template( $template_path ) {
    if ( get_post_type() == 'tank_journal' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-tank_journal.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-tank_journal.php';
            }
        }
    }
    return $template_path;
}

add_filter( 'term_link', 'my_term_to_type', 10, 3 );
add_filter( 'template_include', 'include_tank_journal_template', 1 );

<p>
            <label for="water-parameters"><?php _e( "Water Parameters", 'example' ); ?></label>
            <br />
            <input class="widefat" type="text" name="water-parameters" id="water-parameters" value="<?php echo esc_attr( get_post_meta( $object->ID, 'water_parameters', true ) ); ?>" size="30" />
        </p>

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

add_action( 'admin_init', 'journal_entry_meta_setup' );