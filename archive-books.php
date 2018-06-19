<?php get_header(); ?>

<div id="content">
	<?php setos_content_header(); ?>

	<div class="container">

		<article class="hentry">
			<header class="content-header">
				<h1 class="content-title">
				<?php _e( 'Books', 'setos' ); ?>
				</h1>
			</header>

			<?php if ( have_posts() ) : ?>
				<div class="tile">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'books' ); ?>
					<?php endwhile; ?>

				</div>
			<?php endif; ?>
		</article>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
