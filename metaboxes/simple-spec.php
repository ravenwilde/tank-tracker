<?php

$custom_metabox = $simple_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_custom_meta',
	'title' => 'My Custom Meta',
	'template' => WP_PLUGIN_DIR . '/tank-tracker/metaboxes/simple-meta.php',
));

/* eof */