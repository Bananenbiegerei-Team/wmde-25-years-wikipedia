<?php

add_action('wp_enqueue_scripts', function () {
    if (has_block('acf/video-portrait-text')) {
        $u = get_stylesheet_directory_uri() . '/blocks/video-portrait-text';
        wp_enqueue_style('plyr', $u . '/plyr.css');
        // plyr-overrides-portrait-video removed - now compiled via style.scss in main build
        wp_enqueue_script('plyr', $u . '/plyr.js', [], null, true);
        wp_enqueue_script('video-portrait-logic', $u . '/video-portrait-text.js', ['plyr'], null, true);
    }
});