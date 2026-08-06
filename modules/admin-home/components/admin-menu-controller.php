<?php

namespace HelloTheme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Menu_Controller {

	const MENU_PAGE_ICON = 'dashicons-plus-alt';
	const MENU_PAGE_POSITION = 59.9;

	public function admin_menu(): void {
		add_menu_page(
			__( 'Hello', 'hello-elementor' ),
			__( 'Hello', 'hello-elementor' ),
			'manage_options',
			EHP_THEME_SLUG,
			[ $this, 'redirect_to_settings' ],
			self::MENU_PAGE_ICON,
			self::MENU_PAGE_POSITION
		);

		do_action( 'hello-plus-theme/admin-menu', EHP_THEME_SLUG );
	}

	public function redirect_to_settings(): void {
		wp_safe_redirect( admin_url( 'admin.php?page=' . Settings_Controller::SETTINGS_PAGE_SLUG ) );
		exit;
	}

	public function cleanup_submenu(): void {
		remove_submenu_page( EHP_THEME_SLUG, EHP_THEME_SLUG );
	}

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_menu', [ $this, 'cleanup_submenu' ], 999 );
	}
}
