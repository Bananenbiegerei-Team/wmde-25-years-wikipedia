<?php
$template_uri = get_template_directory_uri();

// Get all bus text fields
$bus_texts = [];
for ($i = 1; $i <= 6; $i++) {
    $bus_texts[$i] = get_field('bus_text_0' . $i);
}
?>
<div class="relative" id="bus-container">
    <?php foreach (range(1, 6) as $busNumber):
        $busNumberPadded = str_pad($busNumber, 2, '0', STR_PAD_LEFT);
        $isFirst = ($busNumber === 1);
        $busText = $bus_texts[$busNumber];
    ?>
        <div class="<?php echo $isFirst ? 'relative' : 'absolute top-0 left-0'; ?> w-screen bus-item puzzle-piece"
            style="opacity: <?php echo $isFirst ? '1' : '0'; ?>;">
            <img class="w-screen h-auto"
                src="<?php echo $template_uri; ?>/blocks/w25-bus/img/animation/bus-overlay-<?php echo $busNumberPadded; ?>.svg"
                alt="Bus image">
            <?php if ($busText): ?>
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="container">
                    <div class="max-w-2xl p-4 text-white">
                        <p class="text-xl font-bold lg:text-3xl"><?php echo esc_html($busText); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>