		</div><!-- #content -->

		<footer id="footer" role="contentinfo">

			<?php if ( has_nav_menu( 'navigation' ) ) { ?>
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

		</footer><!-- #footer -->
		
	</div><!-- #wrapper .hfeed -->

	<div id="wp-footer">
		<?php wp_footer(); ?>
	</div><!-- #wp-footer -->

</body>
</html>