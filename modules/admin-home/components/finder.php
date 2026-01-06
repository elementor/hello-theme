<?php

namespace Hello420Theme\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Finder {
	public function __construct() {
		add_filter( 'elementor/finder/categories', [ $this, 'register_finder_item' ] );
	}

	public function register_finder_item( array $categories_data ): array {
		$categories_data['site']['items']['hello420-home'] = [
			'title' => esc_html__( 'Hello 420 Home', 'hello420' ),
			'icon'  => 'eicon-home',
			'url'   => admin_url( 'admin.php?page=' . HELLO420_THEME_SLUG ),
		];

		return $categories_data;
	}
}
