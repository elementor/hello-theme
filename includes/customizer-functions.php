<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Customizer controls which add Elementor deeplinks
 *
 * @return void
 */
add_action( 'customize_register', 'hello_customizer_register' );
function hello_customizer_register( $wp_customize ) {
	require get_template_directory() . '/includes/customizer/elementor-upsell.php';

	$wp_customize->add_section(
		'hello_theme_options',
		[
			'title' => __( 'Header &amp; Footer', 'hello-elementor' ),
			'capability' => 'edit_theme_options',
		]
	);

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

function hello_customizer_custom_logo_button() {
	?>
	<script>
		jQuery( function( $ ) {
			function insertLogoButton( elementId ) {
				var button = $( '<a class="button button-primary create-logo-button" target="_blank" href="https://go.fiverr.com/visit/?bta=496327&brand=fiverrcpa&utm_campaign=SiteLogo&landingPage=https%3A%2F%2Fwww.fiverr.com%2Flogo-maker%2Felementor" />' )
					.text( '<?php echo esc_attr__( 'Create a Logo in Minutes', 'hello-elementor' ); ?>' ),
					description = $( '<div class="create-logo-desc" />' )
						.text( '<?php echo esc_attr__( 'Add a logo to display on your website, or create a professional logo with the Fiverr logo maker.', 'hello-elementor' ); ?>' );

				setTimeout( function() {
					$( elementId + ' .actions' ).prepend( button ).before( description );
				}, 10 );
			}

			wp.customize.bind( 'ready', function() {
				var logoThumbnail,
					controlId = 'custom_logo',
					logoControlId = '#customize-control-' + controlId;

				if ( wp.customize( controlId ) ) {
					wp.customize( controlId ).bind( 'change', function( to ) {
						if ( ! to ) {
							insertLogoButton( logoControlId );
						}
					} );

					logoThumbnail = $( logoControlId + ' .thumbnail' );
					if ( ! logoThumbnail.length ) {
						insertLogoButton( logoControlId );
					}
				}
			} );
		} );
	</script>
	<?php
}
add_action( 'customize_controls_print_scripts', 'hello_customizer_custom_logo_button' );
