<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @return void
 */
function hello_elementor_fail_load_admin_notice() {
	// Leave to Elementor Pro to manage this.
	if ( function_exists( 'elementor_pro_load_plugin' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	if ( 'true' === get_user_meta( get_current_user_id(), '_hello_elementor_install_notice', true ) ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	$installed_plugins = get_plugins();

	$is_elementor_installed = isset( $installed_plugins[ $plugin ] );

	if ( $is_elementor_installed ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$message = esc_html__( 'The Hello Theme is a lightweight starter theme that works perfectly with the Elementor award-winning page builder plugin. Once you activate the plugin, you are only 1 click away from building an amazing website.', 'hello-elementor' );

		$button_text = esc_html__( 'Activate Elementor', 'hello-elementor' );
		$button_link = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$message = esc_html__( 'The Hello Theme is a lightweight starter theme that works perfectly with the Elementor award-winning page builder plugin. Once you download and activate the plugin, you are only 1 click away from building an amazing website.', 'hello-elementor' );

		$button_text = esc_html__( 'Install Elementor', 'hello-elementor' );
		$button_link = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
	}

	?>
	<style>
		.notice.hello-elementor-notice {
			border: 1px solid #ccd0d4;
			border-inline-start: 4px solid #9b0a46 !important;
			box-shadow: 0 1px 4px rgba(0,0,0,0.15);
			display: flex;
			padding: 0px;
		}
		.notice.hello-elementor-notice .hello-elementor-notice-aside {
			width: 50px;
			display: flex;
			align-items: start;
			justify-content: center;
			padding-block-start: 15px;
			background: rgba(215,43,63,0.04);
		}
		.notice.hello-elementor-notice .hello-elementor-notice-aside img{
			width: 1.5rem;
		}
		.notice.hello-elementor-notice .hello-elementor-notice-inner {
			display: table;
			padding: 20px 0px;
			width: 100%;
		}
		.notice.hello-elementor-notice .hello-elementor-notice-content {
			padding: 0 20px;
		}
		.notice.hello-elementor-notice p {
			padding: 0;
			margin: 0;
		}
		.notice.hello-elementor-notice h3 {
			margin: 0 0 5px;
		}
		.notice.hello-elementor-notice .hello-elementor-install-now {
			display: block;
			margin-block-start: 15px;
		}
		.notice.hello-elementor-notice .hello-elementor-install-now .hello-elementor-install-button {
			background: #127DB8;
			border-radius: 3px;
			color: #fff;
			text-decoration: none;
			height: auto;
			line-height: 20px;
			padding: 0.4375rem 0.75rem;
			text-transform: capitalize;
		}
		.notice.hello-elementor-notice .hello-elementor-install-now .hello-elementor-install-button:active {
			transform: translateY(1px);
		}
		@media (max-width: 767px) {
			.notice.hello-elementor-notice.hello-elementor-install-elementor {
				padding: 0px;
			}
			.notice.hello-elementor-notice .hello-elementor-notice-inner {
				display: block;
				padding: 10px;
			}
			.notice.hello-elementor-notice .hello-elementor-notice-inner .hello-elementor-notice-content {
				display: block;
				padding: 0;
			}
			.notice.hello-elementor-notice .hello-elementor-notice-inner .hello-elementor-install-now {
				display: none;
			}
		}
	</style>
	<script>jQuery( function( $ ) {
			$( 'div.notice.hello-elementor-install-elementor' ).on( 'click', 'button.notice-dismiss', function( event ) {
				event.preventDefault();

				$.post( ajaxurl, {
					action: 'hello_elementor_set_admin_notice_viewed'
				} );
			} );
		} );</script>
	<div class="notice updated is-dismissible hello-elementor-notice hello-elementor-install-elementor">
		<div class="hello-elementor-notice-aside">
			<img src="<?php echo esc_url( get_template_directory_uri() ) . '/assets/images/elementor-notice-icon.svg'; ?>" alt="<?php echo esc_attr__( 'Get Elementor', 'hello-elementor' ); ?>" />
		</div>
		<div class="hello-elementor-notice-inner">
			<div class="hello-elementor-notice-content">
				<h3><?php echo esc_html__( 'Thanks for installing the Hello Theme!', 'hello-elementor' ); ?></h3>
				<p><?php echo esc_html( $message ); ?></p>
				<a href="https://go.elementor.com/hello-theme-learn/" target="_blank"><?php echo esc_html__( 'Explore Elementor Page Builder Plugin', 'hello-elementor' ); ?></a>
				<div class="hello-elementor-install-now">
					<a class="hello-elementor-install-button" href="<?php echo esc_attr( $button_link ); ?>"><?php echo esc_html( $button_text ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Set Admin Notice Viewed.
 *
 * @return void
 */
function ajax_hello_elementor_set_admin_notice_viewed() {
	update_user_meta( get_current_user_id(), '_hello_elementor_install_notice', 'true' );
	die;
}

add_action( 'wp_ajax_hello_elementor_set_admin_notice_viewed', 'ajax_hello_elementor_set_admin_notice_viewed' );
if ( ! did_action( 'elementor/loaded' ) ) {
	add_action( 'admin_notices', 'hello_elementor_fail_load_admin_notice' );
}
