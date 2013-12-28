<?php

include_once WP_PLUGIN_DIR . '/tank-tracker/wpalchemy/MetaBox.php';

// global styles for the meta boxes
if (is_admin()) add_action('admin_enqueue_scripts', 'metabox_style');

function metabox_style() {
	wp_enqueue_style('wpalchemy-metabox', WP_PLUGIN_DIR . '/tank-tracker/metaboxes/meta.css');
}

/* eof */