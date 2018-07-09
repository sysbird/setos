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
		<?php if( !( $setos_header_image = setos_headerslider())): ?>
			<section id="wall" class="no-image"></section>
		<?php endif; ?>

	<?php endif; ?>

	<?php
		$args = array(
			'post_type'		=> 'page',
			'tag'			=> 'top',
			'post_status'	=> 'publish'
		);
		$the_query = new WP_Query($args);
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
	?>

	<section class="information section <?php  echo get_post_field( 'post_name', get_the_ID() ); ?>">
		<div class="container">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

			<?php
				$more_text = sprintf( __( 'See more &#8216;%s&#8217;', 'setos' ), get_the_title() );
				$more_url = get_the_permalink();
			?>

			<?php
				if( !( false === strpos( $post->post_name, 'fruit' ) ) ){
					echo do_shortcode('[miyazaki_en_fruits_list]');
				}
				else{
					the_content('');
				}
			?>

			<div class="more"><a href="<?php echo $more_url; ?>" class="more"><?php echo $more_text; ?></a></div>

		</div>
	</section>

	<?php endwhile;
		wp_reset_postdata();
		endif;
	?>

	<?php if ( is_front_page() && setos_has_news_posts()): ?>
		<?php get_template_part( 'news-content' ); ?>
		<?php $setos_has_news = 1; ?>
	<?php endif; ?>

	<?php if ( have_posts()) : ?>
		<section id="blog" class="section essay">
			<div class="container">
				<?php if( ! is_paged() && $setos_has_news ): ?>
					<h2><?php _e('RECENT', 'setos') ?></h2>
				<?php endif; ?>

				<ul class="article">
				<?php while ( have_posts()) : the_post(); ?>
					<?php get_template_part( 'content', 'home' ); ?>
				<?php endwhile; ?>
				</ul>

				<?php $setos_pagination = get_the_posts_pagination( array(
						'mid_size'	=> 3,
						'screen_reader_text'	=> 'pagination',
					));

					$setos_pagination = str_replace( '<h2 class="screen-reader-text">pagination</h2>', '', $setos_pagination );
					echo $setos_pagination; ?>

			</div>
		</section>
	<?php endif; ?>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
