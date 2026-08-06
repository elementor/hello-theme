<?php

namespace HelloTheme\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * class Utils
 **/
class Utils {

	public static function is_elementor_active(): bool {
		static $elementor_active = null;
		if ( null === $elementor_active ) {
			$elementor_active = defined( 'ELEMENTOR_VERSION' );
		}

		return $elementor_active;
	}

	public static function get_action_link_type() {
		if ( ! hello_header_footer_experiment_active() ) {
			return 'activate-header-footer-experiment';
		}

		return 'style-header-footer';
	}
}
