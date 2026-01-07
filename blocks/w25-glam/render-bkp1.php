<?php
/**
 * W25 GLAM Presents Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-glam-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-glam';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$headline = get_field('headline');
$describtion = get_field('describtion');
$glam_cta = get_field('glam_cta');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> bg-accent-light relative">
    <?php if (!is_admin()): ?>
    <div class="overflow-hidden glam-container">
        <div class="relative w-full">
        <img src="<?php echo get_template_directory_uri(); ?>/blocks/w25-glam/transition-top.png" alt="" class="block w-full h-auto">
        <?php
        $glam_puzzles = get_field('glam_puzzles');
        if ($glam_puzzles): ?>
        <div id="glam-puzzles-container" class="absolute top-0 left-0 z-10 w-full h-full pointer-events-none glam-puzzles">
            <?php $puzzle_index = 1;
            foreach ($glam_puzzles as $image_id):
            $image_url = wp_get_attachment_image_url($image_id, 'full');
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            ?>
            <img class="absolute w-full h-auto puzzle-item puzzle-<?php echo $puzzle_index; ?>"
                src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
            <?php $puzzle_index++;
            endforeach; ?>
        </div>
        <?php endif; ?>
        </div>
        <div class="container relative z-20 h-full pb-12">
            <div class="glam-content-sticky pl-[40%] md:pl-[50%]">
                <div class="mr-8 space-y-4 md:space-y-8">
                    <?php if ($headline): ?>
                <h2 class="text-2xl lg:text-3xl xl:text-4xl"><?php echo esc_html($headline); ?></h2>
                <?php endif; ?>

                <?php if ($describtion): ?>
                <div class="text-xl leading-tight md:text-2xl font-headings">
                    <?php echo nl2br(esc_html($describtion)); ?>
                </div>
                <?php endif; ?>

                <?php if ($glam_cta): ?>
                    <a href="<?php echo esc_url($glam_cta['url']); ?>" class="btn btn-outline"
                        <?php if ($glam_cta['target']): ?>target="<?php echo esc_attr($glam_cta['target']); ?>"
                        <?php endif; ?>
                        onclick="window._paq && window._paq.push(['trackEvent','CTA','Klick','GLAM CTA Button',1])"
                        >
                        <?php echo esc_html($glam_cta['title']); ?>
                    </a>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="flex flex-col items-center gap-4 p-8 bg-white border border-dashed rounded-lg">
        <p class="text-base font-bold">W25 GLAM Presents Block</p>
        <p class="text-sm text-gray-600">Click to edit headline and description</p>
    </div>
    <?php endif; ?>
</div>