<?php
$template_uri = get_template_directory_uri();

// Get bus text fields for bus 1 and 2
$bus_text_1 = get_field('bus_text_01');
$bus_text_2 = get_field('bus_text_02');
?>
<div class="relative min-h-screen" id="bus-container">
    <!-- Bus 01 -->
    <div class="relative w-full bus-item">
        <img class="w-full h-auto"
            src="<?php echo $template_uri; ?>/blocks/w25-bus/img/animation/bus-01.png"
            alt="Bus image 1">
        <?php if ($bus_text_1): ?>
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="container">
                <div class="max-w-2xl p-4 text-white">
                    <p class="text-xl font-bold lg:text-3xl"><?php echo esc_html($bus_text_1); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Bus 02 -->
    <div class="absolute top-0 left-0 w-full bus-item">
        <img class="w-full h-auto"
            src="<?php echo $template_uri; ?>/blocks/w25-bus/img/animation/bus-02.png"
            alt="Bus image 2">
        <?php if ($bus_text_2): ?>
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="container">
                <div class="max-w-2xl p-4 text-white">
                    <p class="text-xl font-bold lg:text-3xl"><?php echo esc_html($bus_text_2); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
