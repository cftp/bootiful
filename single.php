<?php get_header(); ?>

	<div id="content-container">

		<?php if ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'parts/loop', get_post_format() ); ?>

		<?php endif; ?>

		<?php
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		?>
		<nav class="pagination" role="navigation">
			<ul class="nav-links pager">

				<?php if ( $previous ) : ?>
				<li class="nav-previous previous"><?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'bootiful' ) ); ?></li>
				<?php endif; ?>

				<?php if ( $next ) : ?>
				<li class="nav-next next"><?php next_post_link( '%link', _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link', 'bootiful' ) ); ?></li>
				<?php endif; ?>

			</ul><!-- .pager -->
		</nav><!-- .navigation -->

	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>