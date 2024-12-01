<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Some codes for this feature are in customizer_settings.php
// Disable wp_elementor_enable_ai for all Administrator and Editor users
add_action( 'admin_init', function(){
  // Only run in the admin area for users with Administrator or Editor roles
  if (!is_admin() || !(current_user_can('administrator') || current_user_can('editor'))) {
    return;
  }

  update_option( 'elementor_pro_tracker_notice', 1 );
  update_option( 'elementor_tracker_notice', 1 );

  $disable_elementor_ai = get_theme_mod( 'htc_theme_elementor_ai_setting' );

  // Get the current user's data
  $current_user = wp_get_current_user();

  if( $disable_elementor_ai != "no" ) {
    update_user_meta( $current_user->ID, 'wp_elementor_enable_ai', '0' );
  }
  else {
    update_user_meta( $current_user->ID, 'wp_elementor_enable_ai', '1' );
  }
});

// Disable wp_elementor_enable_ai for new users upon registration
add_action( 'user_register', function($user_id) {
  $disable_elementor_ai = get_theme_mod( 'htc_theme_elementor_ai_setting' );

  if( $disable_elementor_ai != "no" ) {
    update_user_meta( $user_id, 'wp_elementor_enable_ai', '0' );
  }
});

// Disable Elementor notices
add_action( 'admin_footer', function() {
  $hide_elementor_notices = get_theme_mod( 'htc_theme_elementor_notices_setting' );

  if( $hide_elementor_notices != "no" ) {
    echo '<style>.notice.e-notice{display: none !important;}</style>';
  }
});