<?php

namespace Hello420Theme\Modules\AdminHome\Components;

use Hello420Theme\Includes\Script;
use Hello420Theme\Includes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Menu_Controller {
	private const THEME_BUILDER_SLUG = '-theme-builder';

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_menu_pages' ] );
		add_action( 'admin_init', [ $this, 'redirect_menus' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	public function add_menu_pages(): void {
		add_menu_page(
			__( 'Hello 420', 'hello420' ),
			__( 'Hello 420', 'hello420' ),
			'manage_options',
			HELLO420_THEME_SLUG,
			[ $this, 'render_home' ],
			'dashicons-admin-generic',
			58
		);

		// Home (submenu).
		add_submenu_page(
			HELLO420_THEME_SLUG,
			__( 'Home', 'hello420' ),
			__( 'Home', 'hello420' ),
			'manage_options',
			HELLO420_THEME_SLUG,
			[ $this, 'render_home' ]
		);

		// Elementor Theme Builder (internal).
		add_submenu_page(
			HELLO420_THEME_SLUG,
			__( 'Theme Builder', 'hello420' ),
			__( 'Theme Builder', 'hello420' ),
			'manage_options',
			HELLO420_THEME_SLUG . self::THEME_BUILDER_SLUG,
			[ $this, 'render_home' ]
		);

		do_action( 'hello420/admin-menu', HELLO420_THEME_SLUG );
	}

	public function render_home(): void {
		echo '<div id="hello420-admin-home"></div>';
	}

	public function redirect_menus(): void {
		if ( empty( $_GET['page'] ) ) {
			return;
		}

		$page = sanitize_key( wp_unslash( $_GET['page'] ) );

		switch ( $page ) {
			case HELLO420_THEME_SLUG . self::THEME_BUILDER_SLUG:
				wp_safe_redirect( Utils::get_theme_builder_url() );
				exit;
		}
	}

	public function admin_enqueue_scripts(): void {
		$screen = get_current_screen();
		if ( ! $screen || false === strpos( $screen->id, HELLO420_THEME_SLUG ) ) {
			return;
		}

		$script = new Script( 'hello420-admin-menu', [ 'wp-element', 'wp-i18n' ] );
		$script->enqueue();
	}
}
