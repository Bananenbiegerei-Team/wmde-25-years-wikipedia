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
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> bg-accent-light overflow-hidden lg:h-[750px]">
    <div class="container h-full">
    <?php if (!is_admin()): ?>
        <?php if ( get_field('headline') ) : ?>
            <h2 class="py-10 mb-8 text-2xl lg:text-4xl xl:text-6xl">
                <?php echo get_field('headline'); ?>
            </h2>
        <?php endif; ?>

        <div class="container relative" id="numbers-parallax-container">
            <div class="number-item lg:absolute lg:top-[0px] lg:left-[10vw]">
                <?php get_template_part('blocks/w25-numbers/number-01'); ?>
            </div>
            <div class="number-item lg:absolute lg:top-[10px] right-[3vw]">
                <div class="-translate-y-[20px] lg:translate-y-0">
                    <?php get_template_part('blocks/w25-numbers/number-02'); ?>
                </div>
            </div>
            <div class="number-item lg:absolute lg:top-[160px] lg:left-[33vw]">
                <div class="-translate-y-[40px] lg:translate-y-0">
                    <?php get_template_part('blocks/w25-numbers/number-03'); ?>
                </div>
            </div>
            <div class="number-item lg:absolute lg:top-[270px] right-[4vw]">
                <div class="-translate-y-[60px] lg:translate-y-0">
                    <?php get_template_part('blocks/w25-numbers/number-04'); ?>
                </div>
            </div>
            <div class="number-item lg:absolute lg:top-[250px] lg:left-0">
                <div class="-translate-y-[80px] lg:translate-y-0">
                    <?php get_template_part('blocks/w25-numbers/number-05'); ?>
                </div>
            </div>
            <div class="number-item lg:absolute lg:top-[400px] lg:left-[20vw]">
                <div class="-translate-y-[100px] lg:translate-y-0 ">
                    <?php get_template_part('blocks/w25-numbers/number-06'); ?>
                </div>
            </div>
        </div>
    <?php else: ?>
    <div class="p-8">
        <h2 class="text-base font-texts">edit numbers!</h2>
    </div>
    <?php endif; ?>
    </div>
</div>