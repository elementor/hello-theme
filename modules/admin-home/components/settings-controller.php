<?php

namespace HelloTheme\Modules\AdminHome\Components;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Settings_Controller {

	const SETTINGS_FILTER_NAME = 'hello-plus-theme/settings';
	const SETTINGS_PAGE_SLUG = 'hello-elementor-settings';

	public static function get_settings_mapping(): array {
		return [
			'DESCRIPTION_META_TAG' => 'hello_elementor_settings_description_meta_tag',
			'SKIP_LINK' => 'hello_elementor_settings_skip_link',
			'HEADER_FOOTER' => 'hello_elementor_settings_header_footer',
			'PAGE_TITLE' => 'hello_elementor_settings_page_title',
			'HELLO_STYLE' => 'hello_elementor_settings_hello_style',
			'HELLO_THEME' => 'hello_elementor_settings_hello_theme',
		];
	}

	public static function get_settings(): array {

		$settings = array_map( function ( $key ) {
			return self::get_option( $key );
		}, self::get_settings_mapping() );

		return apply_filters( self::SETTINGS_FILTER_NAME, $settings );
	}

	protected static function get_option( string $option_name, $default_value = false ) {
		$option = get_option( $option_name, $default_value );
		return apply_filters( self::SETTINGS_FILTER_NAME . '/' . $option_name, $option );
	}

	public function enqueue_hello_plus_settings_scripts() {
		$screen = get_current_screen();

		if ( 'hello_page_hello-elementor-settings' !== $screen->id ) {
			return;
		}

		$handle = 'hello-elementor-settings';
		$asset_path = HELLO_THEME_SCRIPTS_PATH . $handle . '.asset.php';
		$asset_url = HELLO_THEME_SCRIPTS_URL;

		if ( ! file_exists( $asset_path ) ) {
			throw new \Exception( 'You need to run `npm run build` for the "hello-elementor" first.' );
		}

		$script_asset = require $asset_path;

		$script_asset['dependencies'][] = 'wp-util';

		wp_enqueue_script(
			$handle,
			$asset_url . "$handle.js",
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		wp_set_script_translations( $handle, 'hello-elementor' );
	}

	public function register_settings_page( $parent_slug ): void {
		add_submenu_page(
			$parent_slug,
			__( 'Settings', 'hello-elementor' ),
			__( 'Settings', 'hello-elementor' ),
			'manage_options',
			self::SETTINGS_PAGE_SLUG,
			[ $this, 'render_settings_page' ]
		);
	}

	public function render_settings_page(): void {
		echo '<div id="ehe-admin-settings" data-path="' . esc_attr( HELLO_THEME_PATH ) . '"></div>';
	}

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_hello_plus_settings_scripts' ] );
		add_action( 'hello-plus-theme/admin-menu', [ $this, 'register_settings_page' ], 10, 1 );
	}
}
