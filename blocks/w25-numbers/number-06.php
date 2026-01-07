<div class="flex h-[100px] lg:h-24 max-w-md gap-4">
    <div class="w-24 text-warning">
        <?php include get_template_directory() . '/blocks/w25-numbers/puzzle.svg'; ?>
    </div>
    <div class="h-full pt-[20px] lg:pt-[18px] flex-1 ">
        <div class="flex items-center h-full text-base lg:text-xl font-headings">
            <?php if (get_field('number_6')): ?>
                <?php echo get_field('number_6'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>