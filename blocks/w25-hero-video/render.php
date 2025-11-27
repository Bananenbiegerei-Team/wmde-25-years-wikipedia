<?php
/**
 * W25 Hero Video Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-hero-video-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$full_video  = get_field('full_video');
$video_loop  = get_field('video_loop');
$poster_id   = get_field('poster_image');

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-hero-video';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
// Add your ACF field retrieval here, for example:
// $video_url = get_field('video_url');
// $video_loop = get_field('video_loop');

?>
<div id="<?php echo esc_attr($id); ?>" class="w25-video-hero relative aspect-[1.769] max-h-[80vh] bg-[#F0BC00] <?php echo esc_attr($className); ?>">
    <h1 class="sr-only">Wikipedia 25</h1>

    <div class="video-overlay">

        <video
            class="absolute top-0 left-0 w-full h-full object-cover"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
            <?php if ($poster_url): ?>poster="<?= esc_url($poster_url) ?>"<?php endif; ?>
        >
            <source src="<?= esc_url($video_loop['url']) ?>" type="<?= esc_attr($video_loop['mime_type']) ?>">
        </video>

        <img
            src="<?php echo esc_url( get_template_directory_uri() . '/blocks/w25-hero-video/overlay.svg' ); ?>"
            alt="<?php echo esc_attr( 'Hero Video Placeholder', 'wmde-25-years-wikipedia' ); ?>"
            class="object-cover w-full h-full relative max-h-[80vh]"
        ></<img>

        <button 
            class="play-button absolute left-1/2 top-[calc(50%+4rem)] -translate-x-1/2 flex items-center justify-center gap-4 group"
            aria-label="<?php echo esc_attr( 'Play full video', 'wmde-25-years-wikipedia' ); ?>"
        > 
           <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle class="transition-[fill-opacity] [fill-opacity:.1] group-hover:[fill-opacity:1]" cx="40" cy="40" r="39" fill="black"  stroke="black" stroke-width="2"/>
                <path class="fill-black group-hover:fill-[#F0BC00]" d="M30 25.8171C30 24.2038 31.812 23.2544 33.1384 24.1728L53.6248 38.3556C54.7736 39.1509 54.7736 40.8491 53.6248 41.6444L33.1384 55.8273C31.812 56.7456 30 55.7962 30 54.1829V25.8171Z"/>
            </svg>

            Play Video

        </button>
    </div>

    <div class="video-container hidden py-16">
                <?php
                $poster_url = '';
                if ( $poster_id ) {
                    $poster_url = wp_get_attachment_image_url( $poster_id, 'full' );
                }
                $player_id = $id . '-plyr';
                ?>
                <video
                    id="<?php echo esc_attr( $player_id ); ?>"
                    class="plyr"
                    controls
                    playsinline
                    preload="metadata"
                    style="display:none;"
                    loop="true"
                    <?php if ( $poster_url ): ?>poster="<?php echo esc_url( $poster_url ); ?>"<?php endif; ?>
                >
                    <?php if ( ! empty( $full_video['url'] ) ): ?>
                        <source src="<?php echo esc_url( $full_video['url'] ); ?>" type="<?php echo esc_attr( $full_video['mime_type'] ?? 'video/mp4' ); ?>">
                    <?php endif; ?>
                </video>
    </div>
</div>

