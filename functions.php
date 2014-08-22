<?php

/*

                _____________
               /      ____   \
         _____/       \   \   \
        /\    \        \___\   \
       /  \    \                \
      /   /    /          _______\
     /   /    /          \       /
    /   /    /            \     /
    \   \    \ _____    ___\   /
     \   \    /\    \  /       \
      \   \  /  \____\/    _____\
       \   \/        /    /    / \
        \           /____/    /___\
         \                        /
          \______________________/

Notes:
----------------------------------------
template parts for all widgets - sensible name/location - add filters to plugins if needed
sticky ness of certain elements
co-authors

TB
Typography
Widget for latest posts
Menu and collapse to mobile
icon font
custom share tools
advert slot - might need to adjust responsiveness of main content

GP
Typography
Widget for latest posts with infinite scroll
Hidden menu on mobile
additional logo for mobile - would involve changing ALL heights!
icon font
add this share tools

*/

// set content width
if ( ! isset( $content_width ) ) $content_width = apply_filters( 'cftp_content_width', 640 );

/**
 * cftp_theme_setup
 *
 * Setup certain aspects of the theme, add theme support for WordPress features
 *
 * @author Scott Evans
 * @return void
 */
function cftp_theme_setup() {

	// load language files
	load_theme_textdomain( 'bootiful', get_template_directory() . '/assets/languages' );

	// add support for custom backgrounds
	// add_theme_support( 'custom-background' );

	// add support for custom header http://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Header
	// add_theme_support( 'custom-header' );

	// add feed links for comments and posts to <head>
	add_theme_support( 'automatic-feed-links' );

	// setup thumbnail support
	add_theme_support( 'post-thumbnails' );

	// custom menu support
	add_theme_support( 'menus' );

	// html5 features
	add_theme_support( 'html5', array(
		'comment-list',
		'comment-form',
		'search-form',
		'gallery',
		'captions'
	) );

	// add theme hook alliance support (https://github.com/zamoose/themehookalliance) - filterable by child theme
	add_theme_support('tha_hooks', apply_filters('bootiful_tha_hooks', array('head', 'body', 'header','content','entry','comments','sidebar','footer')));

	// register navigation menus for this theme
	register_nav_menus( apply_filters( 'cftp_register_menu', array(
			'navigation' => __( 'Navigation', 'bootiful' ),
			'footer' => __('Footer', 'bootiful')
		)
	));

	// image sizes
	// add_image_size( 'custom-image-size', 630, 500, false );

	// remove iconic header CSS
	remove_action( 'wp_head', 'iconic_css' );


}
add_action( 'after_setup_theme','cftp_theme_setup' );

/**
 * cftp_theme_constants
 *
 * Setup theme related constants, added to init hook with low priority
 * so easily filtered by other code (e.g customiser)
 *
 * @return void
 */
function cftp_theme_constants() {

	// parse template info from style.css - version number
	$theme_data = wp_get_theme();
	define( 'CFTP_THEME_VERSION', $theme_data['Version'] );

	// cache bust based on options settings and file gen time of main css - filterable for child themes to add different css filemtime
	$cachefiles = intval( filemtime( get_template_directory() . '/assets/less/styles.less' ) );
	$cacheoptions = md5( serialize( get_theme_mods() ) );
	$cacheoptions = preg_replace( "/[^0-9]/", "", $cacheoptions );
	$cacheoptions = intval( $cacheoptions );
	$cachebust = apply_filters( 'cftp_cache_bust', abs( intval( $cacheoptions+$cachefiles ) ) );
	define( 'CFTP_CACHE_BUST', $cachebust );

}
add_action( 'init', 'cftp_theme_constants', 100 );

/**
 * sidebars
 */
load_template( get_template_directory() . '/assets/inc/sidebars.php' );

/**
 * theme customiser
 */
locate_template( '/assets/inc/customiser.php', true, true );

/**
 * editor
 */
if (is_admin()) { load_template( get_template_directory() . '/assets/inc/editor.php' ); }

/**
 * only load front end functions for theme
 */
if (!is_admin()) { load_template( get_template_directory() . '/assets/inc/theme.php' ); }

/**
 * bootstrap menu walker
 */
if (!is_admin()) { load_template( get_template_directory() . '/assets/inc/nav.php' ); }

/**
 * theme hook alliance
 */
if (!is_admin()) { load_template(get_template_directory() . '/assets/inc/tha.php'); }


/**
 * cftp_admin_css_setup
 *
 * Register and enqueue all css/less files backend (and login screen)
 *
 * @author Scott Evans
 * @return void
 */
function cftp_admin_css_setup() {
	wp_register_style( 'cftp-theme-admin', get_template_directory_uri() . '/assets/less/wp-admin.less', array(), filemtime(get_template_directory() . '/assets/less/wp-admin.less' ) );
	wp_enqueue_style( 'cftp-theme-admin' );
}
add_action( 'admin_init', 'cftp_admin_css_setup' );
add_action( 'login_enqueue_scripts', 'cftp_admin_css_setup' );

/**
 * cftp_theme_css_setup
 *
 * Register and enqueue all css/less files.
 *
 * @author Scott Evans
 * @return void
 */
