<?php
/**
 * The template for displaying the header
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" >
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<?php wp_head(); ?>
</head>

<?php 
	$setos_theme_color = get_theme_mod( 'setos_theme_color', 'dark' );
?>

<body <?php body_class( $setos_theme_color ); ?>>

<div class="wrapper">

	<header id="header">
		<div class="container drawer drawer--top">
			<div id="branding">
				<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
				<<?php echo $heading_tag; ?> id="site-title">
					<?php $site_title = get_bloginfo( 'name' ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php _e( $site_title, 'setos' ); ?>" rel="home"><?php _e( $site_title, 'setos' ); ?></a>
				</<?php echo $heading_tag; ?>>
				<?php $site_description = get_bloginfo( 'description' ); ?>
				<p id="site-description"><?php _e( $site_description, 'setos' ); ?></p>
			</div>

			<nav id="menu-wrapper">
				<button type="button" id="small-menu" class="drawer-toggle drawer-hamburger">
					<span class="sr-only">toggle navigation</span>
					<span class="drawer-hamburger-icon"></span>
				</button>

				<?php wp_nav_menu( array( 'theme_location' => 'primary',
							'container_class' => 'menu',
							'menu_class' => '',
							'menu_id' => 'menu-primary-items',
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'fallback_cb' => '' ) ); ?>
			</nav>
		</div>
	</header>
