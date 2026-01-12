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
                <div class="relative space-y-4">
                    <?php if (!empty($testimonial['image'])):
                        $image_id = $testimonial['image'];
                        $image_url = wp_get_attachment_image_url($image_id, 'four-columns-four-three');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        $image_caption = wp_get_attachment_caption($image_id);
                    ?>
                    <div class="relative group/portrait">
                        <img class="w-full h-auto rounded-t-xl" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        <?php if (!empty($image_caption)): ?>
                            <div class="absolute bottom-0 left-0 items-center hidden w-full gap-2 p-2 text-sm text-white bg-black/80 group-hover/portrait:flex">
                                <div>
                                    <svg class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>
                                </div>
                                <div>
                                    <?php echo $image_caption; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div>
                        <?php if (!empty($testimonial['name'])): ?>
                            <h4 class="text-base">
                                <?php echo esc_html($testimonial['name']); ?>
                            </h4>
                        <?php endif; ?>

                        <?php if (!empty($testimonial['role'])): ?>
                            <p class="text-base font-headings"><?php echo esc_html($testimonial['role']); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($testimonial['text'])): ?>
                        <blockquote class="text-xl leading-tight">
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
