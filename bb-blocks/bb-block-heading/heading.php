<?php

$bgcolor = get_field('bg_color');
$bgcolor = $bgcolor == 'none' ? '' : $bgcolor;
if ($bgcolor) {
    $bgcolor = "bg-{$bgcolor}";
}

$color = get_field('text_color');
$color = $color == 'none' ? '' : $color;
if ($color) {
    $color = "text-{$color}";
}

$title = get_field('anchor_title');
$id = str_replace(' ', '_', esc_attr($title));
$headline_link = get_field('headline_link');
?>
<div data-anchor-title="<?= $title ?>" class="bb-block-heading">
    <div class="anchor-offset" id="<?= $id ?>"></div>
    <?php if ($headline_link): ?>
    <a class="hover:underline transition underline-offset-2 decoration-1 transition" href="<?php echo $headline_link; ?>">
        <<?= get_field('level') ?> class="<?= get_field('style')['headline_size'] ?? '' ?> <?= $color ?>">
            <span class="<?= $bgcolor ?>">
                <?= get_field('headline') ?>
            </span>
        </<?= get_field('level') ?>>
    </a>
    <?php else: ?>
    <<?= get_field('level') ?> class="<?= get_field('style')['headline_size'] ?? '' ?> <?= $color ?>">
        <span class="<?= $bgcolor ?>">
            <?= get_field('headline') ?>
        </span>
    </<?= get_field('level') ?>>
    <?php endif; ?>
</div>