<?php
/**
 * The template functions and definitions
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.0
 */

//////////////////////////////////////////
// Set the content width based on the theme's design and stylesheet.
function setos_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'setos_content_width', 930 );
}
add_action( 'template_redirect', 'setos_content_width' );

//////////////////////////////////////////////////////
// XML-RPC disable
add_filter( 'xmlrpc_enabled', '__return_false');
if ( function_exists( 'add_filter' ) ) {
	add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
}
function remove_xmlrpc_pingback_ping($methods)
{
	unset($methods['pingback.ping']);
	return $methods;
}

//////////////////////////////////////////////////////
// Comment disable
add_filter( 'comments_open', '__return_false' );

//////////////////////////////////////////////////////
// emoji disable
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

//////////////////////////////////////////////////////
// remove theme customize
function setos_customize_register( $wp_customize ) {
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'custom_css' );
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'title_tagline' );
}
add_action( 'customize_register', 'setos_customize_register' );

//////////////////////////////////////////
// Customizer additions.
// require get_template_directory() . '/functions_customizer.php';

//////////////////////////////////////////
// Set Widgets
function setos_widgets_init() {

	register_sidebar( array (
		'name'			=> __( 'Widget Area for footer', 'setos' ),
		'id'			=> 'widget-area-footer',
		'description'	=> __( 'Widget Area for footer', 'setos' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
		) );
}
add_action( 'widgets_init', 'setos_widgets_init' );

//////////////////////////////////////////////////////
// Copyright Year
function setos_get_copyright_year() {

	$setos_copyright_year = date("Y");

	$setos_first_year = $setos_copyright_year;
	$args = array(
		'numberposts'	=> 1,
		'orderby'		=> 'post_date',
		'order'			=> 'ASC',
	);
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$setos_first_year = mysql2date( 'Y', $post->post_date, true );
	}

	if( $setos_copyright_year <> $setos_first_year ){
		$setos_copyright_year = $setos_first_year .' - ' .$setos_copyright_year;
	}

	return $setos_copyright_year;
}

