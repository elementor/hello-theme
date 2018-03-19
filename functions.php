<?php // _e Theme

if ( ! defined( 'ABSPATH' ) ) { exit;
}

add_action( 'elementor/theme/register_locations', function( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
} );

// Set up theme support
function _e_setup() {
	add_theme_support( 'custom-logo', array(
		'height' => 70,
		'width' => 350,
		'flex-height' => true,
		'flex-width' => true,
	) );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
	) );

	load_theme_textdomain( '_e', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', '_e_setup' );

function _e_scripts() {
	// Theme stylesheet.
	wp_enqueue_style( '_e-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', '_e_scripts' );

// Remove WP Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove WP Embed
function _e_deregister_scripts() {
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', '_e_deregister_scripts' );
