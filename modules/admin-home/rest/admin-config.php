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

		$config = $this->get_resources( $config );

		$config = apply_filters( 'hello-plus-theme/rest/admin-config', $config );

		$config['config'] = [
			'nonceInstall' => wp_create_nonce( 'updates' ),
			'slug'         => 'elementor',
		];

		return rest_ensure_response( [ 'config' => $config ] );
	}

	public function get_resources( array $config ) {
		$config['resourcesData'] = [
			'community' => [
				[
					'title'  => __( 'FaceBook', 'hello-elementor' ),
					'link'   => 'https://www.facebook.com/groups/Elementors/',
					'icon'   => 'BrandFacebookIcon',
					'target' => '_blank',
				],
				[
					'title'  => __( 'YouTube', 'hello-elementor' ),
					'link'   => 'https://www.youtube.com/@Elementor',
					'icon'   => 'BrandYoutubeIcon',
					'target' => '_blank',
				],
				[
					'title'  => __( 'Discord', 'hello-elementor' ),
					'link'   => 'https://discord.com/servers/elementor-official-community-1164474724626206720',
					'target' => '_blank',
				],
				[
					'title'  => __( 'Rate Us', 'hello-elementor' ),
					'link'   => 'https://wordpress.org/support/theme/hello-elementor/reviews/#new-post',
					'icon'   => 'StarIcon',
					'target' => '_blank',
				],
			],
			'resources' => [
				[
					'title'  => __( 'Help Center', 'hello-elementor' ),
					'link'   => ' https://go.elementor.com/hello-help/',
					'icon'   => 'HelpIcon',
					'target' => '_blank',
				],
				[
					'title'  => __( 'Blog', 'hello-elementor' ),
					'link'   => 'https://go.elementor.com/hello-blog/',
					'icon'   => 'SpeakerphoneIcon',
					'target' => '_blank',
				],
				[
					'title'  => __( 'Platinum Support', 'hello-elementor' ),
					'link'   => 'https://go.elementor.com/platinum-support',
					'icon'   => 'BrandElementorIcon',
					'target' => '_blank',
				],
			],
		];

		return $config;
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
					'icon'  => 'PagesIcon',
				];
			}
		}

		$general = [
			[
				'title' => __( 'Add New Page', 'hello-elementor' ),
				'link'  => self_admin_url( 'post-new.php?post_type=page' ),
				'icon'  => 'PageTypeIcon',
			],
			[
				'title' => __( 'Settings', 'hello-elementor' ),
				'link'  => self_admin_url( 'admin.php?page=hello-elementor-settings' ),
			],
		];

		$config['siteParts'] = [
			'siteParts' => [],
			'sitePages' => $site_pages,
			'general'   => $general,
		];

		if ( Utils::is_elementor_active() ) {
			$config['siteParts']['siteParts'] = [
				[
					'title' => __( 'Theme Builder', 'hello-elementor' ),
					'link'  => Utils::get_theme_builder_url(),
					'icon'  => 'ThemeBuilderIcon',
				],
			];
		}

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
			'site_name'    => [
				'title' => __( 'Site Name', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'settings-site-identity', [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'TextIcon',

			],
			'site_logo'    => [
				'title' => __( 'Site Logo', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'settings-site-identity', [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'PhotoIcon',
			],
			'site_favicon' => [
				'title' => __( 'Site Favicon', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'settings-site-identity', [ 'autofocus[section]' => 'title_tagline' ] ),
				'icon'  => 'AppsIcon',
			],
		];

		if ( Utils::is_elementor_active() ) {
			$config['quickLinks']['site_colors'] = [
				'title' => __( 'Site Colors', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'global-colors' ),
				'icon'  => 'BrushIcon',
			];

			$config['quickLinks']['site_fonts'] = [
				'title' => __( 'Site Fonts', 'hello-elementor' ),
				'link'  => $this->get_open_homepage_with_tab( 'global-typography' ),
				'icon'  => 'UnderlineIcon',
			];
		}

		return $config;
	}

	public function get_welcome_box_config( array $config ): array {
		$is_elementor_installed = Utils::is_elementor_installed();
		$is_elementor_active    = Utils::is_elementor_active();
		$has_pro                = Utils::has_pro();

		if ( ! $is_elementor_active ) {
			$link = $is_elementor_installed ? Utils::get_elementor_activation_link() : 'install';

			$config['welcome'] = [
				'title'   => __( 'Thanks for installing the Hello Theme!', 'hello-elementor' ),
				'text'    => __( 'Welcome to Hello Theme—a lightweight, blank canvas designed to integrate seamlessly with Elementor, the most popular, no-code visual website builder. By installing and activating Elementor, you\'ll unlock the power to craft a professional website with advanced features and functionalities.', 'hello-elementor' ),
				'buttons' => [
					[
						'linkText' => __( 'Install Elementor', 'hello-elementor' ),
						'variant'  => 'contained',
						'link'     => $link,
						'color'    => 'primary',
					],
				],
				'image'   => [
					'src' => HELLO_THEME_IMAGES_URL . 'install-elementor.png',
					'alt' => __( 'Install Elementor', 'hello-elementor' ),
				],
			];

			return $config;
		}

		if ( $is_elementor_active && ! $has_pro ) {
			$config['welcome'] = [
				'title'   => __( 'Go Pro, Go Limitless', 'hello-elementor' ),
				'text'    => __( 'Unlock the theme builder, popup builder, 100+ widgets and more advanced tools to take your website to the next level.', 'hello-elementor' ),
				'buttons' => [
					[
						'linkText' => __( 'Upgrade now', 'hello-elementor' ),
						'variant'  => 'contained',
						'link'     => 'https://go.elementor.com/hello-upgrade-epro/',
						'color'    => 'primary',
						'target'   => '_blank',
					],
				],
			];

			return $config;
		}

		$config['welcome'] = [];

		return $config;
	}
}
