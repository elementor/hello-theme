<?php

namespace Hello420Theme\Modules\AdminHome\Components;

use Hello420Theme\Includes\Script;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Settings_Controller {
	public const SETTINGS_FILTER_NAME = 'hello420-theme/settings';
	public const SETTINGS_PAGE_SLUG = 'hello420-settings';
	public const SETTING_PREFIX = 'hello420_settings';

	public const SETTINGS = [
		'DESCRIPTION_META_TAG' => '_description_meta_tag',
		'SKIP_LINK'            => '_skip_link',
		'HEADER_FOOTER'        => '_header_footer',
		'PAGE_TITLE'           => '_page_title',
		'HELLO_STYLE'          => '_hello_style',
		'HELLO_THEME'          => '_hello_theme',
	];

	public static function get_settings_mapping(): array {
		return array_map(
			static function ( $key ) {
				return self::SETTING_PREFIX . $key;
			},
			self::SETTINGS
		);
	}

	public static function get_settings(): array {
		$settings = array_map( static function ( $key ) {
			return self::get_option( $key ) === 'true';
		}, self::get_settings_mapping() );

		return apply_filters( self::SETTINGS_FILTER_NAME, $settings );
	}

	protected static function get_option( string $option_name, $default_value = false ) {
		$option = get_option( $option_name, $default_value );

		return apply_filters( self::SETTINGS_FILTER_NAME . '/' . $option_name, $option );
	}

	public function legacy_register_settings() {
		$this->register_settings();
		$this->apply_settings();
	}

	public function apply_setting( $setting, $tweak_callback ) {
		$option = get_option( $setting );

		if ( isset( $option ) && ( 'true' === $option ) && is_callable( $tweak_callback ) ) {
			$tweak_callback();
		}
	}

	public function apply_settings( $settings_group = self::SETTING_PREFIX, $settings = self::SETTINGS ) {
		$this->apply_setting(
			$settings_group . $settings['DESCRIPTION_META_TAG'],
			static function () {
				remove_action( 'wp_head', 'hello420_add_description_meta_tag' );
			}
		);

		$this->apply_setting(
			$settings_group . $settings['SKIP_LINK'],
			static function () {
				add_filter( 'hello420_enable_skip_link', '__return_false' );
			}
		);

		$this->apply_setting(
			$settings_group . $settings['HEADER_FOOTER'],
			static function () {
				add_filter( 'hello420_header_footer', '__return_false' );
			}
		);

		$this->apply_setting(
			$settings_group . $settings['PAGE_TITLE'],
			static function () {
				add_filter( 'hello420_page_title', '__return_false' );
			}
		);

		$this->apply_setting(
			$settings_group . $settings['HELLO_STYLE'],
			static function () {
				add_filter( 'hello420_enqueue_style', '__return_false' );
			}
		);

		$this->apply_setting(
			$settings_group . $settings['HELLO_THEME'],
			static function () {
				add_filter( 'hello420_enqueue_theme_style', '__return_false' );
			}
		);
	}

	public function register_settings( $settings_group = self::SETTING_PREFIX, $settings = self::SETTINGS ) {
		foreach ( $settings as $setting_value ) {
			register_setting(
				$settings_group,
				$settings_group . $setting_value,
				[
					'default'      => '',
					'show_in_rest' => true,
					'type'         => 'string',
				]
			);
		}
	}

	public function enqueue_settings_scripts() {
		$screen = get_current_screen();

		if ( ! str_ends_with( $screen->id, '_page_' . self::SETTINGS_PAGE_SLUG ) ) {
			return;
		}

		$script = new Script(
			'hello420-settings',
			[ 'wp-element', 'wp-i18n', 'wp-api-fetch' ]
		);

		$script->enqueue();
	}

	public function register_settings_page( $parent_slug ): void {
		add_submenu_page(
			$parent_slug,
			esc_html__( 'Settings', 'hello420' ),
			esc_html__( 'Settings', 'hello420' ),
			'manage_options',
			self::SETTINGS_PAGE_SLUG,
			[ $this, 'render_settings_page' ]
		);
	}

	public function render_settings_page(): void {
		echo '<div id="hello420-admin-settings"></div>';
	}

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_settings_scripts' ] );
		add_action( 'hello420/admin-menu', [ $this, 'register_settings_page' ], 10, 1 );
	}
}
