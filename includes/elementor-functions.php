<?php
/**
 * Elementor integration and kit settings helpers.
 *
 * @package Hello420
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Hello420Theme\Includes\Settings\Settings_Footer;
use Hello420Theme\Includes\Settings\Settings_Header;

add_action( 'elementor/init', 'hello420_settings_init' );

/**
 * Safe accessor for the Elementor plugin instance.
 *
 * Returns null when Elementor is not available yet.
 */
function hello420_elementor_plugin() {
	if ( ! class_exists( '\\Elementor\\Plugin' ) ) {
		return null;
	}

	// Elementor stores the singleton on a static property in most versions.
	$plugin = \Elementor\Plugin::$instance ?? null;
	if ( is_object( $plugin ) ) {
		return $plugin;
	}

	// Fallback for versions that rely on ::instance().
	if ( method_exists( '\\Elementor\\Plugin', 'instance' ) ) {
		try {
			$plugin = \Elementor\Plugin::instance();
			return is_object( $plugin ) ? $plugin : null;
		} catch ( \Throwable $e ) {
			return null;
		}
	}

	return null;
}


/**
 * Register theme tabs in Elementor Site Settings.
 */
function hello420_settings_init(): void {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		return;
	}

	$plugin = hello420_elementor_plugin();
	if ( ! $plugin ) {
		return;
	}

	// Tabs for header/footer theme styling.
	add_filter( 'elementor/kit/register_tabs', 'hello420_register_elementor_tabs' );

	// Elementor experiment flag (guarded for version compatibility).
	$experiments = $plugin->experiments ?? null;
	if ( is_object( $experiments ) && method_exists( $experiments, 'add_feature' ) ) {
		$experiments->add_feature(
			[
				'name'        => 'hello420-header-footer',
				'title'       => 'Hello 420 – Header & Footer',
				'description' => 'Enables Hello 420 Header & Footer style controls inside Elementor Site Settings.',
				'tags'        => [ 'Hello 420' ],
			]
		);
	}
}

function hello420_register_elementor_tabs( $tabs ) {
	if ( ! hello420_display_header_footer() ) {
		return $tabs;
	}

	$tabs['hello-settings-header'] = Settings_Header::class;
	$tabs['hello-settings-footer'] = Settings_Footer::class;

	return $tabs;
}

/**
 * Cached kit settings.
 */
function hello420_get_setting( string $setting_id ) {
	static $hello420_settings = [];
	$return = '';

	$plugin = hello420_elementor_plugin();
	if ( ! $plugin ) {
		return '';
	}

	if ( ! isset( $hello420_settings['kit_settings'] ) ) {
		$kit_settings = [];
		$kits_manager = $plugin->kits_manager ?? null;
		if ( is_object( $kits_manager ) && method_exists( $kits_manager, 'get_active_kit' ) ) {
			$kit = $kits_manager->get_active_kit();
			$kit_settings = $kit ? $kit->get_settings() : [];
		}
		$hello420_settings['kit_settings'] = is_array( $kit_settings ) ? $kit_settings : [];
	}

	if ( isset( $hello420_settings['kit_settings'][ $setting_id ] ) ) {
		$return = $hello420_settings['kit_settings'][ $setting_id ];
	}

	return apply_filters( 'hello420_' . $setting_id, $return );
}

function hello420_get_show_or_hide_value( string $setting_id ): string {
	return ( 'yes' === hello420_get_setting( $setting_id ) ? 'show' : 'hide' );
}

/**
 * Convenience wrapper used by template parts.
 */
function hello420_show_or_hide( string $setting_id ): string {
	return hello420_get_show_or_hide_value( $setting_id );
}

function hello420_get_header_display(): bool {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		return true;
	}

	return ( 'yes' === hello420_get_setting( 'hello_header_logo_display' ) )
		|| ( 'yes' === hello420_get_setting( 'hello_header_tagline_display' ) )
		|| ( 'yes' === hello420_get_setting( 'hello_header_menu_display' ) );
}

function hello420_get_footer_display(): bool {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		return true;
	}

	return ( 'yes' === hello420_get_setting( 'hello_footer_logo_display' ) )
		|| ( 'yes' === hello420_get_setting( 'hello_footer_tagline_display' ) )
		|| ( 'yes' === hello420_get_setting( 'hello_footer_menu_display' ) )
		|| ( 'yes' === hello420_get_setting( 'hello_footer_copyright_display' ) );
}

function hello420_get_header_layout_class(): string {
	$header_layout = hello420_get_setting( 'hello_header_layout' );

	if ( ! $header_layout ) {
		return 'default';
	}

	return $header_layout;
}

