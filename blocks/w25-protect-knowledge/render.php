<?php
/**
 * W25 Protect Knowledge Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-protect-knowledge-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-protect-knowledge';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Get the headline field
$block_headline = get_field('headline');
?>
<?php if (!is_admin()): ?>
<div id="<?php echo esc_attr($id); ?>" class="container <?php echo esc_attr($className); ?> py-8">
    <?php if ($block_headline): ?>
        <h2 class="max-w-2xl mb-4 text-3xl lg:mb-8 lg:text-5xl"><?php echo esc_html($block_headline); ?></h2>
    <?php endif; ?>
    <?php if (have_rows('knowledge_swiper')): ?>
    <div class="flex items-center">
        <!-- Navigation button - Previous -->
        <div class="!w-8 lg:!w-16 swiper-button-prev">
            <?php echo bb_icon('arrow-left', 'custom-class'); ?>
        </div>

        <!-- Swiper container -->
        <div class="flex-1 swiper">
            <div class="swiper-wrapper">
                <?php while (have_rows('knowledge_swiper')): the_row();
                    $image = get_sub_field('image');
                    $headline = get_sub_field('headline');
                    $description = get_sub_field('description');
                    $link = get_sub_field('link');
                    $background_color = get_sub_field('background_color');
                ?>
                <div class="swiper-slide md:min-h-[430px] overflow-hidden rounded-lg <?php echo !empty($background_color) ? 'bg-' . esc_attr($background_color) : 'bg-primary'; ?>">
                    <div class="relative">
                        <?php if ($image):
                            $image_url = wp_get_attachment_image_url($image, 'four-columns-four-three');
                            $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
                        ?>
                            <img class="w-full" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        <?php endif; ?>
                        <div class="p-4">
                        <?php if ($headline): ?>
                            <?php if ($link): ?>
                                <h3 class="mb-2 lg:text-3xl">
                                <a href="<?php echo esc_url($link['url']); ?>" class="after:content-[''] after:absolute after:inset-0 after:z-10 hover:underline hover:underline-offset-2 decoration-1"<?php if (!empty($link['target'])): ?> target="<?php echo esc_attr($link['target']); ?>"<?php endif; ?>>
                                    <?php echo esc_html($headline); ?>
                                </a>
                                </h3>
                            <?php else: ?>
                                <h3 class="mb-2 lg:text-3xl">
                                <?php echo esc_html($headline); ?>
                                </h3>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($description): ?>
                            <p class="line-clamp-4"><?php echo esc_html($description); ?></p>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-4 swiper-pagination"></div>
        </div>

        <!-- Navigation button - Next -->
        <div class="!w-8 lg:!w-16 swiper-button-next">
            <?php echo bb_icon('arrow-right', 'custom-class'); ?>
        </div>
    </div>

    <?php else: ?>
    <p class="w25-protect-knowledge__empty">No items added yet.</p>
    <?php endif; ?>
</div>

<?php else: ?>
<div class="flex flex-col items-center gap-4 p-8 bg-white border border-dashed rounded-lg">
    <p>Click to edit W25 Protect Knowledge Swiper</p>
    <img class="w-128" src="<?php echo get_template_directory_uri(); ?>/blocks/w25-protect-knowledge/w25-protect-knowledge-preview.png" alt="W25 Protect Knowledge Preview">
</div>
<?php endif; ?>