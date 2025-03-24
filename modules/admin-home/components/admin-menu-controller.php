<?php

namespace HelloTheme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use HelloTheme\Includes\Utils;
use HelloTheme\Modules\AdminHome\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Menu_Controller {

	const MENU_PAGE_ICON = 'dashicons-plus-alt';
	const MENU_PAGE_POSITION = 59.9;
	const AI_SITE_PLANNER_SLUG = '-ai-site-planner';
	const THEME_BUILDER_SLUG = '-theme-builder';

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


		if ( Utils::is_elementor_active() ) {
			add_submenu_page(
				Module::MENU_PAGE_SLUG,
				__( 'Theme Builder', 'hello-elementor' ),
				__( 'Theme Builder', 'hello-elementor' ),
				'manage_options',
				Module::MENU_PAGE_SLUG . self::THEME_BUILDER_SLUG,
				[ $this, 'render_home' ],
			);
		}

		add_submenu_page(
			Module::MENU_PAGE_SLUG,
			__( 'Ai Site Planner', 'hello-elementor' ),
			__( 'Ai Site Planner', 'hello-elementor' ),
			'manage_options',
			Module::MENU_PAGE_SLUG . self::AI_SITE_PLANNER_SLUG,
			[ $this, 'render_home' ],
		);
	}

	public function render_home(): void {
		echo '<div id="ehe-admin-home"></div>';
	}

	public function redirect_menus(): void {
		$page = sanitize_key( filter_input( INPUT_GET, 'page', FILTER_UNSAFE_RAW ) );

		switch ( $page ) {
			case Module::MENU_PAGE_SLUG . self::AI_SITE_PLANNER_SLUG:
				wp_redirect( Utils::get_ai_site_planner_url() );
				exit;

			case Module::MENU_PAGE_SLUG . self::THEME_BUILDER_SLUG:
				wp_safe_redirect( Utils::get_theme_builder_url() );
				exit;

			default:
				break;
		}
	}

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_init', [ $this, 'redirect_menus' ] );
	}
}
