<!doctype html>
<!--[if lt IE 7 ]> <html <?php language_attributes() ?> class="no-js ie6 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes() ?> class="no-js ie7 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes() ?> class="no-js ie8 lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes() ?> class="no-js"> <!--<![endif]-->
<head>

<!-- utf-8 -->
<meta charset="<?php bloginfo('charset') ?>" />

<!-- title -->
<title><?php wp_title( '|', true, 'right' ); ?></title>

<!-- set mobile viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- wp_head -->
<?php wp_head(); ?>

</head>

<body <?php body_class()?>>

	<div id="accessibility" class="sr-only">
		<a href="#content" class="skip-link" title="<?php _e('Skip to content &raquo;', 'bootiful'); ?>"><?php _e('Skip to content &raquo;', 'bootiful'); ?></a>
	</div><!-- #accessibility -->
	
	<div id="wrapper" class="hfeed container">

		<header id="header" role="banner">
			
			<?php if ( has_nav_menu( 'navigation' ) ) { ?>
			<nav id="navigation" role="navigation">

				<?php
				wp_nav_menu( 
					array( 
						'menu' => 'navigation',
						'theme_location' => 'navigation',
						'depth' => 2,
						'container_class' => 'menu-navigation'
					)
				);
				?>

			</nav><!--  #navigation -->
			<?php } ?>

		<div id="content" role="main">