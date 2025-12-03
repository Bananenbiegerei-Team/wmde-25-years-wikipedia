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

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> p-8 flex flex-col md:flex-row items-center justify-center gap-4 font-headings text-xl md:text-3xl">
    <p class="text-xl text-center md:text-3xl md:text-left">Sie wollen die Wikipedia unterstützen?</p><a class="px-3 py-2 text-white transition-colors rounded-lg bg-error hover:bg-error-dark" href="https://spenden.wikimedia.de/">Jetzt spenden</a>
</div>
