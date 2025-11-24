<?php
/**
 * W25 News Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-news-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-news';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if (have_rows('news_swiper')): ?>
    <div class="swiper">
        <div class="py-16 swiper-wrapper">
            <?php while (have_rows('news_swiper')): the_row();
                $image = get_sub_field('image');
                $headline = get_sub_field('headline');
                $description = get_sub_field('description');
                $link = get_sub_field('link');
                $background_color = get_sub_field('background_color');
            ?>
            <div class="swiper-slide overflow-hidden rounded-lg <?php echo !empty($background_color) ? 'bg-' . esc_attr($background_color) : 'bg-primary'; ?>">
                <div class="relative">
                    <?php if ($image):
                        $image_url = wp_get_attachment_image_url($image, 'four-columns-four-three');
                        $image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
                    ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    <?php endif; ?>
                    <div class="p-4">
                    <?php if ($headline): ?>
                        <?php if ($link): ?>
                            <h3 class="">
                            <a href="<?php echo esc_url($link['url']); ?>" class="after:content-[''] after:absolute after:inset-0 after:z-10 hover:underline"<?php if (!empty($link['target'])): ?> target="<?php echo esc_attr($link['target']); ?>"<?php endif; ?>>
                                <?php echo esc_html($headline); ?>
                            </a>
                            </h3>
                        <?php else: ?>
                            <h3 class="">
                            <?php echo esc_html($headline); ?>
                            </h3>
                        <?php endif; ?>
                    </h3>
                    <?php endif; ?>

                    <?php if ($description): ?>
                        <?php echo esc_html($description); ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Navigation buttons -->
        <div class="swiper-button-prev">prev</div>
        <div class="swiper-button-next">next</div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <?php else: ?>
    <p class="w25-news__empty">No news items added yet.</p>
    <?php endif; ?>
</div>
