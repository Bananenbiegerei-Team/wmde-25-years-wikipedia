<?php
/**
 * Event Teaser Block Template
 */

$id = 'event-teaser-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'event-teaser-block';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// ACF Fields
$image = get_field('image');
$headline = get_field('headline');
$text = get_field('text');
$link = get_field('link');

if ($image || $headline || $text || $link): ?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> my-4 md:my-8 bg-gray rounded-xl p-5 md:flex gap-4">
    <?php if ($image): ?>
        <div class="mb-2 basis-1/4 md:mb-0 h-full">
            <?php echo wp_get_attachment_image($image['ID'], 'four-columns-four-three', false, ['class' => 'rounded-lg']); ?>
        </div>
    <?php endif; ?>
    <div class="basis-3/4">
        <?php include(__DIR__ . '/content.php'); ?>
    </div>
</section>

<?php endif; ?>
