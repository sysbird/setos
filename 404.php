<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
get_header(); ?>

<div id="content">
	<?php setos_content_header(); ?>

	<div class="container">
		<article class="hentry">

	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Error 404 - Not Found', 'setos' ); ?></h1>
	</header>

	<div class="entry-content">
		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'setos' ); ?></p>
	</div>

		</article>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
