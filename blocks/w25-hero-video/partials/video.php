<?php
$full_video   = get_field('full_video');
$poster_id    = get_field('poster_image');
$subtitles    = get_field('subtitles');
$poster_url   = '';
$player_id    = $id . '-plyr';

if ($poster_id) {
  $poster_url = wp_get_attachment_image_url($poster_id, 'full');
}
?>

<video
  id="<?php echo esc_attr($player_id); ?>"
  class="plyr"
  controls
  playsinline
  preload="metadata"
  loop
  <?php if ($poster_url): ?>
    poster="<?php echo esc_url($poster_url); ?>"
  <?php endif; ?>
>
  <?php if (!empty($full_video['url'])): ?>
    <source
      src="<?php echo esc_url($full_video['url']); ?>"
      type="<?php echo esc_attr($full_video['mime_type'] ?? 'video/mp4'); ?>"
    >
  <?php endif; ?>

  <?php if (!empty($subtitles)): ?>
    <?php foreach ($subtitles as $index => $track): ?>
      <?php if (!empty($track['file']['url'])): ?>
        <track
          kind="subtitles"
          src="<?php echo esc_url($track['file']['url']); ?>"
          srclang="<?php echo esc_attr($track['lang']); ?>"
          label="<?php echo esc_attr($track['label']); ?>"
          <?php if ($index === 0): ?>default<?php endif; ?>
        >
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</video>
