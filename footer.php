				<?php tha_content_bottom(); ?>

			</div><!-- #content -->

			<?php tha_content_after(); ?>

		</div><!-- #content-wrapper -->

		<div id="footer-wrapper">

			<?php tha_footer_before(); ?>

			<footer id="footer" role="contentinfo">

				<?php tha_footer_top(); ?>

				<?php if ( has_nav_menu( 'footer' ) ) { ?>
				<nav id="footer-navigation" role="navigation">

					<?php
					wp_nav_menu(
						array(
							'menu' => 'footer',
							'theme_location' => 'footer',
							'depth' => 1,
							'container' => false
						)
					);
					?>

				</nav><!--  #footer-navigation -->
				<?php } ?>

				<?php tha_footer_bottom(); ?>

			</footer><!-- #footer -->

			<?php tha_footer_after(); ?>

		</div><!-- #footer-wrapper -->

	</div><!-- #wrapper .hfeed -->

	<div id="wp-footer">
		<?php wp_footer(); ?>
	</div><!-- #wp-footer -->

	<?php tha_body_bottom(); ?>

</body>
</html>