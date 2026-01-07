<?php
/**
 * W25 Donate CTA Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-donate-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-donate';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$cta_text = get_field('cta_text') ?: 'Sie wollen die Wikipedia unterstützen?';
$button_text = get_field('button_text') ?: 'Jetzt spenden';
$button_link = get_field('button_link') ?: 'https://spenden.wikimedia.de/';
?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> bg-accent-light p-8 pt-0 lg:py-16 flex flex-col md:flex-row items-center justify-center gap-4">
    <p class="text-xl text-center md:text-2xl md:text-left font-headings"><?php echo esc_html($cta_text); ?></p>
    <a class="px-6 py-1 text-xl text-white transition-colors rounded-lg bg-error hover:bg-error-dark md:text-2xl font-menus" href="<?php echo esc_url($button_link); ?>"
    onclick="window._paq && window._paq.push(['trackEvent','CTA','Klick','Spenden CTA in content',1])"
    >
        <?php echo esc_html($button_text); ?>
    </a>
</div>
