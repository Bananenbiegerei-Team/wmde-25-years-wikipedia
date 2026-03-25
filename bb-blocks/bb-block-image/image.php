<?php
/* ACF Block: Image
 */

$image_id = get_field('image') ?: $args['image']['id'] ?? false;

if (!$image_id) {
	return;
}

$image_caption = strip_tags(wp_get_attachment_caption($image_id), ['a']);
$image_meta_data = wp_get_attachment_metadata($image_id);
$image_link = get_field('image_link');
$image_link_aria_label = get_field('image_link_aria_label');

// Get values for container and image classes
if ($image_meta_data && ($image_meta_data['width'] ?? 2) * 0.74 < ($image_meta_data['height'] ?? 1)) {
	// Portrait (SVG images have no size metadata so we force landscape for them)
	$figure_classes = 'mb-2 portrait flex flex-col justify-center relative overflow-hidden';
	$image_attr = ['class' => 'h-full w-auto'];
} else {
	// Landscape
	$figure_classes = 'mb-2 flex flex-col relative';
	$image_attr = ['class' => 'w-full h-auto'];
}
// Force unset 'sizes' image attribute to let the browser pick the right image (WP does something weird here...)
$image_attr['sizes'] = ' ';
$image_attr['loading'] = 'lazy';

$figure_classes .= $image_caption ? ' group' : ' no_caption';
$caption_classes =
	'flex absolute opacity-0 group-hover:opacity-80 transition-opacity left-0 bottom-0 right-0 text-white bg-gray-900 w-auto h-auto z-20 p-2 md:px-6 text-sm items-start gap-2 break-all rounded-b-lg md:rounded-b-2xl';

// Create image tag
$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
$image_attr['alt'] = esc_attr($alt);
$size = $args['size'] ?? 'full';
$image = wp_get_attachment_image($image_id, $size, '', $image_attr);
$attachment = get_post($image_id);
$description = $attachment ? $attachment->post_content : '';

// Wrap image in A tag if needed
$link_open = '';
$link_close = '';
if ($image_link) {
	$aria_attr = $image_link_aria_label
		? ' aria-label="' . esc_attr($image_link_aria_label) . '"'
		: '';
	$link_open = '<a href="' . esc_url($image_link) . '"' . $aria_attr . '>';
	$link_close = '</a>';
}
?>

<div class="bb-image-block">
	<?= $link_open ?>
	<figure class="<?= $figure_classes ?>" role="group">
		<?= $image ?>
		<?php if (is_string($image_caption) && !empty($image_caption)): ?>
		<figcaption class="<?= $caption_classes ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="self-center shrink-0"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m1 15h-2v-6h2zm0-8h-2V7h2z"/></svg>
			<div class="self-center"><?= $image_caption ?></div>
		</figcaption>
		<?php endif; ?>
	</figure>
	<?= $link_close ?>
	<?php if (is_string($description) && !empty($description)): ?>
	<p class="text-sm"><?= $description ?></p>
	<?php endif; ?>
</div>
