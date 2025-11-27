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
<div id="<?php echo esc_attr($id); ?>" class="relative aspect-[1.769] max-h-[80vh] bg-[#F0BC00] <?php echo esc_attr($className); ?>">
    <h1 class="sr-only">Wikipedia 25</h1>

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
        class="px-[20px] py-[8px] bg-[#F21B5A] rounded-[8px] text-3xl text-white  absolute left-1/2 top-[calc(50%+4rem)] -translate-x-1/2"
    > Video ansehen! </button>

</div>

