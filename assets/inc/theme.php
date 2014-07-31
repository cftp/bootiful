<?php

/**
 * cftp_language_attributes
 *
 * Set the correct HTML attributes
 *
 * @return string of html attributes
 */
function cftp_language_attributes() {
	$attributes = array();
	$output = '';

	if (function_exists('is_rtl')) {
		if (is_rtl() == 'rtl') {
			$attributes[] = 'dir="rtl"';
		}
	}

	$lang = get_bloginfo('language');

	if ($lang && $lang !== 'en-US') {
		$attributes[] = "lang=\"$lang\"";
	} else {
		$attributes[] = 'lang="en"';
	}

	$output = implode(' ', $attributes);
	$output = apply_filters('cftp_language_attributes', $output);
	return $output;
}
add_filter('language_attributes', 'cftp_language_attributes');

/**
 * cftp_schema
 *
 * Add schema data to the html tag (http://schema.org/)
 * Currently not used
 *
 * @return void
 */
function cftp_schema() {

	$schema = 'http://schema.org/';
	$type = '';

	if( is_singular( 'post' ) ) {
		$type = "BlogPosting";
	} else if( is_author() ) {
		$type = 'ProfilePage';
	} else if( is_search() ) {
		$type = 'SearchResultsPage';
	} else if( is_page() ) {
		$type = 'WebPage';
	}

	if ($type != '') {
		echo 'itemscope itemtype="' . $schema . $type . '"';
	}
}

/**
 * cftp_remove_recent_comments_style
 *
 * Remove inline styles caused by using the recent comments widget
 *
 * @author Scott Evans
 * @return void
 */
add_action('widgets_init', 'cftp_remove_recent_comments_style', 99);

function cftp_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}

/**
 * cftp_body_class
 *
 * Filter the body class to be more meaningful
 *
 * @param  array $classes
 * @return array $classes
 */
function cftp_body_class($classes) {

	global $wpdb, $post, $blog_id;

	// multisite site id and child-site
	if (isset($blog_id)) {
		$classes[] = 'site-'.$blog_id;

		if($blog_id != 1) {
			$classes[] = 'child-site';
		}
	}

	// date & time
	$t = time() + ( get_option('gmt_offset') * 3600 );
	$classes[] = 'y' . gmdate( 'Y', $t ); // Year
	$classes[] = 'm' . gmdate( 'm', $t ); // Month
	$classes[] = 'd' . gmdate( 'd', $t ); // Day
	$classes[] = 'h' . gmdate( 'H', $t ); // Hour

	// parent section
    if (is_page()) {
        if ($post->post_parent) {
        	$ancestors = get_post_ancestors($post->ID);
            $parent  = end($ancestors);
        } else {
            $parent = $post->ID;
        }
        $post_data = get_post($parent, ARRAY_A);
        $classes[] = 'section-' . $post_data['post_name'];
    }

	// post/page name/slug
	if (is_page() || is_single()) {
		$classes[] = $post->post_name;
	}

	return $classes;
}
add_filter('body_class','cftp_body_class');

/**
 * cftp_post_class
 *
 * Add some custom classes to each post loop
 *
 * @author Scott Evans
 * @param  array $classes
 * @return array
 */
function cftp_post_class($classes){

	global $wp_query, $post;

	// apply only to archives not single posts
	if ( !is_single() ) {

		// loop
		$classes[] = 'loop';

		// first and last
		if ($wp_query->current_post+1 == 1) $classes[] = 'loop-first';
		if (($wp_query->current_post+1) == $wp_query->post_count) $classes[] = 'loop-last';

		// odd and even
		if ($wp_query->current_post+1 & 1) { $classes[] = "loop-odd"; } else { $classes[] = "loop-even"; }

		// counter
		$count = $wp_query->current_post+1;
		$classes[] = 'loop-'.$count;

	}

	// featured image
	if (has_post_thumbnail($post->ID)) $classes[] = "featured-image";

	return $classes;
}
add_filter('post_class', 'cftp_post_class', 20);

/**
 * cftp_time
 *
 * Create a post time based on WordPress settings, can be declared in child theme
 *
 * @author Scott Evans
 * @param  string $format a custom stamp format e.g. F jS, Y &#8212; H:i
 * @param  string $separator
 * @return void
 */
