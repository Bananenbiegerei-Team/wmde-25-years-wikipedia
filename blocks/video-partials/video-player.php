<?php
/**
 * Video Player Partial
 *
 * Shared video player component used by video-portrait-text and video-swiper blocks.
 *
 * Expected variables:
 * - $video: ACF file field array with 'url', 'mime_type', 'width', 'height'
 * - $poster_id: ACF image ID for poster
 * - $title: Optional video title
 * - $subtitle: Optional video subtitle
 * - $unique_id: Optional unique identifier for multiple videos (default: uniqid())
 */

// Defaults
$unique_id   = $unique_id ?? uniqid('video-');
$title       = $title ?? '';
$subtitle    = $subtitle ?? '';
$video_url   = $video['url'] ?? '';
$video_mime  = $video['mime_type'] ?? 'video/mp4';

// Determine orientation from poster image dimensions
$is_portrait = true; // Default to portrait
if ($poster_id) {
    $poster_meta = wp_get_attachment_metadata($poster_id);
    if ($poster_meta && isset($poster_meta['width']) && isset($poster_meta['height'])) {
        $is_portrait = $poster_meta['height'] > $poster_meta['width'];
    }
}

// Set aspect ratio class based on orientation
$aspect_class = $is_portrait ? 'aspect-[9/16]' : 'aspect-video';

// Use appropriate image size based on orientation
$poster_size = $is_portrait ? 'three-columns-portrait' : 'three-columns-landscape';
$poster_url  = $poster_id ? wp_get_attachment_image_url($poster_id, $poster_size) : '';

if (!$video_url) return;
?>

<div class="relative w-full overflow-hidden rounded-xl video-player-wrapper group <?php echo esc_attr($aspect_class); ?>" data-video-id="<?php echo esc_attr($unique_id); ?>">
<?php if ($title || $subtitle) : ?>
    <div class="absolute z-30 w-full p-4 transition-opacity duration-300 video-title-container bg-easing-b-black-transparent h-1/2">
        <?php if ($title) : ?>
            <h2 class="mb-0 font-sans text-white"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($subtitle) : ?>
            <h3 class="font-sans text-lg text-neon"><?php echo esc_html($subtitle); ?></h3>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="plyr__video-embed">
        <video class="js-plyr-video" preload="metadata" playsinline
            poster="<?php echo esc_url($poster_url); ?>">
            <source src="<?php echo esc_url($video_url); ?>"
                type="<?php echo esc_attr($video_mime); ?>">
        </video>
    </div>
    <button class="play-button absolute inset-0 z-30 flex items-center justify-center w-16 h-16 m-auto text-white transition-all duration-300 border-[1px] border-black/50 rounded-full shadow-xl bg-black/50 hover:bg-black group-hover:scale-110">
        <span class="sr-only"><?php _e('Play video', 'flavor'); ?></span>
        <svg class="translate-x-[2px]" width="1.5em" height="1.5em" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 2.00537C0 0.387327 1.82137 -0.560979 3.14692 0.36691L12.6593 7.0256C13.7968 7.8218 13.7968 9.50632 12.6593 10.3025L3.14692 16.9612C1.82137 17.8891 0 16.9408 0 15.3228V2.00537Z" fill="currentColor" />
        </svg>
    </button>
</div>
