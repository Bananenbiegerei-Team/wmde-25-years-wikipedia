<?php

// Site scripts and style
add_action(
    'wp_enqueue_scripts',
    function () {
        // Site javascript, loaded with defer
        $site_js_version = filemtime(get_template_directory() . '/js/site.js');
        wp_enqueue_script('site', get_template_directory_uri() . '/js/site.js', ['jquery'], $site_js_version, ['in_footer' => true, 'strategy' => 'defer']);
        // Allow easy editing of post with `CTLR-E`
        if (current_user_can('edit_post', get_the_ID())) {
            $post_edit_url = get_edit_post_link(get_the_ID(), '&');
            $script = <<<EOF
			var postEditURL = "$post_edit_url";
			document.addEventListener('keydown', function (event) {
			event = event || window.event;
			if(event.key == 'e' && event.ctrlKey) { window.open(postEditURL, '_blank'); }
			});
			EOF;
            wp_add_inline_script('site', $script);
        }

        // Threaded comment reply styles.
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        // Site style
        $site_css_version = filemtime(get_template_directory() . '/css/site.css');
        wp_enqueue_style('style', get_template_directory_uri() . '/css/site.css', [], $site_css_version, 'all');
    },
    999
);

// Editor style and script: only enqueue if editing a post
add_action(
    'admin_enqueue_scripts',
    function () {
        global $pagenow;
        if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
            $editor_js_version = filemtime(get_template_directory() . '/js/editor.js');
            wp_enqueue_script('editor-addon', get_template_directory_uri() . '/js/editor.js', ['jquery', 'acf-input'], $editor_js_version, false);
            // Load editor-specific overrides first to reset WordPress defaults
            $editor_css_version = filemtime(get_template_directory() . '/css/editor.css');
            wp_enqueue_style('editor-wmde', get_template_directory_uri() . '/css/editor.css', [], $editor_css_version, 'all');
            // Load frontend styles last so Tailwind utilities can override (depends on editor-wmde)
            $site_css_version = filemtime(get_template_directory() . '/css/site.css');
            wp_enqueue_style('site-frontend', get_template_directory_uri() . '/css/site.css', ['editor-wmde'], $site_css_version, 'all');
        }
        $admin_js_version = file_exists(get_template_directory() . '/js/admin.js') ? filemtime(get_template_directory() . '/js/admin.js') : '1.0';
        wp_enqueue_script('admin', get_template_directory_uri() . '/js/admin.js', ['jquery'], $admin_js_version, false);
        if (current_user_can('administrator')) {
            $acf_url = get_admin_url() . '/edit.php?post_type=acf-field-group';
            if (is_multisite()) {
                $migrate_db_url = network_admin_url() . '/settings.php?page=wp-migrate-db-pro';
            } else {
                $migrate_db_url = get_admin_url() . '/settings.php?page=wp-migrate-db-pro';
            }
            $script = <<<EOF
            document.addEventListener('keydown', function (event) {
                event = event || window.event;
                if (event.key == 'a' && event.ctrlKey) {
                    window.open('$acf_url', '_blank');
                } else if (event.key == 'm' && event.ctrlKey) {
                    window.open('$migrate_db_url', '_blank');
                }
              });
            EOF;
            wp_add_inline_script('admin', $script);
        }
    },
    999
);

// style for wysiwyg editor
function bb_add_custom_editor_styles($mce_css)
{
    if (! empty($mce_css)) {
        $mce_css .= ',';
    }

    // Adjust the path to where your custom CSS file is located
    $mce_css .= get_template_directory_uri() . '/css/editor.css';

    return $mce_css;
}
add_filter('mce_css', 'bb_add_custom_editor_styles');

// Login page style
function my_custom_login_logout_styles() {
    // Check if we are on the login page
    if (strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false) {
        // Deregister the default WordPress login styles
        wp_deregister_style('login');

        // Enqueue your custom login styles
        wp_enqueue_style('custom-login', get_template_directory_uri() . '/css/login.css');
    }

    // Check if we are on the logout page
    if (isset($_GET['loggedout']) && $_GET['loggedout'] == 'true') {
        // Enqueue your custom logout styles
        wp_enqueue_style('custom-logout', get_template_directory_uri() . '/css/login.css');
    }
}
add_action('login_enqueue_scripts', 'my_custom_login_logout_styles', 20);
add_action('wp_enqueue_scripts', 'my_custom_login_logout_styles', 20);