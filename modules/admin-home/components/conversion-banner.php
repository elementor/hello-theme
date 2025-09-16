<?php

namespace HelloTheme\Modules\AdminHome\Components;

use HelloTheme\Includes\Script;
use HelloTheme\Includes\Utils;

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

	private function get_allowed_admin_pages(): array {
		return [
			'dashboard' => [ 'selector' => '#wpbody #wpbody-content .wrap h1' ],
			'update-core' => [ 'selector' => '.wrap h1, .wrap h2' ],
			'edit-post' => [ 'selector' => '.wrap h1, .wrap h2' ],
			'edit-category' => [ 'selector' => '.wrap h1, .wrap h2' ],
			'edit-post_tag' => [ 'selector' => '.wrap h1, .wrap h2' ],
			'upload' => [ 'selector' => '.wrap h1, .wrap h2' ],
			'media' => [ 'selector' => '.wrap h1, .wrap h2' ],
			'edit-page' => [ 'selector' => '.wrap h1, .wrap h2' ],
			'elementor_page_elementor-settings' => [ 'selector' => '.wrap h1, .wrap h2' ],
			'edit-elementor_library' => [
                'selector' => '.wrap h1, .wrap h2',
                'before' => true,
            ],
			'elementor_page_elementor-tools' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'elementor_page_elementor-role-manager' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'elementor_page_elementor-element-manager' => [
                'selector' => '.wrap h1, .wrap h3.wp-heading-inline',
            ],
			'elementor_page_elementor-system-info' => [
                'selector' => '#wpbody #wpbody-content #elementor-system-info .elementor-system-info-header',
                'before' => true,
            ],
			'elementor_library_page_e-floating-buttons' => [
                'selector' => '#wpbody-content .e-landing-pages-empty, .wrap h2',
                'before' => true,
            ],
            'edit-e-floating-buttons' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'edit-elementor_library_category' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'themes' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'nav-menus' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'theme-editor' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'plugins' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'plugin-install' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'plugin-editor' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'users' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'user' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'profile' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'tools' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'import' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'export' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'site-health' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'export-personal-data' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'erase-personal-data' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'options-general' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'options-writing' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'options-reading' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'options-discussion' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'options-media' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'options-permalink' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'options-privacy' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
			'privacy-policy-guide' => [
                'selector' => '.wrap h1, .wrap h2',
            ],
		];
	}

	private function is_allowed_admin_page(): array {
		$current_screen = get_current_screen();
		
		if ( ! $current_screen ) {
			return [];
		}

		$allowed_pages = $this->get_allowed_admin_pages();
		$current_page = $current_screen->id;
        error_log( print_r( $current_page, true ) );

		return $allowed_pages[ $current_page ] ?? [];
	}

	private function is_conversion_banner_active(): array {
		if ( get_user_meta( get_current_user_id(), '_hello_elementor_install_notice', true ) ) {
			return [];
		}

		if ( Utils::has_pro() && Utils::is_elementor_active() ) {
			return [];
		}

		return $this->is_allowed_admin_page();
	}

	private function enqueue_scripts( array $conversion_banner_active ) {
		$script = new Script(
			'hello-conversion-banner',
			[ 'wp-util' ]
		);

		$script->enqueue();

		$is_installing_plugin_with_uploader = 'upload-plugin' === filter_input( INPUT_GET, 'action', FILTER_UNSAFE_RAW );

		wp_localize_script(
			'hello-conversion-banner',
			'ehe_cb',
			[
				'nonce' => wp_create_nonce( 'ehe_cb_nonce' ),
				'beforeWrap' => $is_installing_plugin_with_uploader,
                'data' => $conversion_banner_active,
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
            $conversion_banner_active = $this->is_conversion_banner_active();
			if ( ! $conversion_banner_active ) {
				return;
			}

			add_action( 'in_admin_header', function () {
				$this->render_conversion_banner();
			}, 11 );

			add_action( 'admin_enqueue_scripts', function () use ( $conversion_banner_active ) {
				$this->enqueue_scripts( $conversion_banner_active );
			} );
		} );
	}
}
