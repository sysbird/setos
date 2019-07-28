<?php
/**
 * The template for displaying archive pages
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
get_header(); ?>

<div id="content">
	<?php setos_content_header(); ?>

	<div class="container">
		<header class="content-header">
			<?php
				the_archive_title( '<h1 class="content-title">', '</h1>' );
			?>
		</header>

		<?php if ( have_posts() ) : ?>
			<ul class="two-columns-list">
				<?php while ( have_posts() ) : the_post(); ?>

					<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'setos' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
								<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( __( 'F j, Y', 'setos')); ?></time>
								<?php if( has_post_thumbnail() ): ?>
									<div class="entry-eyecatch">
										<?php the_post_thumbnail( 'middle' ); ?>
									</div>
								<?php endif; ?>
							</a>
						</header>
						<div class="entry-content">
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'setos' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
								<h2 class="entry-title"><?php the_title(); ?></h2>
							</a>
							<?php the_content(); ?>
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
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
