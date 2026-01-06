<?php

use Hello420Theme\Theme;
use Hello420Theme\Modules\AdminHome\Components\Settings_Controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register and apply Hello 420 theme settings.
 *
 * Settings are registered and exposed to the REST API by the Admin Home module.
 * The module also applies feature toggles based on saved options.
 */
function hello420_bootstrap_settings(): void {
	$theme = Theme::instance();

	$module = $theme->get_module( 'AdminHome' );
	if ( ! $module ) {
		return;
	}

	$settings_controller = $module->get_component( 'Settings_Controller' );
	if ( $settings_controller instanceof Settings_Controller ) {
		$settings_controller->legacy_register_settings();
	}
}
add_action( 'init', 'hello420_bootstrap_settings', 0 );
