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
			[ $this, 'render_home' ],
			self::MENU_PAGE_ICON,
			self::MENU_PAGE_POSITION
		);

		add_submenu_page(
			EHP_THEME_SLUG,
			__( 'Home', 'hello-elementor' ),
			__( 'Home', 'hello-elementor' ),
			'manage_options',
			EHP_THEME_SLUG,
			[ $this, 'render_home' ]
		);

		do_action( 'hello-plus-theme/admin-menu', EHP_THEME_SLUG );
	}

	public function render_home(): void {
		echo '<div id="ehe-admin-home"></div>';
	}

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}
}
