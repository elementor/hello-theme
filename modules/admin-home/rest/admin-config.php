<?php

namespace HelloTheme\Modules\AdminHome\Rest;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use HelloTheme\Includes\Utils;
use WP_REST_Server;

class Admin_Config extends Rest_Base {

	public function register_routes() {
		register_rest_route(
			self::ROUTE_NAMESPACE,
			'/admin-settings',
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_admin_config' ],
				'permission_callback' => [ $this, 'permission_callback' ],
			]
		);
	}

	public function get_admin_config() {
		$config = $this->get_welcome_box_config( [] );

		$config = apply_filters( 'hello-plus-theme/rest/admin-config', $config );

		$config['config'] = [
			'nonceInstall' => wp_create_nonce( 'updates' ),
			'slug'         => 'elementor',
		];

		return rest_ensure_response( [ 'config' => $config ] );
	}

	public function get_welcome_box_config( array $config ): array {
		$is_elementor_installed = Utils::is_elementor_installed();
		$is_elementor_active    = Utils::is_elementor_active();

		if ( ! $is_elementor_active ) {
			$link = $is_elementor_installed ? Utils::get_elementor_activation_link() : 'install';

			$action_link_type = Utils::get_action_link_type();

			if ( 'activate-elementor' === $action_link_type ) {
				$cta_text = __( 'Activate Elementor', 'hello-elementor' );
				$text     = __( 'Hello Theme is a lightweight blank canvas built for Elementor. Looks like you already have Elementor installed. Activate it to start building.', 'hello-elementor' );
			} else {
				$cta_text = __( 'Install Elementor', 'hello-elementor' );
				$text     = __( 'Welcome to Hello Theme—a lightweight, blank canvas designed to integrate seamlessly with Elementor, the most popular, no-code visual website builder. By installing and activating Elementor, you\'ll unlock the power to craft a professional website with advanced features and functionalities.', 'hello-elementor' );
			}

			$config['welcome'] = [
				'title'   => __( 'Thanks for installing the Hello Theme!', 'hello-elementor' ),
				'text'    => $text,
				'buttons' => [
					[
						'linkText' => $cta_text,
						'variant'  => 'contained',
						'link'     => $link,
						'color'    => 'primary',
					],
				],
				'image'   => [
					'src' => HELLO_THEME_IMAGES_URL . 'install-elementor.png',
					'alt' => $cta_text,
				],
			];

			return $config;
		}

		$config['welcome'] = [];

		return $config;
	}
}
