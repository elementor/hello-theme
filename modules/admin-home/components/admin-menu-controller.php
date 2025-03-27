<?php

namespace HelloTheme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use HelloTheme\Includes\Utils;
use HelloTheme\Modules\AdminHome\Module;

class Admin_Menu_Controller {

	const MENU_PAGE_ICON = 'dashicons-plus-alt';
	const MENU_PAGE_POSITION = 59.9;
	const AI_SITE_PLANNER_SLUG = '-ai-site-planner';

	public function admin_menu(): void {
		add_menu_page(
			__( 'Hello', 'hello-elementor' ),
			__( 'Hello', 'hello-elementor' ),
			'manage_options',
			Module::MENU_PAGE_SLUG,
			[ $this, 'render_home' ],
			self::MENU_PAGE_ICON,
			self::MENU_PAGE_POSITION
		);

		add_submenu_page(
			Module::MENU_PAGE_SLUG,
			__( 'Home', 'hello-elementor' ),
			__( 'Home', 'hello-elementor' ),
			'manage_options',
			Module::MENU_PAGE_SLUG,
			[ $this, 'render_home' ]
		);

		do_action( 'hello-plus-theme/admin-menu', Module::MENU_PAGE_SLUG );

		add_submenu_page(
			Module::MENU_PAGE_SLUG,
			__( 'Ai Site Planner', 'hello-elementor' ),
			__( 'Ai Site Planner', 'hello-elementor' ),
			'manage_options',
			Module::MENU_PAGE_SLUG . self::AI_SITE_PLANNER_SLUG,
			[ $this, 'redirect_to_external_site' ],
		);
	}

	public function render_home(): void {
		echo '<div id="ehe-admin-home"></div>';
	}

	public function redirect_to_external_site(): void {
		echo '<script type="text/javascript">
			    window.open("' . esc_url( Utils::get_ai_site_planner_url() ) . '", "_blank");
			  </script>';
	}

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}
}
