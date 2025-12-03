<?php
/**
 * W25 Numbers Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-numbers-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-numbers';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$display = get_field('display');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> bg-accent-light overflow-hidden">
    <?php if (!is_admin()): ?>
        <div class="container grid grid-cols-1 items-end h-[120vh] md:grid-cols-2 lg:grid-cols-3 gap-8" id="numbers-parallax-container">
            <div class="number-item">
                <?php get_template_part('blocks/w25-numbers/number-01'); ?>
            </div>
            <div class="flex justify-end md:block number-item">
                <?php get_template_part('blocks/w25-numbers/number-02'); ?>
            </div>
            <div class="number-item">
                <?php get_template_part('blocks/w25-numbers/number-03'); ?>
            </div>
            <div class="flex justify-end number-item md:block">
                <?php get_template_part('blocks/w25-numbers/number-04'); ?>
            </div>
            <div class="number-item">
                <?php get_template_part('blocks/w25-numbers/number-05'); ?>
            </div>
            <div class="flex justify-end number-item md:block">
                <?php get_template_part('blocks/w25-numbers/number-06'); ?>
            </div>
        </div>
    <?php else: ?>
    <div class="p-8">
        <h2 class="text-base font-texts">Numbers are hardcoded. Please contact is@bananenbiegerei.de</h2>
    </div>
    <?php endif; ?>
</div>