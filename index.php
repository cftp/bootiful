<?php get_header(); ?>

	<div id="content-container">

		<section class="archive-header">

			<header class="page-header">

				<h1 class="archive-title">
					<?php
					if (is_home()) {
						if (get_option('page_for_posts', true)) {
							echo get_the_title(get_option('page_for_posts', true));
						} else {
							echo __('Latest Posts', 'bootiful');
						}
					} elseif (is_archive()) {
						$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
						if ($term) {
							echo apply_filters('single_term_title', $term->name);
						} elseif (is_post_type_archive()) {
							echo apply_filters('the_title', get_queried_object()->labels->name);
						} elseif (is_day()) {
							echo sprintf(__('Daily Archives: %s', 'bootiful'), get_the_date());
						} elseif (is_month()) {
							echo sprintf(__('Monthly Archives: %s', 'bootiful'), get_the_date('F Y'));
						} elseif (is_year()) {
							echo sprintf(__('Yearly Archives: %s', 'bootiful'), get_the_date('Y'));
						} elseif (is_author()) {
							$author = get_queried_object();
							echo sprintf(__('Author Archives: %s', 'bootiful'), $author->display_name);
						} else {
							echo single_cat_title('', false);
						}
					} elseif (is_search()) {
						echo sprintf(__('Search Results for %s', 'bootiful'), get_search_query());
					} elseif (is_404()) {
						echo __('Not Found', 'bootiful');
					} else {
						echo get_the_title();
					}
					?>
				</h1>

			</header>

		</section>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'parts/loop', get_post_format() ); ?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'parts/loop', 'none' ); ?>

		<?php endif; ?>

		<?php get_template_part( 'parts/paginate' ); ?>

	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>