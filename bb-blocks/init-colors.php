<?php



// Colors definition
// 1. This needs to be consistent with tailwind.config.js.
// 2. Colors options need to be declared in ACF Group Theme Options/Custom Colors
define('BB_COLORS', [
    'primary' => 'Primary',
    'secondary' => 'Secondary',
    'neutral' => 'Neutral',
    'accent' => 'Accent',
    'warning' => 'Warning',
    'error' => 'Error',
    'success' => 'Success',
]);

define(
    'BB_COLORS_BW',
    [ 'white' => 'White', 'black' => 'Black']
);

define('BB_COLORS_VARIANTS', [
    'default' => '',
    'light' => '-light',
    'dark' => '-dark'
]);

// Load field settings from block.json files
foreach (glob(__DIR__ . '/*/block.json') as $json) {
    $block = json_decode(file_get_contents($json));
    if (isset($block->bb->colors)) {
        foreach ($block->bb->colors as $field) {
            $colors = bb_get_colors($field);
            add_filter("acf/load_field/key={$field->key}", function ($f) use ($colors) {
                $f['choices'] = $colors;
                return $f;
            });
        }
    }
}

// Get list of colors for requested variant
function bb_get_colors($field)
{
    $variant = $field->variant;
    $bw = isset($field->bw) ? $field->bw : false;
    $none = isset($field->none) ? $field->none : false;

    $bw = $bw ? [ 'black' => 'Black', 'white' => 'White'] : [];
    $none = $none ? [ 'none' => 'None'] : [];

    $all_colors = [];
    $all_colors['default'] = BB_COLORS ;

    foreach (BB_COLORS as $color => $label) {
        if ($color == 'none') {
            continue;
        }
        if ($color != 'white' && $color != 'black') {
            $light_colors[$color . BB_COLORS_VARIANTS['light']] = "{$label} light";
        }
    }
    $all_colors['light'] = $light_colors ;

    $dark_colors = [];
    foreach (BB_COLORS as $color => $label) {
        if ($color == 'none') {
            continue;
        }
        if ($color != 'white' && $color != 'black') {
            $dark_colors[$color . BB_COLORS_VARIANTS['dark']] = "{$label} dark";
        }
    }
    $all_colors['dark'] = $dark_colors ;

    $all_colors['all'] = array_merge($all_colors['default'], $all_colors['light'], $all_colors['dark']);
    return array_merge($none, $bw, $all_colors[$variant]);
}

/**
 * Get component color (titlebar, navbar, footer, body)
 * Returns array with 'class' for Tailwind bg class or 'style' for inline style
 *
 * @param string $component Component name (titlebar_color, navbar_color, footer_color, body_color)
 * @return array ['class' => 'bg-xxx', 'style' => ''] or ['class' => '', 'style' => 'background-color: #xxx']
 */
function bb_get_component_color($component)
{
    $color_field = get_field($component, 'options');

    // Handle new group structure with preset + custom
    if (is_array($color_field)) {
        $preset = $color_field['preset'] ?? 'white';
        $custom = $color_field['custom'] ?? '';

        if ($preset === 'custom' && !empty($custom)) {
            return [
                'class' => '',
                'style' => "background-color: {$custom};"
            ];
        }

        return [
            'class' => "bg-{$preset}",
            'style' => ''
        ];
    }

    // Handle legacy simple string value (backwards compatibility)
    if (is_string($color_field) && !empty($color_field)) {
        return [
            'class' => "bg-{$color_field}",
            'style' => ''
        ];
    }

    // Default to white
    return [
        'class' => 'bg-white',
        'style' => ''
    ];
}

// Create a list of CSS variables to override Tailwind colors
function bb_inline_style_colors()
{
    $options = get_fields('options');
    $tw_colors = null; // Lazy load defaults only if needed

    $bb_colors_css = "/* Custom Colors */\n:root {\n";
    foreach (array_merge(BB_COLORS_BW, BB_COLORS) as $color => $label) {
        if ($color == 'none') {
            continue;
        }
        if ($color == 'white' || $color == 'black') {
            $color_val = null;
            if (is_array($options['bw_colors']["color_{$color}"] ?? null)) {
                $vals = array_slice(array_values($options['bw_colors']["color_{$color}"]), 0, 3);
                // Check if it's a valid color (not all zeros unless it's black)
                if ($color === 'black' || array_sum($vals) > 0) {
                    $color_val = join(', ', $vals);
                }
            }
            // Fall back to CSS default if not set
            if (!$color_val) {
                if ($tw_colors === null) {
                    $tw_colors = bb_get_tw_colors(__DIR__ . '/../css/site.css');
                }
                $color_val = $tw_colors[$color] ?? null;
            }
            if ($color_val) {
                $bb_colors_css .= "    --colors-{$color}: {$color_val};\n";
            }
        } else {
            foreach (BB_COLORS_VARIANTS as $k => $v) {
                $color_val = null;
                if (is_array($options["color_{$color}"][$k] ?? null)) {
                    $vals = array_slice(array_values($options["color_{$color}"][$k]), 0, 3);
                    // Only use if not all zeros (unset colors default to 0,0,0)
                    if (array_sum($vals) > 0) {
                        $color_val = join(', ', $vals);
                    }
                }
                // Fall back to CSS default if not set
                if (!$color_val) {
                    if ($tw_colors === null) {
                        $tw_colors = bb_get_tw_colors(__DIR__ . '/../css/site.css');
                    }
                    $css_key = $v ? $color . $v : $color;
                    $color_val = $tw_colors[$css_key] ?? null;
                }
                if ($color_val) {
                    $bb_colors_css .= "    --colors-{$color}{$v}: {$color_val};\n";
                }
            }
        }
    }
    $bb_colors_css .= "}\n";
    return $bb_colors_css;
}

