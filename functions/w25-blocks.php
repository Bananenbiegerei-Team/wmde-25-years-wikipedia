<?php
/**
 * W25 Blocks Integration
 * Includes the blocks initialization system and optional global configuration
 */

// Define text domain constant if not already defined
if (!defined('BB_TEXT_DOMAIN')) {
	define('BB_TEXT_DOMAIN', wp_get_theme()->get('TextDomain'));
}

// Optional: Define global blocks configuration
global $WMDE_BLOCKS_CONFIG;
$WMDE_BLOCKS_CONFIG = array(
	'colors' => array(
		'primary' => '#000099',
		'secondary' => '#009900',
		'neutral' => '#F6F6F6',
		'accent' => '#2878ff',
	),
	// Add more shared configuration here as needed
);

// Include the blocks initialization system
require_once get_template_directory() . '/blocks/init.php';
