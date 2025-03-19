<?php

namespace HelloTheme\Modules\AdminHome\Components;

use HelloTheme\Includes\Utils;
use HelloTheme\Modules\AdminHome\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Top_Bar {

	private function render_admin_top_bar() {
		?>
		<div id="ehe-admin-top-bar-root" style="height: 50px">
		</div>
		<?php
	}

	private function is_top_bar_active() {
		$current_screen = get_current_screen();

		return strpos( $current_screen->id ?? '', Module::MENU_PAGE_SLUG ) !== false &&
			! Utils::is_elementor_active();
	}

	private function enqueue_scripts() {
		$handle = 'hello-elementor-topbar';
		$asset_path = HELLO_THEME_SCRIPTS_PATH . $handle . '.asset.php';
		$asset_url = HELLO_THEME_SCRIPTS_URL;

		if ( ! file_exists( $asset_path ) ) {
			return;
		}

		$asset = require $asset_path;

		wp_enqueue_script(
			$handle,
			$asset_url . $handle . '.js',
			$asset['dependencies'],
			$asset['version'],
			true
		);

		wp_set_script_translations( $handle, 'hello-elementor' );
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
		} );
	}
}