if (!function_exists('cftp_time')) {
	function cftp_time($format = '', $separator = ' - ') {

		global $post;

		if ($format) {
			the_time($format);
			return;
		}

		if ( ( get_option('date_format') != '' ) && ( get_option('time_format') != '' ) ) {
			the_time( get_option( 'date_format' ) );
			echo $separator;
			the_time();
			return;
		}

		if ( ( get_option('date_format') != '' ) && ( get_option( 'time_format' ) == '' ) ) {
			the_time( get_option( 'date_format' ) );
			return;
		}
	}
}

/**
 * cftp_get_time
 *
 * Return a post time based on WordPress settings, can be declared in child theme
 *
 * @author Scott Evans
 * @param  string $format a custom stamp format e.g. F jS, Y &#8212; H:i
 * @param  string $separator
 * @return string
 */
if (!function_exists('cftp_get_time')) {
	function cftp_get_time($format = '', $separator = ' - ') {

		global $post;

		if ($format) {
			return get_the_time($format);
		}

		if ((get_option('date_format') != '') && (get_option('time_format') != '')) {
			return get_the_time(get_option('date_format')) . " - " . get_the_time();
		}

		if ((get_option('date_format') != '') && (get_option('time_format') == '')) {
			return get_the_time(get_option('date_format'));
		}
	}
}

/**
 * cftp_oembed_wmode
 *
 * Fix oembed window mode for flash objects
 *
 * @author Scott Evans
 * @param  string $embed
 * @return string $embed
 */
function cftp_oembed_wmode( $embed ) {
    if ( strpos( $embed, '<param' ) !== false ) {
        $embed = str_replace( '<embed', '<embed wmode="transparent" ', $embed );
        $embed = preg_replace( '/param>/', 'param><param name="wmode" value="transparent" />', $embed, 1);
    }
    return $embed;
}
add_filter('embed_oembed_html', 'cftp_oembed_wmode', 1);

/**
 * cftp_embed_html
 *
 * Wrap oembed objects with a responsive container
 *
 * @author Scott Evans
 * @param  string $html
 * @param  string $url
 * @param  array $attr
 * @param  int $post_ID
 * @return string $return
 */
function cftp_embed_html($html, $url, $attr, $post_ID) {
	$url = str_replace(array('www.', '.com'), '', parse_url($url, PHP_URL_HOST));
    $return = '<figure class="o-container '.sanitize_title_with_dashes($url).'">'.$html.'</figure>';
    return $return;
}
add_filter('embed_oembed_html', 'cftp_embed_html', 10, 4) ;

/**
 * cftp_embed_tweaks
 *
 * Filter vimeo embeds to match the site branding
 *
 * @author Scott Evans
 * @param  string $provider
 * @param  array $args
 * @param  string $url
 * @return string $provider
 */
function cftp_embed_tweaks($provider, $args, $url) {

	if (cftp_string_search('vimeo', $provider)) {
		$provider = add_query_arg(apply_filters('cftp_viemo_features', array('color' => str_replace('#','', get_theme_mod( 'brandprimary', '#ff0000')))), $provider);
	}

	return $provider;
}
add_filter('oembed_fetch_url', 'cftp_embed_tweaks', 30, 3);

/**
 * cftp_bootstrap_comment_fields
 *
 * Use bootstrap compatible HTML for comments
 *
 * @param  array $fields
 * @return array
 */
function cftp_bootstrap_comment_fields( $fields ) {
	$commenter = wp_get_current_commenter();

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

	$fields   =  array(
		'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		'<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
		'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		'<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
		'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
		'<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
	);

	return $fields;
}
add_filter( 'comment_form_default_fields', 'cftp_bootstrap_comment_fields' );

/**
 * cftp_bootstrap_comment_textarea
 *
 * Use bootstrap compatible HTML for comments
 *
 * @param  array $args
 * @return array
 */
function cftp_bootstrap_comment_textarea( $args ) {
	$args['comment_field'] = '<div class="form-group comment-form-comment">
			<label for="comment">' . _x( 'Comment', 'noun' ) . '</label>
			<textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
		</div>';
	return $args;
}
add_filter( 'comment_form_defaults', 'cftp_bootstrap_comment_textarea' );