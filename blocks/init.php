<?php
/**
 * ACF Blocks Initialization System
 * Automatically discovers and registers ACF blocks with block.json
 */

// Define constants
define('WMDE_BB_BLOCKS_DIR', 'blocks');
define('WMDE_BB_BLOCKS_PATH', get_template_directory() . '/' . WMDE_BB_BLOCKS_DIR);

// Define text domain constant if not already defined
if (!defined('BB_TEXT_DOMAIN')) {
	define('BB_TEXT_DOMAIN', wp_get_theme()->get('TextDomain'));
}

/**
 * Register custom block category
 */
add_filter('block_categories_all', function ($categories) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'custom-blocks',
				'title' => __('Custom Blocks', BB_TEXT_DOMAIN),
			),
		)
	);
}, 10, 2);

/**
 * Get all available block directories
 */
function wmde_get_available_blocks()
{
	$blocks = array();
	$block_dirs = glob(WMDE_BB_BLOCKS_PATH . '/*', GLOB_ONLYDIR);

	if (!empty($block_dirs)) {
		foreach ($block_dirs as $block_dir) {
			$block_name = basename($block_dir);
			// Check if block.json exists
			if (file_exists($block_dir . '/block.json')) {
				$blocks[$block_name] = $block_name;
			}
		}
	}

	return $blocks;
}

/**
 * Check if a block should be loaded
 */
function wmde_should_load_block($block_name)
{
	// Always load all blocks by default (simplest approach)
	// You can enable the options-based filtering by uncommenting below

	/* Option-based filtering:
	$load_all = get_field('load_all_wmde_blocks', 'option');
	if ($load_all) {
		return true;
	}

	$enabled_blocks = get_field('wmde_blocks_enabled', 'option');
	if (is_array($enabled_blocks) && in_array($block_name, $enabled_blocks)) {
		return true;
	}

	// Default: load all blocks if no options are set
	if (empty($enabled_blocks)) {
		return true;
	}

	return false;
	*/

	return true;
}

/**
 * Register ACF Blocks
 */
add_action('acf/init', function () {
	$block_dirs = glob(WMDE_BB_BLOCKS_PATH . '/*', GLOB_ONLYDIR);

	if (!empty($block_dirs)) {
		foreach ($block_dirs as $block_dir) {
			$block_name = basename($block_dir);
			$block_json = $block_dir . '/block.json';

			// Check if block.json exists and block should be loaded
			if (file_exists($block_json) && wmde_should_load_block($block_name)) {
				// Register the block
				register_block_type($block_dir);

				// Load optional functions.php for this block
				$block_functions = $block_dir . '/functions.php';
				if (file_exists($block_functions)) {
					require_once $block_functions;
				}
			}
		}
	}
});

/**
 * Enqueue block-specific styles
 */
add_action('wp_enqueue_scripts', function () {
	$block_dirs = glob(WMDE_BB_BLOCKS_PATH . '/*', GLOB_ONLYDIR);

	if (!empty($block_dirs)) {
		foreach ($block_dirs as $block_dir) {
			$block_name = basename($block_dir);

			// Check if block should be loaded
			if (wmde_should_load_block($block_name)) {
				// Check for style.css or style.scss
				$style_css = $block_dir . '/style.css';
				$style_scss = $block_dir . '/style.scss';

				if (file_exists($style_css)) {
					wp_enqueue_style(
						'block-' . $block_name,
						get_template_directory_uri() . '/blocks/' . $block_name . '/style.css',
						array(),
						filemtime($style_css)
					);
				} elseif (file_exists($style_scss)) {
					// SCSS files need to be compiled first
					// For now, we'll just note they exist
					// You'll need to compile them to CSS or use a build process
				}
			}
		}
	}
}, 100);

/**
 * Load ACF JSON from block directories
 */
add_filter('acf/settings/load_json', function ($paths) {
	$block_dirs = glob(WMDE_BB_BLOCKS_PATH . '/*', GLOB_ONLYDIR);

	if (!empty($block_dirs)) {
		foreach ($block_dirs as $block_dir) {
			// Check if block should be loaded and has ACF JSON files
			$block_name = basename($block_dir);
			if (wmde_should_load_block($block_name) && is_dir($block_dir)) {
				// Check if there are any group_*.json files
				$json_files = glob($block_dir . '/group_*.json');
				if (!empty($json_files)) {
					$paths[] = $block_dir;
				}
			}
		}
	}

	return $paths;
});

/**
 * Filter allowed block types based on ACF options
 */
