<?php
get_header();

if ( is_singular() ) {
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
		get_template_part( 'template-parts/single' );
	}
} elseif ( is_archive() || is_home() || is_search() ) {
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
		get_template_part( 'template-parts/archive' );
	}
} else {
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'page_404' ) ) {
		get_template_part( 'template-parts/404' );
	}
}

get_footer();
