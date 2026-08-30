<?php
/**
 * Block editor patterns and styles for Theme Check compatibility.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'hello_elementor_register_block_patterns' ) ) {
	/**
	 * Register minimal block patterns and styles.
	 *
	 * @return void
	 */
	function hello_elementor_register_block_patterns() {
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}

		register_block_pattern(
			'hello-elementor/section',
			[
				'title'       => esc_html__( 'Hello Section', 'hello-elementor' ),
				'description' => esc_html__( 'A simple content section.', 'hello-elementor' ),
				'content'     => '<!-- wp:group {"layout":{"type":"constrained"}} --><div class="wp-block-group"><!-- wp:heading --><h2 class="wp-block-heading">' . esc_html__( 'Section title', 'hello-elementor' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>' . esc_html__( 'Add your content here.', 'hello-elementor' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
				'categories'  => [ 'text' ],
			]
		);

		if ( function_exists( 'register_block_style' ) ) {
			register_block_style(
				'core/group',
				[
					'name'  => 'hello-elementor-section',
					'label' => esc_html__( 'Hello Section', 'hello-elementor' ),
				]
			);
		}
	}
}
add_action( 'init', 'hello_elementor_register_block_patterns' );
