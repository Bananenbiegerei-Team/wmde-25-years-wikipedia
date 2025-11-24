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

// Register ACF Blocks using block.json
function register_acf_block_types()
{
	$blocks = [
		'w25-hero-video',
		'w25-welcome-text',
		'w25-testimonials',
		'w25-numbers',
		'w25-bus',
		'w25-news',
	];

	foreach ($blocks as $block) {
		register_block_type(get_template_directory() . '/blocks/' . $block);
	}
}
add_action('acf/init', 'register_acf_block_types');