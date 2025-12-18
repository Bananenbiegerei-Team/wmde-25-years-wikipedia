<div class="flex h-[100px] lg:h-24 max-w-md gap-4">
    <div class="w-24 text-primary">
        <?php include get_template_directory() . '/blocks/w25-numbers/puzzle.svg'; ?>
    </div>
    <div class="h-full pt-[20px] lg:pt-[5px] flex-1 ">
        <div class="flex items-center h-full text-base lg:text-xl">
            <?php if (get_field('number_2')): ?>
                <?php echo get_field('number_2'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>