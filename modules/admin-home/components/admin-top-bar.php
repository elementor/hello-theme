<?php

namespace Hello420Theme\Modules\AdminHome\Components;

use Hello420Theme\Includes\Script;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Top_Bar {
	private function render_admin_top_bar(): void {
		?>
		<div id="hello420-admin-top-bar-root" style="min-height: 50px"></div>
		<?php
	}

	private function is_top_bar_active(): bool {
		$current_screen = get_current_screen();

		return ( false !== strpos( $current_screen->id ?? '', HELLO420_THEME_SLUG ) );
	}

	private function enqueue_scripts(): void {
		$script = new Script(
			'hello420-topbar',
			[ 'wp-element', 'wp-i18n' ]
		);

		$script->enqueue();
	}

	public function __construct() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'current_screen', function () {
			if ( ! $this->is_top_bar_active() ) {
				return;
			}

			add_action( 'in_admin_header', function () {
				$this->render_admin_top_bar();
			} );

			add_action( 'admin_enqueue_scripts', function () {
				$this->enqueue_scripts();
			} );

			// Disable Elementor's top bar for our theme pages to avoid double headers.
			add_action( 'elementor/admin-top-bar/is-active', '__return_false' );
		} );
	}
}
