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
$cta = get_field('cta'); // Returns array with 'url', 'title', 'target'
$image = get_field('image'); // Returns array with 'url', 'alt', 'width', 'height', etc.

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="w25-bus__content">
        <?php if ($headline): ?>
            <h2 class="w25-bus__headline">
                <?php echo esc_html($headline); ?>
            </h2>
        <?php endif; ?>

        <?php if ($text): ?>
            <div class="w25-bus__text">
                <?php echo nl2br(esc_html($text)); ?>
            </div>
        <?php endif; ?>

        <?php if ($cta): ?>
            <div class="w25-bus__cta">
                <a href="<?php echo esc_url($cta['url']); ?>"
                   class="w25-bus__link"
                   <?php if ($cta['target']): ?>target="<?php echo esc_attr($cta['target']); ?>"<?php endif; ?>>
                    <?php echo esc_html($cta['title']); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($image): ?>
        <div class="w25-bus__image">
            <img src="<?php echo esc_url($image['url']); ?>"
                 alt="<?php echo esc_attr($image['alt']); ?>"
                 width="<?php echo esc_attr($image['width']); ?>"
                 height="<?php echo esc_attr($image['height']); ?>">
        </div>
    <?php endif; ?>
</div>
