<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'admin_menu', 'hello_elementor_settings_page' );
add_action( 'init', 'hello_elementor_tweaks', 0 );

/**
 * Register theme settings page.
 */
function hello_elementor_settings_page() {

	$menu_hook = '';

	$menu_hook = add_theme_page(
		esc_html__( 'Hello Theme Settings', 'hello-elementor' ),
		esc_html__( 'Theme Settings', 'hello-elementor' ),
		'manage_options',
		'hello_elementor_settings',
		'hello_elementor_settings_page_render'
	);

	add_action( 'load-' . $menu_hook, function() {
		add_action( 'admin_enqueue_scripts', 'hello_elementor_settings_page_scripts', 10 );
	} );

}

/**
 * Register settings page scripts.
 */
function hello_elementor_settings_page_scripts() {

	$dir = get_template_directory() . '/assets/js';
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	$handle = 'hello-admin';
	$asset_path = "$dir/hello-admin$suffix.asset.php";
	$asset_url = get_template_directory_uri() . '/assets/js';
	if ( ! file_exists( $asset_path ) ) {
		throw new \Error( 'You need to run `npm run build` for the "hello-theme" first.' );
	}
	$script_asset = require( $asset_path );

	wp_enqueue_script(
		$handle,
		"$asset_url/$handle$suffix.js",
		$script_asset['dependencies'],
		$script_asset['version']
	);

	wp_set_script_translations( $handle, 'hello-elementor' );

	wp_enqueue_style(
		$handle,
		"$asset_url/$handle$suffix.css",
		[ 'wp-components' ],
		$script_asset['version']
	);

}

function hello_elementor_settings_page_render() {
	?>
	<div id="hello-elementor-settings"></div>
	<?php
}

/**
 * Theme tweaks & settings.
 */
function hello_elementor_tweaks() {
	hello_elementor_register_settings();
	hello_elementor_render_tweaks();
}

/**
 * Register theme settings.
 */
function hello_elementor_register_settings() {

	$settings_group = 'hello_elementor_settings';

	/* Theme features */

	register_setting(
		$settings_group,
		$settings_group . '_description_meta_tag',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_skip_link',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_page_title',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	/* Page metadata */

	register_setting(
		$settings_group,
		$settings_group . '_generator',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_shortlink',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_wlw',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_rsd',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_oembed',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_wp_sitemap',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_post_prev_next',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	/* RSS Feeds */

	register_setting(
		$settings_group,
		$settings_group . '_site_rss',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_comments_rss',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_post_comments_rss',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	/* Scripts & styles */

	register_setting(
		$settings_group,
		$settings_group . '_emoji',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_jquery_migrate',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_oembed_script',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_classic_theme_styles',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

	register_setting(
		$settings_group,
		$settings_group . '_gutenberg',
		[
			'default' => '',
			'show_in_rest' => true,
			'type' => 'string',
		]
	);

}

/**
 * Render theme tweaks.
 */
function hello_elementor_render_tweaks() {

	$settings_group = 'hello_elementor_settings';

	/* Theme features */

	$option = get_option( $settings_group . '_description_meta_tag' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );
	}

	$option = get_option( $settings_group . '_skip_link' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		add_filter( 'hello_elementor_enable_skip_link', '__return_false' );
	}

	$option = get_option( $settings_group . '_page_title' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		add_filter( 'hello_elementor_page_title', '__return_false' );
	}

	/* Page metadata */

	$option = get_option( $settings_group . '_generator' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'wp_generator' );
	}

	$option = get_option( $settings_group . '_shortlink' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	}

	$option = get_option( $settings_group . '_wlw' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'wlwmanifest_link' );
	}

	$option = get_option( $settings_group . '_rsd' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'rsd_link' );
	}

	$option = get_option( $settings_group . '_oembed' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	}

	$option = get_option( $settings_group . '_wp_sitemap' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		add_filter( 'use_block_editor_for_post', '__return_false', 10 );
	}

	$option = get_option( $settings_group . '_post_prev_next' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
	}

	/* RSS feeds */

	$option = get_option( $settings_group . '_site_rss' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
	}

	$option = get_option( $settings_group . '_comments_rss' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		add_filter( 'feed_links_show_comments_feed', '__return_false' );
	}

	$option = get_option( $settings_group . '_post_comments_rss' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		add_filter( 'feed_links_show_posts_feed', '__return_false' );
	}

	/* Scripts & styles */

	$option = get_option( $settings_group . '_emoji' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' ); // Up to WP 6.4
		remove_action( 'wp_print_styles', 'wp_enqueue_emoji_styles' ); // WP 6.4 and above
	}

	$option = get_option( $settings_group . '_jquery_migrate' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		add_action( 'wp_enqueue_scripts', function() {
			wp_deregister_script( 'jquery-migrate' );
		}, 99 );
	}

	$option = get_option( $settings_group . '_oembed_script' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		add_action( 'wp_enqueue_scripts', function() {
			wp_deregister_script( 'wp-embed' );
		}, 99 );
	}

	$option = get_option( $settings_group . '_classic_theme_styles' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		add_action( 'wp_enqueue_scripts', function() {
			wp_dequeue_style( 'classic-theme-styles' );
		}, 99 );
	}

	$option = get_option( $settings_group . '_gutenberg' );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		add_filter( 'use_block_editor_for_post', '__return_false', 10 );
		add_action( 'wp_enqueue_scripts', function() {
			// WordPress blocks styles
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			// WooCommerce blocks styles
			wp_dequeue_style( 'wc-block-style' );
			wp_dequeue_style( 'wc-blocks-style' );
			// Gutenberg inline styles
			wp_dequeue_style( 'global-styles' );
		}, 99 );
	}

}
