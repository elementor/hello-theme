<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'admin_menu', 'hello_elementor_settings_page' );
add_action( 'init', 'hello_elementor_tweak_settings', 0 );

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

/**
 * Render settings page wrapper element.
 */
function hello_elementor_settings_page_render() {
	?>
	<div id="hello-elementor-settings"></div>
	<?php
}

/**
 * Theme tweaks & settings.
 */
function hello_elementor_tweak_settings() {

	$settings_group = 'hello_elementor_settings';

	$settings = [
		/* Theme features */
		'_description_meta_tag',
		'_skip_link',
		'_page_title',
		/* Page metadata */
		'_generator',
		'_shortlink',
		'_wlw',
		'_rsd',
		'_oembed',
		'_wp_sitemap',
		'_post_prev_next',
		/* RSS Feeds */
		'_site_rss',
		'_comments_rss',
		'_post_comments_rss',
		/* Scripts & styles */
		'_emoji',
		'_jquery_migrate',
		'_oembed_script',
		'_classic_theme_styles',
		'_gutenberg',
		'_hello_style',
		'_hello_theme',
	];

	hello_elementor_register_settings( $settings_group, $settings );
	hello_elementor_render_tweaks( $settings_group );
}

/**
 * Register theme settings.
 */
function hello_elementor_register_settings( $settings_group, $settings ) {

	foreach ($settings as $setting) {
		register_setting(
			$settings_group,
			$settings_group . $setting,
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);
	}

}

/**
 * Run a tweek only if the user requested it.
 */
function hello_elementor_do_tweak( $setting, $tweak_callback ) {

	$option = get_option( $setting );
	if ( isset( $option ) && ( 'true' === $option ) ) {
		$tweak_callback();
	}

}

/**
 * Render theme tweaks.
 */
function hello_elementor_render_tweaks( $settings_group ) {

	/* Theme features */

	hello_elementor_do_tweak( $settings_group . '_description_meta_tag', function() {
		remove_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );
	} );

	hello_elementor_do_tweak( $settings_group . '_skip_link', function() {
		add_filter( 'hello_elementor_enable_skip_link', '__return_false' );
	} );

	hello_elementor_do_tweak( $settings_group . '_page_title', function() {
		add_filter( 'hello_elementor_page_title', '__return_false' );
	} );

	/* Page metadata */

	hello_elementor_do_tweak( $settings_group . '_generator', function() {
		remove_action( 'wp_head', 'wp_generator' );
	} );

	hello_elementor_do_tweak( $settings_group . '_shortlink', function() {
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	} );

	hello_elementor_do_tweak( $settings_group . '_wlw', function() {
		remove_action( 'wp_head', 'wlwmanifest_link' );
	} );

	hello_elementor_do_tweak( $settings_group . '_rsd', function() {
		remove_action( 'wp_head', 'rsd_link' );
	} );

	hello_elementor_do_tweak( $settings_group . '_oembed', function() {
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	} );

	hello_elementor_do_tweak( $settings_group . '_wp_sitemap', function() {
		add_filter( 'wp_sitemaps_enabled', '__return_false' );
	} );

	hello_elementor_do_tweak( $settings_group . '_post_prev_next', function() {
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
	} );

	/* RSS feeds */

	hello_elementor_do_tweak( $settings_group . '_site_rss', function() {
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
	} );

	hello_elementor_do_tweak( $settings_group . '_comments_rss', function() {
		add_filter( 'feed_links_show_comments_feed', '__return_false' );
	} );

	hello_elementor_do_tweak( $settings_group . '_post_comments_rss', function() {
		add_filter( 'feed_links_show_posts_feed', '__return_false' );
	} );

	/* Scripts & styles */

	hello_elementor_do_tweak( $settings_group . '_emoji', function() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' ); // Up to WP 6.4
		remove_action( 'wp_print_styles', 'wp_enqueue_emoji_styles' ); // WP 6.4 and above
	} );

	hello_elementor_do_tweak( $settings_group . '_jquery_migrate', function() {
		add_action( 'wp_enqueue_scripts', function() {
			wp_deregister_script( 'jquery-migrate' );
		}, 99 );
	} );

	hello_elementor_do_tweak( $settings_group . '_oembed_script', function() {
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		add_action( 'wp_enqueue_scripts', function() {
			wp_deregister_script( 'wp-embed' );
		}, 99 );
	} );

	hello_elementor_do_tweak( $settings_group . '_classic_theme_styles', function() {
		add_action( 'wp_enqueue_scripts', function() {
			wp_dequeue_style( 'classic-theme-styles' );
		}, 99 );
	} );

	hello_elementor_do_tweak( $settings_group . '_gutenberg', function() {
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
	} );

	hello_elementor_do_tweak( $settings_group . '_hello_style', function() {
		add_filter( 'hello_elementor_enqueue_style', '__return_false' );
	} );

	hello_elementor_do_tweak( $settings_group . '_hello_theme', function() {
		add_filter( 'hello_elementor_enqueue_theme_style', '__return_false' );
	} );

}
