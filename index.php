<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
get_header(); ?>

<div id="content">
	<?php setos_content_header(); ?>

	<div class="container">

		<?php if( is_search()): ?>
			<header class="content-header">
				<h1 class="content-title"><?php printf( __( 'Search Results: %s', 'setos' ), esc_html( $s ) ); ?></h1>
			</header>
		<?php elseif( is_archive()): ?>
			<header class="content-header">
				<?php the_archive_title( '<h1 class="content-title">', '</h1>' ); ?>
			</header>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<ul class="archive">
				<?php while ( have_posts() ) : the_post(); ?>

					<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if( has_post_thumbnail() ): ?>
							<div class="two-columns">
								<div class="side">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
								</div>
							<div class="main">
						<?php endif; ?>

						<div class="entry-header">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php if( !wp_is_mobile()): ?>
								<?php if ( is_post_type_archive( 'books' )): ?>
									<?php setos_entry_meta(); ?>
								<?php endif; ?>
								<?php the_excerpt(); ?>
							<?php endif; ?>
						</div>

						<?php if( has_post_thumbnail() ): ?>
								</div>
							</div>
						<?php endif; ?>
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

			<?php if( is_search()): ?>
				<p><?php printf( __( 'Sorry, no posts matched &#8216;%s&#8217;', 'setos' ), esc_html( $s ) ); ?>
			<?php elseif( is_archive()): ?>
				<header class="content-header">
					<p><?php _e( 'Sorry, no posts matched your criteria.', 'setos' ); ?></p>
				</header>
			<?php endif; ?>

		<?php endif; ?>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
