<?php


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Polyfills (provides a few functions not yet in PHP7)
require_once get_template_directory() . '/functions/polyfills.php';

// Load localization functions
// Usage: `__('my example text', BB_TEXT_DOMAIN)`
// String translations can be edited with [Poedit](https://poedit.net)
require_once get_template_directory() . '/functions/localization.php';

// Special features of theme
require_once get_template_directory() . '/functions/features.php';

// Load ACF blocks
require_once get_template_directory() . '/functions/acf-blocks.php';
require_once get_template_directory() . '/functions/acf-options.php';

// Custom fonts
require_once get_template_directory() . '/functions/fonts.php';

// Wrap blocks with containers for page layout
require_once get_template_directory() . '/functions/containers.php';

// Load styles & scripts
require_once get_template_directory() . '/functions/enqueue-scripts.php';

// Define menu locations and menu getter
require_once get_template_directory() . '/functions/menu.php';

// Icon dispenser
require_once get_template_directory() . '/functions/icons.php';

// Excerpts
require_once get_template_directory() . '/functions/excerpts.php';

// Search
require_once get_template_directory() . '/functions/search.php';

// Disable comments
require_once get_template_directory() . '/functions/disable-comments.php';

//
require_once get_template_directory() . '/functions/login.php';
