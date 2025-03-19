<?php

namespace HelloTheme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use HelloTheme\Modules\AdminHome\Module;

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
			Module::MENU_PAGE_SLUG,
			[ $this, 'render' ],
			self::MENU_PAGE_ICON,
			self::MENU_PAGE_POSITION
		);

		add_submenu_page(
			Module::MENU_PAGE_SLUG,
			__( 'Home', 'hello-elementor' ),
			__( 'Home', 'hello-elementor' ),
			'manage_options',
			Module::MENU_PAGE_SLUG,
			[ $this, 'render' ]
		);

		do_action( 'hello-plus-theme/admin-menu', Module::MENU_PAGE_SLUG );
	}

	public function render(): void {
		echo '<div id="ehe-admin-home"></div>';
	}

	public function theme_page() {
		$menu_hook = \add_theme_page(
			esc_html__( 'Home', 'hello-elementor' ),
			esc_html__( 'Home', 'hello-elementor' ),
			'manage_options',
			Module::MENU_PAGE_SLUG,
			[ $this, 'render' ]
		);
	}

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_menu', [ $this, 'theme_page' ] );
	}
}
