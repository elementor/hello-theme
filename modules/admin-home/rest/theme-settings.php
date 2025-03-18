<?php

namespace HelloTheme\Modules\AdminHome\Rest;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use HelloTheme\Includes\Utils;
use HelloTheme\Modules\Settings\Components\Settings_Controller;
use WP_REST_Server;

class Theme_Settings extends Rest_Base {

	public function register_routes() {
		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/theme-settings',
			[
				'methods' => WP_REST_Server::READABLE,
				'callback' => [ $this, 'get_theme_settings' ],
				'permission_callback' => [ $this, 'permission_callback' ],
			]
		);

		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/theme-settings',
			[
				'methods' => WP_REST_Server::EDITABLE,
				'callback' => [ $this, 'set_theme_settings' ],
				'permission_callback' => [ $this, 'permission_callback' ],
			]
		);
	}

	public function get_theme_settings() {
		return rest_ensure_response(
			[
				'settings' => Settings_Controller::get_settings(),
				'hello_plus_active' => Utils::is_hello_plus_active(),
			]
		);
	}

	public function set_theme_settings( \WP_REST_Request $request ) {
		$settings = $request->get_param( 'settings' );

		if ( ! is_array( $settings ) ) {
			return new \WP_Error(
				'invalid_settings',
				esc_html__( 'Settings must be an array', 'hello-elementor' ),
				[ 'status' => 400 ]
			);
		}

		$current_settings = Settings_Controller::get_settings();
		$new_settings = array_merge( $current_settings, $settings );

		update_option( Settings_Controller::SETTINGS_META_KEY, $new_settings );

		return rest_ensure_response( [ 'settings' => $new_settings ] );
	}
}
