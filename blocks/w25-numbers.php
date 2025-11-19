<?php
/**
 * W25 Numbers Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-numbers-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-numbers';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$display = get_field('display');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if ($display): ?>
        <div class="w25-numbers__content">
            <!-- Add your numbers/statistics content here -->
            <p>Numbers block is enabled and ready to display statistics.</p>
        </div>
    <?php else: ?>
        <div class="w25-numbers__hidden">
            <p>Numbers display is currently disabled.</p>
        </div>
    <?php endif; ?>
</div>
