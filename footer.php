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
				<div class="widget-area-left">
					<?php dynamic_sidebar( 'widget-area-footer-left' ); ?>
				</div>
				<div class="widget-area-center">
					<?php dynamic_sidebar( 'widget-area-footer-center' ); ?>
				</div>
				<div class="widget-area-right">
					<?php dynamic_sidebar( 'widget-area-footer-right' ); ?>
				</div>
			</div>
		</section>

		<div class="site-title">
			<div class="container">
				<?php $site_title = get_bloginfo( 'name' ); ?>
			<a href="<?php echo esc_url( home_url( '/' ) ) ; ?>"><strong><?php _e( $site_title, 'setos' ); ?></strong></a>

				<?php if( get_theme_mod( 'setos_copyright', true ) ): ?>
				<?php printf(__( 'Copyright &copy; %s All Rights Reserved.', 'setos' ), setos_get_copyright_year() ); ?>
			<?php endif; ?>

			</div>
		</div>
		<p id="back-top"><a href="#top"><span><?php _e( 'Go Top', 'setos' ); ?></span></a></p>
	</footer>

</div><!-- wrapper -->

<?php wp_footer(); ?>

<span style="display: none;">
	<?php echo do_shortcode( '[bogo]' ); ?>
</span>

</body>
</html>