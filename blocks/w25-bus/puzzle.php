<?php
$template_uri = get_template_directory_uri();
$animation_dir = get_template_directory() . '/blocks/w25-bus/img/animation/';

// Get all bus-puzzle images from the animation directory
$images = glob($animation_dir . 'bus-puzzle-*.png');
sort($images); // Ensure they're in numerical order

// Get the total number of images
$image_count = count($images);
?>
<div class="relative" id="bus-container">
    <?php foreach ($images as $index => $image_path):
        $image_number = $index + 1;
        $image_filename = basename($image_path);
        $bus_text_field = 'bus_text_' . str_pad($image_number, 2, '0', STR_PAD_LEFT);
        $bus_text = get_field($bus_text_field);
        $position_class = ($index === 0) ? 'relative' : 'absolute top-0 left-0';
    ?>
    <!-- Bus <?php echo str_pad($image_number, 2, '0', STR_PAD_LEFT); ?> -->
    <div class="<?php echo $position_class; ?> w-full bus-item">
        <img class="w-full h-auto"
            src="<?php echo $template_uri; ?>/blocks/w25-bus/img/animation/<?php echo $image_filename; ?>"
            alt="Bus image <?php echo $image_number; ?>"
            loading="lazy"
            decoding="async">
        <?php if ($bus_text): ?>
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="container">
                <div class="max-w-2xl p-4 text-white">
                    <p class="text-xl font-bold lg:text-3xl"><?php echo esc_html($bus_text); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
