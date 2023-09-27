<?php

namespace HelloElementor\Includes\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Settings_Panel {

	public $menu_hook = '';

	public $settings_group = 'hello_elementor_settings';

	public function __construct() {

		add_action( 'admin_menu', [ $this, 'register_settings_page' ], 10 );
		add_action( 'init', [ $this, 'register_settings' ], 10 );

		$this->render_tweaks();

	}

	public function register_settings_page() {

		$this->menu_hook = add_theme_page(
			esc_html__( 'Hello Theme Settings', 'hello-elementor' ),
			esc_html__( 'Theme Settings', 'hello-elementor' ),
			'manage_options',
			'hello_elementor_settings',
			[ $this, 'render_settings_panel' ]
		);

		add_action( 'load-' . $this->menu_hook, function() {
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ], 10 );
		} );

	}

	public function render_settings_panel() {
		?>
		<div id="hello-elementor-settings"></div>
		<?php
	}

	public function register_settings() {

		/* Theme features */

		register_setting(
			$this->settings_group,
			$this->settings_group . '_description_meta_tag',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_skip_link',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_page_title',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		/* Page metadata */

		register_setting(
			$this->settings_group,
			$this->settings_group . '_generator',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_shortlink',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_wlw',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_rsd',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_oembed',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_wp_sitemap',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_post_prev_next',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		/* RSS Feeds */

		register_setting(
			$this->settings_group,
			$this->settings_group . '_site_rss',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_comments_rss',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_post_comments_rss',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		/* Scripts & styles */

		register_setting(
			$this->settings_group,
			$this->settings_group . '_emoji',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_jquery_migrate',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_oembed_script',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

		register_setting(
			$this->settings_group,
			$this->settings_group . '_gutenberg',
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);

	}

	public function enqueue_admin_scripts() {

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

	public function render_tweaks() {

		/* Theme features */

		$option = get_option( $this->settings_group . '_description_meta_tag' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );
		}

		$option = get_option( $this->settings_group . '_skip_link' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			add_filter( 'hello_elementor_enable_skip_link', '__return_false' );
		}

		$option = get_option( $this->settings_group . '_page_title' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			add_filter( 'hello_elementor_page_title', '__return_false' );
		}

		/* Page metadata */

		$option = get_option( $this->settings_group . '_generator' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'wp_generator' );
		}

		$option = get_option( $this->settings_group . '_shortlink' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		}

		$option = get_option( $this->settings_group . '_wlw' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'wlwmanifest_link' );
		}

		$option = get_option( $this->settings_group . '_rsd' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'rsd_link' );
		}

		$option = get_option( $this->settings_group . '_oembed' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		}

		$option = get_option( $this->settings_group . '_wp_sitemap' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			add_filter( 'use_block_editor_for_post', '__return_false', 10 );
		}

		$option = get_option( $this->settings_group . '_post_prev_next' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
		}

		/* RSS Feeds */

		$option = get_option( $this->settings_group . '_site_rss' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'feed_links', 2 );
			remove_action( 'wp_head', 'feed_links_extra', 3 );
		}

		$option = get_option( $this->settings_group . '_comments_rss' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			add_filter( 'feed_links_show_comments_feed', '__return_false' );
		}

		$option = get_option( $this->settings_group . '_post_comments_rss' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			add_filter( 'feed_links_show_posts_feed', '__return_false' );
		}

		/* Scripts & styles */

		$option = get_option( $this->settings_group . '_emoji' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'wp_print_styles', 'print_emoji_styles' ); // Up to WP 6.4
			remove_action( 'wp_print_styles', 'wp_enqueue_emoji_styles' ); // WP 6.4 and above
		}

		$option = get_option( $this->settings_group . '_jquery_migrate' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			add_action( 'wp_enqueue_scripts', function() {
				wp_deregister_script('jquery-migrate');
			}, 99 );
		}

		$option = get_option( $this->settings_group . '_oembed_script' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			remove_action( 'wp_head', 'wp_oembed_add_host_js' );
			add_action( 'wp_enqueue_scripts', function() {
				wp_deregister_script('wp-embed');
			}, 99 );
		}

		$option = get_option( $this->settings_group . '_gutenberg' );
		if ( isset( $option ) && ( 'true' === $option ) ) {
			add_filter( 'use_block_editor_for_post', '__return_false', 10 );
			add_action( 'wp_enqueue_scripts', function() {
				wp_dequeue_style( 'wp-block-library' );
				wp_dequeue_style( 'wp-block-library-theme' );
				wp_dequeue_style( 'wc-block-style' );
				wp_dequeue_style( 'wc-blocks-style' );
			}, 99 );
		}

	}

}
