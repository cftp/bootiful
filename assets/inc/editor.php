<?php

class cftp_mce_editor {

	/**
	* Tweak TinyMCE
	*
	* @author Scott Evans
	*/
	public function __construct() {

		// actions
		add_action( 'init', array( $this, 'add_editor_style' ) );

		// filters
		// need to add bootstrap stuff, plus the defaults, plus find a way to embed the Google fonts
		//add_filter( 'tiny_mce_before_init', array( $this, 'editor_style_select' ) );
		add_filter( 'mce_css', array( $this, 'editor_css' ) );

	}

	/**
	* add_editor_style
	*
	* Register the editor styles
	* 
	* @author Scott Evans 
	* @return void 
	*/
	function add_editor_style() {
		add_editor_style( 'assets/less/wp-editor.less' );
	}

	/**
	 * editor_style_select
	 *
	 * Make custom bootstrap styles accessible in the editor
	 *
	 * @author Scott Evans
	 * @param  array $settings
	 * @return array
	 */
	function editor_style_select( $settings ) {

		$style_formats = array(
			array(
				'title' => __('Error', 'bootiful'),
				'block' => 'div',
				'classes' => 'error',
				'wrapper' => true
			),
			array(
				'title' => __('Notice', 'bootiful'),
				'block' => 'div',
				'classes' => 'notice',
				'wrapper' => true
			),
			array(
				'title' => __('Success', 'bootiful'),
				'block' => 'div',
				'classes' => 'success',
				'wrapper' => true
			),
			array(
				'title' => __('Text Button', 'bootiful'),
				'selector' => 'a',
				'classes' => 'a-button'
			),
			array(
				'title' => __('Loud', 'bootiful'),
				'inline' => 'span',
				'classes' => 'loud',
			),
			array(
				'title' => __('Quiet', 'bootiful'),
				'inline' => 'span',
				'classes' => 'quiet',
			),
			array(
				'title' => __('Highlight', 'bootiful'),
				'inline' => 'span',
				'classes' => 'highlight'
			)
		);

		$settings['style_formats'] = json_encode($style_formats);

		return $settings;
	}

	/**
	 * editor_css
	 *
	 * Cache bust TinyMCE editor styles and load Google fonts
	 *
	 * @author http://bit.ly/12Yz03u
	 * @param  string $css 
	 * @return string     
	 */
	function editor_css($css) {

		global $editor_styles;

		if (empty($css) or empty($editor_styles)) {
			return $css;
		}

		$mce_css   = array();
		$style_uri = get_stylesheet_directory_uri();
		$style_dir = get_stylesheet_directory();

		// get google fonts
		$heading_font = get_theme_mod( 'headingfont', 'Cabin' );
		$heading_font_weight = get_theme_mod( 'headingfontweight', '700' );
		$body_font = get_theme_mod( 'bodyfont', 'a1' );

		global $cftp_customiser;
		$allfonts = $cftp_customiser->get_fonts();

		$gfonts = array();
		
		if ( ! $cftp_customiser->string_search('(system)', $allfonts[$heading_font]['name'] ) ) {
			$gfonts[] = $heading_font . ':' . $heading_font_weight;
		}
		
		if ( ! $cftp_customiser->string_search('(system)', $allfonts[$body_font]['name'] ) ) {
			$gfonts[] = $body_font;
		}
	
		if ( ! empty( $gfonts ) ) { 
			$gfonts = array_unique($gfonts);
			$getfonts = implode('|', $gfonts);
			$protocol = is_ssl() ? 'https' : 'http';
			$mce_css[] = add_query_arg('version', CFTP_CACHE_BUST, $protocol . '://fonts.googleapis.com/css?family='.$getfonts); 
		}		

		// cache bust
		if (is_child_theme()) {
			$template_uri = get_template_directory_uri();
			$template_dir = get_template_directory();

			foreach($editor_styles as $key => $file) {
				if ($file && file_exists("$template_dir/$file")) {
					$mce_css[] = add_query_arg(
						'version',
						CFTP_CACHE_BUST,
						"$template_uri/$file"
					);
				}
			}
		}

		foreach($editor_styles as $file) {
			if ($file && file_exists( "$style_dir/$file")) {
				$mce_css[] = add_query_arg(
					'version',
					CFTP_CACHE_BUST,
					"$style_uri/$file"
				);
			}
		}

		return implode( ',', $mce_css );
	}
}

global $cftp_mce_editor;
$cftp_mce_editor = new cftp_mce_editor();