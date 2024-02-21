<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IP24
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<title><?php echo wp_get_document_title(); ?></title>
	<meta name="description" content="<?php if (is_singular()) : echo get_the_excerpt(); else: bloginfo( 'description' ); endif; ?>"/>

	<link rel="preload" href="<?php echo get_template_directory_uri() . '/fonts/OpenSans-Variable.ttf' ?>" as="font" type="font/ttf" crossorigin>
	<link rel="preload" href="<?php echo get_template_directory_uri() . '/fonts/SourceSerif4-Variable.ttf' ?>" as="font" type="font/ttf" crossorigin>
	<link rel="preload" as="image" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id(2) ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php $bgIMG = wp_get_attachment_url( get_post_thumbnail_id(2) ); ?>
<div id="introbg" style="background-image: url(<?php echo $bgIMG; ?>);">
	<img src="<?php echo get_template_directory_uri() . '/images/bg_top_2024.svg' ?>" width="100%" height="100%" border="0" alt="IMPERATORI &amp; PARTNERS">
</div>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'ip24' ); ?></a>


<?php if ( is_front_page()  ) : ?>
	<header id="masthead" class="site-header site-header-big">
		<div class="site-branding">

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri() . '/images/IMPERATORI&PARTNERS.svg' ?>" alt="logo" width="330" height="86" /></a></h1>

			<?php 
			$ip24_description = get_bloginfo( 'description', 'display' );
			if ( $ip24_description || is_customize_preview() ) : ?>
				<p class="site-description"><?php //echo $ip24_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					Frutto dell'esperienza del suo fondatore <strong>Andrea Imperatori</strong> presso alcune delle realtà immobiliari più importanti del settore, <strong>Imperatori&Partners</strong> opera principalmente nell'area urbana di Milano.
				</p>
			<?php endif; ?>

		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ip24' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	
	</header><!-- #masthead -->

<?php else : ?>
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri() . '/images/IMPERATORI&PARTNERS.svg' ?>" alt="logo" width="330" height="86" /></a></p>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'ip24' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	
	</header><!-- #masthead -->

<?php endif; ?>



