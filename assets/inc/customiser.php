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
		add_action( 'wp_enqueue_scripts', array( $this, 'css' ) );
		add_action( 'customize_save_after', array( $this, 'save' ) );
		add_action( 'wp_head', array( $this, 'background_size_output' ), 10  );

		// filters
		add_filter( 'less_vars', array( $this, 'less_vars' ), 10, 2 );

	}

	/**
	 * customiser_init
	 * 
	 * Apply certain filters to WordPress when customisations are being made.
	 * Force a cache recompile and filter the cache bust variable and merge new settings into existing options.
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

		// rename colours  
		$wp_customize->get_section( 'colors' )->title = __( 'Colours', 'bootiful' );

		// rename background image section
		$wp_customize->get_section( 'background_image' )->title = __( 'Logos &amp; Images', 'bootiful' );

		// adjust all transports in use to refresh due to requirement to recompile LESS -> CSS
		$wp_customize->get_setting( 'background_image' )->transport = 'refresh';
		$wp_customize->get_setting( 'background_color' )->transport = 'refresh';

		// colours
		// primary colour
		$wp_customize->add_setting( 'primarycol',
			array(
				'default' => '#fff'
			) 
		);      
	        
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 
			'primarycol', 
			array(
				'label' => __( 'Primary Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'primarycol',
				'priority' => 13
			) 
		) );


		// secondary colour
		$wp_customize->add_setting( 'secondarycol',
			array(
				'default' => '#fff'
			) 
		);      
	        
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 
			'secondarycol', 
			array(
				'label' => __( 'Secondary Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'secondarycol',
				'priority' => 14
			) 
		) );

	  	// body font colour
		$wp_customize->add_setting( 'bodycol',
			array(
				'default' => '#000000'
			) 
		);      
	        
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 
			'bodycol', 
			array(
				'label' => __( 'Body Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'bodycol',
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
		$wp_customize->add_setting( 'successcol',
			array(
				'default' => '#5cb85c'
			) 
		);      

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 
			'successcol', 
			array(
				'label' => __( 'Success Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'successcol',
				'priority' => 18
			) 
		) );

		// warning colour
		$wp_customize->add_setting( 'warningcol',
			array(
				'default' => '#f0ad4e'
			) 
		);      

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 
			'warningcol', 
			array(
				'label' => __( 'Warning Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'warningcol',
				'priority' => 19
			) 
		) );

		// danger colour
		$wp_customize->add_setting( 'dangercol',
			array(
				'default' => '#d9534f'
			) 
		);      

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 
			'dangercol', 
			array(
				'label' => __( 'Danger Colour', 'bootiful' ),
				'section' => 'colors',
				'settings' => 'dangercol',
				'priority' => 20
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

		// heading font
		$wp_customize->add_setting('headingfont', 
			array(
				'default' => 'a1',
			)
		);

		$wp_customize->add_control(new Google_Font_Custom_Control(
			$wp_customize, 
			'headingfont', 
			array(
				'label' => __( 'Heading Font', 'bootiful' ), 
				'section' => 'typography', 
				'settings' => 'headingfont', 
				'priority' => 10
			) 
		) );

		// heading font weight
		$wp_customize->add_setting('headingfontweight', 
			array(
				'default' => 'normal',
			)
		);
		
		$wp_customize->add_control(new Google_Font_Weight_Custom_Control(
			$wp_customize, 
			'headingfontweight', 
			array(
				'label' => __( 'Weight', 'bootiful' ), 
				'section' => 'typography', 
				'visibility' => 'headingfont',
				'settings' => 'headingfontweight', 
				'priority' => 10
			) 
		) );

		// body font
		$fonts = $this->get_fonts();
		$font_list = array();
		foreach ($fonts as $key => $font) { 
			$font_list[$key] = $font['name'];			
		}

		$wp_customize->add_setting('bodyfont', 
			array(
				'default' => 'a1',
			)
		);

		$wp_customize->add_control('bodyfont', 
			array( 
				'label' => __( 'Body Font', 'bootiful' ), 
				'section' => 'typography', 
				'settings' => 'bodyfont', 
				'type' => 'select',
				'choices' => $font_list,
				'priority' => 11
			)
		);

		// Logos & Images
		// Background Size
		$wp_customize->add_setting( 'background_size', array(
			'default'           => 'auto',
			'control'           => 'select',
			//'transport'         => 'postMessage',
			'sanitize_callback' => array($this, 'sanitise_background_size'),
		) );

		$wp_customize->add_control( 'background_size', array(
			'label'             => __( 'Background Size', 'bootiful' ),
			'section'           => 'background_image',
			'visibility'        => 'background_image',
			'theme_supports'    => 'custom-background',
			'type'              => 'radio',
			'choices'           => array(
				'auto'      => __( 'Auto', 'bootiful' ),
				'contain'   => __( 'Contain', 'bootiful' ),
				'cover'     => __( 'Cover', 'bootiful' ),
			)
		) );

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
				'section' => 'background_image', 
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
				'section' => 'background_image', 
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
				'section' => 'background_image', 
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
				'section' => 'background_image', 
				'settings' => 'touchicon',
				'priority' => 15
			)
		) );

		// placeholder
		$wp_customize->add_setting('placeholder', 
			array(

			)
		);

		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize, 
			'placeholder', 
			array( 
				'label' => __( 'Placeholder (for posts without media)', 'bootiful' ), 
				'section' => 'background_image', 
				'settings' => 'placeholder',
				'priority' => 16
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
	}

	/**
	 * sanitise_background_size
	 *
	 * Sanitise the input for the background size
	 *
	 * @author Scott Evans
	 * @param  string $value
	 * @return string
	 */
	function sanitise_background_size( $value ) {
		$safe = array( 'auto', 'contain', 'cover' );
		return in_array( $value, $safe ) ? $value : $safe[0];
	}

	/**
	 * css
	 * 
	 * Enqueue the correct Google font for typography settings
	 * 
	 * @author Scott Evans
	 * @return void  
	 */
	function css() {

		$heading_font = get_theme_mod( 'headingfont', 'Cabin' );
		$heading_font_weight = get_theme_mod( 'headingfontweight', '700' );
		$body_font = get_theme_mod( 'bodyfont', 'a1' );
		
		$allfonts = $this->get_fonts();

		// a bug fix when customising a font change - reset the weight as the controls are independent
		if ($this->is_customising()) {
			$variants = array();
			foreach ($allfonts as $key => $font) { 
				if ($font['name'] == $heading_font) {
					foreach ($font['variants'] as $variant) {
						$variants[] = $variant;
					}
				}
			}
			if (!in_array($heading_font_weight, $variants)) {
				$heading_font_weight = 'regular';
			}
		}

		$gfonts = array();
		
		if ( ! $this->string_search('(system)', $allfonts[$heading_font]['name'] ) ) {
			$gfonts[] = $heading_font . ':' . $heading_font_weight;
		}
		
		if ( ! $this->string_search('(system)', $allfonts[$body_font]['name'] ) ) {
			$gfonts[] = $body_font;
		}
		
		if ( ! empty( $gfonts ) ) { 
			$gfonts = array_unique($gfonts);
			$getfonts = implode('|', $gfonts);
			wp_register_style('google-fonts', '//fonts.googleapis.com/css?family='.$getfonts, '', CFTP_CACHE_BUST, 'all'); 
			wp_enqueue_style('google-fonts');
		}		
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

		// fix a bug where we may have saved incorrect font weight
		$current_weight = get_theme_mod( 'headingfontweight', '700' );
		$heading_font = get_theme_mod( 'headingfont', 'Cabin' );
		$allfonts = $this->get_fonts();
		$variants = array();
		foreach ($allfonts as $key => $font) { 
			if ($font['name'] == $heading_font) {
				foreach ($font['variants'] as $variant) {
					$variants[] = $variant;
				}
			}
		}
		if (!in_array($current_weight, $variants)) {
			set_theme_mod( 'headingfontweight', 'regular' );
		}
	}

	/**
	 * background_size_output
	 * 
	 * not passed to less as it uses core background image functionality
	 * 
	 * @author Scott Evans
	 * @return void
	 */
	function background_size_output() {
		$style = get_theme_mod( 'background_size', 'auto' );
		printf( '<style type="text/css"> body.custom-background { -webkit-background-size: %1$s; -moz-background-size: %1$s; background-size: %1$s; } </style>'."\n", trim( $style ) );
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

		$vars['primarycol'] = get_theme_mod( 'primarycol', '#ff0000');
		$vars['secondarycol'] = get_theme_mod( 'secondarycol', '#bcbcbc');
		$vars['bodycol'] = get_theme_mod( 'bodycol', '#bcbcbc');
		$vars['linkcol'] = get_theme_mod( 'linkcol', '#0000EE');
		$vars['linkhovercol'] = get_theme_mod( 'linkhovercol', '#000000');
		$vars['successcol'] = get_theme_mod( 'successcol', '#5cb85c');
		$vars['warningcol'] = get_theme_mod( 'warningcol', '#f0ad4e');
		$vars['dangercol'] = get_theme_mod( 'dangercol', '#d9534f');
		$vars['headingfont']  = '~"'.$this->font_stack( get_theme_mod( 'headingfont', 'Cabin') ).'"';
		$vars['headingfontweight'] = '~"'.get_theme_mod( 'headingfontweight', '700').'"';
		$vars['bodyfont'] = '~"'.$this->font_stack( get_theme_mod( 'bodyfont', 'a1') ).'"';
		//$vars['bodyfontweight'] = '~"'.get_theme_mod( 'bodyfontweight', 'normal').'"';
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
			$vars['logoheight'] = 0;	
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
	 * get_fonts
	 * 
	 * System & Google Web Fonts saved as transient.
	 * 
	 * @author Scott Evans
	 * @param  string $sort 
	 * @return array $font_list    
	 */
	function get_fonts($sort = 'alpha') {
		
		// sort options
		// alpha: Sort the list alphabetically
		// date: Sort the list by date added (most recent font added or updated first)
		// popularity: Sort the list by popularity (most popular family first)
		// style: Sort the list by number of styles available (family with most styles first)
		// trending: Sort the list by families seeing growth in usage (family seeing the most growth first)
		
		if (false === ($font_list = get_transient('cftp_google_fonts_'.$sort))) { 
			
			// system fonts - the stacks are available in mixins.less and simple array references are used for compatibility with LESS guards
			$font_list['a1'] = array( 'name' => 'Arial (system)', 'variants' => array('normal') );
			$font_list['a2'] = array( 'name' => 'Arial Rounded (system)', 'variants' => array('normal') ); 
			$font_list['b1'] = array( 'name' => 'Baskerville (system)', 'variants' => array('normal') );
			$font_list['c1'] = array( 'name' => 'Cambria (system)', 'variants' => array('normal') );
			$font_list['c2'] = array( 'name' => 'Centry Gothic (system)', 'variants' => array('normal') );
			$font_list['c3'] = array( 'name' => 'Courier New (system)', 'variants' => array('normal') );
			$font_list['g1'] = array( 'name' => 'Georgia (system)', 'variants' => array('normal') );
			$font_list['h1'] = array( 'name' => 'Helvetica (system)', 'variants' => array('normal') );
			$font_list['l1'] = array( 'name' => 'Lucida Bright (system)', 'variants' => array('normal') );
			$font_list['l2'] = array( 'name' => 'Lucida Sans (system)', 'variants' => array('normal') );
			$font_list['t1'] = array( 'name' => 'Tahoma (system)', 'variants' => array('normal') );
			$font_list['t2'] = array( 'name' => 'Trebuchet MS (system)', 'variants' => array('normal') );
			$font_list['v1'] = array( 'name' => 'Verdana (system)', 'variants' => array('normal') );
						
			// google fonts
			$api_key = 'AIzaSyCTTbK5s0or8LmQfUCNhndMfSvyz-f6jqk';
			$gwf_uri = "https://www.googleapis.com/webfonts/v1/webfonts?key=" . $api_key . "&sort=" . $sort;
			
			// should use wp_remote_post
			$raw = wp_remote_get( $gwf_uri, array( 'timeout' => 120 ) );

			if (! is_wp_error( $raw ) ) {

				$fonts = json_decode( $raw['body'] );

				foreach ($fonts->items as $font) {
					$font_list[$font->family] = array(
						'name' => $font->family,
						'variants' => $font->variants
					);
				}
				
				// cache for 3 days
				set_transient('cftp_google_fonts_' . $sort, $font_list, 60 * 60 * 24 * 3);
			}
		}
		
		// return the saved list of Google Web Fonts
		return $font_list;

	}	

	/**
	 * font_stack
	 * 
	 * Covert a font from the function above into a font stack
	 * 
	 * @author Scott Evans
	 * @param  string $font
	 * @return string $font_stack    
	 */
	function font_stack($font) {
		
		switch( $font ) {

			case 'a1':
				$font_stack = "Arial, 'Helvetica Neue', Helvetica, sans-serif";
			break;

			case 'a2':
				$font_stack = "'Arial Rounded MT Bold', 'Helvetica Rounded', Arial, sans-serif";
			break;

			case 'b1':
				$font_stack = "Baskerville, 'Baskerville Old Face', 'Hoefler Text', Garamond, 'Times New Roman', serif";
			break;

			case 'c1':
				$font_stack = "Cambria, Georgia, serif";
			break;

			case 'c2':
				$font_stack = "'Century Gothic', CenturyGothic, AppleGothic, sans-serif";
			break;

			case 'c3':
				$font_stack = "'Courier New', Courier, 'Lucida Sans Typewriter', 'Lucida Typewriter', monospace";
			break;

			case 'g1':
				$font_stack = "Georgia, Times, 'Times New Roman', serif";
			break;

			case 'h1':
				$font_stack = "'Helvetica Neue', Helvetica, Arial, sans-serif";
			break;

			case 'l1':
				$font_stack = "'Lucida Bright', Georgia, serif";
			break;

			case 'l2':
				$font_stack = "'Lucida Sans', 'DejaVu Sans', 'Bitstream Vera Sans', 'Liberation Sans', Verdana, 'Verdana Ref', sans-serif";
			break;

			case 't1':
				$font_stack = "Tahoma, Verdana, Segoe, sans-serif";
			break;

			case 't2':
				$font_stack = "'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif";
			break;

			case 'v1':
				$font_stack = "Verdana, Geneva, sans-serif";
			break;

			default:
				$font_stack = $font;

		}
		
		return $font_stack;
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

if (class_exists('WP_Customize_Control')) {

	/**
	* Create a new theme customiser control to manage Google Fonts
	*
	* @author Scott Evans
	*/
	class Google_Font_Custom_Control extends WP_Customize_Control {

        public $type = 'google-font-custom-control';

		public function enqueue() {
			wp_register_script( 'cftp-control', get_template_directory_uri() . '/assets/js/admin/customiser.js', array('jquery'), '1', true);
			wp_enqueue_script( 'cftp-control' );
		}

		public function render_content() {

			global $cftp_customiser;
			?>
			<div class="google-font-custom-control">
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>" class="widefat font-select" <?php $this->link(); ?>>
						<?php 
						$fonts = $cftp_customiser->get_fonts();
						foreach ($fonts as $key => $font) { 
							
							printf('<option value="%s" data-weights="%s" %s>%s</option>', $font['name'], implode(',', $font['variants']), selected($this->value(), $font['name'], false), $font['name']);

						}
						?>
					</select>
				</label>
			</div>
			<?php
		}
	}
}

if (class_exists('WP_Customize_Control')) {

	/**
	* Create a new theme customiser control to manage Google Font Weight
	*
	* @author Scott Evans
	*/
	class Google_Font_Weight_Custom_Control extends WP_Customize_Control {

        public $type = 'google-font-weight-custom-control';

		public function render_content() {

			global $cftp_customiser;
			?>
			<div class="google-font-weight-custom-control">
				<label>
					<span class="customzie-control-title"><?php echo esc_html( $this->label ); ?></span>
					<select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>" class="widefat variant-select" <?php $this->link(); ?>>
						<?php 
						$fonts = $cftp_customiser->get_fonts();
						$variants = array();
						foreach ($fonts as $key => $font) { 
							foreach ($font['variants'] as $variant) {
								if (! in_array($variant, $variants)) {
									$variants[] = $variant;
								}
							}
						}
						?>
						<?php foreach ($variants as $variant) { 
							printf('<option value="%s" %s>%s</option>', $variant, selected($this->value(), $variant, false), $variant);
						} 
						?>
					</select>
				</label>
			</div>
			<?php
		}
	}
}