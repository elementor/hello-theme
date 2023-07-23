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
		'hello_elementor',
		[
			'title' => esc_html__( 'Theme Settings', 'hello-elementor' ),
			'description' => esc_html__( 'Customize your Hello Elementor theme settings.', 'hello-elementor' ),
			'capability' => 'edit_theme_options',
		]
	);

	// Description meta tag

	$wp_customize->add_setting(
		'hello_elementor_disable_description_meta_tag',
		[
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'default' => '',
			'sanitize_callback' => 'hello_customizer_sanitize_checkbox',
		]
	);

	$wp_customize->add_control(
		'hello_elementor_disable_description_meta_tag',
		[
			'label' => esc_html__( 'Disable description meta tag', 'hello-elementor' ),
			'type' => 'checkbox',
			'section' => 'hello_elementor',
			'settings' => 'hello_elementor_disable_description_meta_tag',
		]
	);

	// Page titles

	$wp_customize->add_setting(
		'hello_elementor_disable_page_title',
		[
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'default' => '',
			'sanitize_callback' => 'hello_customizer_sanitize_checkbox',
		]
	);

	$wp_customize->add_control(
		'hello_elementor_disable_page_title',
		[
			'label' => esc_html__( 'Disable page title', 'hello-elementor' ),
			'type' => 'checkbox',
			'section' => 'hello_elementor',
			'settings' => 'hello_elementor_disable_page_title',
		]
	);

	// Header & Footer promotion

	$wp_customize->add_setting(
		'hello_elementor_header_footer',
		[
			'sanitize_callback' => false,
			'transport' => 'refresh',
		]
	);

	$wp_customize->add_control(
		new HelloElementor\Includes\Customizer\Elementor_Upsell(
			$wp_customize,
			'hello_elementor_header_footer',
			[
				'section' => 'hello_elementor',
				'priority' => 20,
			]
		)
	);
}

function hello_customizer_sanitize_checkbox( $checked ) {
	return $checked == '1' ? '1' : '';
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
