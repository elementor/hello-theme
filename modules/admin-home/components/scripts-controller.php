<?php

namespace Hello420Theme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Hello420Theme\Includes\Script;

class Scripts_Controller {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	public function admin_enqueue_scripts(): void {
		$screen = get_current_screen();

		if ( ! $screen || 'toplevel_page_' . HELLO420_THEME_SLUG !== $screen->id ) {
			return;
		}

		$script = new Script(
			'hello420-admin-home',
			[ 'wp-element', 'wp-i18n', 'wp-api-fetch' ]
		);
		$script->enqueue();
	}
}
