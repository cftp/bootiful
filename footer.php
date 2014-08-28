				<?php tha_content_bottom(); ?>

			</div><!-- #content -->

			<?php tha_content_after(); ?>

		</div><!-- #content-wrapper -->

		<div id="footer-wrapper">

			<?php tha_footer_before(); ?>

			<footer id="footer" role="contentinfo">

				<?php tha_footer_top(); ?>

				<?php // no footer on an infinite scroll site ?>

				<?php tha_footer_bottom(); ?>

			</footer><!-- #footer -->

			<?php tha_footer_after(); ?>

		</div><!-- #footer-wrapper -->

	</div><!-- #wrapper .hfeed -->

	<div id="wp-footer">
		<?php wp_footer(); ?>
	</div><!-- #wp-footer -->

	<?php tha_body_bottom(); ?>
	<?php get_template_part( 'parts/google-analytics' ); ?>

</body>
</html>