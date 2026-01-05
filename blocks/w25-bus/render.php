<?php
/**
 * W25 Bus Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-bus-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-bus';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$headline = get_field('headline');
$text = get_field('text');
$cta = get_field('cta');
$image = get_field('image'); // Returns array with 'url', 'id', etc.

// Get background image URL
$background_image_url = '';
if ($image && is_array($image)) {
    $background_image_url = $image['url'];
} elseif ($image) {
    // Fallback if it's just an ID
    $background_image_url = wp_get_attachment_image_url($image, 'full');
}
?>
<div id="<?php echo esc_attr($id); ?>" class="overflow-hidden relative <?php echo esc_attr($className); ?>">
    <div class="relative bg-secondary-light">
        <div class="relative z-10">
            <?php
            // Load mobile template for mobile devices, desktop template for others
            if (wp_is_mobile()) {
                get_template_part('blocks/w25-bus/puzzle-mobile');
            } else {
                get_template_part('blocks/w25-bus/puzzle');
            }
            ?>
        </div>
        <div class="relative top-0 left-0 z-20 w-full h-full lg:absolute">
            <div class="container">
                <div class="max-w-5xl space-y-4 lg:pt-8 lg:pr-8 lg:mb-8 lg:pt-16 lg:w-1/2">
                    <?php if ($headline): ?>
                    <h2
                        class="text-2xl lg:text-4xl xl:text-6xl">
                        <?php echo esc_html($headline); ?>
                    </h2>
                    <?php endif; ?>

                    <?php if ($text): ?>
                    <div class="mb-0 text-xl leading-tight xl:text-2xl font-headings">
                        <?php echo nl2br(esc_html($text)); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($cta): ?>
                        <a href="<?php echo esc_url($cta['url']); ?>" class="btn btn-outline"
                            <?php if ($cta['target']): ?>target="<?php echo esc_attr($cta['target']); ?>"
                            <?php endif; ?>>
                            <?php echo esc_html($cta['title']); ?>
                        </a>
                    <?php endif; ?>
                    <?php if (have_rows('social_media')): ?>
                <?php if ( get_field('social_media_headline') ) : ?>
                <div>
                <h3 class="mt-8 mb-4 text-xl leading-tight xl:text-2xl">
                    <?php echo get_field('social_media_headline'); ?>
                </h3>
                <?php endif; ?>
                <ul class="flex items-center w-full list-none lg:pb-12">
                    <?php while (have_rows('social_media')): the_row();
                        $icon = get_sub_field('icon');
                        $link = get_sub_field('link');
                        if ($icon && $link):
                    ?>
                    <li>
                        <a class="btn btn-ghost btn-sm social-icon-link" href="<?php echo esc_url($link); ?>" target="_blank"
                            rel="noopener noreferrer"
                            onclick="window._paq && window._paq.push(['trackEvent','CTA','Klick','<?php echo esc_url($link); ?>',1])"
                            >
                            <?php
                            $attr = [
                                'class' => 'h-8 w-auto'
                            ];
                            echo wp_get_attachment_image($icon, 'full', false, $attr);
                            ?>
                        </a>
                    </li>
                    <?php
                        endif;
                    endwhile; ?>
                </ul>
                <?php endif; ?>
                </div>
                </div>
            </div>
        </div>

    </div>

</div>