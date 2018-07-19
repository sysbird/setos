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
		<article class="hentry">
			<header class="content-header">
                <h1><?php _e( 'Information', 'setos' ) ?></a>
			</header>

			<?php if ( have_posts() ) : ?>
				<ul class="list">
                    <?php while ( have_posts() ) : the_post(); ?>

						<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'setos' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
								<header class="entry-header">
									<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( __( 'F j, Y', 'setos')); ?></time>
									<h2 class="entry-title">

										<?php the_title(); ?>
			
									</h2>

								</header>
							</a>
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