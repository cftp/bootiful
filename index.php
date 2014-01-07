<?php get_header(); ?>
	
	<div id="content-container">
		
		<?php get_template_part( 'parts/header' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'parts/loop', get_post_format() ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'parts/loop', 'none' ); ?>

		<?php endif; ?>

	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>