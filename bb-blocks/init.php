<?php

// Check if ACF Pro is installed
if (!function_exists('acf_register_block_type')) {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p><b>Custom Blocks:</b> ' .
          __('Das erforderliche Plugin „Advanced Custom Fields" fehlt. Bitte installiere und aktiviere es.', BB_TEXT_DOMAIN) .
          '</p></div>';
    });
    return;
}

define('BB_BLOCKS_PATH', dirname(__FILE__));
define('BB_BLOCKS_DIR', basename(BB_BLOCKS_PATH));


// Get list of enabled BB blocks
function bb_get_enabled_custom_blocks()
{
    $blocks = [];

    // Check if ACF is fully initialized before calling get_field
    $acf_initialized = did_action('acf/init');

    // Determine if we should load all blocks
    $load_all = defined('BB_LOAD_ALL_BB_BLOCKS') && BB_LOAD_ALL_BB_BLOCKS;
    if ($acf_initialized) {
        $load_all = $load_all || get_field('load_all_custom_blocks', 'options');
    }

    if ($load_all) {
        $dirs = glob(__DIR__ . '/*');
        if (is_array($dirs)) {
            foreach ($dirs as $dir) {
                $block = basename($dir);
                if (is_dir($dir)) {
                    $blocks[] = $block;
                }
            }
        }
    } else if ($acf_initialized) {
        $blocks = get_field('custom_blocks_enabled', 'options');
        if (!is_array($blocks)) {
            $blocks = [];
        }
    }
    return $blocks;
}

// Populate select field `custom_blocks_enabled`
add_filter('acf/load_field/name=custom_blocks_enabled', function ($field) {
    $dirs = glob(__DIR__ . '/*');
    if (is_array($dirs)) {
        foreach ($dirs as $dir) {
            $block = basename($dir);
            if (is_dir($dir)) {
                $field['choices'][$block] = $block;
            }
        }
    }
    ksort($field['choices']);
    return $field;
});

// Populate select field `wp_blocks_enabled`
add_filter('acf/load_field/name=wp_blocks_enabled', function ($field) {
    $wp_blocks = array_filter(array_keys(WP_Block_Type_Registry::get_instance()->get_all_registered()), function ($b) {
        return str_starts_with($b, 'core/');
    });
    foreach ($wp_blocks as $wp_block) {
        $field['choices'][$wp_block] = $wp_block;
    }
    ksort($field['choices']);
    return $field;
});

// Load ACF groups from the blocks directories...
// Note: We load all block paths here (not just enabled ones) because this filter
// runs very early during ACF initialization. Selective loading happens in block registration.
add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = BB_BLOCKS_PATH;
    $dirs = glob(BB_BLOCKS_PATH . '/*');
    if (is_array($dirs)) {
        foreach ($dirs as $dir) {
            if (is_dir($dir)) {
                $paths[] = $dir;
            }
        }
    }
    return $paths;
});

// Register blocks
add_action('init', function () {
    $blocks = bb_get_enabled_custom_blocks();
    if (is_array($blocks)) {
        foreach ($blocks as $block) {
            register_block_type(BB_BLOCKS_PATH . '/' . $block); // . '/block.json');
            // Each block can come with its set of functions...
            if (file_exists($function = BB_BLOCKS_PATH . '/' . $block . '/functions.php')) {
                include_once $function;
            }
        }
    }
    // Get a warning if blocks have not yet been configured
    add_action('admin_notices', function () {
        if (get_field('custom_blocks_enabled', 'options') === null && get_field('load_all_custom_blocks', 'options') === null) {
            $url = get_admin_url() . '/admin.php?page=acf-options';
            $message = sprintf(__("<b>Custom Blocks:</b> Vergesse nicht, die benutzerdefinierten Blöcke auf der <a href=\"%s\">Optionen Seite</a> zu aktivieren.", BB_TEXT_DOMAIN), $url);
            echo "<div class=\"notice notice-warning\"><p>{$message}</p></div>";
        }
    });
});

// Each block can come with its set of functions...
// Must run after ACF is initialized to use get_field()
add_action('acf/init', function () {
    $blocks = bb_get_enabled_custom_blocks();
    if (is_array($blocks)) {
        foreach ($blocks as $block) {
            if (file_exists($function = BB_BLOCKS_PATH . '/' . $block . '/functions.php')) {
                include_once $function;
            }
        }
    }
}, 5); // Priority 5 to run before block registration

// Define list of allowed block types
add_filter('allowed_block_types_all', function ($allowed_blocks) {
    if (get_field('load_all_wp_blocks', 'options')) {
        return $allowed_blocks;
    }

    // Get all registered blocks except 'core/*' blocks
    $other_blocks = array_filter(array_keys(WP_Block_Type_Registry::get_instance()->get_all_registered()), function ($b) {
        return !str_starts_with($b, 'core/');
    });

    $core_blocks = get_field('wp_blocks_enabled', 'options');
    if (empty($core_blocks)) {
        $core_blocks = [];
    }
    $allowed_wp_blocks = defined('BB_ALLOWED_WP_BLOCKS') ? BB_ALLOWED_WP_BLOCKS : [];
    return array_merge($other_blocks, $core_blocks, $allowed_wp_blocks);
});

// Add custom blocks category
add_filter(
    'block_categories',
    function ($categories, $post) {
        return array_merge($categories, [
            [
                'slug' => 'bb-blocks',
                'title' => __('Custom Blocks', BB_TEXT_DOMAIN)
            ]
        ]);
    },
    10,
    2
);

// Remove fullscreen button in text editor
add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    unset($toolbars['Basic'][1][13]);
    unset($toolbars['Full'][1][12]);
    return $toolbars;
});


// Load theme colors
include(BB_BLOCKS_PATH . '/init-colors.php');
