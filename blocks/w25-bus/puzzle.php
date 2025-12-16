<?php
$template_uri = get_template_directory_uri();
?>
<div class="relative" id="bus-container">
    <?php foreach (range(1, 6) as $busNumber):
        $busNumberPadded = str_pad($busNumber, 2, '0', STR_PAD_LEFT);
        $isFirst = ($busNumber === 1);
    ?>
        <img class="<?php echo $isFirst ? 'relative' : 'absolute top-0 left-0'; ?> w-screen h-auto puzzle-piece"
            style="opacity: <?php echo $isFirst ? '1' : '0'; ?>;"
            src="<?php echo $template_uri; ?>/blocks/w25-bus/img/animation/bus-overlay-<?php echo $busNumberPadded; ?>.svg"
            alt="Bus image">
    <?php endforeach; ?>
</div>