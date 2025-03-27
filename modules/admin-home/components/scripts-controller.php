<?php

namespace HelloTheme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use HelloTheme\Includes\Script;
use HelloTheme\Modules\AdminHome\Module;

class Scripts_Controller {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	public function admin_enqueue_scripts() {
		$screen = get_current_screen();

		if ( 'toplevel_page_' . Module::MENU_PAGE_SLUG !== $screen->id ) {
			return;
		}

		$script = new Script(
			'hello-home-app',
			[ 'wp-util' ]
		);

		$script->enqueue();
	}
}
