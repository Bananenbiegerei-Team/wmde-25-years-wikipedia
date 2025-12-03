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
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> bg-secondary">
    <?php if ($testimonials): ?>
        <div class="container grid grid-cols-1 gap-12 pb-16 md:gap-8 md:grid-cols-2 lg:grid-cols-4">
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="space-y-4">
                    <?php if (!empty($testimonial['image'])):
                        $image_id = $testimonial['image'];
                        $image_url = wp_get_attachment_image_url($image_id, 'four-columns-four-three');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    ?>
                        <img class="w-full h-auto rounded-t-lg" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    <?php endif; ?>

                    <div class="">
                        <?php if (!empty($testimonial['name'])): ?>
                            <h4 class="font-bold font-texts">
                                <?php echo esc_html($testimonial['name']); ?>
                            </h4>
                        <?php endif; ?>

                        <?php if (!empty($testimonial['role'])): ?>
                            <p><?php echo esc_html($testimonial['role']); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($testimonial['text'])): ?>
                        <blockquote class="text-xl leading-tight font-headings">
                            <img class="float-left w-auto h-6 mr-2" src="<?php echo get_template_directory_uri(); ?>/blocks/w25-testimonials/quote-icon-testimonials.svg" alt="Quote">
                            <?php echo nl2br(esc_html($testimonial['text'])); ?>
                        </blockquote>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="w25-testimonials__empty">No testimonials added yet.</p>
    <?php endif; ?>
</div>
