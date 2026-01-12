<?php get_header(); ?>
<?php while (have_posts()): ?>
<?php the_post(); ?>
	<?php get_template_part('template-parts/page-header'); ?>
	<div class="pt-10 content">
		<?php the_content(); ?>
	</div>
<?php endwhile; ?>
<?php get_footer(); ?>
