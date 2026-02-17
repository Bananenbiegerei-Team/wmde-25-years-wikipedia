<div class="flex flex-col justify-between h-full">
    <div class="flex items-start justify-between gap-4 mb-2">
    <?php if ($headline): ?>
    <h2><?php echo esc_html($headline); ?></h2>
    <?php endif; ?>
</div>

<div class="">
    <?php if ($text): ?>
    <div class="mb-2 event-text">
        <?php echo $text; ?>
    </div>
    <?php endif; ?>

    <?php if ($link): ?>
        <a class="btn btn-sm btn-outline" href="<?php echo esc_url($link['url']); ?>" class="underline"
        <?php echo $link['target'] ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
            <?php echo esc_html($link['title']); ?>
        </a>
    <?php endif; ?>
</div>
</div>