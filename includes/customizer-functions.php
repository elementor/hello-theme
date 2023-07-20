<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Customizer controls for Hello Elementor theme.
 *
 * @return void
 */
add_action( 'customize_register', 'hello_customizer_register' );
function hello_customizer_register( $wp_customize ) {

	// Theme settings section

	require get_template_directory() . '/includes/customizer/elementor-upsell.php';

	$wp_customize->add_section(
		'hello_theme_options',
		[
			'title' => esc_html__( 'Theme Settings', 'hello-elementor' ),
			'description' => esc_html__( 'Customize your Hello Elementor theme settings.', 'hello-elementor' ),
			'description_hidden' => false,
			'capability' => 'edit_theme_options',
		]
	);

	// Description meta tag

	$wp_customize->add_setting(
		'hello_elementor_description_meta_tag',
		[
			'sanitize_callback' => false,
			'transport' => 'refresh',
		]
	);

	$wp_customize->add_control(
		'hello_elementor_description_meta_tag_control',
		[
			'label' => esc_html__( 'Enable description meta tag', 'hello-elementor' ),
			'default' => true,
			'type' => 'checkbox',
			'section' => 'hello_theme_options',
			'settings' => 'hello_elementor_description_meta_tag',
		]
	);

	// Header & Footer promotion

	$wp_customize->add_setting(
		'hello-elementor-header-footer',
		[
			'sanitize_callback' => false,
			'transport' => 'refresh',
		]
	);

	$wp_customize->add_control(
		new HelloElementor\Includes\Customizer\Elementor_Upsell(
			$wp_customize,
			'hello-elementor-header-footer',
			[
				'section' => 'hello_theme_options',
				'priority' => 20,
			]
		)
	);
}


/**
 * Enqueue Customiser CSS
 *
 * @return string HTML to use in the customizer panel
 */
add_action( 'admin_enqueue_scripts', 'hello_customizer_print_styles' );
function hello_customizer_print_styles() {

	$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style(
		'hello-elementor-customizer',
		get_template_directory_uri() . '/customizer' . $min_suffix . '.css',
		[],
		HELLO_ELEMENTOR_VERSION
	);
}
