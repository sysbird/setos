<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
?>
	<footer id="footer">
		<section id="widget-area">
			<div class="container">
				<?php dynamic_sidebar( 'widget-area-footer' ); ?>
			</div>
		</section>

		<div class="container">
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ) ; ?>"><strong><?php bloginfo(); ?></strong></a>

				<?php if( get_theme_mod( 'setos_copyright', true ) ): ?>
					<?php printf(__( 'Copyright &copy; %s All Rights Reserved.', 'setos' ), setos_get_copyright_year() ); ?>
				<?php endif; ?>

			</div>
		</div>
		<p id="back-top"><a href="#top"><span><?php _e( 'Go Top', 'setos' ); ?></span></a></p>
	</footer>

</div><!-- wrapper -->

<?php wp_footer(); ?>

</body>
</html>