<?php

namespace HelloTheme\Modules\AdminHome\Rest;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\DocumentTypes\Page;
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

		$config = $this->get_site_parts( $config );

		$config = apply_filters( 'hello-plus-theme/rest/admin-config', $config );

		$config['config'] = [
			'showText'     => ! Utils::is_hello_plus_installed(),
			'nonceInstall' => wp_create_nonce( 'updates' ),
		];

		return rest_ensure_response( [ 'config' => $config ] );
	}

	public function get_site_parts( array $config ): array {
		$last_five_pages_query = new \WP_Query(
			[
				'posts_per_page'         => 5,
				'post_type'              => 'page',
				'post_status'            => 'publish',
				'orderby'                => 'post_date',
				'order'                  => 'DESC',
				'fields'                 => 'ids',
				'no_found_rows'          => true,
				'lazy_load_term_meta'    => true,
				'update_post_meta_cache' => false,
			]
		);

		$site_pages = [];

		if ( $last_five_pages_query->have_posts() ) {
			$elementor_active    = Utils::is_elementor_active();
			$edit_with_elementor = $elementor_active ? '&action=elementor' : '';
			while ( $last_five_pages_query->have_posts() ) {
				$last_five_pages_query->the_post();
				$site_pages[] = [
					'title' => get_the_title(),
					'link'  => get_edit_post_link( get_the_ID(), 'admin' ) . $edit_with_elementor,
				];
			}
		}

		$general = [
			[
				'title' => __( 'Add New Page', 'hello-elementor' ),
				'link'  => self_admin_url( 'post-new.php?post_type=page' ),
			],
			[
				'title' => __( 'Settings', 'hello-elementor' ),
				'link'  => self_admin_url( 'admin.php?page=hello-plus-settings' ),
			],
		];

		$config['siteParts'] = [
			'siteParts' => [
				[
					'title' => __( 'Header', 'hello-elementor' ),
					'link' => self_admin_url( 'customize.php?autofocus[section]=hello-elementor-options' ),
				],
				[
					'title' => __( 'Footer', 'hello-elementor' ),
					'link' => self_admin_url( 'customize.php?autofocus[section]=hello-elementor-options' ),
				],
			],
			'sitePages' => $site_pages,
			'general'   => $general,
		];

		return $this->get_quicklinks( $config );
	}

	public function get_open_homepage_with_tab( $action, $customizer_fallback_args = [] ): string {
		if ( Utils::is_elementor_active() ) {
			return Page::get_site_settings_url_config( $action )['url'];
		}

		return add_query_arg( $customizer_fallback_args, self_admin_url( 'customize.php' ) );
	}

	public function get_quicklinks( $config ): array {
		$config['quickLinks'] = [
			'site_name' => [
				'title' => __( 'Site name', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'settings-site-identity', [ 'autofocus[section]' => 'title_tagline' ] ),
			],
			'site_logo' => [
				'title' => __( 'Site Logo', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'settings-site-identity', [ 'autofocus[section]' => 'title_tagline' ] ),
			],
		];

		if ( Utils::is_elementor_active() ) {
			$config['quickLinks']['site_colors'] = [
				'title' => __( 'Site Colors', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'global-colors' ),
			];

			$config['quickLinks']['site_fonts'] = [
				'title' => __( 'Site Fonts', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'global-typography' ),
			];
		}

		return $config;
	}

	public function get_welcome_box_config( array $config ): array {
		$is_elementor_active  = Utils::is_elementor_active();
		$is_hello_plus_active = Utils::is_hello_plus_active();

		if ( ! $is_hello_plus_active ) {
			$link = Utils::is_hello_plus_installed() ? Utils::get_hello_plus_activation_link() : 'install';

			$config['welcome'] = [
				'text'    => __( 'To get access to the full suite of features, including theme kits, header and footer templates, and more widgets, click “Begin setup” and start your web creator journey.', 'hello-elementor' ),
				'buttons' => [
					[
						'title'   => __( 'Begin Setup', 'hello-elementor' ),
						'variant' => 'contained',
						'link'    => $link,
						'color'   => 'primary',
					],
				],
			];

			return $config;
		}

		if ( ! $is_elementor_active || ! Utils::is_hello_plus_setup_wizard_done() ) {
			$config['welcome'] = [
				'text'    => __( 'To get access to the full suite of features, including theme kits, header and footer templates, and more widgets, click “Begin setup” and start your web creator journey.', 'hello-elementor' ),
				'buttons' => [
					[
						'title'   => __( 'Begin Setup', 'hello-elementor' ),
						'variant' => 'contained',
						'link'    => self_admin_url( 'admin.php?page=hello-plus-setup-wizard' ),
						'color'   => 'primary',
					],
				],
			];

			return $config;
		}

		$config['welcome'] = [
			'text'    => __( 'Here you’ll find quick access to key site settings. Customizing and managing your site is a breeze with Hello Biz.', 'hello-elementor' ),
			'buttons' => [
				[
					'title'   => __( 'Edit home page', 'hello-elementor' ),
					'variant' => 'contained',
					'link'    => get_edit_post_link( get_option( 'page_on_front' ), 'admin' ) . '&action=elementor',
					'color'   => 'primary',
				],
				[
					'title'   => __( 'View site', 'hello-elementor' ),
					'variant' => 'outlined',
					'link'    => get_site_url(),
					'color'   => 'secondary',
				],
			],
		];

		return $config;
	}
}
