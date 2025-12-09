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
<div id="<?php echo esc_attr($id); ?>" class="w25-video-hero relative w-full bg-secondary <?php echo esc_attr($className); ?>">
    <div class="relative h-mobilescreenheader video-overlay md:h-screenheader">
        <?php get_template_part('blocks/w25-hero-video/overlay'); ?>
        <?php
            $video_swiper_gallery = get_field('video_swiper');
            if ($video_swiper_gallery):
        ?>
            <!-- Swiper container for video stills -->
            <div class="w-full h-full swiper hero-swiper">
                <div class="w-full h-full swiper-wrapper">
                    <?php foreach ($video_swiper_gallery as $image):
                        $image_url = wp_get_attachment_image_url($image['ID'], 'full');
                        $image_alt = $image['alt'];
                    ?>
                        <div
                            class="relative bg-cover swiper-slide"
                            style="background-image: url('<?php echo esc_url($image_url); ?>');"
                            role="img"
                            aria-label="<?php echo esc_attr($image_alt); ?>"
                        >
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="video-hero-modal w-full h-screen hidden left-0 absolute z-[100]">
    <div class="backdrop absolute w-full h-full bg-[#000000] opacity-[0.4] cursor-pointer"></div>
    <div class="modal-content absolute w-[calc(100%-8rem)] h-auto flex top-1/2 left-[calc(50%-4rem)] -translate-y-1/2 -translate-x-1/2 items-center justify-center mx-4 sm:mx-8 md:mx-16">
        <?php get_template_part('blocks/w25-hero-video/video'); ?>
        <div class="close-button top-0 right-[-3.5rem] absolute cursor-pointer">
            <?php get_template_part('blocks/w25-hero-video/close-button'); ?>
        </div>
    </div>
</div>
