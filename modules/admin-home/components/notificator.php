<?php
namespace HelloTheme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Notificator {
	private ?\Elementor\WPNotificationsPackage\V120\Notifications $notificator = null;

	public function get_notifications_by_conditions( $force_request = false ) {
		if ( null === $this->notificator ) {
			return [];
		}

		return $this->notificator->get_notifications_by_conditions( $force_request );
	}

	public function __construct() {
		if ( ! $this->ensure_notifications_class_loaded() ) {
			return;
		}

		$this->notificator = new \Elementor\WPNotificationsPackage\V120\Notifications( [
			'app_name' => 'hello-elementor',
			'app_version' => HELLO_ELEMENTOR_VERSION,
			'short_app_name' => 'hello-elementor',
			'app_data' => [
				'theme_name' => 'hello-elementor',
			],
		] );
	}

	private function ensure_notifications_class_loaded(): bool {
		if ( class_exists( 'Elementor\WPNotificationsPackage\V120\Notifications' ) ) {
			return true;
		}

		$elementor_autoload = defined( 'ELEMENTOR_PATH' )
			? ELEMENTOR_PATH . 'vendor/autoload.php'
			: WP_PLUGIN_DIR . '/elementor/vendor/autoload.php';

		if ( file_exists( $elementor_autoload ) ) {
			require_once $elementor_autoload;
		}

		if ( class_exists( 'Elementor\WPNotificationsPackage\V120\Notifications' ) ) {
			return true;
		}

		$hello_theme_autoload = HELLO_THEME_PATH . '/vendor/autoload.php';
		if ( file_exists( $hello_theme_autoload ) ) {
			require_once $hello_theme_autoload;
		}

		return class_exists( 'Elementor\WPNotificationsPackage\V120\Notifications' );
	}
}
