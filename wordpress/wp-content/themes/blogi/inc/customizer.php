<?php
/**
 * Blogi Theme Customizer.
 *
 * @package Blogi
 */


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blogi_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->get_setting( 'header_textcolor' )->default = '#ffffff';
	$wp_customize->get_setting( 'background_color' )->default = '#f1f2f4';

	$wp_customize->get_control( 'header_textcolor' )->priority = 8;

	

	$wp_customize->add_setting( 'header_bg_color' , array(
		'default'     => '#263340',
		'transport'   => 'postMessage',
		'sanitize_callback'    => 'sanitize_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg_color_ctrl', array(
		'label'        => esc_html__( 'Header Background Color', 'blogi' ),
		'section'    => 'colors',
		'settings'   => 'header_bg_color',
		'priority'    => 9
	) ) );

	$wp_customize->add_section( 'social' , array(
		'title'      => esc_html__( 'Social', 'blogi' ),
		'priority'   => 30,
	) );

	$wp_customize->add_setting( 'social_facebook' , array(
		'default'     => '',
		'transport'   => 'postMessage',
		'sanitize_callback'    => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'social_facebook', array(
		'label'        => esc_html__( 'Facebook', 'blogi' ),
		'section'    => 'social',
		'settings'   => 'social_facebook',
		'priority'    => 9
	) );

	$wp_customize->add_setting( 'social_twitter' , array(
		'default'     => '',
		'transport'   => 'postMessage',
		'sanitize_callback'    => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'social_twitter', array(
		'label'        => esc_html__( 'Twitter', 'blogi' ),
		'section'    => 'social',
		'settings'   => 'social_twitter',
		'priority'    => 9
	) );

	$wp_customize->add_setting( 'social_google_plus' , array(
		'default'     => '',
		'transport'   => 'postMessage',
		'sanitize_callback'    => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'social_google_plus', array(
		'label'        => esc_html__( 'Google Plus', 'blogi' ),
		'section'    => 'social',
		'settings'   => 'social_google_plus',
		'priority'    => 9
	) );

	$wp_customize->add_section( 'footer' , array(
		'title'      => esc_html__( 'Footer', 'blogi' ),
		'priority'   => 30,
	) );

	$wp_customize->add_setting( 'footer_text' , array(
		'default'     => sprintf('<a href="%1$s">%2$s</a>', esc_url(__('https://wordpress.org/', 'blogi')), __('Proudly powered by WordPress', 'blogi')),
		'sanitize_callback'    => 'blogi_sanitize_html_text',
	) );

	$wp_customize->add_control( 'footer_text', array(
		'label'        => esc_html__( 'Footer Text', 'blogi' ),
		'section'    => 'footer',
		'settings'   => 'footer_text',
		'type'       => 'textarea',
		'priority'    => 9
	) );

	$wp_customize->add_setting( 'footer_love', array(
		'default'           => 1,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'footer_love', array(
		'label'    => esc_html__( 'Display some love by showing credit to us.', 'blogi' ),
		'section'  => 'footer',
		'settings' => 'footer_love',
		'type'     => 'checkbox',
	) );


}
add_action( 'customize_register', 'blogi_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blogi_customize_preview_js() {
	wp_enqueue_script( 'blogi_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'blogi_customize_preview_js' );



function blogi_sanitize_html_text( $value ) {
	$value = wp_kses_post( $value );

	return $value;
}