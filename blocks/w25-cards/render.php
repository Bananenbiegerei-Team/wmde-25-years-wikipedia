<?php
/**
 * W25 Card Block Template
 *
 * @param array       $block    The block settings and attributes.
 * @param string      $content  The block inner HTML (empty).
 * @param bool        $is_preview True during AJAX preview.
 * @param int|string  $post_id  The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'w25-card-block-' . $block['id'];
if (! empty($block['anchor'])) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'w25-card-block';
if (! empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (! empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

// Load ACF fields.
$title       = get_field('title');
$text        = get_field('text');
$link_to_all = get_field('link_to_all');
$cards       = get_field('cards') ?: [];
?>
<div id="<?php echo esc_attr($id); ?>"
    class="<?php echo esc_attr($className); ?> bg-secondary-light/50 text-primary-dark py-8 lg:py-16 px-0 lg:px-8">
    <div class="container">
        <?php if ($title || $text || $link_to_all): ?>
        <div class="flex flex-col gap-4 mb-6 md:flex-row md:items-end md:justify-between">
            <div class="">
                <?php if ($title): ?>
                <h2 class="text-3xl lg:text-6xl">
                    <?php echo esc_html($title); ?>
                </h2>
                <?php endif; ?>

                <?php if ($text): ?>
                <p class="mt-3 text-xl md:text-2xl lg:text-3xl  max-w-[75%] font-headings">
                    <?php echo esc_html($text); ?>
                </p>
                <?php endif; ?>
            </div>


        </div>
        <?php endif; ?>

        <?php if (! empty($cards)): ?>
        <div class="grid gap-6 mb-4 md:gap-8 md:grid-cols-2 xl:grid-cols-4">
            <?php foreach ($cards as $card): ?>
            <?php
                    $card_image_id = $card['image'] ?? 0;
                    $card_text     = $card['text'] ?? '';
                    $card_link     = $card['link'] ?? null;

                    $card_image_url = $card_image_id ? wp_get_attachment_image_url($card_image_id, 'large') : '';
                    $card_image_alt = $card_image_id ? get_post_meta($card_image_id, '_wp_attachment_image_alt', true) : '';

                    $card_link_url    = $card_link['url'] ?? '';
                    $card_link_target = $card_link['target'] ?? '_self';

                    // Decide if card is clickable as a whole.
                    $card_tag_open  = '';
                    $card_tag_close = '';
                    if ($card_link_url) {
                        $card_tag_open  = '<a href="' . esc_url($card_link_url) . '" target="' . esc_attr($card_link_target) . '" class="block h-full group focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-black">';
                        $card_tag_close = '</a>';
                    }
                    ?>
            <div class="">
                <?php echo $card_tag_open; ?>

                <?php if ($card_image_url): ?>
                <div class="relative overflow-hidden rounded-xl md:rounded-2xl aspect-w-16 aspect-h-9">
                    <img src="<?php echo esc_url($card_image_url); ?>" alt="<?php echo esc_attr($card_image_alt); ?>"
                        class="object-cover w-full h-full">
                    <div
                        class="absolute inset-0 transition-opacity duration-300 ease-in-out opacity-0 bg-gradient-to-t from-white via-white to-transparent group-hover:opacity-30">
                    </div>
                </div>
                <?php endif; ?>

                <div class="flex flex-col gap-3 px-0 py-4 md:py-5">
                    <?php if ($card_text): ?>
                    <p class="text-base font-medium md:text-xl">
                        <?php echo esc_html($card_text); ?>
                    </p>
                    <?php endif; ?>
                </div>

                <?php echo $card_tag_close; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (! empty($link_to_all['url'])): ?>
        <?php
                $see_all_url    = $link_to_all['url'];
                $see_all_title  = $link_to_all['title'] ?: __('See all', 'wmde-25-years-wikipedia');
                $see_all_target = $link_to_all['target'] ?: '_self';
                ?>
        <div class="flex justify-center mt-4 md:mt-0">
            <a class="text-xl btn btn-outline md:text-2xl" href="<?php echo esc_url($see_all_url); ?>"
                target="<?php echo esc_attr($see_all_target); ?>">
                <?php echo esc_html($see_all_title); ?>
            </a>
        </div>
        <?php endif; ?>
    </div>


</div>