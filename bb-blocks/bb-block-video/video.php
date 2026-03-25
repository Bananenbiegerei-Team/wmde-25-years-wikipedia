<?php
$video_file = get_field('video');

if ($video_file): ?>
<div class="bb-block-video w-full">
    <video class="object-cover object-center w-full h-full" controls>
        <source src="<?php echo esc_url($video_file['url']); ?>" type="<?php echo esc_attr($video_file['mime_type']); ?>">
        Your browser does not support the video tag.
    </video>
</div>
<?php endif; ?>
