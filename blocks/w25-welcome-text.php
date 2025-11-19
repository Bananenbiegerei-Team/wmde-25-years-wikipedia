<?php
/**
 * W25 Welcome Text Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-welcome-text-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-welcome-text';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$icon_id = get_field('icon');
$icon_url = $icon_id ? wp_get_attachment_image_url($icon_id, 'medium') : '';
$icon_alt = $icon_id ? get_post_meta($icon_id, '_wp_attachment_image_alt', true) : '';
$headline = get_field('headline');
$description = get_field('description');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if ($icon_url): ?>
        <div class="w25-welcome-text__icon">
            <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>">
        </div>
    <?php endif; ?>

    <?php if ($headline): ?>
        <h2 class="w25-welcome-text__headline">
            <?php echo esc_html($headline); ?>
        </h2>
    <?php endif; ?>

    <?php if ($description): ?>
        <div class="w25-welcome-text__description">
            <?php echo nl2br(esc_html($description)); ?>
        </div>
    <?php endif; ?>
</div>
