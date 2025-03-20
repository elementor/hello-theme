<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'init', 'hello_elementor_tweak_settings', 0 );


/**
 * Theme tweaks & settings.
 */
function hello_elementor_tweak_settings() {

	$settings_group = 'hello_elementor_settings';

	$settings = [
		'DESCRIPTION_META_TAG' => '_description_meta_tag',
		'SKIP_LINK' => '_skip_link',
		'HEADER_FOOTER' => '_header_footer',
		'PAGE_TITLE' => '_page_title',
		'HELLO_STYLE' => '_hello_style',
		'HELLO_THEME' => '_hello_theme',
	];

	hello_elementor_register_settings( $settings_group, $settings );
	hello_elementor_render_tweaks( $settings_group, $settings );
}

/**
 * Register theme settings.
 */
function hello_elementor_register_settings( $settings_group, $settings ) {

	foreach ( $settings as $setting_key => $setting_value ) {
		register_setting(
			$settings_group,
			$settings_group . $setting_value,
			[
				'default' => '',
				'show_in_rest' => true,
				'type' => 'string',
			]
		);
	}

}

/**
 * Run a tweek only if the user requested it.
 */
function hello_elementor_do_tweak( $setting, $tweak_callback ) {

	$option = get_option( $setting );
	if ( isset( $option ) && ( 'true' === $option ) && is_callable( $tweak_callback ) ) {
		$tweak_callback();
	}

}

/**
 * Render theme tweaks.
 */
function hello_elementor_render_tweaks( $settings_group, $settings ) {

	hello_elementor_do_tweak( $settings_group . $settings['DESCRIPTION_META_TAG'], function() {
		remove_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );
	} );

	hello_elementor_do_tweak( $settings_group . $settings['SKIP_LINK'], function() {
		add_filter( 'hello_elementor_enable_skip_link', '__return_false' );
	} );

	hello_elementor_do_tweak( $settings_group . $settings['HEADER_FOOTER'], function() {
		add_filter( 'hello_elementor_header_footer', '__return_false' );
	} );

	hello_elementor_do_tweak( $settings_group . $settings['PAGE_TITLE'], function() {
		add_filter( 'hello_elementor_page_title', '__return_false' );
	} );

	hello_elementor_do_tweak( $settings_group . $settings['HELLO_STYLE'], function() {
		add_filter( 'hello_elementor_enqueue_style', '__return_false' );
	} );

	hello_elementor_do_tweak( $settings_group . $settings['HELLO_THEME'], function() {
		add_filter( 'hello_elementor_enqueue_theme_style', '__return_false' );
	} );

}
