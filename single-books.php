<?php get_header(); ?>

<div id="content">
	<?php setos_content_header(); ?>

	<div class="container">

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<footer class="entry-meta">
				<?php setos_entry_meta(); ?>
			</footer>

			<div class="more"><a href="<?php echo get_post_type_archive_link( 'books' ); ?>"><?php _e( 'Books List', 'setos' ) ?></a></div>
	</article>

	<?php endwhile; ?>
	</div>

	<?php setos_content_footer(); ?>
</div>

<?php get_footer(); ?>
