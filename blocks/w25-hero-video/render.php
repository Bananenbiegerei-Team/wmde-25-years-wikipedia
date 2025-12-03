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
<div id="<?php echo esc_attr($id); ?>" class="w25-video-hero relative  h-screenheader w-full bg-secondary <?php echo esc_attr($className); ?>">
    <div class="relative video-overlay h-screenheader">
        <?php
        $video_swiper_gallery = get_field('video_swiper');
        if ($video_swiper_gallery):
        ?>
            <!-- Swiper container for video stills -->
            <div class="absolute top-0 left-0 w-full h-full swiper hero-swiper">
                <div class="w-full h-full swiper-wrapper">
                    <?php foreach ($video_swiper_gallery as $image):
                        $image_url = wp_get_attachment_image_url($image['ID'], 'full');
                        $image_alt = $image['alt'];
                    ?>
                        <div
                            class="bg-cover swiper-slide"
                            style="background-image: url('<?php echo esc_url($image_url); ?>');"
                            role="img"
                            aria-label="<?php echo esc_attr($image_alt); ?>"
                        >
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/blocks/w25-hero-video/overlay.svg' ); ?>" alt="<?php echo esc_attr( 'Hero Video Placeholder', 'wmde-25-years-wikipedia' ); ?>" class="object-cover w-full h-full relative max-h-[80vh]">
                        <?php get_template_part('blocks/w25-hero-video/play-button'); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="flex items-center justify-center hidden video-container h-screenheader">
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
