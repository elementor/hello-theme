<?php

use HelloTheme\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'init', 'hello_elementor_tweak_settings', 0 );

function hello_elementor_tweak_settings() {
	$settings_controller = Theme::instance()
		->get_module( 'AdminHome' )
		->get_component( 'Settings_Controller' );

	/**
	 * @var \HelloTheme\Modules\AdminHome\Components\Settings_Controller $settings_controller
	 */
	$settings_controller->legacy_register_settings();
}
