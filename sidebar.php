<?php tha_sidebars_before(); ?>

<aside id="sidebar" class="sidebar" role="complementary">

	<div id="sidebar-scroll-wrapper">

		<div id="sidebar-scroll">
			<?php tha_sidebar_top(); ?>

			<?php
			if ( is_active_sidebar( 'sidebar' ) ) {
				dynamic_sidebar('sidebar');
			}
			?>

			<?php tha_sidebar_bottom(); ?>
		</div>

	</div>

</aside>

<?php tha_sidebars_after(); ?>