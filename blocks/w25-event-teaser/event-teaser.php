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
$date = get_field('date');

if ($image || $headline || $text || $link || $date): ?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> group/event relative my-4 md:my-8 bg-gray rounded-xl p-5 md:flex gap-4 ">
    <?php if ($image): ?>
        <div class="h-full mb-2 basis-1/3 md:mb-0">
            <?php echo wp_get_attachment_image($image['ID'], 'four-columns-sixteen-nine', false, ['class' => 'rounded-lg group-hover/event:opacity-50 transition w-full h-auto']); ?>
        </div>
    <?php endif; ?>
    <div class="basis-2/3">
        <?php include(__DIR__ . '/content.php'); ?>
    </div>
</section>

<?php endif; ?>
