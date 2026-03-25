<?php
/**
 * ACF Block: Button
 * Basecoat classes: btn, btn-sm, btn-lg, btn-secondary, btn-destructive, btn-outline, btn-ghost, btn-link
 * Note: btn-primary doesn't exist - primary is the default (just btn)
 */

$link = get_field('link') ?: ['title' => 'Missing Link!', 'url' => '#', 'target' => '_self'];
$size = get_field('size') ?: 'default';
$position = get_field('position') ?: 'justify-start';
$color = get_field('colors') ?: 'primary';
$design = get_field('design') ?: 'default';

// Build button class: btn-{size}-{color}-{design}
// Primary color = no color suffix (btn is primary by default)
// Default design = no design suffix
$parts = ['btn'];

// Size: sm, lg (skip for default)
if (!in_array($size, ['default', ''])) {
    $size_clean = str_replace('btn-', '', $size); // Remove btn- prefix if present
    $parts[] = $size_clean;
}

// Color: secondary, destructive (skip for primary - it's the default)
if ($color && $color !== 'primary') {
    $parts[] = $color;
}

// Design: outline, ghost (skip for default)
if ($design && $design !== 'default') {
    $parts[] = $design;
}

$btn_class = implode('-', $parts);
?>
<div id="<?= esc_attr($block['id']) ?>" class="bb-block-button flex lg:<?= esc_attr($position) ?>">
    <a class="<?= esc_attr($btn_class) ?>" href="<?= esc_url($link['url']) ?>" target="<?= esc_attr($link['target']) ?>">
        <?= esc_html($link['title']) ?>
    </a>
</div>