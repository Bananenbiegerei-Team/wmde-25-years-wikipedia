<?php
/**
 * W25 Video Swiper Block Template
 *
 * @param array $block The block settings and attributes.
 * @param bool $is_preview True during AJAX preview.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-video-swiper-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-video-swiper';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// Fetch the Repeater field
$video_slides = get_field('videoSlides');

// Show simplified preview in WordPress backend
if (is_admin() || $is_preview): ?>
    <div id="<?php echo esc_attr($id); ?>" class="relative w-full p-8 bg-secondary <?php echo esc_attr($className); ?>">
        <div class="text-left">
            <h2 class="mb-2 uppercase font-bold">W25 Video Swiper Block</h2>
            <p class="mb-2 font-texts btn btn-outline">Edit slider slides in the sidebar</p>
            <?php if ($video_slides): ?>
                <p class="text-sm font-texts">✓ <?php echo count($video_slides); ?> Slides configured</p>
            <?php else: ?>
                <p class="text-sm font-texts text-red-500 italic">No slides added yet. Please add slides in the editor sidebar.</p>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>

<div id="<?php echo esc_attr($id); ?>" class="relative w-full py-8 px-8 <?php echo esc_attr($className); ?>">
    <?php if ($video_slides): ?>
        <div class="swiper w25-video-swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($video_slides as $slide): 
                    $video       = $slide['videoFile'];
                    $poster_id   = $slide['posterImage'];
                    $title       = $slide['title'];
                    $subtitle    = $slide['subtitle'];
                    $description = $slide['description'];
                    
                    $poster_url  = wp_get_attachment_image_url($poster_id, 'full');
                ?>
                    <div class="swiper-slide relative flex flex-col rounded-[20px] overflow-hidden">
                        <div class="relative w-full h-full  bg-black">
                            <video 
                                class="w-full h-full object-cover"
                                preload="none"
                                poster="<?php echo esc_url($poster_url); ?>"
                            >
                                <source src="<?php echo esc_url($video['url']); ?>" type="<?php echo esc_attr($video['mime_type']); ?>">
                            </video>
                            
                        </div>

                        <?php if ($title || $subtitle): ?>
                            <div class="slide-content p-6 absolute top-0 left-0 w-full pb-16">
                                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-black/0 to-black/70 z-5"></div>
                                
                                <?php if ($title): ?>
                                    <h3 class="text-3xl text-white mb-2 relative z-10"><?php echo esc_html($title); ?></h3>
                                <?php endif; ?>
                                
                                <?php if ($subtitle): ?>
                                    <span class="text-green relative z-10"><?php echo esc_html($subtitle); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                                    
                        <div class="slide-video-controls p-4 pt-16 absolute bottom-0 left-0 w-full">
                                <button class="play-button bg-white hover:bg-black text-black hover:text-white rounded-full w-12 h-12 flex items-center justify-center transition-colors duration-300 relative z-10"> 
                                    <svg class="translate-x-[2px]" width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 2.00537C0 0.387327 1.82137 -0.560979 3.14692 0.36691L12.6593 7.0256C13.7968 7.8218 13.7968 9.50632 12.6593 10.3025L3.14692 16.9612C1.82137 17.8891 0 16.9408 0 15.3228V2.00537Z" fill="currentColor"/>
                                    </svg>
                                </button>

                                <button class="pause-button bg-white hover:bg-black text-black hover:text-white rounded-full w-12 h-12 flex items-center justify-center transition-colors duration-300 relative z-10 hidden"> 
                                    <svg class="translate-x-[1.5px]" width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="6" height="19" rx="2" fill="currentColor"/>
                                        <rect x="10" width="6" height="19" rx="2" fill="currentColor"/>
                                    </svg>
                                </button>

                                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-t from-black/70 to-black/0 z-5"></div>
                        </div>  
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>