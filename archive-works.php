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
				<?php
					the_archive_title( '<h1 class="content-title">', '</h1>' );
				?>
			</header>

			<?php if ( have_posts() ) : ?>
				<ul class="archive">
					<?php while ( have_posts() ) : the_post(); ?>

						<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if( has_post_thumbnail() ): ?>
							<div class="entry-eyecatch"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a></div>
						<?php endif; ?>
						<div class="entry-header">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php if( !wp_is_mobile()): ?>
								<?php setos_entry_meta(); ?>
								<?php the_excerpt(); ?>
							<?php endif; ?>
						</div>
						</li>

					<?php endwhile; ?>
				</ul>

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