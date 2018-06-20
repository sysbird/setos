<?php
/**
 * setos Theme Customizer
 *
 * @package WordPress
 * @subpackage setos
 * @since setos 1.10
 */
//////////////////////////////////////////////////////
// Theme Customizer for Header Slider
function setos_customize_headerslider( $wp_customize ) {

	// preview
	for( $setos_count = 1; $setos_count <= 5; $setos_count++ ) {
		$wp_customize->selective_refresh->add_partial( 'slider_image_' .strval( $setos_count ),
			array( 'selector' => '#slideitem_' .strval( $setos_count ) . ' .fixedimage',
			));

		$wp_customize->selective_refresh->add_partial( 'slider_title_' .strval( $setos_count ),
			array( 'selector' => '#slideitem_' .strval( $setos_count ) . ' strong',
			));

		$wp_customize->selective_refresh->add_partial( 'slider_description_' .strval( $setos_count ),
			array( 'selector' => '#slideitem_' .strval( $setos_count ) . ' span',
			));

		$wp_customize->selective_refresh->add_partial( 'slider_link_' .strval( $setos_count ),
			array( 'selector' => '#slideitem_' .strval( $setos_count ) . ' a',
			));
	}

	$wp_customize->selective_refresh->add_partial( 'slide_interval',
		array( 'selector' => '.slide-interval',
		));

	// separation
	class setos_Info extends WP_Customize_Control {
		public $type = 'info';
		public $label = '';
		public function render_content() {
	?>

		<h4 style="font-size: 1.2em; margin-top:16.em; padding:0.8em 0; color:#000; background:#cbcbcb ;text-align:center; "><?php echo esc_html( $this->label ); ?></h4>
	<?php
		}
	}

	// slider section
	$wp_customize->add_section(
		'setos_slider',
		array(
			'title'		=> __('Header Slider', 'setos' ),
			'description'	=> __( 'You can add up to 5 images in the header slider. also you can add title, description, link URL for each image.', 'setos' ),
			'priority'	=> 61,
		));

	// use slider
	$wp_customize->add_setting( 'use_slider',
		array(
			'default'  => false,
			'sanitize_callback' => 'setos_sanitize_checkbox',
		));

	$wp_customize->add_control( 'use_slider',
		array(
			'label'		=> __( 'Use Header Slider', 'setos' ),
			'section'	=> 'setos_slider',
			'type'		=> 'checkbox',
			'settings'	=> 'use_slider',
		));

	// Interval
	$wp_customize->add_setting( 'slide_interval',
		array(
			'default'		=> 7000,
			'sanitize_callback'	=> 'absint',
			'transport'		=> 'postMessage'
		));

	$wp_customize->add_control( 'slide_interval',
		array(
			'label'		=> __( 'Slide Interval (1/1000 second)', 'setos' ),
			'section'	=> 'setos_slider',
			'type'		=> 'text',
			'settings'	=> 'slide_interval',
		));

	// Slider 1 - 5
	for( $setos_count = 1; $setos_count <= 5; $setos_count++ ) {

		// Label
		$wp_customize->add_setting( 'setos_options[info]',
			array(
				'type'			=> 'info_control',
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'esc_attr',
			));

		$setos_label = '';
		if( 1 == $setos_count ){
			$setos_label = __( '1st slide', 'setos' );
		}
		else if( 2 == $setos_count ){
			$setos_label = __( '2nd slide', 'setos' );
		}
		else if( 3 == $setos_count ){
			$setos_label = __( '3rd slide', 'setos' );
		}
		else if( 4 == $setos_count ){
			$setos_label = __( '4th slide', 'setos' );
		}
		else if( 5 == $setos_count ){
			$setos_label = __( '5th slide', 'setos' );
		}

		$wp_customize->add_control(
			new setos_Info( $wp_customize,
				's' .strval( $setos_count ),
				array(
					'label'		=> $setos_label,
					'section'	=> 'setos_slider',
					'settings'	=> 'setos_options[info]',
					'priority'	=> ( $setos_count *10 ),
				)));

		// Upload image
		$setos_default_text = '';
		if( 1 == $setos_count ){
			$setos_default_text = get_template_directory_uri() . '/images/header.jpg';
		}

		$wp_customize->add_setting( 'slider_image_' .strval( $setos_count ),
			array(
				'default'		=> $setos_default_text,
				'sanitize_callback'	=> 'esc_url_raw',
				'transport'		=> 'postMessage'
			));

			$wp_customize->add_control(
				new WP_Customize_Image_Control( $wp_customize, 'slider_image_' .strval( $setos_count ),
					array(
						'label'		=> __( 'Upload image', 'setos' ) .' ' .strval( $setos_count ),
						'type'		=> 'image',
						'section'	=> 'setos_slider',
						'settings'	=> 'slider_image_' .strval( $setos_count ),
						'priority'	=> ( $setos_count *10 ) + 1,
					)));

		// Title
		$setos_default_text = '';
		if( 1 == $setos_count ){
			$setos_default_text = __( 'Hello world!','setos' );
		}

		$wp_customize->add_setting( 'slider_title_' .strval( $setos_count ),
			array(
				'default'		=> $setos_default_text,
				'sanitize_callback'	=> 'setos_sanitize_text',
				'transport'		=> 'postMessage'
			));

		$wp_customize->add_control( 'slider_title_' .strval( $setos_count ),
			array(
				'label'		=> __( 'Title', 'setos' ) .' ' .strval( $setos_count ),
				'section'	=> 'setos_slider',
				'type'		=> 'text',
				'priority'	=> ( $setos_count *10 ) + 2
			));

		// Description
		$setos_default_text = '';
		if( 1 == $setos_count ){
			$setos_default_text = __( 'Begin your website.','setos' );
		}

		$wp_customize->add_setting( 'slider_description_' .strval( $setos_count ),
			array(
				'default'		=> $setos_default_text,
				'sanitize_callback'	=> 'setos_sanitize_text',
				'transport'		=> 'postMessage'
			));

		$wp_customize->add_control(
			'slider_description_' .strval( $setos_count ),
			array(
				'label'		=> __( 'Title', 'setos' ) .' ' .strval( $setos_count ),
				'section'	=> 'setos_slider',
				'type'		=> 'text',
				'priority'	=> ( $setos_count *10 ) + 3
			));

		// Link URL
		$setos_default_text = '';
		if( 1 == $setos_count ){
			$setos_default_text = '#';
		}

		$wp_customize->add_setting( 'slider_link_' .strval( $setos_count ),
			array(
				'default'		=> $setos_default_text,
				'sanitize_callback'	=> 'esc_url_raw',
				'transport'		=> 'postMessage'
			));

		$wp_customize->add_control(
			'slider_link_' .strval( $setos_count ),
			array(
				'label'		=> __( 'Link URL', 'setos' ) .' ' .strval( $setos_count ),
				'section'	=> 'setos_slider',
				'type'		=> 'url',
				'priority'	=> ( $setos_count *10 ) + 4
			));
	}
}
add_action( 'customize_register', 'setos_customize_headerslider' );
