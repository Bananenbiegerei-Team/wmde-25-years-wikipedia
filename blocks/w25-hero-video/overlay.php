<div class="absolute top-0 left-0 z-20 w-full h-full">
 <img class="object-cover w-full h-full"
     src="<?php echo esc_url( get_template_directory_uri() . '/blocks/w25-hero-video/overlay.png' ); ?>"
     alt="<?php echo esc_attr( 'Hero Video Placeholder', 'wmde-25-years-wikipedia' ); ?>">
 <img class="absolute z-40 w-auto h-auto p-4 -translate-x-1/2 -translate-y-8 top-1/2 left-1/2 max-w-[320px] md:max-w-none"
     src="<?php echo esc_url( get_template_directory_uri() . '/blocks/w25-hero-video/wikipedia-25-logo.svg' ); ?>"
     alt="<?php echo esc_attr( '25 Jahre Wikipedia Logo', 'wmde-25-years-wikipedia' ); ?>">
 <?php get_template_part('blocks/w25-hero-video/play-button'); ?>
</div>