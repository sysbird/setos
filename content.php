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

	<?php if( has_post_thumbnail() ): ?>

		<div class="entry-eyecatch">
			<?php the_post_thumbnail( 'middle' ); ?>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<h2 class="entry-title">

			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'setos' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<?php the_title(); ?>
			</a>

		</h2>

		<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( __( 'F j, Y', 'setos')); ?></time>
		<?php the_excerpt(); ?>

	</header>
</li>
