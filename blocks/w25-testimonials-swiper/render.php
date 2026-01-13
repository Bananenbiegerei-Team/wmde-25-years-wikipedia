<?php
// Show simplified preview in WordPress backend
if (is_admin() || $is_preview): ?>
    <div class="p-8 border-2 border-gray-300 border-dashed bg-gray-50">
        <div class="text-center">
            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            <p class="mb-2 text-xl font-semibold">W25 Testimonials Swiper</p>
            <p class="text-sm text-gray-600">Edit testimonials in the block panel →</p>
            <?php if (have_rows('testimonials')): ?>
                <p class="mt-2 text-sm text-green-600">✓ <?php echo count(get_field('testimonials')); ?> testimonial(s) configured</p>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
<div class="mb-10 -mx-6 w25-testimonials-swiper-block lg:mb-20 lg:mx-0" id="<?= $block['id'] ?>">
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php if (have_rows('testimonials')): ?>
                <?php while (have_rows('testimonials')): the_row(); ?>
                    <?php
                    $testimonial_text = get_sub_field('testimonial_text');
                    $testimonial_source = get_sub_field('testimonial_source');
                    $testimonial_source_role = get_sub_field('testimonial_source_role');
                    ?>
                    <div class="swiper-slide !h-auto">
                        <div class="rounded-xl bg-neutral-light p-4 !h-full">
                            <blockquote class="flex flex-col items-stretch h-full gap-4 text-xl justfiy-between text-primary-dark">
                                    <div>
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-red-100 rounded-full">
                                        <?= bb_icon('quote', 'icon-xs') ?>
                                    </span>
                                    <?= esc_html($testimonial_text) ?>
                                    </div>
                                <?php if ($testimonial_source): ?>
                                    <div class="flex flex-col mt-auto">
                                        <cite class="text-base not-italic font-bold leading-tight">
                                            — <?= esc_html($testimonial_source) ?>
                                        </cite>
                                        <?php if ($testimonial_source_role): ?>
                                            <span class="text-sm text-neutral-dark"><?= esc_html($testimonial_source_role) ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </blockquote>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
