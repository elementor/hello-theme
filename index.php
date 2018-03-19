<?php

get_header();

if ( is_singular() ) {
	do_action( 'elementor/theme/single' );
} elseif ( is_archive() || is_home() || is_search() ) {
	do_action( 'elementor/theme/archive' );
} else {
	do_action( 'elementor/theme/page_404' );
}

get_footer();