// Add custom colors to stylesheet
add_action(
    'wp_enqueue_scripts',
    function () {
        if (get_field('use_custom_colors', 'options')) {
            wp_add_inline_style('style', bb_inline_style_colors());
        }
    },
    PHP_INT_MAX
);

// Add custom colors to editor stylesheet
add_action(
    'admin_enqueue_scripts',
    function () {
        if (get_field('use_custom_colors', 'options')) {
            wp_add_inline_style('editor-wmde', bb_inline_style_colors());
        }
    },
    PHP_INT_MAX
);


// Add custom colors to login screen
add_action(
    'login_enqueue_scripts',
    function () {
        if (get_field('use_custom_colors', 'options')) {
            wp_add_inline_style('custom-login', bb_inline_style_colors());
            wp_add_inline_style('custom-logout', bb_inline_style_colors());
        }
    },
    PHP_INT_MAX
);

// Load default colors from CSS for any colors that are not set
add_action('admin_init', function () {
    $options = get_fields('options');
    $tw_colors = null; // Lazy load only if needed

    // Check each color individually and load defaults for missing ones
    foreach (BB_COLORS as $color => $label) {
        foreach (BB_COLORS_VARIANTS as $variant => $v) {
            // Calculate sum for this specific color variant
            $color_sum = 0;
            if (isset($options["color_" . $color][$variant])) {
                foreach (['red', 'green', 'blue'] as $channel) {
                    $color_sum += $options["color_" . $color][$variant][$channel] ?? 0;
                }
            }

            // If this color variant is not set (sum is 0), load default from CSS
            if ($color_sum == 0) {
                // Lazy load CSS colors only when needed
                if ($tw_colors === null) {
                    $tw_colors = bb_get_tw_colors(__DIR__ . '/../css/site.css');
                }

                if ($v != '') {
                    $key = $color . $v;
                } else {
                    $key = $color;
                }

                if (!isset($tw_colors[$key]) || empty($tw_colors[$key])) {
                    continue;
                }

                $tw_color = explode(',', $tw_colors[$key]);
                if (count($tw_color) < 3) {
                    continue;
                }

                $tw_hex_color = sprintf("#%02x%02x%02x", trim($tw_color[0]), trim($tw_color[1]), trim($tw_color[2]));

                if ($v == '') {
                    $key .= '-default';
                }
                $key = str_replace('-', '_', $key);
                update_field('color_' . $key, $tw_hex_color, 'options');
            }
        }
    }

    // Check B&W colors individually
    foreach (BB_COLORS_BW as $bwcolor => $label) {
        $color_sum = 0;
        if (isset($options['bw_colors']["color_{$bwcolor}"])) {
            foreach (['red', 'green', 'blue'] as $channel) {
                $color_sum += $options['bw_colors']["color_{$bwcolor}"][$channel] ?? 0;
            }
        }

        // Black has sum 0 naturally, so check if the field exists and has valid data
        $field_value = $options['bw_colors']["color_{$bwcolor}"] ?? null;
        $is_set = is_array($field_value) && isset($field_value['red']);

        if (!$is_set) {
            if ($tw_colors === null) {
                $tw_colors = bb_get_tw_colors(__DIR__ . '/../css/site.css');
            }

            if (!isset($tw_colors[$bwcolor]) || empty($tw_colors[$bwcolor])) {
                continue;
            }

            $tw_color = explode(',', $tw_colors[$bwcolor]);
            if (count($tw_color) < 3) {
                continue;
            }

            $tw_hex_color = sprintf("#%02x%02x%02x", trim($tw_color[0]), trim($tw_color[1]), trim($tw_color[2]));
            update_field('bw_colors_color_' . $bwcolor, $tw_hex_color, 'options');
        }
    }
});

function bb_get_tw_colors($file)
{
    $css = file_get_contents($file);
    preg_match('/:root{\s?+(.*?)}/', $css, $m);

    if (!isset($m[1]) || empty($m[1])) {
        return [];
    }

    $c = explode(";", $m[1]);
    $tw_colors = [];
    foreach ($c as $col) {
        $col = explode(':', str_replace('--colors-', '', trim($col)));
        if (empty($col[0])) {
            continue;
        }
        $tw_colors[$col[0]] = str_replace(';', '', $col[1] ?? '');
    }
    return $tw_colors;
}
