<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blogi
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="/wp-content/themes/blogi/jquery.js"></script>
<?php if (is_home()) { ?>
<link rel="stylesheet" type="text/css" href="/wp-content/themes/blogi/css/style-1.css">

<script type="text/javascript">         
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    }); 
</script>    

<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">Yimian Blog<br><span>Loading</span></div>
</div>
<?php } ?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'blogi' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-3">
					<ul class="social-header clearfix">
						<?php if( get_theme_mod( 'social_facebook' )): ?>
							<li><a href="<?php echo esc_url( get_theme_mod( 'social_facebook' ) ); ?>" class="facebook"><i class="fa fa-facebook"></i></a></li>
						<?php endif; ?>
						<?php if( get_theme_mod( 'social_twitter' )): ?>
							<li><a href="<?php echo esc_url( get_theme_mod( 'social_twitter' ) ); ?>" class="twitter"><i class="fa fa-twitter"></i></a></li>
						<?php endif; ?>
						<?php if( get_theme_mod( 'social_google_plus' )): ?>
							<li><a href="<?php echo esc_url( get_theme_mod( 'social_google_plus' ) ); ?>" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
						<?php endif; ?>
					</ul>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<div class="site-branding text-center">
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
						<?php
						if ( function_exists( 'the_custom_logo' ) ) {
							the_custom_logo();
						}
						?>
					</div><!-- .site-branding -->
				</div>
				<div class="col-md-4 col-sm-4 col-xs-3 menu-col">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span class="sr-only"><?php esc_html_e( 'Menu', 'blogi' ); ?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class' => 'primary-menu' ) ); ?>
					</nav><!-- #site-navigation -->
				</div>
			</div>
			
			
			
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
