<article id="post-<?php the_ID(); ?>" <?php post_class('media'); ?> role="article">

	<?php if ( has_post_thumbnail() ) { ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark" class="pull-left">
			<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'media-object' ) ); ?>
		</a>
	<?php } ?>

	<div class="media-body">

		<header class="entry-header">

			<h2 class="entry-title media-heading"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<?php if ( is_sticky() ) : ?>
				<div class="entry-sticky"><?php _e( 'Featured', 'bootiful' ); ?></div>
			<?php else : ?>
				<div class="entry-date"><time class="published" datetime="<?php the_time('Y-m-d\TH:i:s') ?>"><?php cftp_time(); ?></time></div>
			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

		<footer>

			<ul class="entry-meta">
				<li class="author vcard entry-author"><?php _e('By:', 'bootiful'); ?> <a class="url fn n" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php the_author_meta('display_name'); ?>"><?php the_author_meta('display_name'); ?></a></li>
				<li class="entry-categories"><?php _e('Posted in:', 'bootiful'); ?> <?php the_category(', ') ?></li>
				<?php the_tags('<li class="entry-tags">'.__('Tagged:', 'bootiful').' ', ', ', '</li>'); ?>
				<?php if ( comments_open() && ! post_password_required() ) : ?><li class="entry-comments"><?php comments_popup_link(__('No Comments', 'bootiful'), __('1 Comment', 'bootiful'), __('% Comments', 'bootiful')); ?></li><?php endif; ?>
			</ul>

		</footer><!-- .entry-meta -->

	</div><!-- .media-body -->

</article><!-- #post-<?php the_ID(); ?> -->