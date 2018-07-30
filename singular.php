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
						if( "post" == $setos_type ){
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
						<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( __( 'F j, Y', 'setos')); ?></time>
					<?php endif; ?>

				</header>
				<div class="entry-content">
					<?php setos_photos_slide() ?>
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
				<?php setos_entry_meta(); ?>
				<?php $setos_archive_title .= ' more'; ?>
				<div class="more"><a href="<?php  _e( esc_url( $setos_archive_url, 'setos' )); ?>"><?php _e( esc_html( $setos_archive_title ), 'setos' ) ?></a></div>
			<?php endif; ?>

			<?php if( is_single()): ?>
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