<?php

namespace HelloTheme\Modules\AdminHome\Rest;

use Elementor\WPNotificationsPackage\V110\Notifications as ThemeNotifications;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Whats_New extends Rest_Base {

	public function get_theme_notifications(): ThemeNotifications {
		static $notifications = null;

		if ( null === $notifications ) {
			require get_template_directory() . '/vendor/autoload.php';

			$notifications = new ThemeNotifications(
				'hello-elementor',
				HELLO_ELEMENTOR_VERSION,
				'hello-elementor'
			);
		}

		return $notifications;
	}

	public function get_notifications() {
		return $this->get_theme_notifications()->get_notifications_by_conditions();
	}

	public function register_routes() {
		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/whats-new',
			[
				'methods' => \WP_REST_Server::READABLE,
				'callback' => [ $this, 'get_notifications' ],
				'permission_callback' => [ $this, 'permission_callback' ],
			]
		);
	}
}
