<?php

add_action('wp_enqueue_scripts', function () {
    if (has_block('acf/video-swiper')) {
        wmde_enqueue_video_player();
    }
});
