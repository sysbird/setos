<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'setos' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<?php the_title(); ?>
			</a>
		</h2>
		<?php the_excerpt(); ?>
	</header>
</li>
