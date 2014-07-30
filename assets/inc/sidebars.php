<?php

class cftp_sidebars {

	/**
	* Register sidebars, format and control widgets
	*
	* @author Scott Evans
	*/
	public function __construct() {

		// actions
		add_action( 'init', array( $this, 'register_sidebars' ) );
		add_action( 'widgets_init', array( $this, 'remove_wordpress_widgets'), 10);

		// filters

		// Enable oEmbed & shortcodes in text widgets
		global $wp_embed;
		add_filter('widget_text', array( $wp_embed, 'run_shortcode' ), 8);
		add_filter('widget_text', array( $wp_embed, 'autoembed'), 8);
		add_filter('widget_text', 'do_shortcode', 11);

	}

	/**
	 * register_sidebars
	 *
	 * Register the required sidebars for this theme
	 *
	 * @author Scott Evans
	 * @return void
	 */
	function register_sidebars() {

		if (!function_exists('register_sidebars'))
			return;

		$sidebars = apply_filters('cftp_sidebars', array(

			// sidebar
			'sidebar'	=> array( 'title' => __('Default Sidebar', 'bootiful'), 'description' => __('Default sidebar.', 'bootiful') ),

			// 404
			'error'		=> array( 'title' => __('Error 404', 'bootiful'), 'description' => __('Optional sidebar for 404 page.', 'bootiful') )

		));

		foreach ($sidebars as $key => $sidebar) {

			$heading = (isset($sidebar['heading']) ? $sidebar['heading'] : 'h4');

			register_sidebar(
				array(
					'name' 			=> $sidebar['title'],
					'description'	=> (isset($sidebar['description']) ? $sidebar['description'] : ''),
					'id'			=> $key,
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section><!-- .widget -->',
					'before_title'  => '<'.$heading.' class="widgettitle">',
					'after_title'   => '</'.$heading.'>'
				)
			);
		}
	}

	/**
	 * remove_wordpress_widgets
	 *
	 * Remove un-required widgets for this theme
	 *
	 * @author Scott Evans
	 * @return void
	 */
	function remove_wordpress_widgets() {

		// calendar
		unregister_widget('WP_Widget_Calendar');

		// links
		unregister_widget('WP_Widget_Links');

		// meta
		unregister_widget('WP_Widget_Meta');

	}
}

global $cftp_sidebars;
$cftp_sidebars = new cftp_sidebars();