add_filter('allowed_block_types_all', function ($allowed_block_types, $block_editor_context) {
	// Get WordPress blocks settings
	$load_all_wp_blocks = get_field('load_all_wp_blocks', 'option');
	$enabled_wp_blocks = get_field('wp_blocks_enabled', 'option');

	// If load all WP blocks is enabled, return true (all blocks allowed)
	if ($load_all_wp_blocks) {
		return true;
	}

	// If no WP blocks are specifically enabled, allow all by default
	if (empty($enabled_wp_blocks)) {
		return true;
	}

	// Build array of allowed blocks
	$allowed_blocks = is_array($enabled_wp_blocks) ? $enabled_wp_blocks : array();

	// Always allow our custom blocks
	$custom_blocks = wmde_get_available_blocks();
	foreach ($custom_blocks as $block_name) {
		if (wmde_should_load_block($block_name)) {
			$allowed_blocks[] = 'acf/' . $block_name;
		}
	}

	return $allowed_blocks;
}, 10, 2);

/**
 * Create ACF Options Page for Block Management
 */
if (function_exists('acf_add_options_page')) {
	add_action('acf/init', function () {
		acf_add_options_page(array(
			'page_title'  => __('Block Settings', BB_TEXT_DOMAIN),
			'menu_title'  => __('Block Settings', BB_TEXT_DOMAIN),
			'menu_slug'   => 'wmde-block-settings',
			'capability'  => 'manage_options',
			'redirect'    => false,
			'icon_url'    => 'dashicons-block-default',
		));
	});
}

/**
 * Register ACF fields for options page
 */
add_action('acf/init', function () {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	// Get available blocks
	$available_blocks = wmde_get_available_blocks();
	$block_choices = array();
	foreach ($available_blocks as $block_name) {
		$block_choices[$block_name] = ucfirst(str_replace('-', ' ', $block_name));
	}

	// Get available WordPress core blocks
	$wp_block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
	$wp_block_choices = array();
	foreach ($wp_block_types as $block_type) {
		// Only include core blocks (core/*)
		if (strpos($block_type->name, 'core/') === 0) {
			$wp_block_choices[$block_type->name] = $block_type->title;
		}
	}
	ksort($wp_block_choices);

	acf_add_local_field_group(array(
		'key' => 'group_wmde_block_settings',
		'title' => __('Block Management', BB_TEXT_DOMAIN),
		'fields' => array(
			array(
				'key' => 'field_load_all_wmde_blocks',
				'label' => __('Enable All Custom Blocks', BB_TEXT_DOMAIN),
				'name' => 'load_all_wmde_blocks',
				'type' => 'true_false',
				'instructions' => __('Enable this to automatically load all custom blocks, regardless of the selection below.', BB_TEXT_DOMAIN),
				'default_value' => 1,
				'ui' => 1,
			),
			array(
				'key' => 'field_wmde_blocks_enabled',
				'label' => __('Enabled Custom Blocks', BB_TEXT_DOMAIN),
				'name' => 'wmde_blocks_enabled',
				'type' => 'select',
				'instructions' => __('Select which custom blocks should be available in the editor.', BB_TEXT_DOMAIN),
				'choices' => $block_choices,
				'default_value' => array(),
				'allow_null' => 1,
				'multiple' => 1,
				'ui' => 1,
				'ajax' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_load_all_wmde_blocks',
							'operator' => '!=',
							'value' => '1',
						),
					),
				),
			),
			array(
				'key' => 'field_load_all_wp_blocks',
				'label' => __('Enable All WordPress Core Blocks', BB_TEXT_DOMAIN),
				'name' => 'load_all_wp_blocks',
				'type' => 'true_false',
				'instructions' => __('Enable this to allow all WordPress core blocks in the editor.', BB_TEXT_DOMAIN),
				'default_value' => 1,
				'ui' => 1,
			),
			array(
				'key' => 'field_wp_blocks_enabled',
				'label' => __('Enabled WordPress Blocks', BB_TEXT_DOMAIN),
				'name' => 'wp_blocks_enabled',
				'type' => 'select',
				'instructions' => __('Select which WordPress core blocks should be available in the editor.', BB_TEXT_DOMAIN),
				'choices' => $wp_block_choices,
				'default_value' => array(),
				'allow_null' => 1,
				'multiple' => 1,
				'ui' => 1,
				'ajax' => 0,
				'conditional_logic' => array(
					array(
						array(
							'field' => 'field_load_all_wp_blocks',
							'operator' => '!=',
							'value' => '1',
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'wmde-block-settings',
				),
			),
		),
	));
});
