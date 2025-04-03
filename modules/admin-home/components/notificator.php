<?php
namespace HelloTheme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\WPNotificationsPackage\V110\Notifications as Notifications_SDK;

class Notificator {
	private ?Notifications_SDK $notificator = null;

	public function get_notifications_by_conditions( $force_request = false ) {
		return $this->notificator->get_notifications_by_conditions( $force_request );
	}

	public function __construct() {
		require_once HELLO_THEME_PATH . '/vendor/autoload.php';

		$this->notificator = new Notifications_SDK(
			'hello-elementor',
			HELLO_ELEMENTOR_VERSION,
			'hello-elementor'
		);
	}
}
