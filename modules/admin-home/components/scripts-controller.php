<?php

namespace HelloTheme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use HelloTheme\Modules\AdminHome\Module;

class Scripts_Controller {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_hello_elementor_admin_scripts' ] );
	}

	public function enqueue_hello_elementor_admin_scripts() {
		$screen = get_current_screen();

		if ( 'toplevel_page_' . Module::MENU_PAGE_SLUG !== $screen->id ) {
			return;
		}

		$handle     = 'hello-home-app';
		$asset_path = HELLO_THEME_SCRIPTS_PATH . $handle . '.asset.php';
		$asset_url  = HELLO_THEME_SCRIPTS_URL;

		if ( ! file_exists( $asset_path ) ) {
			throw new \Exception( 'You need to run `npm run build` for the "hello-elementor" first.' );
		}

		$script_asset = require $asset_path;

		wp_enqueue_script(
			$handle,
			HELLO_THEME_SCRIPTS_URL . "$handle.js",
			array_merge( $script_asset['dependencies'], [ 'wp-util' ] ),
			$script_asset['version'],
			true
		);

		wp_set_script_translations( $handle, 'hello-elementor' );
	}
}
