<?php
/**
 * Theme functions and definitions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $content_width ) ) {
	$content_width = 800; // pixels
}

/*
 * Set up theme support
 */
if ( ! function_exists( 'hello_elementor_theme_setup' ) ) {
	function hello_elementor_theme_setup() {
		if ( apply_filters( 'hello_elementor_theme_load_textdomain', true ) ) {
			load_theme_textdomain( 'elementor-hello-theme', get_template_directory() . '/languages' );
		}

		if ( apply_filters( 'hello_elementor_theme_register_menus', true ) ) {
			register_nav_menus( array( 'menu-1' => __( 'Primary', 'hello-elementor' ) ) );
		}

		if ( apply_filters( 'hello_elementor_theme_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'custom-logo' );
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );
			add_theme_support( 'custom-logo', array(
				'height' => 100,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			) );

			/*
			 * Editor Style
			 */
			add_editor_style( 'editor-style.css' );

			/*
			 * WooCommerce
			 */
			if ( apply_filters( 'hello_elementor_theme_add_woocommerce_support', true ) ) {
				// WooCommerce in general:
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0):
				// zoom:
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox:
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe:
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_theme_setup' );

/*
 * Theme Scripts & Styles
 */
if ( ! function_exists( 'hello_elementor_theme_scripts_styles' ) ) {
	function hello_elementor_theme_scripts_styles() {
		if ( apply_filters( 'hello_elementor_theme_enqueue_style', true ) ) {
			wp_enqueue_style( 'elementor-hello-theme-style', get_stylesheet_uri() );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_theme_scripts_styles' );

/*
 * Register Elementor Locations
 */
if ( ! function_exists( 'hello_elementor_theme_register_elementor_locations' ) ) {
	function hello_elementor_theme_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_theme_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_theme_register_elementor_locations' );
