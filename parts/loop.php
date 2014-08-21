<?php tha_entry_before(); ?>

<article <?php post_class() ?> role="article" itemscope itemtype="http://schema.org/BlogPosting" <?php post_attributes(); ?>>

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

		<?php tha_entry_footer_bottom(); ?>

	</footer>

	<?php
	// if comments are open or we have at least one comment, load up the comment template
	if (comments_open() || '0' != get_comments_number()) {
		comments_template();
	}
	?>

	<?php tha_entry_bottom(); ?>

</article>

<?php tha_entry_after(); ?>