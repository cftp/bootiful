<!doctype html>
<!--[if lt IE 7 ]> <html <?php language_attributes() ?> class="no-js ie6 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes() ?> class="no-js ie7 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes() ?> class="no-js ie8 lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes() ?> class="no-js"> <!--<![endif]-->
<head>

<?php tha_head_top(); ?>

<!-- utf-8 -->
<meta charset="<?php bloginfo('charset') ?>" />

<!-- title -->
<title itemprop="name"><?php wp_title( '|', true, 'right' ); ?></title>

<!-- set mobile viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php tha_head_bottom(); ?>

<!-- wp_head -->
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> <?php body_attributes(); ?>>

	<?php tha_body_top(); ?>

	<div id="accessibility" aria-label="<?php _e('Page skip links', 'bootiful'); ?>">
		<a href="#content" class="skip-link skip-content" title="<?php _e('Skip to content &raquo;', 'bootiful'); ?>"><?php _e('Skip to content &raquo;', 'bootiful'); ?></a>
	</div><!-- #accessibility -->

	<div id="wrapper" class="hfeed">

		<div id="header-wrapper">

			<?php tha_header_before(); ?>

			<header id="header" role="banner">

				<?php tha_header_top(); ?>

				<div id="site-info" itemscope itemtype="http://schema.org/Organization">
					<a id="site-title" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo('name') ); ?>" rel="home" class="logo" itemprop="url"><span itemprop="name"><?php bloginfo('name'); ?></span></a>
					<span id="site-description" itemprop="description"><?php bloginfo('description') ?></span>
				</div>

				<?php if ( has_nav_menu( 'navigation' ) ) { ?>
				<nav id="navigation" role="navigation">

					<?php
					wp_nav_menu(
						array(
							'menu' => 'navigation',
							'theme_location' 	=> 'navigation',
							'depth' 			=> 2,
							'container_class'   => 'menu-navigation'
							// example menu with bootstrap walker
							//'container'         => 'div',
							//'container_class'   => 'collapse navbar-collapse',
							//'container_id'      => 'bs-example-navbar-collapse-1',
							//'menu_class'        => 'nav navbar-nav',
							//'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
							//'walker'            => new wp_bootstrap_navwalker())
						)
					);
					?>

				</nav><!--  #navigation -->
				<?php } ?>

				<?php tha_header_bottom(); ?>

			</header><!-- #header -->

			<?php tha_header_after(); ?>

		</div><!-- #header-wrapper -->

		<div id="content-wrapper">

			<?php tha_content_before(); ?>

			<div id="content" role="main">

				<?php tha_content_top(); ?>
