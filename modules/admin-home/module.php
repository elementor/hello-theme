<?php

namespace HelloTheme\Modules\AdminHome;

use HelloTheme\Includes\Module_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * class Module
 *
 * @package HelloPlus
 * @subpackage HelloPlusModules
 */
class Module extends Module_Base {
	const MENU_PAGE_SLUG = 'hello-elementor';

	/**
	 * @inheritDoc
	 */
	public static function get_name(): string {
		return 'admin-home';
	}

	/**
	 * @inheritDoc
	 */
	protected function get_component_ids(): array {
		return [
			'Admin_Menu_Controller',
			'Scripts_Controller',
			'Api_Controller',
		];
	}

	protected function register_hooks(): void {
		add_action( 'upgrader_process_complete', [ $this, 'add_attribution' ], 10, 2 );
	}

	public function add_attribution( $upgrader_object, $options ) {
		if ( 'update' === $options['action'] && 'plugin' === $options['type'] ) {
			$installed_plugin = filter_input( INPUT_GET, 'plugin', FILTER_UNSAFE_RAW );
			$referrer = filter_input( INPUT_GET, 'referrer', FILTER_UNSAFE_RAW );

			if ( 'hello-elementor' === $referrer && 'image-optimization' === $installed_plugin ) {
				$campaign_data = [
					'source' => 'io-ehp-install',
					'campaign' => 'io-plg',
					'medium' => 'wp-dash',
				];

				set_transient( 'elementor_image_optimization_campaign', $campaign_data, 30 * DAY_IN_SECONDS );
			}
		}
	}
}
