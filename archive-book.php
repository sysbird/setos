<?php
/**
 * The template for displaying archive-book pages
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
			<header class="content-header">
				<h1 class="content-title"><?php _e( 'Book List', 'setos' ); ?></h1>
			</header>

			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if( has_post_thumbnail() ): ?>
							<div class="entry-eyecatch"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a></div>
						<?php endif; ?>
						<div class="entry-content">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php setos_entry_meta(); ?>
							<?php the_excerpt(); ?>
						</div>
					</div>

				<?php endwhile; ?>

				<?php $setos_pagination = get_the_posts_pagination( array(
						'mid_size'				=> 3,
						'screen_reader_text'	=> 'pagination',
					) );

					$setos_pagination = str_replace( '<h2 class="screen-reader-text">pagination</h2>', '', $setos_pagination );
					echo $setos_pagination; ?>

			<?php else: ?>
				<p><?php _e( 'Sorry, no posts matched your criteria.', 'setos' ); ?></p>
			<?php endif; ?>
		</article>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
