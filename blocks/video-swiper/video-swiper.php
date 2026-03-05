<div id="<?= $block['id'] ?>">
    <div class="flex items-center my-8">
        <?php if (!is_admin()): ?>
        <div class="w-full bb-video-swiper-block">
            <div class="flex items-center justify-end w-full">
                <div class="flex items-center mb-4 space-x-2">
                    <div class="p-2 transition border rounded-lg swiper-button-prev border-primary hover:bg-primary-light">
                    <?= bb_icon('chevron-left', '') ?>
                    </div>

                    <div class="flex mx-2 text-3xl align-middle swiper-pagination font-alt"></div>

                    <div class="p-2 transition border rounded-lg swiper-button-next border-primary hover:bg-primary-light">
                    <?= bb_icon('chevron-right', '') ?>
                    </div>
                </div>
            </div>
            <div class="relative swiper">
                <div class="swiper-wrapper">
                    <?php if (have_rows('video_swiper')) : ?>
                    <?php $index = 0; ?>
                    <?php while (have_rows('video_swiper')) : the_row(); ?>
                    <div class="swiper-slide !h-unset" x-data="{ open: false }">
                        <?php include locate_template('blocks/video-swiper/video-content.php'); ?>

                        <?php
                        $modal_headline = get_sub_field('info_modal_headline');
                        $modal_subline = get_sub_field('info_modal_subline');
                        $modal_text = get_sub_field('info_modal_text');

                        if ($modal_headline || $modal_subline || $modal_text) : ?>
                        <!-- Info Button -->
                        <button
                            x-on:click="open = true"
                            type="button"
                            class="absolute z-30 flex items-center justify-center w-8 h-8 m-auto text-white transition-all duration-300 border-[1px] border-black/50 rounded-full shadow-xl bg-black/50 hover:bg-black group-hover:scale-110 bottom-4 right-4"
                        >
                            <?= bb_icon('info-2', 'icon-xs') ?>
                            <span class="sr-only"><?php _e('Info', 'flavor'); ?></span>
                        </button>

                        <!-- Modal (teleported to body) -->
                        <template x-teleport="body">
                            <div
                                x-show="open"
                                style="display: none"
                                x-on:keydown.escape.prevent.stop="open = false"
                                role="dialog"
                                aria-modal="true"
                                x-id="['modal-title-<?php echo $index; ?>']"
                                :aria-labelledby="$id('modal-title-<?php echo $index; ?>')"
                                class="fixed inset-0 z-50 overflow-y-auto"
                            >
                                <!-- Overlay -->
                                <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/80"></div>

                                <!-- Panel -->
                                <div
                                    x-show="open"
                                    x-transition
                                    x-on:click="open = false"
                                    class="relative flex items-center justify-center min-h-screen p-4"
                                >
                                    <div
                                        x-on:click.stop
                                        x-trap.noscroll.inert="open"
                                        class="relative w-full max-w-4xl p-4 pr-12 bg-white shadow-lg md:pb-32 md:p-24 rounded-xl"
                                    >
                                        <!-- Close Button -->
                                        <button
                                            type="button"
                                            x-on:click="open = false"
                                            class="absolute flex items-center justify-center w-10 h-10 p-1 cursor-pointer top-2 right-2 md:top-8 md:right-8 btn btn-ghost icon-md"
                                        >
                                            <?= bb_icon('x', 'w-6 h-6') ?>
                                            <span class="sr-only"><?php _e('Close', 'flavor'); ?></span>
                                        </button>

                                        <?php if ($modal_headline) : ?>
                                        <!-- Headline -->
                                        <h2 class="mb-0 font-sans text-primary" :id="$id('modal-title-<?php echo $index; ?>')">
                                            <?php echo esc_html($modal_headline); ?>
                                        </h2>
                                        <?php endif; ?>

                                        <?php if ($modal_subline) : ?>
                                        <!-- Subline -->
                                        <h3 class="mb-6 font-sans">
                                            <?php echo esc_html($modal_subline); ?>
                                        </h3>
                                        <?php endif; ?>

                                        <?php if ($modal_text) : ?>
                                        <!-- Content -->
                                        <div class="max-w-none md:[&_p]:text-xl">
                                            <?php echo wp_kses_post($modal_text); ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <?php endif; ?>
                    </div>
                    <?php $index++; // Increment the counter?>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script>
            SwipersConfig['#<?php echo $block['id']; ?>'] = {
                pagination: {
                    el: '#<?php echo $block['id']; ?> .swiper-pagination',
                    type: 'fraction',
                },
                navigation: {
                    nextEl: '#<?php echo $block['id']; ?> .swiper-button-next',
                    prevEl: '#<?php echo $block['id']; ?> .swiper-button-prev',
                },
                autoHeight: true,
                slidesPerView: 1,
                spaceBetween: 32,
                freeMode: true,
                simulateTouch: false,
                touchMoveStopPropagation: false,
                breakpoints: {
                    // sm: 640px
                    640: {
                        slidesPerView: 1,
                    },
                    // md: 821px
                    821: {
                        slidesPerView: 2,
                    },
                    // lg: 1024px
                    1024: {
                        slidesPerView: 3,
                    },
                    // xl: 1280px
                    1280: {
                        slidesPerView: 3,
                    },
                },
                on: {
                    init: function() {
                        // Initialize video players after swiper is ready
                        if (typeof VideoPlayer !== 'undefined') {
                            VideoPlayer.initAllPlayers();
                        }
                    },
                    slideChange: function() {
                        // Pause all videos when changing slides
                        if (typeof VideoPlayer !== 'undefined') {
                            VideoPlayer.pauseAll();
                        }
                    }
                }
            };
        </script>
        <?php else: ?>
        <div>
            <h2><?php _e('Swiper hier editieren'); ?></h2>
            <?php if (have_rows('video_swiper')) : ?>
            <div class="grid grid-cols-6 gap-5">
                <?php while (have_rows('video_swiper')) : the_row(); ?>
                <div class="p-2">
                    <?php $video = get_sub_field('video'); ?>
                    <?php if ($video) : ?>
                    <?php echo esc_html($video['filename']); ?>
                    <?php endif; ?>
                    <?php $poster_id = get_sub_field('poster'); ?>
                    <?php if ($poster_id) : ?>
                    <img src="<?php echo esc_url(wp_get_attachment_image_url($poster_id, 'thumbnail')); ?>" alt="" />
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
