<?php

namespace Hello420Theme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Hello420Theme\Modules\AdminHome\Rest\Admin_Config;
use Hello420Theme\Modules\AdminHome\Rest\Theme_Settings;

/**
 * Registers the REST endpoints used by the Admin Home UI.
 *
 * Promotions/"what's new" endpoints were removed in Hello 420 to avoid
 * marketing and external tracking.
 */
class Api_Controller {
	protected array $endpoints = [];

	public function __construct() {
		$this->endpoints['admin-config']   = new Admin_Config();
		$this->endpoints['theme-settings'] = new Theme_Settings();
	}
}