function cftp_theme_css_setup() {

	// the rest of the styles
	wp_register_style( 'cftp-theme', get_template_directory_uri() . '/assets/less/styles.less', array(), CFTP_CACHE_BUST, 'all' );
	//wp_register_style('cftp-print', get_template_directory_uri() . '/assets/less/print.less' array(), CFTP_CACHE_BUST, 'print');

	// register ie styles
	wp_register_style( 'cftp-ie', get_template_directory_uri() . '/assets/less/styles-ie.less', array(), CFTP_CACHE_BUST, 'screen' );

	// all styles for this theme
	wp_enqueue_style( 'cftp-theme' );

	// remove admin bar css for print media - added already
	remove_action( 'wp_head', 'wp_admin_bar_header' );

	// print style sheet (including admin bar hide removed above)
	// wp_enqueue_style('cftp-print');

	// tidy up widgets in tabs (use our own css)
	wp_dequeue_style( 'wit' );

	// ie styles
	wp_enqueue_style( 'cftp-ie' );

}
add_action( 'wp_enqueue_scripts', 'cftp_theme_css_setup', 50 );

/**
 * cftp_admin_js_setup
 *
 * Register and enqueue all admin javascript files.
 *
 * @author Scott Evans
 * @return void
 */
function cftp_admin_js_setup() {

}
add_action( 'admin_enqueue_scripts', 'cftp_admin_js_setup' );

/**
 * cftp_theme_js_setup
 *
 * Register and enqueue all theme javascript files.
 *
 * @author Scott Evans
 * @return void
 */
function cftp_theme_js_setup() {

	// register all scripts
	wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/modernizr.js', null, filemtime(get_template_directory() . '/assets/js/modernizr.js'));
	wp_register_script('cftp-js', get_template_directory_uri() . '/assets/js/scripts.min.js', array('jquery', 'modernizr', 'jquery-ui-tabs'), filemtime(get_template_directory() . '/assets/js/scripts.min.js'));

	// comment threading
	if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// tidy up widgets in tabs (use our own JS)
	wp_dequeue_script( 'wit' );

	// modernizr
	wp_enqueue_script( 'modernizr' );

	// standard shipped jquery
	wp_enqueue_script( 'jquery' );

	// theme js file
	wp_enqueue_script( 'cftp-js' );
}
add_action( 'wp_enqueue_scripts', 'cftp_theme_js_setup', 50 );

/**
 * cftp_conditional_ie_styles
 *
 * Add conditional comments around IE specific stylesheets
 *
 * @author Scott Evans
 * @param  string $tag
 * @param  strong $handle
 * @return string
 */
function cftp_conditional_ie_styles( $tag, $handle ) {

	if ('cftp-ie' == $handle || 'screen-ie' == $handle)
		$tag = '<!-- IE css -->' . "\n" .'<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";

	return $tag;

}
add_filter( 'style_loader_tag', 'cftp_conditional_ie_styles', 10, 2 );

/**
 * current_url
 *
 * Determine the current url.
 *
 * @author Scott Evans
 * @param  boolean $parse
 * @return string or array
 */
if (!function_exists('current_url')) {
	function current_url($parse = false) {
		$s = empty($_SERVER['HTTPS']) ? '' : ($_SERVER['HTTPS'] == 'on') ? 's' : '';
		$protocol = substr(strtolower($_SERVER['SERVER_PROTOCOL']), 0, strpos(strtolower($_SERVER['SERVER_PROTOCOL']), '/')) . $s;
		$port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (":".$_SERVER['SERVER_PORT']);
		if ($parse) {
			return parse_url($protocol . "://" . $_SERVER['HTTP_HOST'] . $port . $_SERVER['REQUEST_URI']);
		} else {
			return $protocol . "://" . $_SERVER['HTTP_HOST'] . $port . $_SERVER['REQUEST_URI'];
		}
	}
}

/**
 * cftp_string_search
 *
 * Search a $string for $needle.
 *
 * @author Scott Evans
 * @param  string $needle
 * @param  string $string
 * @return bool
 */
if ( !function_exists( 'cftp_string_search' ) ) {
	function cftp_string_search($needle,$string) {
		return (strpos($string, $needle) !== false);
	}
}

/**
 * cftp_wp_head
 *
 * Custom header meta for theme - move to exposure?
 *
 * @author Scott Evans
 * @return void
 */
function cftp_wp_head() {

?>

<!-- icons -->
<link rel="shortcut icon" type="image/x-icon" href="<?php if ($favicon = get_theme_mod('favicon')) { echo $favicon; } else { echo get_template_directory_uri() . '/assets/images/favicon.ico'; } ?>" />
<link rel="apple-touch-icon-precomposed" href="<?php if ($touchicon = get_theme_mod('touchicon')) { echo $touchicon; } else { echo get_template_directory_uri() . '/assets/images/apple-touch-icon-precomposed.png'; } ?>" />
<?php

// ie9+ pinned app
?>

<!-- allow pinned app in ie9+ / windows 8 -->
<meta name="application-name" content="<?php bloginfo('name'); ?>" />
<meta name="msapplication-tooltip" content="<?php bloginfo('description'); ?>"/>
<meta name="msapplication-starturl" content="<?php echo home_url(); ?>"/>
<?php if ($touchicon = get_theme_mod('touchicon')) { ?><meta name="msapplication-TileImage" content="<?php echo $touchicon; ?>"><?php echo "\n"; } ?>
<?php if ($ie9colour = get_theme_mod('primarycol')) { ?><meta name="msapplication-TileColor" content="<?php echo $ie9colour; ?>"><?php echo "\n"; } ?>
<?php if ($ie9colour = get_theme_mod('ie9_colour')) { ?><meta name="msapplication-navbutton-color" content="<?php echo $ie9colour; ?>"><?php echo "\n"; }  ?>

<?php
}
add_action('wp_head', 'cftp_wp_head');
add_action('admin_head', 'cftp_wp_head');
