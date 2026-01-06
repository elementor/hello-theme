<?php
/**
 * Customizer controls used only inside the Customizer preview.
 *
 * @package Hello420
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Customizer controls for header & footer.
 */
function hello420_customizer_register( $wp_customize ): void {
	require_once get_template_directory() . '/includes/customizer/customizer-action-links.php';

	$wp_customize->add_section(
		'hello420-options',
		[
			'title'      => esc_html__( 'Header & Footer', 'hello420' ),
			'capability' => 'edit_theme_options',
		]
	);

	$wp_customize->add_setting(
		'hello420-header-footer',
		[
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		new Hello420Theme\Includes\Customizer\Hello_Customizer_Action_Links(
			$wp_customize,
			'hello420-header-footer',
			[
				'section'  => 'hello420-options',
				'priority' => 20,
			]
		)
	);
}
add_action( 'customize_register', 'hello420_customizer_register' );

/**
 * Enqueue Customizer CSS.
 */
function hello420_customizer_styles(): void {
	wp_enqueue_style(
		'hello420-customizer',
		HELLO420_STYLE_URL . 'customizer.css',
		[],
		HELLO420_VERSION
	);
}
add_action( 'customize_controls_enqueue_scripts', 'hello420_customizer_styles' );
