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
$image = get_field('image');
$background_image = get_field('image');
?>
<div id="<?php echo esc_attr($id); ?>" class="overflow-hidden relative <?php echo esc_attr($className); ?>">
    <div class="relative bg-secondary-light">
        <div class="relative z-10">
            <?php //get_template_part('blocks/w25-bus/puzzle'); ?>
        </div>
        <div class="relative top-0 left-0 z-20 w-full h-full">
            <div class="container relative z-20">
                <div class="relative max-w-5xl mb-8 lg:w-1/2 bg-secondary-light">
                    <?php if ($headline): ?>
                    <h2
                        class="pt-24 mb-4 text-3xl before:bg-secondary-light lg:text-6xl before:h-full before:w-full before:absolute before:top-0 before:-left-full">
                        <?php echo esc_html($headline); ?>
                    </h2>
                    <?php endif; ?>

                    <?php if ($text): ?>
                    <div class="mb-4 text-xl font-headings">
                        <?php echo nl2br(esc_html($text)); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($cta): ?>
                    <div class="w25-bus__cta">
                        <a href="<?php echo esc_url($cta['url']); ?>" class="w25-bus__link"
                            <?php if ($cta['target']): ?>target="<?php echo esc_attr($cta['target']); ?>"
                            <?php endif; ?>>
                            <?php echo esc_html($cta['title']); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if (have_rows('social_media')): ?>
                <?php if ( get_field('social_media_headline') ) : ?>
                <h3 class="mb-4 text-center">
                    <?php echo get_field('social_media_headline'); ?>
                </h3>
                <?php endif; ?>
                <ul class="flex items-center justify-center w-full pb-12 list-none">
                    <?php while (have_rows('social_media')): the_row();
                        $icon = get_sub_field('icon');
                        $link = get_sub_field('link');
                        if ($icon && $link):
                    ?>
                    <li>
                        <a class="btn btn-ghost btn-sm social-icon-link" href="<?php echo esc_url($link); ?>" target="_blank"
                            rel="noopener noreferrer">
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