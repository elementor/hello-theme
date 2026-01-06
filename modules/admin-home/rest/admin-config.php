<?php

namespace Hello420Theme\Modules\AdminHome\Rest;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\DocumentTypes\Page;
use Hello420Theme\Includes\Utils;
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
		$elementor_page_id = Utils::is_elementor_active() ? $this->ensure_elementor_page_exists() : null;

		$config = $this->get_welcome_box_config( [] );
		$config = $this->get_site_parts( $config, $elementor_page_id );
		$config = $this->get_resources( $config );

		$config = apply_filters( 'hello420/rest/admin-config', $config );

		return rest_ensure_response( [ 'config' => $config ] );
	}

	private function ensure_elementor_page_exists(): int {
		$existing_page = Page::get_elementor_page();

		if ( $existing_page ) {
			return $existing_page->ID;
		}

		$page_id = wp_insert_post(
			[
				'post_title'   => 'Hello 420 page',
				'post_content' => '',
				'post_status'  => 'draft',
				'post_type'    => 'page',
				'meta_input'   => [
					'_elementor_edit_mode'     => 'builder',
					'_elementor_template_type' => 'wp-page',
				],
			]
		);

		if ( is_wp_error( $page_id ) ) {
			throw new \RuntimeException( 'Failed to create Elementor page: ' . esc_html( $page_id->get_error_message() ) );
		}

		if ( ! $page_id ) {
			throw new \RuntimeException( 'Page creation returned invalid ID' );
		}

		wp_update_post(
			[
				'ID'         => $page_id,
				'post_title' => 'Hello 420 #' . $page_id,
			]
		);

		return $page_id;
	}

	private function get_elementor_editor_url( ?int $page_id, string $active_tab ): string {
		$url = add_query_arg(
			[
				'post'       => $page_id,
				'action'     => 'elementor',
				'active-tab' => $active_tab,
			],
			admin_url( 'post.php' )
		);

		return $url . '#e:run:panel/global/open';
	}

	public function get_resources( array $config ): array {
		$config['resourcesData'] = [
			'community' => [],
			'resources' => [
				[
					'title' => __( 'Elementor: Site Settings', 'hello420' ),
					'link'  => admin_url( 'admin.php?page=elementor-app' ),
					'icon'  => 'BrandElementorIcon',
				],
				[
					'title' => __( 'WordPress: Customize', 'hello420' ),
					'link'  => admin_url( 'customize.php' ),
					'icon'  => 'HelpIcon',
				],
				[
					'title' => __( 'WordPress: Menus', 'hello420' ),
					'link'  => admin_url( 'nav-menus.php' ),
					'icon'  => 'PagesIcon',
				],
			],
		];

		return $config;
	}

	public function get_site_parts( array $config, ?int $elementor_page_id = null ): array {
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
					'icon'  => 'PagesIcon',
				];
			}
		}

		$general = [
			[
				'title' => __( 'Add New Page', 'hello420' ),
				'link'  => self_admin_url( 'post-new.php?post_type=page' ),
				'icon'  => 'PageTypeIcon',
			],
			[
				'title' => __( 'Theme Settings', 'hello420' ),
				'link'  => self_admin_url( 'admin.php?page=hello420-settings' ),
			],
		];

		$customizer_header_footer_url = $this->get_open_homepage_with_tab( $elementor_page_id, '', null, [ 'autofocus[section]' => 'hello420-options' ] );

		$header_part = [
			'id'      => 'header',
			'title'   => __( 'Header', 'hello420' ),
			'link'    => $customizer_header_footer_url,
			'icon'    => 'HeaderTemplateIcon',
			'sublinks' => [],
		];

		$footer_part = [
			'id'      => 'footer',
			'title'   => __( 'Footer', 'hello420' ),
			'link'    => $customizer_header_footer_url,
			'icon'    => 'FooterTemplateIcon',
			'sublinks' => [],
		];

		$common_parts = [];

		if ( Utils::is_elementor_active() ) {
			$common_parts = [
				[
					'title' => __( 'Theme Builder', 'hello420' ),
					'link'  => Utils::get_theme_builder_url(),
					'icon'  => 'ThemeBuilderIcon',
				],
			];

			$header_part['link'] = $this->get_open_homepage_with_tab( $elementor_page_id, 'hello-settings-header' );
			$footer_part['link'] = $this->get_open_homepage_with_tab( $elementor_page_id, 'hello-settings-footer' );

			if ( Utils::has_pro() ) {
				$header_part = $this->update_pro_part( $header_part, 'header' );
				$footer_part = $this->update_pro_part( $footer_part, 'footer' );
			}
		}

		$site_parts = [
			'siteParts' => array_merge( [ $header_part, $footer_part ], $common_parts ),
			'sitePages' => $site_pages,
			'general'   => $general,
		];

		$config['siteParts'] = apply_filters( 'hello420/template-parts', $site_parts );

		return $this->get_quicklinks( $config, $elementor_page_id );
	}

	private function update_pro_part( array $part, string $location ): array {
		$theme_builder_module = \ElementorPro\Modules\ThemeBuilder\Module::instance();
		$conditions_manager   = $theme_builder_module->get_conditions_manager();

		$documents = $conditions_manager->get_documents_for_location( $location );
		if ( ! empty( $documents ) ) {
			$first_document_id = array_key_first( $documents );
			$edit_link         = get_edit_post_link( $first_document_id, 'admin' ) . '&action=elementor';
		} else {
			$edit_link = $this->get_open_homepage_with_tab( null, 'hello-settings-' . $location );
		}

		$part['sublinks'] = [
			[
				'title' => __( 'Edit', 'hello420' ),
				'link'  => $edit_link,
			],
			[
				'title' => __( 'Add New', 'hello420' ),
				'link'  => \Elementor\Plugin::instance()->app->get_base_url() . '#/site-editor/templates/' . $location,
			],
		];

		return $part;
	}

	public function get_open_homepage_with_tab( ?int $page_id, $action, $section = null, $customizer_fallback_args = [] ): string {
		if ( Utils::is_elementor_active() ) {
			$url = $page_id
				? $this->get_elementor_editor_url( $page_id, $action )
				: Page::get_site_settings_url_config( $action )['url'];

			if ( $section ) {
				$url = add_query_arg( 'active-section', $section, $url );
			}

			return $url;
		}

		return add_query_arg( $customizer_fallback_args, self_admin_url( 'customize.php' ) );
	}

	public function get_quicklinks( array $config, ?int $elementor_page_id = null ): array {
		$config['quickLinks'] = [
			'site_name' => [
				'title' => __( 'Site Name', 'hello420' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-site-identity', null, [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'TextIcon',
			],
			'site_logo' => [
				'title' => __( 'Site Logo', 'hello420' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-site-identity', null, [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'PhotoIcon',
			],
			'site_favicon' => [
				'title' => __( 'Site Icon', 'hello420' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'settings-site-identity', null, [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'AppsIcon',
			],
		];

		if ( Utils::is_elementor_active() ) {
			$config['quickLinks']['site_colors'] = [
				'title' => __( 'Site Colors', 'hello420' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'global-colors' ),
				'icon'  => 'BrushIcon',
			];

			$config['quickLinks']['site_fonts'] = [
				'title' => __( 'Site Fonts', 'hello420' ),
				'link'  => $this->get_open_homepage_with_tab( $elementor_page_id, 'global-typography' ),
				'icon'  => 'UnderlineIcon',
			];
		}

		return $config;
	}

	public function get_welcome_box_config( array $config ): array {
		$is_elementor_installed = Utils::is_elementor_installed();
		$is_elementor_active    = Utils::is_elementor_active();

		if ( ! $is_elementor_active ) {
			$link = $is_elementor_installed ? Utils::get_elementor_activation_link() : Utils::get_plugin_install_url( 'elementor' );
			$cta  = $is_elementor_installed ? __( 'Activate Elementor', 'hello420' ) : __( 'Install Elementor', 'hello420' );

			$config['welcome'] = [
				'title'   => __( 'Elementor required', 'hello420' ),
				'text'    => __( 'Hello 420 is designed to run with Elementor. Install and activate Elementor to unlock the full experience.', 'hello420' ),
				'buttons' => [
					[
						'linkText' => $cta,
						'variant'  => 'contained',
						'link'     => $link,
						'color'    => 'primary',
					],
				],
			];

			return $config;
		}

		$config['welcome'] = [];
		return $config;
	}
}
