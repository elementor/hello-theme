<?php

namespace Hello420Theme\Includes\Customizer;

use Hello420Theme\Includes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Hello_Customizer_Action_Links extends \WP_Customize_Control {

	// Whitelist content parameter.
	public $content = '';

	/**
	 * Render the control's content.
	 */
	public function render_content(): void {
		$this->print_customizer_action_links();

		if ( isset( $this->description ) ) {
			echo '<span class="description customize-control-description">' . wp_kses_post( $this->description ) . '</span>';
		}
	}

	/**
	 * Print customizer action links.
	 */
	private function print_customizer_action_links(): void {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$action_link_type = Utils::get_action_link_type();
		$theme_builder_url = Utils::get_theme_builder_url();

		$action_link_data = [];

		switch ( $action_link_type ) {
			case 'install-elementor':
				$action_link_data = [
					'image'   => get_template_directory_uri() . '/assets/images/elementor.svg',
					'alt'     => esc_attr__( 'Elementor', 'hello420' ),
					'title'   => esc_html__( 'Install Elementor', 'hello420' ),
					'message' => esc_html__( 'To design your site with Hello 420, install the Elementor plugin.', 'hello420' ),
					'button'  => esc_html__( 'Install Elementor', 'hello420' ),
					'link'    => Utils::get_plugin_install_url( 'elementor' ),
				];
				break;

			case 'activate-elementor':
				$action_link_data = [
					'image'   => get_template_directory_uri() . '/assets/images/elementor.svg',
					'alt'     => esc_attr__( 'Elementor', 'hello420' ),
					'title'   => esc_html__( 'Activate Elementor', 'hello420' ),
					'message' => esc_html__( 'To design your site with Hello 420, activate the Elementor plugin.', 'hello420' ),
					'button'  => esc_html__( 'Activate Elementor', 'hello420' ),
					'link'    => admin_url( Utils::get_elementor_activation_link() ),
				];
				break;

			case 'activate-header-footer-experiment':
				$action_link_data = [
					'image'   => get_template_directory_uri() . '/assets/images/elementor.svg',
					'alt'     => esc_attr__( 'Elementor', 'hello420' ),
					'title'   => esc_html__( 'Enable Header & Footer Styling', 'hello420' ),
					'message' => esc_html__( 'Hello 420 can style the theme header and footer from Elementor Site Settings.', 'hello420' ),
					'button'  => esc_html__( 'Open Elementor Experiments', 'hello420' ),
					'link'    => admin_url( 'admin.php?page=elementor#tab-experiments' ),
				];
				break;

			case 'style-header-footer':
			default:
				$action_link_data = [
					'image'   => get_template_directory_uri() . '/assets/images/elementor.svg',
					'alt'     => esc_attr__( 'Elementor', 'hello420' ),
					'title'   => esc_html__( 'Style Header & Footer in Elementor', 'hello420' ),
					'message' => esc_html__( 'Open Elementor Site Settings to style your site header and footer.', 'hello420' ),
					'button'  => esc_html__( 'Open Site Settings', 'hello420' ),
					'link'    => $theme_builder_url,
				];
				break;
		}

		echo wp_kses_post( $this->get_customizer_action_links_html( $action_link_data ) );
	}

	/**
	 * Build the customizer action links HTML.
	 */
	private function get_customizer_action_links_html( array $data ): string {
		$required = [ 'image', 'alt', 'title', 'message', 'link', 'button' ];
		foreach ( $required as $key ) {
			if ( empty( $data[ $key ] ) ) {
				return '';
			}
		}

		return sprintf(
			'<div class="hello-action-links">'
			. '<img src="%1$s" alt="%2$s">'
			. '<p class="hello-action-links-title">%3$s</p>'
			. '<p class="hello-action-links-message">%4$s</p>'
			. '<a class="button button-primary" href="%5$s">%6$s</a>'
			. '</div>',
			esc_url( $data['image'] ),
			esc_attr( $data['alt'] ),
			esc_html( $data['title'] ),
			esc_html( $data['message'] ),
			esc_url( $data['link'] ),
			esc_html( $data['button'] )
		);
	}
}
