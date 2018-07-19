<?php
/**
 * The home template file.
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
get_header(); ?>

<div id="content">
	<?php setos_content_header(); ?>

	<?php if( ! is_paged()): ?>
		<?php if( !setos_headerslider()): ?>
			<section id="wall" class="no-image"></section>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( have_posts()) : ?>
		<section id="information" class="section">
			<div class="container">
				<h2><?php _e( 'Information', 'setos' ) ?></h2>
				<ul class="list">
				<?php while ( have_posts()) : the_post(); ?>
					<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'setos' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
							<header class="entry-header">
								<time class="postdate" datetime="<?php echo get_the_time('Y-m-d') ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
								<h2 class="entry-title"><?php the_title(); ?></h2>
							</header>
						</a>
					</li>

				<?php endwhile; ?>
				</ul>
				<?php $category_id = get_cat_ID( 'Information' ); ?>
				<div class="more"><a href="<?php echo get_category_link( $category_id ); ?>"><?php _e( 'Information more', 'setos' ) ?></a></div>
			</div>
		</section>
	<?php endif; ?>

	<?php
		//プロフィールを表示する？
		$args = array(
			'post_type'	=> 'page',
			'tag'		=> 'top',
			'post_status'	=> 'publish'
		);
		$the_query = new WP_Query($args);
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
	?>

	<section class="section <?php  echo get_post_field( 'post_name', get_the_ID() ); ?>">
		<div class="container">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<?php
				$more_text = sprintf( __( 'See more &#8216;%s&#8217;', 'setos' ), get_the_title() );
				$more_url = get_the_permalink();
			?>

			<?php
				the_content('');
			?>

			<div class="more"><a href="<?php echo $more_url; ?>" class="more"><?php echo $more_text; ?></a></div>
		</div>
	</section>

	<?php endwhile;
		wp_reset_postdata();
		endif;
	?>

	<?php
		$args = array(
			'post_type'		=> 'essay',
			'posts_per_page'	=> '6',
			'post_status'		=> 'publish'
		);
		$the_query = new WP_Query($args);
		if ( $the_query->have_posts() ) : ?>
			<section id="essay" class="section">
				<div class="container">
					<h2>Essay</h2>
					<ul class="tile">

					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

						<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'setos' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
							<?php if( has_post_thumbnail() ): ?>
								<div class="entry-eyecatch">
									<?php the_post_thumbnail( 'large' ); ?>
								</div>
							<?php endif; ?>

							<header class="entry-header">
								<h3 class="entry-title"><?php the_title(); ?></h3>
								<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( __( 'F j, Y', 'setos')); ?></time>
							</header>
							</a>
						</li>

					<?php endwhile;
						wp_reset_postdata();
					 ?>

					</ul>
					<div class="more"><a href="<?php echo get_post_type_archive_link( 'essay' ); ?>"><?php _e( 'Essay more', 'setos' ) ?></a></div>
				</div>
			</section>

		<?php endif; ?>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
_____