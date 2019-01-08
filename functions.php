<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Set up theme support
function elementor_hello_theme_setup() {

	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'custom-logo', array(
		'height' => 70,
		'width' => 350,
		'flex-height' => true,
		'flex-width' => true,
	) );

	add_theme_support( 'woocommerce' );

	// Register wp_nav_menu() location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'elementor-hello-theme' ),
	) );

	load_theme_textdomain( 'elementor-hello-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'elementor_hello_theme_setup' );

// Theme Scripts & Styles
function elementor_hello_theme_scripts_styles() {
	wp_enqueue_style( 'elementor-hello-theme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'elementor_hello_theme_scripts_styles' );

// Register Elementor Locations
function elementor_hello_theme_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
};
add_action( 'elementor/theme/register_locations', 'elementor_hello_theme_register_elementor_locations' );

// Remove WP Embed
function elementor_hello_theme_deregister_scripts() {
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'elementor_hello_theme_deregister_scripts' );

// Header template
function elementor_hello_theme_header_template() {

	if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
		return;
	}

	get_template_part( 'template-parts/header' );

}
add_action( 'elementor_hello_theme_header', 'elementor_hello_theme_header_template' );

// Footer template
function elementor_hello_theme_footer_template() {

	if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'footer' ) ) {
		return;
	}

	get_template_part( 'template-parts/footer' );

}
add_action( 'elementor_hello_theme_footer', 'elementor_hello_theme_footer_template' );

// Google Tag Manager head including
function elementor_hello_theme_gtm_head() {

	if ( defined( 'WP_GTM' ) ) { ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo WP_GTM; ?>');</script>
<!-- End Google Tag Manager -->
	<?php }

}
add_action( 'wp_head', 'elementor_hello_theme_gtm_head', 1 );

// Google Tag Manager body including
function elementor_hello_theme_gtm_body() {

	if ( defined( 'WP_GTM' ) ) { ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo WP_GTM; ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<?php }

}
add_action( 'elementor_hello_theme_header', 'elementor_hello_theme_gtm_body', 1 );

// Remove WP Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );