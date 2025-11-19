<?php
// Register custom Blocks for W25
// Custom Block Categories
function custom_block_category($categories, $post)
{
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'custom-blocks',
				'title' => __('Custom Blocks', 'custom-blocks'),
			),
		)
	);
}
add_filter('block_categories_all', 'custom_block_category', 10, 2);

// For Icons go to: https://developer.wordpress.org/resource/dashicons/ – But leave out the "dashicons-" Prefix
function register_acf_block_types()
{
	acf_register_block_type([
		'name' => 'w25-hero-video',
		'title'				=> __('W25 Hero Video'),
		'description'		=> __('Video on top with full and looped version'),
		'render_template'	=> 'blocks/w25-hero-video.php',
		'category'			=> 'custom-blocks',
		'icon'				=> 'editor-video',
		'keywords'			=> [],
		'mode' => 'edit',
	]);
}
if (function_exists('acf_register_block_type')) {
	add_action('acf/init', 'register_acf_block_types');
}