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

// Remove WP Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Enable custom settings in WP Customizer
include( 'customizer_settings.php' );
include( 'customizer_scripts.php' );

// Custom admin functions
include( 'custom_admin_functions.php' );

// Declare additional theme styles & scripts here
add_action( 'wp_enqueue_scripts', 'custom_hello_theme_scripts' );
function custom_hello_theme_scripts() {
	// additional theme styles & scripts here
}

function custom_hello_theme_setup() {
  add_image_size( 'login-logo', 300, 100 ); // max width 300px and max height 100
  add_image_size( 'content-wide-thumb', 1200, 2000 ); // max width 1200px and max height 2000px
  add_image_size( 'single-post-thumb', 600, 600 ); // max width 600px and max height 600px
}
add_action( 'after_setup_theme', 'custom_hello_theme_setup' );

// Gravity form notification settings
add_filter( 'gform_notification', 'change_notification_email', 10, 3 );
function change_notification_email( $notification, $form, $entry ) {
	if ( $notification['to'] == '{admin_email}' ) {
		$notification['subject'] .= " on " . get_bloginfo('name');
	}
	return $notification;
}

// Enable Gravity form field label visibility setting
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// Display current year in front-end
add_shortcode( 'year', 'year_shortcode' );
function year_shortcode() {
	$year = date('Y');
	return $year;
}

// Theme update checker
include( 'includes/plugin-update-checker-master/plugin-update-checker.php' );
$serverUrl = 'http://zoro.com.au';
$customThemeUpdateChecker = Puc_v4_Factory::buildUpdateChecker( $serverUrl .'/theme_updater.json', __FILE__, 'elementor-hello-theme-master-child' );
