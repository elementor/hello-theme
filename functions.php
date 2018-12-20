<?php
/**
 * Elementor Hello Theme functions and definitions
 *
 * @link http://elementor.com
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Elementor Hello Theme requires WordPress 4.7 or later.
 */
function elementor_hello_theme_switch_theme( $oldtheme_name, $oldtheme ) {
	$missing_dependencies = false;

	if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
		$missing_dependencies = true;
	}

	if ( ! $missing_dependencies ) {
		return true;
	}
	add_action( 'admin_notices', 'elementor_hello_theme_switch_admin_notice' );

	// Switch back to previous theme
	switch_theme( $oldtheme->stylesheet );

	return false;
}
add_action( 'after_switch_theme', 'elementor_hello_theme_switch_theme', 10, 2 );

function elementor_hello_theme_switch_admin_notice() {
	$message = sprintf( __( 'Elementor Hello Theme requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'elementor-hello-theme' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/*
 * Set up theme support
 */
function elementor_hello_theme_setup() {
	if ( apply_filters( 'elementor_hello_theme_load_textdomain', true ) ) {
		load_theme_textdomain( 'elementor-hello-theme', get_template_directory() . '/languages' );
	}

	if ( apply_filters( 'elementor_hello_theme_register_menus', true ) ) {
		register_nav_menus( array( 'hello-menu-1' => __( 'Primary', 'elementor-hello-theme' ) ) );
	}

	if ( apply_filters( 'elementor_hello_theme_add_theme_support', true ) ) {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		add_theme_support( 'custom-logo', array(
			'height' => 100,
			'width' => 350,
			'flex-height' => true,
			'flex-width' => true,
		) );

		if ( apply_filters( 'elementor_hello_theme_add_woocommerce_support', true ) ) {
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}
}
add_action( 'after_setup_theme', 'elementor_hello_theme_setup' );

/*
 * Theme Scripts & Styles
 */
function elementor_hello_theme_scripts_styles() {
	if ( apply_filters( 'elementor_hello_theme_enqueue_style', true ) ) {
		wp_enqueue_style( 'elementor-hello-theme-style', get_stylesheet_uri() );
	}
}
add_action( 'wp_enqueue_scripts', 'elementor_hello_theme_scripts_styles' );

/*
 * Register Elementor Locations
 */
function elementor_hello_theme_register_elementor_locations( $elementor_theme_manager ) {
	if ( apply_filters( 'elementor_hello_theme_register_elementor_locations', true ) ) {
		$elementor_theme_manager->register_all_core_location();
	}
}
add_action( 'elementor/theme/register_locations', 'elementor_hello_theme_register_elementor_locations' );

/*
 * Remove WP Embed
 */
function elementor_hello_theme_deregister_scripts() {
	if ( apply_filters( 'elementor_hello_theme_deregister_scripts', true ) ) {
		wp_deregister_script( 'wp-embed' );
	}
}
add_action( 'wp_footer', 'elementor_hello_theme_deregister_scripts' );

/*
 * Set content width
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}

/*
 * Remove WP Emoji
 */
if ( apply_filters( 'elementor_hello_theme_remove_wp_actions', true ) ) {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
