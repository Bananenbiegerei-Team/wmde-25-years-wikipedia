<?php
$title = get_field('title');
$link = get_field('link');
?>
<div class="card w-full">
	<?php if ($title): ?>
	<header>
		<h3><?= esc_html($title) ?></h3>
	</header>
	<?php endif; ?>

	<?php if ($link): ?>
	<footer>
		<a class="btn w-full" href="<?= esc_url($link['url']) ?>" target="<?= esc_attr($link['target'] ?: '_self') ?>">
			<?= esc_html($link['title']) ?>
		</a>
	</footer>
	<?php endif; ?>
</div>
