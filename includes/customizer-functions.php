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
			'description' => esc_html__( 'Customize your Hello theme settings.', 'hello-elementor' ),
			'capability' => 'edit_theme_options',
		]
	);

	// Description meta tag

	$wp_customize->add_setting(
		'description_meta_tag',
		[
			'type' => 'theme_mod',
			'default' => 'off',
			'transport' => 'postMessage',
			'capability' => 'edit_theme_options',
		]
	);

	$wp_customize->add_control(
		'description_meta_tag',
		[
			'label' => esc_html__( 'Description meta tag', 'hello-elementor' ),
			'description' => esc_html__( 'Meta tag in the `<head>` containing the post/page excerpt.', 'hello-elementor' ),
			'type' => 'radio',
			'choices' => [
				'on' => esc_html__( 'Enable', 'hello-elementor' ),
				'off' => esc_html__( 'Disable', 'hello-elementor' ),
			],
			'section' => 'hello_elementor',
			'settings' => 'description_meta_tag',
		]
	);

	// Skip Links

	$wp_customize->add_setting(
		'skip_link',
		[
			'type' => 'theme_mod',
			'default' => 'on',
			'transport' => 'postMessage',
			'capability' => 'edit_theme_options',
		]
	);

	$wp_customize->add_control(
		'skip_link',
		[
			'label' => esc_html__( 'Skip link', 'hello-elementor' ),
			'description' => esc_html__( 'A link to the main content used by screen-reader users.', 'hello-elementor' ),
			'type' => 'radio',
			'choices' => [
				'on' => esc_html__( 'Enable', 'hello-elementor' ),
				'off' => esc_html__( 'Disable', 'hello-elementor' ),
			],
			'section' => 'hello_elementor',
			'settings' => 'skip_link',
		]
	);

	// Page titles

	$wp_customize->add_setting(
		'page_title',
		[
			'type' => 'theme_mod',
			'default' => 'on',
			'capability' => 'edit_theme_options',
		]
	);

	$wp_customize->add_control(
		'page_title',
		[
			'label' => esc_html__( 'Page title', 'hello-elementor' ),
			'description' => esc_html__( 'A section above the content contaning the `<h1>` heading of the page.', 'hello-elementor' ),
			'type' => 'radio',
			'choices' => [
				'on' => esc_html__( 'Enable', 'hello-elementor' ),
				'off' => esc_html__( 'Disable', 'hello-elementor' ),
			],
			'section' => 'hello_elementor',
			'settings' => 'page_title',
		]
	);

	// Header & Footer promotion

	$wp_customize->add_setting(
		'hello_elementor_header_footer',
		[]
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
