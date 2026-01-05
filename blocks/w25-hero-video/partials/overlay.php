<div class="overlay absolute top-0 left-0 z-20 w-full h-full">
  <div class="hidden md:block overlayPuzzles absolute inset-0">
    <?php for ($i = 1; $i <= 6; $i++): ?>
      <img
        class="overlayPuzzle desktop object-cover w-full h-full absolute inset-0 <?php echo $i === 1 ? 'opacity-100' : 'opacity-0'; ?>"
        src="<?php echo esc_url(get_template_directory_uri() . '/blocks/w25-hero-video/assets/Puzzle-Header' . $i . '.svg'); ?>"
        alt="<?php echo esc_attr('Hero Video Placeholder ' . $i, 'wmde-25-years-wikipedia'); ?>"
        data-puzzle="<?php echo esc_attr($i); ?>"
      >
    <?php endfor; ?>
  </div>

  <div class=" md:hidden overlayPuzzles absolute inset-0">
    <?php for ($i = 1; $i <= 4; $i++): ?>
      <img
        class="overlayPuzzle mobile object-cover w-full h-full absolute inset-0 <?php echo $i === 1 ? 'opacity-100' : 'opacity-0'; ?>"
        src="<?php echo esc_url(get_template_directory_uri() . '/blocks/w25-hero-video/assets/MOBILE-Overlay' . $i . '.svg'); ?>"
        alt="<?php echo esc_attr('Hero Video Placeholder ' . $i, 'wmde-25-years-wikipedia'); ?>"
        data-puzzle="<?php echo esc_attr($i); ?>"
      >
    <?php endfor; ?>
  </div>

  <img
    class="absolute z-40 w-auto h-auto p-4 -translate-x-1/2 -translate-y-8 top-1/2 left-1/2 max-w-[320px] md:max-w-none"
    src="<?php echo esc_url( get_template_directory_uri() . '/blocks/w25-hero-video/assets/wikipedia-25-logo.svg' ); ?>"
    alt="<?php echo esc_attr( '25 Jahre Wikipedia Logo', 'wmde-25-years-wikipedia' ); ?>"
  >

  <?php get_template_part('blocks/w25-hero-video/partials/play-button'); ?>
</div>
