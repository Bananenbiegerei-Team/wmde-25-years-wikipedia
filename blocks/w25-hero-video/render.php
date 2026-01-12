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

// Show simplified preview in WordPress backend
if (is_admin() || $is_preview): ?>
    <div id="<?php echo esc_attr($id); ?>" class="w25-video-hero relative w-full p-8 bg-secondary <?php echo esc_attr($className); ?>">
        <div class="text-left">
            <h2 class="mb-2">W25 Hero Video Block</h2>
            <p class="mb-2 font-texts">Edit the hero video settings in the block panel</p>
            <?php
            $full_video = get_field('full_video');
            $video_swiper = get_field('video_swiper');
            if ($full_video): ?>
                <p class="text-sm font-texts">✓ Video uploaded</p>
            <?php endif; ?>
            <?php if ($video_swiper && count($video_swiper) > 0): ?>
                <p class="text-sm font-texts">✓ <?php echo count($video_swiper); ?> swiper images</p>
            <?php endif; ?>
        </div>
    </div>
<?php else:
// Load values from ACF fields for frontend rendering
?>
<div id="<?php echo esc_attr($id); ?>" class="w25-video-hero relative w-full bg-secondary <?php echo esc_attr($className); ?>">
    <div class="relative h-dvhheader video-overlay md:h-dvhheaderdesktop">
        <?php get_template_part('blocks/w25-hero-video/partials/overlay'); ?>
        <?php
            $video_swiper_gallery = get_field('video_swiper');
            if ($video_swiper_gallery):
        ?>
            <!-- Swiper container for video stills -->
            <div class="w-full h-full swiper hero-swiper">
                <div class="w-full h-full swiper-wrapper">
                    <?php foreach ($video_swiper_gallery as $image):
                        // Handle both array and ID formats
                        $image_id = is_array($image) ? $image['ID'] : $image;
                        $image_url = wp_get_attachment_image_url($image_id, 'full');
                        $image_alt = is_array($image) ? $image['alt'] : get_post_meta($image_id, '_wp_attachment_image_alt', true);
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
    <div class="modal-content absolute w-full max-w-[1180px] h-auto flex top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 items-center justify-center mx-0">
        <?php get_template_part('blocks/w25-hero-video/partials/video', null, ['id' => $id]); ?>
        <div class="close-button  right-0 top-[-3.25rem] xl:top-0 xl:right-[-3.25rem] absolute cursor-pointer">
            <?php get_template_part('blocks/w25-hero-video/partials/close-button'); ?>
        </div>
    </div>
</div>
<?php endif; ?>
