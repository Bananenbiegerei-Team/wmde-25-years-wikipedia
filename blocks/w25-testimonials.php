<?php
/**
 * W25 Testimonials Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-testimonials-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-testimonials';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$testimonials = get_field('testimials'); // Note: typo in field name from ACF

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if ($testimonials): ?>
        <div class="w25-testimonials__grid">
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="w25-testimonials__item">
                    <?php if (!empty($testimonial['image'])):
                        $image_id = $testimonial['image'];
                        $image_url = wp_get_attachment_image_url($image_id, 'medium');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    ?>
                        <div class="w25-testimonials__image">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($testimonial['text'])): ?>
                        <blockquote class="w25-testimonials__quote">
                            <?php echo nl2br(esc_html($testimonial['text'])); ?>
                        </blockquote>
                    <?php endif; ?>

                    <div class="w25-testimonials__author">
                        <?php if (!empty($testimonial['name'])): ?>
                            <div class="w25-testimonials__name">
                                <?php echo esc_html($testimonial['name']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($testimonial['role'])): ?>
                            <div class="w25-testimonials__role">
                                <?php echo esc_html($testimonial['role']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="w25-testimonials__empty">No testimonials added yet.</p>
    <?php endif; ?>
</div>