function hello420_get_header_width_class(): string {
	$header_width = hello420_get_setting( 'hello_header_width' );

	if ( ! $header_width ) {
		return 'default';
	}

	return $header_width;
}

function hello420_get_menu_dropdown_class(): string {
	$header_menu_dropdown = hello420_get_setting( 'hello_header_menu_dropdown' );

	if ( ! $header_menu_dropdown ) {
		return 'default';
	}

	return $header_menu_dropdown;
}

function hello420_get_header_menu_layout_class(): string {
	$hello_header_menu_layout = hello420_get_setting( 'hello_header_menu_layout' );

	if ( ! $hello_header_menu_layout ) {
		return 'default';
	}

	return $hello_header_menu_layout;
}

function hello420_get_header_container_class(): string {
	$classes = [
		'site-header',
		'hello-header',
		'hello-header-' . hello420_get_header_layout_class(),
		'hello-header-width-' . hello420_get_header_width_class(),
		'hello-header-menu-layout-' . hello420_get_header_menu_layout_class(),
		'hello-header-menu-dropdown-' . hello420_get_menu_dropdown_class(),
		'hello-header-logo-' . hello420_get_show_or_hide_value( 'hello_header_logo_display' ),
		'hello-header-tagline-' . hello420_get_show_or_hide_value( 'hello_header_tagline_display' ),
		'hello-header-menu-' . hello420_get_show_or_hide_value( 'hello_header_menu_display' ),
	];

	return implode( ' ', array_filter( $classes ) );
}

function hello420_get_footer_layout_class(): string {
	$footer_layout = hello420_get_setting( 'hello_footer_layout' );

	if ( ! $footer_layout ) {
		return 'default';
	}

	return $footer_layout;
}

function hello420_get_footer_width_class(): string {
	$footer_width = hello420_get_setting( 'hello_footer_width' );

	if ( ! $footer_width ) {
		return 'default';
	}

	return $footer_width;
}

function hello420_get_footer_container_class(): string {
	$classes = [
		'site-footer',
		'hello-footer',
		'hello-footer-' . hello420_get_footer_layout_class(),
		'hello-footer-width-' . hello420_get_footer_width_class(),
		'hello-footer-logo-' . hello420_get_show_or_hide_value( 'hello_footer_logo_display' ),
		'hello-footer-tagline-' . hello420_get_show_or_hide_value( 'hello_footer_tagline_display' ),
		'hello-footer-menu-' . hello420_get_show_or_hide_value( 'hello_footer_menu_display' ),
		'hello-footer-copyright-' . hello420_get_show_or_hide_value( 'hello_footer_copyright_display' ),
	];

	return implode( ' ', array_filter( $classes ) );
}

function hello420_get_footer_copyright_text(): string {
	if ( hello420_get_setting( 'hello_footer_copyright_display' ) && '' !== hello420_get_setting( 'hello_footer_copyright_text' ) ) {
		return (string) hello420_get_setting( 'hello_footer_copyright_text' );
	}

	return '';
}

/**
 * Elementor Editor script.
 */
function hello420_elementor_editor_script(): void {
	wp_enqueue_script(
		'hello420-editor',
		HELLO420_SCRIPTS_URL . 'hello-editor.js',
		[ 'wp-hooks' ],
		HELLO420_VERSION,
		true
	);

	wp_enqueue_style(
		'hello420-editor',
		HELLO420_STYLE_URL . 'editor.css',
		[],
		HELLO420_VERSION
	);
}
add_action( 'elementor/editor/before_enqueue_scripts', 'hello420_elementor_editor_script' );

function hello420_elementor_preview_style(): void {
	wp_enqueue_script(
		'hello420-frontend',
		HELLO420_SCRIPTS_URL . 'hello-frontend.js',
		[ 'wp-hooks' ],
		HELLO420_VERSION,
		true
	);
}
add_action( 'elementor/preview/enqueue_styles', 'hello420_elementor_preview_style' );

/**
 * Whether the Hello 420 Header/Footer experiment is active.
 */
function hello420_header_footer_experiment_active(): bool {
	$plugin = hello420_elementor_plugin();
	if ( ! $plugin ) {
		return false;
	}

	$experiments = $plugin->experiments ?? null;
	if ( ! is_object( $experiments ) ) {
		return false;
	}

	if ( ! method_exists( $experiments, 'is_feature_active' ) ) {
		return false;
	}

	return (bool) $experiments->is_feature_active( 'hello420-header-footer' );
}
