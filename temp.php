
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