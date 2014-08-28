<?php

class cftp_customiser {

	/**
	* Add theme customiser controls, manage cache busting and less variables
	*
	* @author Scott Evans
	* @see add_action('customize_register',$func)
	* @param \WP_Customize_Manager $wp_customize
	*/
	public function __construct() {

		// actions
		add_action( 'init', array( $this, 'customiser_init' ) );
		add_action( 'customize_register' , array( $this , 'register' ) );
		add_action( 'customize_save_after', array( $this, 'save' ) );

		// filters
		add_filter( 'less_vars', array( $this, 'less_vars' ), 10, 2 );

	}

	/**
	 * customiser_init
	 *
	 * Apply certain filters to WordPress when customisations are being made.
	 * Filter the cache bust variable and merge new (temporary) settings into existing options.
	 *
	 * @author Scott Evans
	 * @return void
	 */
	function customiser_init() {

		$ref = ( isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' );

		if ( $this->is_customising() ) {

			add_filter(	'cftp_cache_bust', array( $this, 'cache_bust' ), 10, 1 );
			$theme_slug = get_option( 'stylesheet' );
			add_filter( 'option_theme_mods_' . $theme_slug, array($this, 'merge_theme_mods'), 10, 1 );

		}
	}

	/**
	 * register
	 *
	 * Register the themes custom options and setting with the WP theme customiser.
	 *
	 * @author Scott Evans
	 * @param  object $wp_customize
	 * @return void
	 */
	function register ( $wp_customize ) {

		// remove static front page
		$wp_customize->remove_section( 'static_front_page' );

		// move menus
		$wp_customize->get_section( 'nav' )->priority = 25;

		// adjust all transports in use to refresh due to requirement to recompile LESS -> CSS
		$wp_customize->get_setting( 'background_image' )->transport = 'refresh';
		$wp_customize->get_setting( 'background_color' )->transport = 'refresh';

		// colours
		// background colour
		$wp_customize->add_setting( 'bodybg',
			array(
				'default' => '#fff'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'bodybg',
			array(
				'label' => __( 'Background Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'bodybg',
				'priority' => 8
			)
		) );

		// header
		$wp_customize->add_setting( 'header',
			array(
				'default' => '#000'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'header',
			array(
				'label' => __( 'Header Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'header',
				'priority' => 9
			)
		) );

		// sidebar
		$wp_customize->add_setting( 'sidebar',
			array(
				'default' => '#f0f0f0'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'sidebar',
			array(
				'label' => __( 'Sidebar Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'sidebar',
				'priority' => 10
			)
		) );

		// content
		$wp_customize->add_setting( 'content',
			array(
				'default' => '#fff'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'content',
			array(
				'label' => __( 'Content Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'content',
				'priority' => 11
			)
		) );

		// article
		$wp_customize->add_setting( 'article',
			array(
				'default' => '#fff'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'article',
			array(
				'label' => __( 'Article Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'article',
				'priority' => 12
			)
		) );
		// primary colour
		$wp_customize->add_setting( 'brandprimary',
			array(
				'default' => '#fff'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'brandprimary',
			array(
				'label' => __( 'Brand Primary Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'brandprimary',
				'priority' => 13
			)
		) );


		// secondary colour
		$wp_customize->add_setting( 'brandsecondary',
			array(
				'default' => '#fff'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'brandsecondary',
			array(
				'label' => __( 'Brand Secondary Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'brandsecondary',
				'priority' => 14
			)
		) );

	  	// body font colour
		$wp_customize->add_setting( 'textcol',
			array(
				'default' => '#000000'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'textcol',
			array(
				'label' => __( 'Text Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'textcol',
				'priority' => 15
			)
		) );

	  	// link colour
		$wp_customize->add_setting( 'linkcol',
			array(
				'default' => '#0000EE',
				'transport' => 'refresh'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'linkcol',
			array(
				'label' => __( 'Link Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'linkcol',
				'priority' => 16
			)
		) );

		// link hover colour
		$wp_customize->add_setting( 'linkhovercol',
			array(
				'default' => '#000000'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'linkhovercol',
			array(
				'label' => __( 'Link Hover Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'linkhovercol',
				'priority' => 17
			)
		) );

		// success colour
		$wp_customize->add_setting( 'brandsuccess',
			array(
				'default' => '#5cb85c'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'brandsuccess',
			array(
				'label' => __( 'Success Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'brandsuccess',
				'priority' => 18
			)
		) );

		// warning colour
		$wp_customize->add_setting( 'brandwarning',
			array(
				'default' => '#f0ad4e'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'brandwarning',
			array(
				'label' => __( 'Warning Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'brandwarning',
				'priority' => 19
			)
		) );

		// danger colour
		$wp_customize->add_setting( 'branddanger',
			array(
				'default' => '#d9534f'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'branddanger',
			array(
				'label' => __( 'Danger Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'branddanger',
				'priority' => 20
			)
		) );

		// info colour
		$wp_customize->add_setting( 'brandinfo',
			array(
				'default' => '#5bc0de'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'brandinfo',
			array(
				'label' => __( 'Info Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'brandinfo',
				'priority' => 21
			)
		) );

		// typography
		$wp_customize->add_section( 'typography',
			array(
				'title' => __( 'Typography', 'bootiful' ),
				'priority' => 35,
				'capability' => 'edit_theme_options',
			)
		);

		// Logos & Images
		$wp_customize->add_section( 'images',
			array(
				'title' => __( 'Logos & Images', 'bootiful' ),
				'priority' => 45,
				'capability' => 'edit_theme_options',
			)
		);
		// Logo
		$wp_customize->add_setting('logo',
			array(

			)
		);

		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			'logo',
			array(
				'label' => __( 'Logo', 'bootiful' ),
				'section' => 'images',
				'settings' => 'logo',
				'priority' => 10
			)
		) );

		// retina logo
		$wp_customize->add_setting('logoretina',
			array(

			)
		);

		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			'logoretina',
			array(
				'label' => __( 'Logo @2x', 'bootiful' ),
				'section' => 'images',
				'settings' => 'logoretina',
				'priority' => 11
			)
		) );

		// favicon
		$wp_customize->add_setting('favicon',
			array(

			)
		);

		$wp_customize->add_control(new WP_Customize_Upload_Control(
			$wp_customize,
			'favicon',
			array(
				'label' => __( 'Favicon (.ico 32px by 32px)', 'bootiful' ),
				'section' => 'images',
				'settings' => 'favicon',
				'priority' => 14
			)
		) );

		// touch icon
		$wp_customize->add_setting('touchicon',
			array(

			)
		);

		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			'touchicon',
			array(
				'label' => __( 'Touch Icon (152px by 152px)', 'bootiful' ),
				'section' => 'images',
				'settings' => 'touchicon',
				'priority' => 15
			)
		) );

		// layout
		$wp_customize->add_section( 'layout',
			array(
				'title' => __( 'Layout', 'bootiful' ),
				'priority' => 35,
				'capability' => 'edit_theme_options',
				'description' => __('Layout theme options.', 'bootiful'),
			)
		);

		// Google Analytics
		$wp_customize->add_section( 'analytics',
			array(
				'title'       => __( 'Analytics', 'bootiful' ),
				'priority' => 100,
				'capability'  => 'edit_theme_options',
				'description' => __( 'Google Analytics settings.', 'bootiful' ),
			)
		);

		$wp_customize->add_setting( 'ga_tracking_id', array(
			'default'   => '',
			'section'   => 'analytics',
			'transport' => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ga_tracking_id', array(
			'label'        => __( 'Tracking ID', 'mytheme' ),
			'section'    => 'analytics',
			'settings'   => 'ga_tracking_id',
		) ) );
	}

	/**
	 * save
	 *
	 * Fires when theme customiser is saved, calculates image size
	 *
	 * @return void
	 */
	function save() {

		$size = $this->image_size( get_theme_mod('logo', '') );
		$sizesmall = $this->image_size( get_theme_mod('logosmall', '') );

		if ( ! empty( $size ) )
			set_theme_mod( 'logosize', $size );

		if ( ! empty( $sizesmall ) )
			set_theme_mod( 'logosmallsize', $sizesmall );
	}

	/**
	 * less_vars
	 *
	 * Register variables with the PHP LESS compiler, pass in theme customiser settings, widths etc.
	 *
	 * @author Scott Evans
	 * @param  array $vars
	 * @param  string $handle is a reference to the handle used with wp_enqueue_style()
	 * @return array $vars
	 * @todo add background image
	 */
	function less_vars($vars, $handle) {

		global $content_width;

		$vars['bodybg'] = get_theme_mod( 'bodybg', '#ffffff');
		$vars['header'] = get_theme_mod( 'header', '#000000');
		$vars['sidebar'] = get_theme_mod( 'sidebar', '#f0f0f0');
		$vars['content'] = get_theme_mod( 'content', '#ffffff');
		$vars['article'] = get_theme_mod( 'article', '#ffffff');
		$vars['brandprimary'] = get_theme_mod( 'brandprimary', '#ff0000');
		$vars['brandsecondary'] = get_theme_mod( 'brandsecondary', '#bcbcbc');
		$vars['textcol'] = get_theme_mod( 'textcol', '#bcbcbc');
		$vars['linkcol'] = get_theme_mod( 'linkcol', '#0000EE');
		$vars['linkhovercol'] = get_theme_mod( 'linkhovercol', '#000000');
		$vars['brandsuccess'] = get_theme_mod( 'brandsuccess', '#5cb85c');
		$vars['brandwarning'] = get_theme_mod( 'brandwarning', '#f0ad4e');
		$vars['branddanger'] = get_theme_mod( 'branddanger', '#d9534f');
		$vars['brandinfo'] = get_theme_mod( 'brandinfo', '#5bc0de');
		$vars['logo'] = '~"'.get_theme_mod( 'logo', '' ).'"';
		$vars['logoretina'] = '~"'.get_theme_mod( 'logoretina', '' ).'"';
		$vars['cachebust'] = CFTP_CACHE_BUST;
		$vars['contentwidth'] = $content_width;
		$vars['templateuri'] = '~"'.get_template_directory_uri().'"';
		$vars['stylesheeturi'] = '~"'.get_stylesheet_directory_uri().'"';

		// logo size
		$logosize = get_theme_mod( 'logosize', array() );

		if ( ! empty( $logosize )) {
			$vars['logowidth'] = $logosize['width'];
			$vars['logoheight'] = $logosize['height'];
		} else {
			$vars['logowidth'] = 0;
			$vars['logoheight'] = 30; // default height for logo text (no logo set)
		}

		return $vars;

	}

	/**
	 * is_customising?
	 *
	 * Are we currently customising the theme?
	 * @author Scott Evans
	 * @return boolean
	 */
	function is_customising() {

		// check data has been posted
		if ( ! isset( $_POST[ 'customized' ] ) ) return false;

		// check the nonce
		$theme = wp_get_theme( isset( $_REQUEST['theme'] ) ? $_REQUEST['theme'] : null );
		if ( ! wp_verify_nonce($_POST['nonce'], 'preview-customize_' . $theme->get_stylesheet() ) ) return false;

		// check permissions
		if ( ! current_user_can( 'edit_theme_options' ) ) return false;

		// made it this far, all must be well
		return true;

	}

	/**
	 * cache_bust
	 *
	 * Force the browser to cache bust the compiled CSS
	 *
	 * @author Scott Evans
	 * @param  int $time
	 * @return int $time
	 */
	function cache_bust( $time ) {

		$time = time();
		return $time;

	}

	/**
	 * merge_theme_mods
	 *
	 * Filter the option from the option table when edits have been performed in the customiser.
	 *
	 * @author Scott Evans
	 * @param  array $option
	 * @return array $option
	 */
	function merge_theme_mods($option) {

		if ( ! isset( $_POST['customized'] ) ) return $option;

		if (! is_array( $option ) ) return $option;

		$new = json_decode( wp_unslash( $_POST['customized'] ), true );

		// check data from customiser refresh
		// print_r($new);

		// merge all other keys
		foreach ( $option as $key => $o ) {

			if ( ! isset( $new[$key] ) ) continue;

			if ( $new[$key] !== $o ) {
				$option[$key] = esc_attr( $new[$key] );
			}
		}

		// make sure the correct logo sizes are returned
		$option['logosize'] = $this->image_size( $new['logo'] );
		$option['logosmallsize'] = $this->image_size( $new['logosmall'] );

		return $option;
	}

	/**
	 * string_search
	 *
	 * Search a $string for $needle.
	 *
	 * @author Scott Evans
	 * @param  string $needle
	 * @param  string $string
	 * @return bool
	 */
	function string_search( $needle, $string ) {
		return (strpos($string, $needle) !== false);
	}

	/**
	 * image_size
	 *
	 * Calculate an image width and height from URL
	 *
	 * @param  string $image url to image
	 * @return array $size_return image size as array
	 */
	function image_size( $image ) {

		$size_return = array();

		if ($image == '') return $size_return;

		// convert the URL to a path
		$upload = wp_upload_dir();
		$imageurl = str_replace(array('http://', 'https://'), '', $image);
		$uploadurl = str_replace(array('http://', 'https://'), '', $upload['baseurl']);
		$image = str_replace($uploadurl, $upload['basedir'], $imageurl);

		// bail if the file no longer exists
		if ( ! file_exists( $image ) ) return $size_return;

		// determine image size
		$size = getimagesize( $image );

		if ( ! empty( $size ) ) {
			$size_return['width'] = $size[0];
			$size_return['height'] = $size[1];
		}

		return $size_return;
	}
}

global $cftp_customiser;
$cftp_customiser = new cftp_customiser();
