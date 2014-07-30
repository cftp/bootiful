<?php get_header(); ?>

	<div id="content-container">

		<article id="post-0" class="post error404 not-found">

			<header class="page-header">
				<h1 class="entry-title"><?php _e('404: Page Not Found', 'bootiful'); ?></h1>
			</header>

			<div class="entry-content">

				<p><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable. Try using the search form below to find what you are looking for.', 'bootiful'); ?></p>

				<?php get_search_form(); ?>

			</div>


		</article>

	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>