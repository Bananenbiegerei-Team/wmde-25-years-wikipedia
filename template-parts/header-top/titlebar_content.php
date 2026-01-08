<?php
$home_url = 'https://www.wikimedia.de/';
?>


<div class="flex items-center w-full">
    <div class="flex-1">
        <a href="<?= $home_url ?>" class="hidden md:block">
            <img class="logo" style="max-height: 41px" src="<?= get_stylesheet_directory_uri() ?>/img/wikimedia-logo.svg" alt="Wikimedia Logo">
        </a>
        <a href="<?= $home_url ?>" class="block md:hidden">
            <img style="max-height: 41px" src="<?= get_stylesheet_directory_uri() ?>/img/wikimedia-logo-mini.svg" alt="Wikimedia Logo">
        </a>
    </div>

    <div class="hidden md:block">
        <?php get_template_part('template-parts/header-top/cta'); ?>

        <?php if (has_nav_menu('nav-right-level-1')) : ?>
            <?php get_template_part('template-parts/header-top/menu-top-right-1'); ?>
        <?php endif; ?>
    </div>
</div>