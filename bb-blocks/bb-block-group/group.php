<?php
$bg_color = get_field('background_color');

// p-2 padding is added if the group has a background color
$classes = "wp-block-group p-4 rounded md:rounded-lg bg-{$bg_color} text-{$bg_color}-foreground " . ($bg_color !== 'none' ? 'p-2' : 'bb-fullwidth-no-padding') ;
?>

<div class="<?= $classes ?>">
    <InnerBlocks/>
</div>
