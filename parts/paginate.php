<?php if ($wp_query->max_num_pages > 1) : // only paginate when necessary ?>

<nav class="pagination" role="navigation">

	<ul class="nav-links pager">
		<?php if ( get_next_posts_link() ) : ?>
		<li class="nav-previous previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bootiful' ) ); ?></li>
		<?php endif; ?>
		<?php if ( get_previous_posts_link() ) : ?>
		<li class="nav-next next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bootiful' ) ); ?></li>
		<?php endif; ?>
	</ul><!-- .nav-links -->

</nav>

<?php endif; ?>