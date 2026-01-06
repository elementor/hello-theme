<?php

namespace Hello420Theme\Modules\AdminHome;

use Hello420Theme\Includes\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Admin Home module.
 */
class Module extends Module_Base {
	public static function get_name(): string {
		return 'admin-home';
	}

	protected function get_component_ids(): array {
		return [
			'Admin_Menu_Controller',
			'Scripts_Controller',
			'Api_Controller',
			'Ajax_Handler',
			'Admin_Top_Bar',
			'Settings_Controller',
			'Finder',
		];
	}
}
