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
    <div class="grid grid-cols-4 gap-8 mx-auto md:grid-cols-8">
        <div class="flex flex-col justify-center col-span-4 space-y-2 md:order-2 md:col-span-5">
            <div>
                <?php if (!empty($text_content['preTitle'])): ?>
                <p class="mb-1 text-sm font-bold uppercase">
                    <?php echo esc_html($text_content['preTitle']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($text_content['title'])): ?>
                <h2 class="mb-2 text-2xl lg:text-3xl xl:text-4xl">
                    <?php echo esc_html($text_content['title']); ?>
                </h2>
            <?php endif; ?>
            </div>

            <?php if (!empty($text_content['content'])): ?>
                <p class="mb-0 text-xl leading-tight lg:text-2xl font-headings">
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

        <div class="relative grid w-full h-full col-span-4 md:order-1 md:col-span-3">
            <?php if ($video_content):
                $video      = $video_content['video'];
                $width      = $video['width'] ?? null;
                $height     = $video['height'] ?? null;
                $style_ratio = ($width && $height) ? "aspect-ratio: {$width} / {$height};" : "aspect-ratio: 9 / 16;";
                $poster_id  = $video_content['poster'];
                $poster_url = wp_get_attachment_image_url($poster_id, 'full');
            ?>
                <div class="relative w-full overflow-hidden overrides-portrait-video group">

                    <div class="plyr__video-embed" style="<?php echo esc_attr($style_ratio); ?>">
                        <video
                            class="js-plyr-video"
                            preload="metadata"
                            playsinline
                            poster="<?php echo esc_url($poster_url); ?>"
                        >
                            <source src="<?php echo esc_url($video['url']); ?>" type="<?php echo esc_attr($video['mime_type']); ?>">
                        </video>
                    </div>

                    <button class="absolute inset-0 z-30 flex items-center justify-center w-16 h-16 m-auto text-white transition-all duration-300 border-[1px] border-black/50 rounded-full shadow-xl bg-black/50 play-button hover:bg-black group-hover:scale-110">
                        <svg class="translate-x-[2px]" width="1.5em" height="1.5em" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 2.00537C0 0.387327 1.82137 -0.560979 3.14692 0.36691L12.6593 7.0256C13.7968 7.8218 13.7968 9.50632 12.6593 10.3025L3.14692 16.9612C1.82137 17.8891 0 16.9408 0 15.3228V2.00537Z" fill="currentColor"/>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php endif; ?>