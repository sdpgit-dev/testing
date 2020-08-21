<?php
require( obspgb_get_plugin_directory() . '/inc/builder/core/templates/overlay-header.php' );

wp_editor( '', 'obspgb_content_editor', array(
	'tinymce' => array(
		'wp_autoresize_on' => false,
		'resize'           => false,
	),
	'editor_height' => 270
) );

require( obspgb_get_plugin_directory() . '/inc/builder/core/templates/overlay-footer.php' );
