<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.09
 */
?>

<header class="entry-header">
	<h1 class="entry-title"><?php the_title(); ?></h1>

	<?php if( is_single() ) : ?>
		<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( __( 'F j, Y', 'setos')); ?></time>
	<?php endif; ?>

</header>
<div class="entry-content">
	<?php the_content(); ?>
	<?php wp_link_pages( array(
		'before'		=> '<div class="page-links">' . __( 'Pages:', 'setos' ),
		'after'			=> '</div>',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>'
		) ); ?>
</div>
