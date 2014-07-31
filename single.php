<?php get_header(); ?>

	<div id="content-container">

		<?php if ( have_posts() ) : the_post(); ?>

			<?php tha_entry_before(); ?>

			<article <?php post_class() ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

				<?php tha_entry_top(); ?>

				<header class="page-header">

					<?php tha_entry_header_top(); ?>

					<h1 class="entry-title" itemprop="headline"><?php the_title() ?></h1>

					<?php tha_entry_header_bottom(); ?>

				</header>

				<div class="entry-content" itemprop="articleBody">
					<?php wp_link_pages('before=<div class="page-link">'  . __('Page:', 'bootiful') . '&after=</div>&link_before=<span>&link_after=</span>') ?>
					<?php the_content() ?>
				</div>

				<footer>

					<?php tha_entry_footer_top(); ?>

					<p class="entry-meta entry-description">
					<?php
					printf(__('This entry was posted by %1$s on %2$s and is filed under %3$s. ', 'bootiful'),
						get_the_author(),
						'<time datetime="'.get_the_time('Y-m-d').'">'.cftp_get_time('l, F jS, Y @ g:ia').'</time>',
						get_the_category_list(', ')
					);

					printf(__('You can follow any responses to this entry through the %1$sRSS 2.0%2$s feed. ', 'bootiful'),
						'<a href="'.get_post_comments_feed_link().'">',
						'</a>'
					);

					if ( comments_open() && pings_open() ) {

						// Both Comments and Pings are open
						printf(
							__('You can <a href="#respond">leave a response</a>, or <a href="%1$s" rel="trackback">trackback</a> from your own site.', 'bootiful'),
							get_trackback_url()
						);

					} else if ( !comments_open() && pings_open() ) {

						// Only Pings are Open
						printf(
							__('Responses are currently closed, but you can leave a <a href="%1$s" rel="trackback">trackback</a> from your own site.', 'bootiful'),
							get_trackback_url()
						);

					} else if ( comments_open() && !pings_open() ) {

						// Comments are open, Pings are not
						_e('You can skip to the end and leave a response. Pinging is currently not allowed.', 'bootiful');

					} else if ( !comments_open() && !pings_open() ) {

						// Neither Comments, nor Pings are open
						_e('Both comments and pings are currently closed.', 'bootiful');

					}
					?>
					</p>

					<?php tha_entry_footer_bottom(); ?>

				</footer>

				<nav class="pagination" role="navigation">
					<div class="previous"><?php previous_post_link('%link', '&laquo; %title') ?></div>
					<div class="next"><?php next_post_link('%link', '%title &raquo;') ?></div>
				</nav>

				<?php
				// if comments are open or we have at least one comment, load up the comment template
				if (comments_open() || '0' != get_comments_number()) {
					comments_template();
				}
				?>

				<?php tha_entry_bottom(); ?>

			</article>

			<?php tha_entry_after(); ?>

		<?php endif; ?>

	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>