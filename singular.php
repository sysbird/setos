<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
get_header(); ?>

<div id="content">
	<?php setos_content_header(); ?>

	<div class="container">

		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<?php if( is_single() ) : ?>
						<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( __( 'F j, Y', 'setos')); ?></time>
					<?php endif; ?>

				</header>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array(
						'before'		=> '<div class="page-links">' . __( 'Pages:', 'setos' ),
						'after'			=> '</div>',
						'link_before'	=> '<span>',
						'link_after'	=> '</span>'
						) ); ?>
				</div>

				</article>

			<?php if( is_single()): ?>
				<nav id="nav-below">
					<span class="nav-next"><?php next_post_link('%link', '%title'); ?></span>
					<span class="nav-previous"><?php previous_post_link('%link', '%title'); ?></span>
				</nav>
			<?php endif; ?>

		<?php endwhile; ?>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>