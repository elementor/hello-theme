<?php

namespace HelloTheme\Includes;

use Elementor\App\App;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * class Utils
 **/
class Utils {

	public static function elementor(): \Elementor\Plugin {
		return \Elementor\Plugin::$instance;
	}

	public static function has_pro(): bool {
		return defined( 'ELEMENTOR_PRO_VERSION' );
	}

	public static function is_elementor_active(): bool {
		static $elementor_active = null;
		if ( null === $elementor_active ) {
			$elementor_active = defined( 'ELEMENTOR_VERSION' );
		}

		return $elementor_active;
	}

	public static function is_elementor_installed(): bool {
		static $elementor_installed = null;
		if ( null === $elementor_installed ) {
			$elementor_installed = file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' );
		}

		return $elementor_installed;
	}

	public static function get_theme_builder_slug(): string {
		if ( self::has_pro() ) {
			return App::PAGE_ID . '&ver=' . ELEMENTOR_VERSION . '#site-editor';
		}

		if ( self::is_elementor_active() ) {
			return App::PAGE_ID . '&ver=' . ELEMENTOR_VERSION . '#site-editor/promotion';
		}

		return '';
	}

	public static function get_theme_builder_url(): string {
		if ( self::has_pro() ) {
			return admin_url( 'admin.php?page=' . App::PAGE_ID . '&ver=' . ELEMENTOR_VERSION ) . '#site-editor';
		}

		if ( self::is_elementor_active() ) {
			return admin_url( 'admin.php?page=' . App::PAGE_ID . '&ver=' . ELEMENTOR_VERSION ) . '#site-editor/promotion';
		}

		return '';
	}

	public static function get_elementor_activation_link(): string {
		$plugin = 'elementor/elementor.php';

		$url = 'plugins.php?action=activate&plugin=' . $plugin . '&plugin_status=all';

		return add_query_arg( '_wpnonce', wp_create_nonce( 'activate-plugin_' . $plugin ), $url );
	}

	public static function get_ai_site_planner_url(): string {
		return 'https://planner.elementor.com/';
	}

	public static function get_plugin_install_url( $plugin_slug ): string {
		$action = 'install-plugin';

		$url = add_query_arg(
			[
				'action'   => $action,
				'plugin'   => $plugin_slug,
				'referrer' => 'hello-elementor',
			],
			admin_url( 'update.php' )
		);

		return add_query_arg( '_wpnonce', wp_create_nonce( $action . '_' . $plugin_slug ), $url );
	}
}
