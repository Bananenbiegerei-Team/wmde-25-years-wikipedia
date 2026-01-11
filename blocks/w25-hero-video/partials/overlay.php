<div class="absolute top-0 left-0 z-20 w-full h-full overlay">
  <div class="absolute inset-0 hidden md:block overlayPuzzles">
    <?php for ($i = 1; $i <= 6; $i++): ?>
      <img
        class="overlayPuzzle desktop object-cover w-full h-full absolute inset-0 <?php echo $i === 1 ? 'opacity-100' : 'opacity-0'; ?>"
        src="<?php echo esc_url(get_template_directory_uri() . '/blocks/w25-hero-video/assets/Puzzle-Header' . $i . '.svg'); ?>"
        alt="<?php echo esc_attr('Hero Video Placeholder ' . $i, 'wmde-25-years-wikipedia'); ?>"
        data-puzzle="<?php echo esc_attr($i); ?>"
      >
    <?php endfor; ?>
  </div>

  <div class="absolute inset-0 md:hidden overlayPuzzles">
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
  <?php if (have_rows('video_credits')): ?>
  <div class="absolute left-0 px-2 bottom-2" x-data="{ showCredits: false }">
    <div x-show="showCredits" class="max-w-xl p-2 mb-2 space-y-2 rounded-lg bg-black/80">
      <?php while (have_rows('video_credits')): the_row();
        $credit = get_sub_field('credit');
        if ($credit):
      ?>
        <p class="text-sm text-white"><?php echo $credit; ?></p>
      <?php
        endif;
      endwhile; ?>
    </div>
    <button @click="showCredits = !showCredits" class="flex items-center gap-1 p-2 text-white transition rounded-lg hover:bg-black/70">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/></svg>
    <span class="sr-only">Credits</span>
    </button>
  </div>
  <?php endif; ?>
</div>
