<?php

namespace HelloElementor\Includes\Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Hello_Customizer_Action_Links extends \WP_Customize_Control {

	// Whitelist content parameter
	public $content = '';

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper.
	 *
	 * @return void
	 */
	public function render_content() {
		$this->print_customizer_action_links();

		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . wp_kses_post( $this->description ) . '</span>';
		}
	}

	/**
	 * Print customizer action links.
	 *
	 * @return void
	 */
	private function print_customizer_action_links() {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$customizer_content = '';

		$plugins = get_plugins();

		if ( ! isset( $plugins['elementor/elementor.php'] ) ) {
			$customizer_content .= $this->get_customizer_action_links_html(
				get_template_directory_uri() . '/assets/images/elementor.svg',
				esc_html__( 'Install Elementor', 'hello-elementor' ),
				esc_html__( 'Create cross-site header & footer using Elementor.', 'hello-elementor' ),
				wp_nonce_url(
						add_query_arg(
							[
								'action' => 'install-plugin',
								'plugin' => 'elementor',
							],
						admin_url( 'update.php' )
					),
					'install-plugin_elementor'
				),
				esc_html__( 'Install Elementor', 'hello-elementor' )
			);
		} elseif ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			$customizer_content .= $this->get_customizer_action_links_html(
				get_template_directory_uri() . '/assets/images/elementor.svg',
				esc_html__( 'Activate Elementor', 'hello-elementor' ),
				esc_html__( 'Create cross-site header & footer using Elementor.', 'hello-elementor' ),
				wp_nonce_url( 'plugins.php?action=activate&plugin=elementor/elementor.php', 'activate-plugin_elementor/elementor.php' ),
				esc_html__( 'Activate Elementor', 'hello-elementor' )
			);
		} elseif ( ! hello_header_footer_experiment_active() ) {
			$customizer_content .= $this->get_customizer_action_links_html(
				get_template_directory_uri() . '/assets/images/elementor.svg',
				esc_html__( 'Set cross-site Header & Footer', 'hello-elementor' ),
				esc_html__( 'Create a cross-site header & footer using Elementor & Hello theme.', 'hello-elementor' ),
				wp_nonce_url( 'admin.php?page=elementor#tab-experiments' ),
				esc_html__( 'Activate Now', 'hello-elementor' )
			);
		} else {
			$customizer_content .= $this->get_customizer_action_links_html(
				get_template_directory_uri() . '/assets/images/elementor.svg',
				esc_html__( 'Style cross-site header & footer', 'hello-elementor' ),
				esc_html__( 'Customize your cross-site header & footer from Elementor’s "Site Settings" panel.', 'hello-elementor' ),
				wp_nonce_url( 'post.php?post=' . get_option( 'elementor_active_kit' ) . '&action=elementor' ),
				esc_html__( 'Start Designing', 'hello-elementor' )
			);
		}

		echo wp_kses_post( $customizer_content );
	}

	/**
	 * Get customizer action links HTML.
	 *
	 * @return void
	 */
	private function get_customizer_action_links_html( $image, $title, $text, $url, $button_text ) {
		return sprintf(
			'<div class="hello-action-links">
				<img src="%1$s">
				<p class="hello-action-links-title">%2$s</p>
				<p class="hello-action-links-message">%3$s</p>
				<a class="button button-primary" target="_blank" href="%4$s">%5$s</a>
			</div>',
			$image,
			$title,
			$text,
			$url,
			$button_text,
		);
	}
}
