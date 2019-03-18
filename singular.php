<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */

$setos_type = get_post_type( $post );
$setos_archive_url = '';
$setos_archive_title = '';

get_header(); ?>

<div id="content">
	<?php setos_content_header(); ?>

	<div class="container">

		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<?php if( is_single()):
						if( "post" === $setos_type ){
							$cat = get_the_category();
							if( count( $cat ) ){
								$setos_archive_url = get_category_link( $cat[0]->cat_ID );
								$setos_archive_title = $cat[0]->name;
							}
						}	
						else{
							$setos_archive_url = get_post_type_archive_link( $setos_type );
							$setos_archive_title = get_post_type_object( $setos_type )->label;
						}
						?>

						<span class="cateogry"><a href="<?php echo esc_url( $setos_archive_url ); ?>"><?php echo esc_html( $setos_archive_title ); ?></a></span>
			
						<?php if( ("books" != $setos_type ) && ("exhibition" != $setos_type ) && setos_is_recently()): ?>
							<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( __( 'F j, Y', 'setos')); ?></time>
						<?php endif; ?>
					<?php endif; ?>

				</header>

				<?php if( 'books' === $setos_type ): ?>
					<div class="two-columns">
						<div class="side">
							<?php if( has_post_thumbnail() ): ?>
								<div class="entry-eyecatch setos-photos-cover">
									<?php the_post_thumbnail( 'middle' ); ?>
								</div>
							<?php endif; ?>

							<?php setos_photos_slide() ?>
						</div>
						<div class="main">
				<?php endif; ?>

				<div class="entry-content">
	
					<?php the_content(); ?>
	
					<?php if( is_single()): ?>
						<?php if ( is_object_in_term( $post->ID, 'works-genre','book' )): ?>
							<?php setos_entry_meta(); ?>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<?php if( 'books' === get_post_type()): ?>
						</div>
					</div>
				<?php endif; ?>

			</article>

			<?php if( is_single()): ?>
				<?php $setos_archive_title .= ' more'; ?>
				<div class="more"><a href="<?php  _e( esc_url( $setos_archive_url, 'setos' )); ?>"><?php _e( esc_html( $setos_archive_title ), 'setos' ) ?></a></div>

				<nav class="nav-below">
					<span class="nav-previous"><?php previous_post_link('%link', '%title' ); ?></span>
					<span class="nav-next"><?php next_post_link('%link', '%title' ); ?></span>
				</nav>
			<?php endif; ?>

		<?php endwhile; ?>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>