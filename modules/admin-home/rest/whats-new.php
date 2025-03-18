<?php

namespace HelloTheme\Modules\AdminHome\Rest;

use HelloTheme\Modules\Theme\Module as Theme_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Whats_New extends Rest_Base {

	public function get_notifications() {
		$notificator = Theme_Module::instance()->get_component( 'Notificator' );
		return $notificator->get_notifications_by_conditions( true );
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
