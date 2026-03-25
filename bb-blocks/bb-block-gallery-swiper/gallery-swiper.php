<?php
$slides_per_view = get_field('slides_per_view') ?: 1;
$block_id = $block['id'];
?>
<div class="bb-block-gallery-swiper bb-fullwidth-no-padding" id="<?= $block_id ?>">
    <div class="flex items-center">
        <?php if (!is_admin()): ?>
        <!-- Swiper -->
        <div class="swiper">
            <div class="flex items-center justify-end mb-4">
                <div class="flex items-center gap-2">
                    <span
                        class="p-2 transition border border-black rounded-lg swiper-button-prev hover:bg-neutral-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                            <path fill="currentColor" d="M10 16L20 6l1.4 1.4l-8.6 8.6l8.6 8.6L20 26z" />
                        </svg>
                    </span>
                    <div class="mx-2 text-xl swiper-pagination font-alt"></div>
                    <span
                        class="p-2 transition border border-black rounded-lg swiper-button-next hover:bg-neutral-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                            <path fill="currentColor" d="M22 16L12 26l-1.4-1.4l8.6-8.6l-8.6-8.6L12 6z" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="swiper-wrapper">
                <?php foreach (get_field('images') as $image):
                    get_template_part('bb-blocks/bb-block-gallery-swiper/image', null, ['image' => $image]);
                endforeach; ?>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('<?= esc_js($block_id) ?>');
            const swiperEl = container.querySelector('.swiper');
            const nextEl = container.querySelector('.swiper-button-next');
            const prevEl = container.querySelector('.swiper-button-prev');
            const paginationEl = container.querySelector('.swiper-pagination');

            new window.Swiper(swiperEl, {
                modules: [window.Navigation, window.Pagination],
                slidesPerView: <?= (int) $slides_per_view ?>,
                spaceBetween: 30,
                loop: true,
                navigation: {
                    nextEl: nextEl,
                    prevEl: prevEl,
                },
                pagination: {
                    el: paginationEl,
                    type: 'fraction',
                },
            });
        });
        </script>
        <?php else: ?>
        <div class="px-4 border rounded-lg">
            <h2 class="text-primary">
                <?php _e('edit gallery swiper', BB_TEXT_DOMAIN); ?>
            </h2>
            <div class="grid grid-cols-2 gap-5 md:grid-cols-2 lg:grid-cols-6">
                <?php foreach (get_field('images') as $image):
                    get_template_part('bb-blocks/bb-block-gallery-swiper/image', null, ['image' => $image]);
                endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>