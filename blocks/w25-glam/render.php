<?php
/**
 * W25 GLAM Presents Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-glam-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-glam';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$headline = get_field('headline');
$describtion = get_field('describtion');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> bg-accent-light">
    <?php if (!is_admin()): ?>
        <div class="container py-8">
            <?php if ($headline): ?>
                <h2 class="mb-4 text-3xl lg:mb-8 lg:text-6xl"><?php echo esc_html($headline); ?></h2>
            <?php endif; ?>

            <?php if ($describtion): ?>
                <div class="text-lg">
                    <?php echo nl2br(esc_html($describtion)); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center gap-4 p-8 bg-white border border-dashed rounded-lg">
            <p class="text-base font-bold">W25 GLAM Presents Block</p>
            <p class="text-sm text-gray-600">Click to edit headline and description</p>
        </div>
    <?php endif; ?>
</div>
