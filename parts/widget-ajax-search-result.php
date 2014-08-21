<li <?php post_class(); ?>>
	<h5 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
	<div class="entry-date"><time class="published" datetime="<?php the_time('Y-m-d\TH:i:s') ?>"><?php the_date(); ?></time></div>
</li>