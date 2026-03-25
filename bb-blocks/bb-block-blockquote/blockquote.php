<div class="bb-block-blockquote relative gap-5 md:grid md:grid-cols-4 mb-10">
    <div class="col-span-3 flex gap-3">
        <div class="w-16">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="currentColor" d="M12 15H6.11A9 9 0 0 1 10 8.86l1.79-1.2L10.69 6L8.9 7.2A11 11 0 0 0 4 16.35V23a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2m14 0h-5.89A9 9 0 0 1 24 8.86l1.79-1.2L24.7 6l-1.8 1.2a11 11 0 0 0-4.9 9.15V23a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2"/></svg>
        </div>
        <div>
            <blockquote class="text-2xl lg:text-3xl leading-tight font-normal">
                <?= get_field('text') ?>
            </blockquote>
            <?php if (get_field('source')): ?>
            <cite class="mt-5 font-bold block"><?= get_field('source') ?></cite>
            <?php endif; ?>
            <?php if (get_field('role')): ?>
            <?php echo get_field('role'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>