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
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

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

    register_taxonomy(
		'works-genre',
        'works',
        array(
            'hierarchical'		=> true,
            'label'				=> 'Worksのカテゴリー',
            'show_admin_column'	=> true,
            'show_ui'			=> true,
        )
    );

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
// set fefault taxonomy for works
function setosdefault_taxonomy_works() {
	echo '<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function($){
		// default check
		if ($("#works-catchecklist.categorychecklist input[type=checkbox]:checked").length == 0) {
		  $("#works-catchecklist.categorychecklist li:first-child input:first-child").attr("checked", "checked");
		}
	});
	//]]>
	</script>';
}
add_action( 'admin_print_footer_scripts', 'setosdefault_taxonomy_works' );

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
	else if ( !is_admin() && $query->is_post_type_archive( 'essay' ) && $query->is_main_query() ) {
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
	wp_enqueue_style( 'setos-google-font-ja', '//fonts.googleapis.com/earlyaccess/sawarabimincho.css', false, null, 'all' );

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
// photos slide in book
function setos_photos_slide () {
	$post_id = get_the_ID();

	// get relate post_id in Japanese post
	$post_id = setos_get_relate_post_id_in_japanese( $post_id );

	// photos in post
	$html = '';
	$html_cover = '';
	$pages = 0;
	$args = array( 'post_type'			=> 'attachment',
					'posts_per_page'	=> -1,
					'post_parent'		=> $post_id,
					'post_mime_type'	=> 'image',
					'orderby'			=> 'ID',
					'order'				=> 'ASC' );

	$images = get_posts( $args );
	if ( $images ) {
		foreach( $images as $image ){
			$pages++;
			$src = wp_get_attachment_url( $image->ID );
			$thumbnail = wp_get_attachment_image_src( $image->ID, 'large' );
			$html .= ' <a href="' .$src .'" data-fancybox="setos-photos-slide" data-caption="' .$image->post_title .'">page' .$pages .'</a>';
		}

		wp_reset_postdata();
	}

	// output
	if( $pages ){
		$html = '<div class="setos-photos-slide">' .$html .'<p><a href="#" class="setos-photos-slide-start">' .sprintf( __( 'show photos(%d pages)', 'setos' ), $pages ) .'</a></p></div>';
		echo $html;
	}
}

//////////////////////////////////////////////////////
//  get relate post_id in Japanese post
function setos_get_relate_post_id_in_japanese( $post_id ) {

	$locales = get_locale(); 
	$pid_loc = get_post_meta( $post_id, '_locale' );
	
	if ( 'ja' === $locales || ! @$pid_loc[0] ){
		// no locale or Japanese
		return $post_id;
	} 

    $translations = bogo_get_post_translations( $post_id );
	foreach ( $translations as $key => $value ) {
		if ( 'ja' === $key ){
			// post in Japanese
			return $value->ID;
		  }
    }

	// no post in Japanese
	return $post_id;
}

//////////////////////////////////////////////////////
// Bogo 
remove_shortcode( 'bogo', 'bogo_language_switcher' );
add_shortcode( 'bogo', 'setos_language_switcher' );
function setos_language_switcher( $args = '' ) {

	$args = wp_parse_args( $args, array(
		'echo' => false,
	) );

	$links = bogo_language_switcher_links( $args );
	$output = '';

	foreach ( $links as $link ) {
		$class = array();
		$class[] = bogo_language_tag( $link['locale'] );
		$class[] = bogo_lang_slug( $link['locale'] );

		if ( get_locale() == $link['locale'] ) {
			$class[] = 'current';
		}

		$class = implode( ' ', array_unique( $class ) );

		$label = $link['native_name'] ? $link['native_name'] : $link['title'];

		if( 'ja' === $link['locale']){
			$label = '日本語';
		}
		elseif( 'en_US' === $link['locale']){
			$label = 'English';
		}			

		$title = $link['title'];

		if ( empty( $link['href'] ) ) {
			$li = '<span>' .esc_html( $label ) .'</span>';
		} else {
			$li = sprintf(
				'<a href="%1$s">%2$s</a>',
				esc_url( $link['href'] ),
				esc_html( $label ) );
		}

		$li = sprintf( '<li class="%1$s">%2$s</li>', $class, $li );
		$output .= $li . "\n";
	}

	$output = '<ul class="bogo-language-switcher">' . $output . '</ul>' . "\n";

	$output = apply_filters( 'bogo_language_switcher', $output, $args );

	if ( $args['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
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

	<ul class="book-meta">
		<?php setos_the_custom_field( get_the_ID(), 'award', '<li><strong>' .__( 'Award', 'setos') .':</strong> ', '</li>' ); ?>
		<?php setos_the_custom_field( get_the_ID(), 'author', '<li><strong>' .__( 'Author', 'setos') .':</strong> ', '</li>' ); ?>
		<?php setos_the_custom_field( get_the_ID(), 'issuer', '<li><strong>' .__( 'Publisher', 'setos') .':</strong> ', '</li>' ); ?>
		<?php setos_the_custom_field( get_the_ID(), 'release', '<li><strong>' .__( 'Release', 'setos') .':</strong> ', '' ); ?>
		<?php setos_the_custom_field( get_the_ID(), 'price', '<li><strong>' .__( 'Price', 'setos') .':</strong> ', ' ' .__( 'yen', 'setos') .'</li>' ); ?>
		<?php setos_the_custom_field( get_the_ID(), 'size', '<li><strong>' .__( 'Size', 'setos') .':</strong> ', '</li>' ); ?>
	</ul>

<?php
}

//////////////////////////////////////////////////////
// Add hook content begin
function setos_content_header() {

	// bread crumb
	$setos_html = '';
/*
	if( !is_home()){
		if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) {
			$setos_html .= '<div class="bread_crumb">';
			$setos_html .= WP_SiteManager_bread_crumb::bread_crumb( array( 'echo'=>'false', 'home_label' => __( 'Home', 'setos' ), 'search_label' =>  __( 'Search Results: %s', 'setos' ), 'elm_class' => 'container' ));
			$setos_html .= '</div>';
		}
	}
*/
	echo $setos_html;
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
// Check postdate Recently
function setos_is_recently() {
	if( strtotime( get_the_date('Y-m-d' )) < strtotime( '2006-01-01' )){
		return false;
	}

	return true;
}

//////////////////////////////////////////////////////
// Theme Customizer
function setos_customize( $wp_customize ) {

	// Theme color Section
	$wp_customize->add_section( 'setos_theme_color', array(
		'title'		=> __( 'Theme Color', 'setos' ),
		'priority'	=> 999,
	) );

	$wp_customize->add_setting( 'setos_theme_color', array(
		'default'		=> 'dark',
		'sanitize_callback'	=> 'setos_sanitize_radiobutton',
	) );

	$wp_customize->add_control( 'setos_theme_color', array(
		'label'		=> __( 'Theme color', 'setos' ),
		'section'	=> 'setos_theme_color',
		'type'		=> 'radio',
		'settings'	=> 'setos_theme_color',
		'choices'	=> array(
					'dark'	=> __( 'dark', 'setos' ),
					'light'	=> __( 'light', 'setos' ),
					)
	) );
}
add_action( 'customize_register', 'setos_customize' );

//////////////////////////////////////////////////////
// Santize a checkbox
function setos_sanitize_radiobutton( $input ) {

	if ( $input === 'light' ) {
		return $input;
	} else {
		return 'dark';
	}
}

//////////////////////////////////////////////////////
// Header Slider
function setos_headerslider() {

	if (( !is_front_page())) {
		return false;
	}

	$setos_slides = array();
	$setos_max = 0;

	$headers = get_posts( array( 'post_type' => 'attachment', 'meta_key' => '_wp_attachment_is_custom_header', 'orderby' => 'title', 'nopaging' => true , 'order' => 'ASC') );

	if ( empty( $headers ) ){
		// one image
		$header_image = get_header_image();
		if( $header_image ){
			$setos_slides[ 0 ] = $header_image;
			$setos_max = 1;
		}
	}else{
		// many image
		foreach ( (array) $headers as $header ) {
			$setos_slides[ $setos_max ] = esc_url_raw( wp_get_attachment_url( $header->ID ) );
			$setos_max++;
			if( 5 == $setos_max ){
				break;
			}
		}
	}
			
	if( !$setos_max ){
		return;
	}

	$slider_class = '';
	if( 1 < $setos_max ){
		$slider_class = ' slider';
	}

	?>

	<section id="wall">
		<div class="headerimage <?php echo $slider_class ?>" data-interval="7000">

<?php
	$setos_html = '';
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
