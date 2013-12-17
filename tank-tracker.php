<?php
/*
Plugin Name: Tank Tracker
Plugin URI: http://www.ravenwilde.com/
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
                'name' => 'Journal Entries',
                'singular_name' => 'Journal Entry',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Journal Entry',
                'edit' => 'Edit',
                'edit_item' => 'Edit Journal Entry',
                'new_item' => 'New Journal Entry',
                'view' => 'View',
                'view_item' => 'View Journal Entry',
                'search_items' => 'Search Journal Entries',
                'not_found' => 'No Journal Entries found',
                'not_found_in_trash' => 'No Journal Entries found in Trash',
                'parent' => 'Parent Journal Entries'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'taxonomies' => array( '' ),
            'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => true
            /* see http://codex.wordpress.org/Function_Reference/register_post_type */
        )
    );
}

add_action( 'admin_init', 'my_admin' );

function my_admin() {
    add_meta_box( 'water_parameters_meta_box',
        'Water Parameters',
        'display_water_parameters_meta_box',
        'journal_entry', 'normal', 'high'
    );
}

function display_water_parameters_meta_box( $journal_entry ) {
	$param_ph = esc_html( get_post_meta( $journal_entry->ID, 'param_ph', true ) );
	$param_ammonia = intval( get_post_meta( $journal_entry->ID, 'param_ammonia', true ) );
	?>

	<table>
		<tr>
			<td style="width: 100%">PH Reading:</td>
			<td><input type="text" size="80"
			name="jounal_entry_param_ph"
			value="<?php echo $param_ph; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 100%">Ammonia:</td>
			<td><input type="text" size="80"
			name="jounal_entry_param_ammonia"
			value="<?php echo $param_ammonia; ?>" /></td>
		</tr>
	</table>
	<?php 
}

add_action( 'save_post', 'add_journal_entry_fields', 10, 2 );

function add_journal_entry_fields( $journal_entry_id,
	$journal_entry ) {
	// Check post type for movie reviews
	if ( $journal_entry->post_type == 'journal_entries' ) {
		// Store data in post meta table if present in post data
		if ( isset( $_POST['jounal_entry_param_ph'] ) &&
			$_POST['jounal_entry_param_ph'] != '' ) {
			update_post_meta( $journal_entry_id, 'param_ph',
			$_POST['jounal_entry_param_ph'] );
		}
		if ( isset( $_POST['journal_entry_param_ammonia'] ) &&
			$_POST['journal_entry_param_ammonia'] != '' ) {
			update_post_meta( $journal_entry_id, 'journal_entry',
			$_POST['journal_entry_param_ammonia'] );
		}
	}
}

/* got to 'Creating a Custom Template Dedicated to Custom Post Types' in tutorial */

?>