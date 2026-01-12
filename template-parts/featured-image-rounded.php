<div class="relative">
    <div class="bb-block-image aspect-w-16 aspect-h-9 bg-neutral-light rounded-3xl">
        <figure class="w-full">
            <?php the_post_thumbnail('large', ['class' => 'rounded-3xl object-cover w-full h-full overflow-hidden']); ?>
            <?php if (get_the_post_thumbnail_caption()): ?>
            <figcaption class="absolute bottom-0 left-0 right-0 z-20 flex items-start invisible w-auto h-auto gap-4 p-2 text-sm text-white break-all nohover:hidden rounded-b-3xl bg-black/80">
                <?= bb_icon('info', 'flex-shrink-0') ?> <div class="self-center"><?php the_post_thumbnail_caption(); ?></div>
            </figcaption>
            <?php endif; ?>
        </figure>
    </div>
    <?php if (get_the_post_thumbnail_caption()): ?>
    <figcaption class="bottom-0 left-0 right-0 z-20 flex items-start hidden w-auto h-auto gap-4 p-2 text-sm text-white break-all nohover:flex rounded-3xl bg-black/80">
        <?= bb_icon('info', 'flex-shrink-0') ?> <div class="self-center"><?php the_post_thumbnail_caption(); ?></div>
    </figcaption>
    <?php endif; ?>
</div>