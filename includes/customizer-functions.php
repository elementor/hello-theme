<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Customizer controls.
 *
 * @return void
 */
function hello_customizer_register( $wp_customize ) {
	require get_template_directory() . '/includes/customizer/customizer-action-links.php';

	$wp_customize->add_section(
		'hello-options',
		[
			'title' => esc_html__( 'Header & Footer', 'hello-elementor' ),
			'capability' => 'edit_theme_options',
		]
	);

	$wp_customize->add_setting(
		'hello-header-footer',
		[
			'sanitize_callback' => false,
			'transport' => 'refresh',
		]
	);

	$wp_customize->add_control(
		new HelloElementor\Includes\Customizer\Hello_Customizer_Action_Links(
			$wp_customize,
			'hello-header-footer',
			[
				'section' => 'hello-options',
				'priority' => 20,
			]
		)
	);
}
add_action( 'customize_register', 'hello_customizer_register' );

/**
 * Enqueue Customizer CSS.
 *
 * @return void
 */
function hello_customizer_styles() {

	$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style(
		'hello-elementor-customizer',
		get_template_directory_uri() . '/customizer' . $min_suffix . '.css',
		[],
		HELLO_ELEMENTOR_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'hello_customizer_styles' );
