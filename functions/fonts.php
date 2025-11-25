<?php

/* Todo
- add support for different styles (normal / italic ?)
*/


add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes, $real_mime) {
    if (! empty($data['ext']) && ! empty($data['type'])) {
        return $data;
    }
    $wp_file_type = wp_check_filetype($filename, $mimes);
    switch ($wp_file_type['ext']) {
        case 'ttf':
            $data['ext'] = 'ttf';
            $data['type'] = 'font/ttf';
            break;
        case 'woff':
            $data['ext'] = 'woff';
            $data['type'] = 'font/woff';
            break;
        case 'woff2':
            $data['ext'] = 'woff2';
            $data['type'] = 'font/woff2';
            break;
    }
    return $data;
}, 10, 5);


add_filter('upload_mimes', function ($mimes) {
    $mimes['ttf']   = 'font/ttf';
    $mimes['woff']  = 'font/woff';
    $mimes['woff2'] = 'font/woff2';
    return $mimes;
});

// Debug stuff...
add_action('xinit', function () {
    echo '<pre>';
    var_dump(get_fields('options'));
    echo '</pre>';
    die;
});


function bb_list_available_fonts()
{
    $fonts = [];
    $args = array('post_type'=>'attachment','numberposts'=>null,'post_status'=>null);
    $attachments = get_posts($args);
    foreach ($attachments as $attachment) {
        if (!str_starts_with($attachment->post_mime_type, 'font/')) {
            continue;
        }
        $fonts[] = wp_get_attachment_url($attachment->ID);
    }
    return $fonts;
}

add_filter('acf/load_field/name=custom_font_file', function ($field) {
    $field['choices'] =[];
    foreach (bb_list_available_fonts() as $font) {
        $field['choices'][$font] = basename($font);
    }
    return $field;
});


function bb_get_font_format($filename)
{
    $types = [
        'ttf' => 'truetype',
        'woff2' => 'woff2',
        'woff' => 'woff'
    ];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return $types[$ext];
}

function bb_inline_style_fonts()
{
    $bb_fonts_css = "/* Custom Fonts */\n";
    foreach ([ 'h' => 'Headings', 't' => 'Texts', 'm' => 'Menus' ] as $k => $l) {
        while (have_rows('fonts_' . $k, 'options')) {
            the_row();
            $name = get_sub_field('custom_font_file')['label'];
            $uri = get_sub_field('custom_font_file')['value'];
            if ($k == 'h' || $k == 'm') {
                $weight = "100 700";
            } else {
                $weight = get_sub_field('custom_font_weight');
                $weight = $weight == 'variable' ? '100 700' : $weight;
            }
            $format = bb_get_font_format(basename($uri));
            $bb_fonts_css .= "@font-face {\n";
            $bb_fonts_css .= "    font-family: '{$l}';\n";
            $bb_fonts_css .= "    font-style: normal;\n";
            $bb_fonts_css .= "    font-weight: {$weight};\n";
            $bb_fonts_css .= "    font-display: swap;\n";
            $bb_fonts_css .= "    src: url('{$uri}') format('{$format}');\n";
            $bb_fonts_css .= "}\n";
        }
    }
    return $bb_fonts_css;
}

// Add custom fonts to frontend stylesheet
add_action(
    'wp_enqueue_scripts',
    function () {
        wp_add_inline_style('style', bb_inline_style_fonts());
    },
    PHP_INT_MAX
);

// Add custom fonts to editor stylesheet so they match frontend
add_action(
    'admin_enqueue_scripts',
    function () {
        global $pagenow;
        if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
            wp_add_inline_style('site-frontend', bb_inline_style_fonts());
        }
    },
    PHP_INT_MAX
);
