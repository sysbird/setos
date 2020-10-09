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
	$GLOBALS['content_width'] = apply_filters( 'setos_content_width', 1000 );
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

    // toppage slider
	register_sidebar( array (
		'name'			=> 'SETOS トップページスライダー',
		'id'			=> 'widget-area-slider',
        'description'	=> '左にある[利用できるウィジェット ]より[画像]を選んでここに入れてください。画像には[リンク先]を設定することができます。画像は3-5枚が適当です',
        'before_widget'	=> '<div class="swiper-slide">',
        'after_widget'	=> '</div>',
    ) );

    // Widget Area for footer first column
	register_sidebar( array (
		'name'			=> __( 'SETOS フッター(左)', 'setos' ),
		'id'			=> 'widget-area-footer-left',
		'description'	=> __( 'Widget Area for footer first column', 'setos' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
		) );

	// Widget Area for footer center column
	register_sidebar( array (
		'name'			=> __( 'SETOS フッター(中央)', 'setos' ),
		'id'			=> 'widget-area-footer-center',
		'description'	=> __( 'Widget Area for footer center column', 'setos' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
		) );

	// Widget Area for footer last column
	register_sidebar( array (
		'name'			=> __( 'SETOS フッター(右)', 'setos' ),
		'id'			=> 'widget-area-footer-right',
		'description'	=> __( 'Widget Area for footer last column', 'setos' ),
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
	add_theme_support( 'editor-styles' );
	add_editor_style( 'editor-style.css' );

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

   // Add support for responsive embeds.
    add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'setos_setup' );

//////////////////////////////////////////////////////
// Add custom post type
function setos_init() {

	//	 add tags at page
	register_taxonomy_for_object_type('post_tag', 'page');

	// add post type books
	$labels = array(
		'name'		=> 'Books',
		'all_items'	=> 'Booksの一覧',
		);

	$args = array(
		'labels'			=> $labels,
		'supports'			=> array( 'title','editor', 'thumbnail', 'custom-fields' ),
		'public'			=> true,	// 公開するかどうが
		'show_ui'			=> true,	// メニューに表示するかどうか
		'menu_position'		=> 5,		// メニューの表示位置
		'has_archive'		=> true,	// アーカイブページの作成
		'show_in_rest' 		=> true,	// Blockeditor
		);

	register_post_type( 'books', $args );

	// add post type works
	$labels = array(
		'name'		=> 'Exhibition',
		'all_items'	=> 'Exhibitionの一覧',
		);

	$args = array(
		'labels'			=> $labels,
		'supports'			=> array( 'title','editor', 'thumbnail', 'custom-fields' ),
		'public'			=> true,	// 公開するかどうが
		'show_ui'			=> true,	// メニューに表示するかどうか
		'menu_position'		=> 5,		// メニューの表示位置
		'has_archive'		=> true,	// アーカイブページの作成
		'show_in_rest' 		=> true,	// Blockeditor
		);

	register_post_type( 'exhibition', $args );

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
		'show_in_rest' 		=> true,	// Blockeditor
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
         $query->set( 'date_query', array(
            array( 'column' => 'post_date_gmt',
                    'after' => '6 month ago' )));
    }
	else if ( $query->is_post_type_archive( 'essay' ) && $query->is_main_query() ) {
        $query->set( 'posts_per_page', 12 );        
    }
}
add_action( 'pre_get_posts', 'setos_home_query' );

//////////////////////////////////////////////////////
// Enqueue Scripts
function setos_scripts() {

	// fancybox
	wp_enqueue_style( 'setos-fancybox', get_stylesheet_directory_uri().'/js/fancybox/jquery.fancybox.min.css' );
	wp_enqueue_script( 'setos-fancybox', get_template_directory_uri() .'/js/fancybox/jquery.fancybox.min.js', array( 'jquery' ), '3.2.10' );

    // Swiper
    wp_enqueue_style( 'setos-swiper', get_template_directory_uri() .'/js/swiper/swiper.min.css', '', '5.4.5'  );
    wp_enqueue_script( 'setos-swiper', get_template_directory_uri() .'/js/swiper/swiper.min.js', array( 'jquery' ), '5.4.5' );

	// Google Fonts
	wp_enqueue_style( 'setos-google-font', '//fonts.googleapis.com/css?family=Open+Sans', false, null, 'all' );
	wp_enqueue_style( 'setos-google-font-ja', '//fonts.googleapis.com/earlyaccess/sawarabimincho.css', false, null, 'all' );

	// this
	wp_enqueue_script( 'setos', get_template_directory_uri() .'/js/setos.js', array( 'jquery', 'setos-fancybox', 'setos-swiper' ), '1.1' );
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
// Add hook content begin
function setos_content_header() {

	// bread crumb
	if( !is_home()){
		if(function_exists('bcn_display_list')){
			echo '<ul class="breadcrumb">';
			bcn_display_list();
			echo '</ul>';
		}
	}
}

//////////////////////////////////////////////////////
// Add hook content end
function setos_content_footer() {
}

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
// show login logo
function setos_login_head() {

	$url = get_stylesheet_directory_uri() .'/images/webclip.png';
	echo '<style type="text/css">.login h1 a { background-image:url(' .$url .'); height: 90px; width: 90px; background-size: 100% 100%;}</style>';
}
add_action('login_head', 'setos_login_head');

//////////////////////////////////////////////////////
// set login logo link url
function setos_login_logo_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'setos_login_logo_url' );

//////////////////////////////////////////////////////
// set favicon
function setos_favicon() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="' .get_stylesheet_directory_uri() .'/images/favicon.ico" />'. "\n";
	echo '<link rel="apple-touch-icon" href="' .get_stylesheet_directory_uri() .'/images/webclip.png" />'. "\n";
}
add_action( 'wp_head', 'setos_favicon' );

//////////////////////////////////////////////////////
// Check postdate Recently
function setos_is_recently() {
	if( strtotime( get_the_date('Y-m-d' )) < strtotime( '2006-01-01' )){
		return false;
	}

	return true;
}

//////////////////////////////////////////////////////
//   get translations post ID
function setos_get_translations_id( $id, $locales ) {
    $pid_loc = get_post_meta( $id, '_locale' ); 
    if (! @$pid_loc[0] ) return $id;
    if ($locales === $pid_loc[0]) {
        return $id; 
    } else {
        $transids = bogo_get_post_translations($id);
        foreach ($transids as $key => $value) {
            if ($locales === $key) return $value->ID;
        }
        
        $originaiids = get_post_meta( $id, '_original_post' ); 
        return $originaiids; 
    }
}