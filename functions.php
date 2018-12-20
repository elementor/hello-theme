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

if ( ! isset( $content_width ) ) {
	$content_width = 800; /* pixels */
}

/*
 * Set up theme support
 */
if ( ! function_exists( 'elementor_hello_theme_setup' ) ) {
	function elementor_hello_theme_setup() {
		if ( apply_filters( 'elementor_hello_theme_load_textdomain', true ) ) {
			load_theme_textdomain( 'elementor-hello-theme', get_template_directory() . '/languages' );
		}

		if ( apply_filters( 'elementor_hello_theme_register_menus', true ) ) {
			register_nav_menus( array( 'menu-1' => __( 'Primary', 'elementor-hello-theme' ) ) );
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
}

/*
 * Theme Scripts & Styles
 */
if ( ! function_exists( 'elementor_hello_theme_scripts_styles' ) ) {
	function elementor_hello_theme_scripts_styles() {
		if ( apply_filters( 'elementor_hello_theme_enqueue_style', true ) ) {
			wp_enqueue_style( 'elementor-hello-theme-style', get_stylesheet_uri() );
		}
	}

	add_action( 'wp_enqueue_scripts', 'elementor_hello_theme_scripts_styles' );
}

/*
 * Register Elementor Locations
 */
if ( ! function_exists( 'elementor_hello_theme_register_elementor_locations' ) ) {
	function elementor_hello_theme_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'elementor_hello_theme_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}

	add_action( 'elementor/theme/register_locations', 'elementor_hello_theme_register_elementor_locations' );
}
