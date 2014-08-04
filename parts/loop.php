<?php tha_entry_before(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('media'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting" <?php post_data(); ?>>

	<?php tha_entry_top(); ?>

	<?php if ( has_post_thumbnail() ) { ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark" class="pull-left">
			<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'media-object', 'itemprop'=>'image' ) ); ?>
		</a>
	<?php } ?>

	<div class="media-body">

		<header class="entry-header">

			<?php tha_entry_header_top(); ?>

			<h2 class="entry-title media-heading" itemprop="headline"><a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>

			<?php if ( is_sticky() ) : ?>
				<div class="entry-sticky"><?php _e( 'Featured', 'bootiful' ); ?></div>
			<?php else : ?>
				<div class="entry-date"><time class="published" datetime="<?php the_date('c'); ?>" itemprop="datePublished"><?php cftp_time(); ?></time></div>
			<?php endif; ?>

			<?php tha_entry_header_bottom(); ?>

		</header><!-- .entry-header -->

		<div class="entry-summary" itemprop="description">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<footer>

			<?php tha_entry_footer_top(); ?>

			<ul class="entry-meta">
				<li class="author vcard entry-author"><?php _e('By:', 'bootiful'); ?> <a class="url" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php the_author_meta('display_name'); ?>"><span class="fn n" rel="author" itemprop="author"><?php the_author_meta('display_name'); ?></span></a></li>
				<li class="entry-categories"><?php _e('Posted in:', 'bootiful'); ?> <?php the_category(', ') ?></li>
				<?php the_tags('<li class="entry-tags">'.__('Tagged:', 'bootiful').' ', ', ', '</li>'); ?>
				<?php if ( comments_open() && ! post_password_required() ) : ?><li class="entry-comments"><?php comments_popup_link(__('No Comments', 'bootiful'), __('1 Comment', 'bootiful'), __('% Comments', 'bootiful')); ?></li><?php endif; ?>
			</ul>

			<?php tha_entry_footer_bottom(); ?>

		</footer><!-- .entry-meta -->

	</div><!-- .media-body -->

	<?php tha_entry_bottom(); ?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php tha_entry_after(); ?>