//////////////////////////////////////////////////////
// Setup Theme
function setos_setup() {

	// Set languages
	load_theme_textdomain( 'setos', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Set feed
	add_theme_support( 'automatic-feed-links' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	/*
	 * Switch default core markup for search form
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'gallery',
		'caption',
	));

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Navigation Menu', 'setos' ),
	));

	// Add support for title tag.
	add_theme_support( 'title-tag' );

	// Add support for custom headers.
	add_theme_support( 'custom-header', array(
		'default-image'		=> get_parent_theme_file_uri( '/images/header.jpg' ),
		'height'			=> 900,
		'width'				=> 1280,
		'flex-height'		=> true,
	));

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/images/header.jpg',
			'thumbnail_url' => '%s/images/header.jpg',
			'description'   => __( 'Default Header Image', 'setos' ),
		),
	) );
}
add_action( 'after_setup_theme', 'setos_setup' );

//////////////////////////////////////////////////////
// Add custom post type
function setos_init() {

	//	 add tags at page
	register_taxonomy_for_object_type('post_tag', 'page');

	// add post type works
	$labels = array(
		'name'		=> 'Works',
		'all_items'	=> 'Worksの一覧',
		);

	$args = array(
		'labels'			=> $labels,
		'supports'			=> array( 'title','editor', 'thumbnail', 'custom-fields' ),
		'public'			=> true,	// 公開するかどうが
		'show_ui'			=> true,	// メニューに表示するかどうか
		'menu_position'		=> 5,		// メニューの表示位置
		'has_archive'		=> true,	// アーカイブページの作成
		);

	register_post_type( 'works', $args );

	// add post type essay
	$labels = array(
		'name'		=> 'Essay',
		'all_items'	=> 'essayの一覧',
		);

	$args = array(
		'labels'			=> $labels,
		'supports'			=> array( 'title','editor', 'thumbnail', 'custom-fields' ),
		'public'			=> true,	// 公開するかどうが
		'show_ui'			=> true,	// メニューに表示するかどうか
		'menu_position'		=> 5,		// メニューの表示位置
		'has_archive'		=> true,	// アーカイブページの作成
		);

	register_post_type( 'essay', $args );
}
add_action( 'init', 'setos_init', 0 );

//////////////////////////////////////////////////////
// Enable custom post type in Bogo
function setos_bogo_localizable_post_types( $localizable ) {
	$args = array(
		'public'   => true,
		'_builtin' => false
	);
	$custom_post_types = get_post_types( $args );
	return array_merge( $localizable, $custom_post_types );
}
add_filter( 'bogo_localizable_post_types', 'setos_bogo_localizable_post_types', 10, 1 );

//////////////////////////////////////////////////////
// Filter main query at home
function setos_home_query( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		// toppage information
		 $query->set( 'posts_per_page', 3 );
	}
	else if ( $query->is_post_type_archive( 'essay' ) && $query->is_main_query() ) {
		 $query->set( 'posts_per_page', 9 );
	}
}
add_action( 'pre_get_posts', 'setos_home_query' );

//////////////////////////////////////////////////////
// Enqueue Scripts
function setos_scripts() {

	// masonry
	wp_enqueue_script( 'jquery-masonry' );

	// fancybox
	wp_enqueue_style( 'setos-fancybox', get_stylesheet_directory_uri().'/js/fancybox/jquery.fancybox.min.css' );
	wp_enqueue_script( 'setos-fancybox', get_template_directory_uri() .'/js/fancybox/jquery.fancybox.min.js', array( 'jquery' ), '4.3.3' );

	// tile
	wp_enqueue_script( 'jquerytile', get_template_directory_uri() .'/js/jquery.tile.js', 'jquery', '1.1.2' );

	// Google Fonts
	wp_enqueue_style( 'setos-google-font', '//fonts.googleapis.com/css?family=Open+Sans', false, null, 'all' );
//	wp_enqueue_style( 'setos-google-font-ja', '//fonts.googleapis.com/earlyaccess/sawarabimincho.css', false, null, 'all' );

	// this
	wp_enqueue_script( 'setos', get_template_directory_uri() .'/js/setos.js', array( 'jquery' , 'jquery-masonry', 'jquerytile' ), '1.11' );
	wp_enqueue_style( 'setos', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'setos_scripts' );

//////////////////////////////////////////////////////
// Santize a checkbox
function setos_sanitize_checkbox( $input ) {

	if ( $input == true ) {
		return true;
	} else {
		return false;
	}
}

///////////////////////////////////////////////////////
// Sanitize text
function setos_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

//////////////////////////////////////////////////////
// Removing the default gallery style
function setos_gallery_atts( $out, $pairs, $atts ) {

	$atts = shortcode_atts( array( 'size' => 'medium', ), $atts );
	$out['size'] = $atts['size'];

	return $out;
}
add_filter( 'shortcode_atts_gallery', 'setos_gallery_atts', 10, 3 );
add_filter( 'use_default_gallery_style', '__return_false' );

//////////////////////////////////////////////////////
// archive title
function setos_get_the_archive_title ( $title ) {

	$setos_title = preg_replace('/.*:\s+/', '', $title );

	return $setos_title;
};
add_filter( 'get_the_archive_title', 'setos_get_the_archive_title' );

//////////////////////////////////////////////////////
// Excerpt More
function setos_excerpt_more( $more ) {
	return ' ...<span class="more"><a href="'. esc_url( get_permalink() ) . '" >' . __( 'more', 'setos') . '</a></span>';
}
add_filter('excerpt_more', 'setos_excerpt_more');

//////////////////////////////////////////////////////
// photos slide
function setos_photos_slide () {
	$post_id = get_the_ID();
	$thumbnail_id = get_post_meta( $post_id, "_thumbnail_id", true );
	$book_title = get_the_title();

	// photos in post
	$html = '';
	$html_cover = '';
	$args = array( 'post_type'			=> 'attachment',
					'posts_per_page'	=> -1,
					'post_parent'		=> $post_id,
					'post_mime_type'	=> 'image',
					'orderby'			=> 'menu_order',
					'order'				=> 'ASC' );

	$images = get_posts( $args );
	if ( $images ) {
		$number = 1;
		foreach( $images as $image ){

			$src = wp_get_attachment_url( $image->ID );
			$thumbnail = wp_get_attachment_image_src( $image->ID, 'large' );
			$html .= ' <a href="' .$src .'" data-fancybox="setos-photos-slide" data-caption="' .$image->post_title .'">page' .$number .'</a>';
			$number++;
		}

		wp_reset_postdata();
	}

	// output
	if( !empty( $html ) ){
		$html = '<div class="setos-photos-slide">' .$html .'<p><a href="#" class="start">写真を見る</a></p></div>';
	}

	echo $html;
}

//////////////////////////////////////////////////////
// Shortcode gallery
function setos_gallery ( $atts ) {

	$post_id = get_the_ID();
	$thumbnail_id = get_post_meta( $post_id, "_thumbnail_id", true );
	$book_title = get_the_title();

	// photos in post
	$html = '';
	$html_cover = '';
	$args = array( 'post_type'			=> 'attachment',
					'posts_per_page'	=> -1,
					'post_parent'		=> $post_id,
					'post_mime_type'	=> 'image',
					'orderby'			=> 'menu_order',
					'order'				=> 'ASC' );

	$images = get_posts( $args );
	if ( $images ) {
		foreach( $images as $image ){

			$src = wp_get_attachment_url( $image->ID );
			$thumbnail = wp_get_attachment_image_src( $image->ID, 'large' );
			$html .= ' <div class="swiper-slide"><a href="' .$src .'" data-fancybox="gallery-' .$post_id .'" data-caption="' .$image->post_title .'"><img src="' .$thumbnail[0] .'" alt="' .$image->post_title .'"' .' class="swiper-lazy"><div class="swiper-lazy-preloader"></div></a></div>';

			// cover photo
			if( $thumbnail_id == $image->ID ){
				$html_cover = '<div class="setos-gallery-cover"><a href="#" ><img src="' .$thumbnail[0] .'" alt="' .$_title .'"></a></div>';
			}
		}

		wp_reset_postdata();
	}

	// output
	if( !empty( $html ) ){
		$html = '<div class="setos-gallery">' .$html_cover .'<div class="swiper-container"><div class="swiper-wrapper">' .$html .'</div><div class="swiper-pagination"></div><div class="swiper-button-prev"></div><div class="swiper-button-next"></div></div></div>';
	}

	return $html;
}
add_shortcode( 'setos-gallery', 'setos_gallery' );

//////////////////////////////////////////
//  Show custom field by ACF
function setos_the_custom_field( $ID, $selector, $before, $after ) {

	$value = get_field( $selector, $ID );
	if( !empty( $value ) ){
		echo $before .$value .$after;
	}
}

//////////////////////////////////////////////////////
// Display entry meta
function setos_entry_meta() {
?>
	<?php if( is_post_type_archive( 'works' ) ): // archive book ?>
		<ul class="book-meta">
			<?php setos_the_custom_field( get_the_ID(), 'issuer', '<li><strong>' .__( 'Publisher', 'setos') .':</strong> ', '</li>' ); ?>
			<?php setos_the_custom_field( get_the_ID(), 'release', '<li><strong>' .__( '発売日', 'setos') .':</strong> ', '</li>' ); ?>
		</ul>
	<?php elseif( is_archive() || is_search() ) : // archive ?>
	<?php elseif( is_home() ): // home ?>
	<?php elseif( is_singular( 'works' ) ): // single book ?>
		<ul class="book-meta">
			<li class="entry-title"><strong><?php _e( 'Photo Book', 'setos'); ?>:</strong> <?php the_title(); ?></li>
			<?php setos_the_custom_field( get_the_ID(), 'author', '<li><strong>' .__( 'Author', 'setos') .':</strong> ', '</li>' ); ?>
			<?php setos_the_custom_field( get_the_ID(), 'issuer', '<li><strong>' .__( 'Publisher', 'setos') .':</strong> ', '</li>' ); ?>
			<?php setos_the_custom_field( get_the_ID(), 'isbn-10', '<li><strong>' .__( 'ISBN-10', 'setos') .':</strong> ', '</li>' ); ?>
			<?php setos_the_custom_field( get_the_ID(), 'isbn-13', '<li><strong>' .__( 'ISBN-13', 'setos') .':</strong> ', '</li>' ); ?>
			<?php setos_the_custom_field( get_the_ID(), 'release', '<li><strong>' .__( '発売日', 'setos') .':</strong> ', '' ); ?>
			<?php setos_the_custom_field( get_the_ID(), 'price', '<li><strong>' .__( 'Price', 'setos') .':</strong> ', ' ' .__( 'yen', 'setos') .'</li>' ); ?>
			<?php setos_the_custom_field( get_the_ID(), 'size', '<li><strong>' .__( 'Size', 'setos') .':</strong> ', '</li>' ); ?>
		</ul>
	<?php endif; ?>

<?php
}

//////////////////////////////////////////////////////
// Add hook content begin
function setos_content_header() {

	// bread crumb
/*	$setos_html = '';

	if( !is_home()){
		if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) {
			$setos_html .= '<div class="bread_crumb">';
			$setos_html .= WP_SiteManager_bread_crumb::bread_crumb( array( 'echo'=>'false', 'home_label' => __( 'Home', 'setos' ), 'search_label' =>  __( 'Search Results: %s', 'setos' ), 'elm_class' => 'container' ));
			$setos_html .= '</div>';
		}
	}

	echo $setos_html; */
}

//////////////////////////////////////////////////////
// Add hook content end
function setos_content_footer() {
}

//////////////////////////////////////////////////////
// Google Analytics
function setos_wp_head() {
	if ( !is_user_logged_in() ) {
		get_template_part( 'google-analytics' );
	}
}
add_action( 'wp_head', 'setos_wp_head' );

//////////////////////////////////////////////////////
// image optimize
function setos_handle_upload( $file )
{
	if( $file['type'] == 'image/jpeg' ) {
		$image = wp_get_image_editor( $file[ 'file' ] );

		if (! is_wp_error($image)) {
			$exif = exif_read_data( $file[ 'file' ] );
			$orientation = $exif[ 'Orientation' ];
			$max_width = 930;
			$max_height = 930;
			$size = $image->get_size();
			$width = $size[ 'width' ];
			$height = $size[ 'height' ];

			if ( $width > $max_width || $height > $max_height ) {
				$image->resize( $max_width, $max_height, false );
			}

			if (! empty($orientation)) {
				switch ($orientation) {
					case 8:
						$image->rotate( 90 );
						break;

					case 3:
						$image->rotate( 180 );
						break;

					case 6:
						$image->rotate( -90 );
						break;
				}
			}
			$image->save( $file[ 'file' ]) ;
		}
	}

	return $file;
}
add_action( 'wp_handle_upload', 'setos_handle_upload' );

//////////////////////////////////////////////////////
// Header Slider
function setos_headerslider() {

	if (( !is_front_page())) {
		return false;
	}

	$setos_slides = array();
	$setos_max = 0;

	$headers = get_uploaded_header_images();
	if($headers) {
		// many omage
		shuffle ( $headers );
		foreach ( $headers as $header ) {
			$setos_slides[ $setos_max ] = $header[ 'url' ];
			$setos_max++;
			if( 3 == $setos_max ){
				break;
			}
		}
	}
	else {
		// one omage
		$header_image = get_header_image();
		if( $header_image ){
			$setos_slides[ 0 ] = $header_image;
			$setos_max = 1;
		}
	}

	if( !$setos_max ){
		return false;
	}

	$slider_class = '';
	if( 1 < $setos_max ){
		$slider_class = ' slider';
	}

	?>

	<section id="wall">
		<div class="headerimage <?php echo $slider_class ?>" data-interval="7000">

<?php
	// sort randam
	$setos_html = '';
//	$setos_start = mt_rand( 1, $setos_max );
	for( $setos_count = 1; $setos_count <= $setos_max; $setos_count++ ) {
			$setos_class = '';
			if( 1 == $setos_count ){
				$setos_class = ' start active';
			}

			$setos_html .= '<div class="slideitem' .$setos_class .'" id="slideitem_' .$setos_count .'">';
			$setos_html .= '<div class="fixedimage" style="background-image: url(' .$setos_slides[ $setos_count -1 ] .')"></div>';
			$setos_html .= '</div>';
	}

	echo $setos_html;
?>
		</div>
	</section>
<?php

	return true;
}

function _setos_headerslider() {

	if (( !is_front_page())) {
		return false;
	}

	$setos_interval = get_theme_mod( 'slide_interval', 7000 );
	if( 0 == $setos_interval){
		$setos_interval = 7000;
	}

	// get headerslide option
	$setos_slides = array();
	$setos_max = 0;

	for( $setos_count = 1; $setos_count <= 5; $setos_count++ ) {
		$setos_default_image = '';
		$setos_default_title = '';
		$setos_default_description = '';
		$setos_default_link = '';

		if( 1 == $setos_count ){
			$setos_default_image = get_template_directory_uri() . '/images/header.jpg';
			$setos_default_title =  __( 'Hello world!','setos' );
			$setos_default_description = __( 'Begin your website.', 'setos' );
			$setos_default_link = '#';
		}

		$setos_image = get_theme_mod( 'slider_image_' .strval( $setos_count ), $setos_default_image );
		if ( ! empty( $setos_image )) {
			$setos_slides[ $setos_count -1 ][ 'image' ] = $setos_image;
			$setos_slides[ $setos_count -1 ][ 'title' ] = get_theme_mod( 'slider_title_' . strval( $setos_count ), $setos_default_title );
			$setos_slides[ $setos_count -1 ][ 'description' ] = get_theme_mod( 'slider_description_' . strval( $setos_count ), $setos_default_description );
			$setos_slides[$setos_count -1 ][ 'link' ] = get_theme_mod( 'slider_link_' . strval( $setos_count ), $setos_default_link );

			$setos_max++;
		}
		else{
			break;
		}
	}

	if( !$setos_max ){
		return false;
	}

?>
	<section id="wall">
		<div class="headerimage slider" data-interval="<?php echo $setos_interval; ?>">

<?php
	// sort randam
	$setos_html = '';
	$setos_start = mt_rand( 1, $setos_max );
	for( $setos_count = 1; $setos_count <= $setos_max; $setos_count++ ) {
			$setos_class = '';
			if( $setos_start == $setos_count ){
				$setos_class = ' start active';
			}

			$setos_html .= '<div class="slideitem' .$setos_class .'" id="slideitem_' .$setos_count .'">';
			$setos_html .= '<div class="fixedimage" style="background-image: url(' .$setos_slides[ $setos_count -1 ][ 'image' ] .')"></div>';
			$setos_html .= '<div class="caption">';
			$setos_html .= '<p><strong>' .$setos_slides[ $setos_count -1 ][ 'title' ] .'</strong><span>' .$setos_slides[ $setos_count -1 ][ 'description' ] .'</span></p>';
			if( ! empty( $setos_slides[ $setos_count -1 ][ 'link' ] )){
				$setos_html .= '<a href="' .$setos_slides[ $setos_count -1 ][ 'link' ] .'">' .__( 'More', 'setos' ) .'</a>';
			}
			$setos_html .= '</div>';
			$setos_html .= '</div>';
	}

	echo $setos_html;
?>
		</div>
	</section>

<?php
	return true;
}