<?php
/**
 * Video Partials - Shared asset loading
 *
 * Registers and enqueues Plyr assets for video blocks.
 */

/**
 * Register video player assets (call this early, assets are only loaded when enqueued)
 */
function wmde_register_video_player_assets() {
    $base_url = get_stylesheet_directory_uri() . '/' . WMDE_BB_BLOCKS_DIR . '/video-partials';

    // Register Plyr library
    wp_register_script('plyr', $base_url . '/plyr.js', [], null, true);
    wp_register_style('plyr', $base_url . '/plyr.css', [], null);

    // Register shared video player script (depends on Plyr)
    wp_register_script('video-player', $base_url . '/video-player.js', ['plyr'], null, true);
    wp_register_style('plyr-overrides', $base_url . '/plyr-overrides.css', ['plyr'], null);
}
add_action('wp_enqueue_scripts', 'wmde_register_video_player_assets', 5);

/**
 * Enqueue video player assets
 * Call this function from blocks that use the video player partial
 */
function wmde_enqueue_video_player() {
    wp_enqueue_script('plyr');
    wp_enqueue_script('video-player');
    wp_enqueue_style('plyr');
    wp_enqueue_style('plyr-overrides');
}
