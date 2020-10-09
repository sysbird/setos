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

				<?php if(( 'exhibition' === $setos_type ) && has_post_thumbnail()) : ?>
					<div class="two-columns">
						<div class="entry-header">
							<div class="entry-eyecatch">
								<?php the_post_thumbnail( 'middle' ); ?>
							</div>
						</div>
				<?php endif; ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<?php if(( 'exhibition' === $setos_type ) && has_post_thumbnail()) : ?>
					</div>
				<?php endif; ?>

				<?php if( 'books' === $setos_type ) :
						$contact_page_obj = get_page_by_path( "contact" );
						if( $contact_page_obj ): 
					?>
							<div class="wp-block-button aligncenter">
								<?php 
									// link for contact form
									$locales = get_locale(); 
									$contact_page_ID = setos_get_translations_id( $contact_page_obj->ID, $locales );
									$url_contact = get_permalink( $contact_page_ID ) .'?your-subject=' .get_the_title();
									$btn_title = sprintf( __( 'Contact about this book &#8216;%s&#8217;', 'setos' ), get_the_title());
								?>

								<a class="wp-block-button__link has-background" href="<?php echo $url_contact; ?>"><?php printf( __( 'Contact about this book &#8216;%s&#8217;', 'setos' ), get_the_title()); ?></a>
							</div>
							
						<?php endif; ?>
				<?php endif; ?>

			</article>

			<?php if( is_single()): ?>
				<?php $setos_archive_title .= ' more'; ?>
				<div class="more"><a href="<?php  _e( esc_url( $setos_archive_url, 'setos' )); ?>"><?php _e( esc_html( $setos_archive_title ), 'setos' ) ?></a></div>

				<nav class="nav-below">
					<div class="nav-previous"><?php previous_post_link('%link', '%title' ); ?></div>
					<div class="nav-next"><?php next_post_link('%link', '%title' ); ?></div>
				</nav>

				<?php posts_nav_link( ' &#183; ', 'previous page', 'next page' ); ?>
			<?php endif; ?>

		<?php endwhile; ?>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>