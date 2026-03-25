<?php
/**
 * ACF Block: Accordion
 * Uses basecoat accordion pattern with details/summary
 */
$block_id = $block['id'];
?>
<section id="<?= esc_attr($block_id) ?>" class="bb-block-accordion accordion">
    <?php while (have_rows('acfb_add_accordion')): the_row(); ?>
    <details class="group border-b last:border-b-0">
        <summary class="w-full focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] transition-all outline-none rounded-md">
            <h2 class="flex flex-1 items-start justify-between gap-4 py-4 text-left text-sm font-medium hover:underline">
                <?= esc_html(get_sub_field('acfb_accordion_title')); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground pointer-events-none size-4 shrink-0 translate-y-0.5 transition-transform duration-200 group-open:rotate-180"><path d="m6 9 6 6 6-6" /></svg>
            </h2>
        </summary>
        <section class="pb-4">
            <?= get_sub_field('acfb_accordion_content'); ?>
        </section>
    </details>
    <?php endwhile; ?>
</section>
<script>
(() => {
    const accordion = document.getElementById('<?= esc_js($block_id) ?>');
    if (!accordion) return;
    accordion.addEventListener('click', (event) => {
        const summary = event.target.closest('summary');
        if (!summary) return;
        const details = summary.closest('details');
        if (!details) return;
        accordion.querySelectorAll('details').forEach((detailsEl) => {
            if (detailsEl !== details) {
                detailsEl.removeAttribute('open');
            }
        });
    });
})();
</script>
