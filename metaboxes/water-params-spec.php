<?php

$water_params_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_water_params_meta',
	'title' => 'Water Parameters',
	'types' => array('journal_entry'), // added only for pages and to custom post type "events"
	'context' => 'normal', // same as above, defaults to "normal"
	'priority' => 'high', // same as above, defaults to "high"
	'template' => WP_PLUGIN_DIR . '/tank-tracker/metaboxes/water-params-meta.php',
	'mode' => WPALCHEMY_MODE_ARRAY // defaults to WPALCHEMY_MODE_ARRAY
));

/* eof */