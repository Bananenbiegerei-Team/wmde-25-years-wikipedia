<div class="flex h-[100px] lg:h-24 max-w-md gap-4">
    <div class="text-secondary-light">
        <?php include get_template_directory() . '/blocks/w25-numbers/puzzle.svg'; ?>
    </div>
    <div class="h-full pt-[20px] lg:pt-[5px] ">
        <div class="flex items-center h-full text-base lg:text-xl">
            <?php if (get_field('number_5')): ?>
                <?php echo get_field('number_5'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>