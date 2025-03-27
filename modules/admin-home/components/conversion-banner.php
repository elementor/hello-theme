<?php

namespace HelloTheme\Modules\AdminHome\Components;

use HelloTheme\Includes\Utils;
use HelloTheme\Modules\AdminHome\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Conversion_Banner {

	private function render_conversion_banner() {
		?>
		<div id="ehe-admin-cb" style="width: calc(100% - 48px)">
		</div>
		<?php
	}

	private function is_conversion_banner_active(): bool {
		if ( get_user_meta( get_current_user_id(), '_hello_elementor_install_notice', true ) ) {
			return false;
		}

		if ( Utils::has_pro() ) {
			return false;
		}

		$current_screen = get_current_screen();

		return false === strpos( $current_screen->id ?? '', Module::MENU_PAGE_SLUG );
	}

	private function enqueue_scripts() {
		$handle = 'hello-conversion-banner';
		$asset_path = HELLO_THEME_SCRIPTS_PATH . $handle . '.asset.php';
		$asset_url = HELLO_THEME_SCRIPTS_URL;

		if ( ! file_exists( $asset_path ) ) {
			return;
		}

		$asset = require $asset_path;

		wp_enqueue_script(
			$handle,
			$asset_url . $handle . '.js',
			array_merge( $asset['dependencies'], [ 'wp-util' ] ),
			$asset['version'],
			true
		);

		wp_set_script_translations( $handle, 'hello-elementor' );

		$is_installing_plugin_with_uploader = 'upload-plugin' === filter_input( INPUT_GET, 'action', FILTER_UNSAFE_RAW );

		wp_localize_script(
			$handle,
			'ehe_cb',
			[
				'nonce' => wp_create_nonce( 'ehe_cb_nonce' ),
				'beforeWrap' => $is_installing_plugin_with_uploader,
			]
		);
	}

	public function dismiss_theme_notice() {
		check_ajax_referer( 'ehe_cb_nonce', 'nonce' );

		update_user_meta( get_current_user_id(), '_hello_elementor_install_notice', true );

		wp_send_json_success( [ 'message' => __( 'Notice dismissed.', 'hello-elementor' ) ] );
	}

	public function __construct() {

		add_action( 'wp_ajax_ehe_dismiss_theme_notice', [ $this, 'dismiss_theme_notice' ] );

		add_action( 'current_screen', function () {
			if ( ! $this->is_conversion_banner_active() ) {
				return;
			}

			add_action( 'in_admin_header', function () {
				$this->render_conversion_banner();
			}, 11 );

			add_action( 'admin_enqueue_scripts', function () {
				$this->enqueue_scripts();
			} );
		} );
	}
}
