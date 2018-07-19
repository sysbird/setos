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

		<article class="hentry">
		<ul class="archive">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
		</ul>

		<?php $setos_pagination = get_the_posts_pagination( array(
				'mid_size'	=> 3,
				'screen_reader_text'	=> 'pagination',
			) );

			$setos_pagination = str_replace( '<h2 class="screen-reader-text">pagination</h2>', '', $setos_pagination );
			echo $setos_pagination; ?>

		</article>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
