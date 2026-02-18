<div class="">
    <?php if ($date): ?>
    <p class="mb-1 text-sm font-bold uppercase font-alt text-primary-dark"><?php echo $date; ?></p>
    <?php endif; ?>
    <?php if ($link): ?>
    <a class="before:absolute before:inset-0" href="<?php echo esc_url($link['url']); ?>"
        <?php echo $link['target'] ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
        <h3 class="mb-2 group-hover/event:underline decoration-1"><?php echo esc_html($headline); ?></h3>
    </a>
    <?php else: ?>
    <h2 class="mb-2"><?php echo esc_html($headline); ?></h2>
    <?php endif; ?>

    <?php if ($text): ?>
    <div class="mb-2 event-text">
        <?php echo $text; ?>
    </div>
    <?php endif; ?>
</div>