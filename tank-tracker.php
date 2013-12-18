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
            'menu_position' => 15,
            'supports' => array( '' ),
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
	$param_ammonia = esc_html( get_post_meta( $journal_entry->ID, 'param_ammonia', true ) );
	$param_nitrite = esc_html( get_post_meta( $journal_entry->ID, 'param_nitrite', true ) );
	$param_nitrate = esc_html( get_post_meta( $journal_entry->ID, 'param_nitrate', true ) );
	$param_kh = esc_html( get_post_meta( $journal_entry->ID, 'param_kh', true ) );
	$param_gh = esc_html( get_post_meta( $journal_entry->ID, 'param_gh', true ) );
	$notes = esc_html( get_post_meta( $journal_entry->ID, 'notes', true ) );
	?>

	<table>
		<tr>
			<td style="width: 100%">PH Reading:</td>
			<td><input type="text" size="10"
			name="jounal_entry_param_ph"
			value="<?php echo $param_ph; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 100%">Ammonia:</td>
			<td><input type="text" size="10"
			name="jounal_entry_param_ammonia"
			value="<?php echo $param_ammonia; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 100%">Nitrite:</td>
			<td><input type="text" size="10"
			name="jounal_entry_param_nitrite"
			value="<?php echo $param_nitrite; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 100%">Nitrate:</td>
			<td><input type="text" size="10"
			name="jounal_entry_param_nitrate"
			value="<?php echo $param_nitrate; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 100%">KH:</td>
			<td><input type="text" size="10"
			name="jounal_entry_param_kh"
			value="<?php echo $param_kh; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 100%">GH:</td>
			<td><input type="text" size="10"
			name="jounal_entry_param_gh"
			value="<?php echo $param_gh; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 100%">Notes:</td>
			<td><textarea rows="10" cols="30" name="jounal_entry_notes" value="<?php echo $notes; ?>" ></textarea>
			</td>
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
			update_post_meta( $journal_entry_id, 'param_ammonia',
			$_POST['journal_entry_param_ammonia'] );
		}
		if ( isset( $_POST['journal_entry_param_nitrite'] ) &&
			$_POST['journal_entry_param_nitrite'] != '' ) {
			update_post_meta( $journal_entry_id, 'param_nitrite',
			$_POST['journal_entry_param_nitrite'] );
		}
		if ( isset( $_POST['journal_entry_param_nitrate'] ) &&
			$_POST['journal_entry_param_nitrate'] != '' ) {
			update_post_meta( $journal_entry_id, 'param_nitrate',
			$_POST['journal_entry_param_nitrate'] );
		}
		if ( isset( $_POST['journal_entry_param_kh'] ) &&
			$_POST['journal_entry_param_kh'] != '' ) {
			update_post_meta( $journal_entry_id, 'param_kh',
			$_POST['journal_entry_param_kh'] );
		}
		if ( isset( $_POST['journal_entry_param_gh'] ) &&
			$_POST['journal_entry_param_gh'] != '' ) {
			update_post_meta( $journal_entry_id, 'param_gh',
			$_POST['journal_entry_param_gh'] );
		}
		if ( isset( $_POST['journal_entry_notes'] ) &&
			$_POST['journal_entry_notes'] != '' ) {
			update_post_meta( $journal_entry_id, 'notes',
			$_POST['journal_entry_notes'] );
		}
	}
}

/* got to 'Creating a Custom Template Dedicated to Custom Post Types' in tutorial */

?>