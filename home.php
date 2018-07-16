<?php
/**
 * The home template file.
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */
get_header();
$setos_has_news = 0; ?>

<div id="content">
	<?php setos_content_header(); ?>

	<?php if( ! is_paged()): ?>
		<?php if( !setos_headerslider()): ?>
			<section id="wall" class="no-image"></section>
		<?php endif; ?>
	<?php endif; ?>

	<?php
		//プロフィールを表示する？
		$args = array(
			'post_type'	=> 'page',
			'name'		=> '____profile',
			'post_status'	=> 'publish'
		);
		$the_query = new WP_Query($args);
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
	?>

	<section class="information section <?php  echo get_post_field( 'post_name', get_the_ID() ); ?>">
		<div class="container">
			<h2>c</h2>

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

	<?php if ( have_posts()) : ?>
		<section id="news" class="section">
			<div class="container">
				<h2><?php _e( 'Information', 'setos' ) ?></h2>
				<ul class="article">
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
			</div>
		</section>
	<?php endif; ?>

	<?php
		$args = array(
			'post_type'		=> 'essay',
			'posts_per_page'	=> '6',
			'post_status'		=> 'publish'
		);
		$the_query = new WP_Query($args);
		if ( $the_query->have_posts() ) : ?>
			<section id="blog" class="section essay">
				<div class="container">
					<h2>Essay</h2>
					<ul class="article">

					<?php	while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

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
							<?php if(is_sticky()): ?>
								<i><span></span></i>
							<?php endif; ?>
						</li>

					<?php endwhile;
						wp_reset_postdata();
						endif; ?>

					</ul>
					<div class="more"><a href="<?php echo get_post_type_archive_link( 'essay' ); ?>"><?php _e( 'Essay List', 'setos' ) ?></a></div>
				</div>
			</section>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
_____