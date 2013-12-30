<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url('/'); ?>">
	<div class="input-group">
		<input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="input-sm search-field form-control" placeholder="<?php _e('Search', 'bootiful'); ?> <?php bloginfo('name'); ?>">
		<label class="sr-only"><?php _e('Search for:', 'bootiful'); ?></label>
		<span class="input-group-btn">
			<button type="submit" class="search-submit btn btn-primary btn-sm"><?php _e('Search', 'bootiful'); ?></button>
		</span>
	</div>
</form>