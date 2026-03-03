<?php
$video     = get_sub_field('video');
$poster_id = get_sub_field('poster');
$title     = get_sub_field('title');
$subtitle  = get_sub_field('subtitle');
$unique_id = 'video-swiper-' . $index;

if ($video) :
?>
<div class="relative w-full h-full">
    <?php include locate_template('blocks/video-partials/video-player.php'); ?>
</div>
<?php endif; ?>
