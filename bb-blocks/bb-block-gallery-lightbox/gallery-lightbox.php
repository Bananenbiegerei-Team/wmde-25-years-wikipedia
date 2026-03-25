<?php
/**
 * ACF Block: Gallery Lightbox
 * Uses Alpine.js for lightbox functionality
 */
$images = get_field('images');
if (!$images) return;
?>
<?php if (is_admin()): ?>
<div class="bb-gallery-lightbox">
    <h2 class="text-muted-foreground text-sm mb-2">Gallery Lightbox</h2>
    <div class="grid grid-cols-5 gap-4">
        <?php foreach ($images as $image): ?>
        <div class="aspect-square">
            <img class="h-full w-full object-cover rounded" src="<?= wp_get_attachment_image_url($image['id'], 'thumbnail') ?>" alt="<?= esc_attr($image['alt']) ?>" />
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<div class="bb-gallery-lightbox" x-data="{ lightbox: false, imgModalSrc: '', imgModalAlt: '', imgModalCaption: '' }">
    <!-- Gallery Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($images as $image): ?>
        <?php
            $image_alt = esc_attr(strip_tags($image['alt']));
            $image_caption = esc_attr(strip_tags($image['caption']));
        ?>
        <div class="cursor-zoom-in aspect-square overflow-hidden rounded-lg">
            <img
                class="block object-cover h-full w-full transition-transform duration-300 hover:scale-105"
                src="<?= esc_url($image['sizes']['large']) ?>"
                alt="<?= $image_alt ?>"
                @click="lightbox = true; imgModalSrc = '<?= esc_url($image['url']) ?>'; imgModalAlt = '<?= $image_alt ?>'; imgModalCaption = '<?= $image_caption ?>'"
            >
            <!-- Preload full image -->
            <link rel="prefetch" href="<?= esc_url($image['url']) ?>" as="image">
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Lightbox Modal -->
    <div
        x-show="lightbox"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="lightbox = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm cursor-zoom-out"
        @click.self="lightbox = false"
        x-cloak
    >
        <!-- Close button -->
        <button
            @click="lightbox = false"
            class="absolute top-4 right-4 text-white/80 hover:text-white transition-colors z-10"
            aria-label="Close lightbox"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
            </svg>
        </button>

        <!-- Image container -->
        <figure
            class="relative max-w-[90vw] max-h-[90vh]"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            @click.stop
        >
            <img
                class="max-h-[85vh] max-w-[90vw] object-contain rounded-lg shadow-2xl"
                :src="imgModalSrc"
                :alt="imgModalAlt"
            >
            <figcaption
                x-show="imgModalCaption"
                class="absolute left-0 bottom-0 right-0 bg-black/70 text-white p-3 text-sm rounded-b-lg"
            >
                <span x-text="imgModalCaption"></span>
            </figcaption>
        </figure>
    </div>
</div>
<?php endif; ?>
