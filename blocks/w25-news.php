<?php
/**
 * W25 News Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-news-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-news';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load values from ACF fields
$news_items = get_field('news_swiper');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if ($news_items): ?>
    <div class="swiper">
        <div class="py-16 swiper-wrapper">
            <?php foreach ($news_items as $news): ?>
            <div class="swiper-slide bg-primary">
                <div class="w25-news__item">
                    <?php if (!empty($news['image'])):
                                $image_id = $news['image'];
                                $image_url = wp_get_attachment_image_url($image_id, 'large');
                                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                            ?>
                    <div class="w25-news__image">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($news['headline'])): ?>
                    <h3 class="w25-news__headline">
                        <?php echo esc_html($news['headline']); ?>
                    </h3>
                    <?php endif; ?>

                    <?php if (!empty($news['description'])): ?>
                    <div class="w25-news__description">
                        <?php echo esc_html($news['description']); ?>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($news['link'])):
                                $link = $news['link'];
                            ?>
                    <a href="<?php echo esc_url($link['url']); ?>" class="w25-news__link"
                        <?php if ($link['target']): ?>target="<?php echo esc_attr($link['target']); ?>" <?php endif; ?>>
                        <?php echo esc_html($link['title']); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation buttons -->
        <div class="swiper-button-prev">prev</div>
        <div class="swiper-button-next">next</div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <!-- Swiper Configuration -->
    <script>
    SwipersConfig['#<?php echo esc_js($id); ?>'] = {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 3,
        coverflowEffect: {
            rotate: -20,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '#<?php echo esc_js($id); ?> .swiper-button-next',
            prevEl: '#<?php echo esc_js($id); ?> .swiper-button-prev',
        },
        pagination: {
            el: '#<?php echo esc_js($id); ?> .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            }
        }
    };
    </script>
    <?php else: ?>
    <p class="w25-news__empty">No news items added yet.</p>
    <?php endif; ?>
</div>