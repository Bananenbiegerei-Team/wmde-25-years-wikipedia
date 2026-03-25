<?php
/**
 * Video Portrait Text Block Template
 */

$id = 'video-portrait-text-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'video-portrait-text-block';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// Fetch Groups
$video_content = get_field('videoContent');
$text_content  = get_field('textContent');

if ($video_content || $text_content): ?>

<section id="<?php echo esc_attr($id); ?>" class="relative my-8 md:my-16 w-full <?php echo esc_attr($className); ?>">
    <div class="gap-10 md:flex">
        <div class="flex flex-col justify-center mb-10 space-y-2 basis-2/3 md:order-2 md:col-span-5 md:md-0">
            <div>
                <?php if (!empty($text_content['preTitle'])): ?>
                <p class="mb-1 text-sm font-bold uppercase">
                    <?php echo esc_html($text_content['preTitle']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($text_content['title'])): ?>
                <h2 >
                    <?php echo esc_html($text_content['title']); ?>
                </h2>
            <?php endif; ?>
            </div>

            <?php if (!empty($text_content['content'])): ?>
                <p class="content">
                    <?php echo wp_kses($text_content['content'], [
                        'a' => [
                            'href' => [],
                            'target' => [],
                            'rel' => [],
                            'class' => [],
                        ],
                        'strong' => [],
                        'em' => [],
                        'br' => [],
                        'span' => ['class' => []],
                    ]); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="relative grid w-full h-full basis-1/3 md:order-1">
            <?php if ($video_content):
                $video      = $video_content['video'];
                $poster_id  = $video_content['poster'];
                $unique_id  = 'video-portrait-' . $block['id'];
                $title      = '';
                $subtitle   = '';
            ?>
                <?php include locate_template('blocks/video-partials/video-player.php'); ?>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php endif; ?>