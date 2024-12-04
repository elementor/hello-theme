<?php
// Disable Comments functionality
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Disable support for comments and trackbacks in post types
add_action( 'admin_init', 'custom_jw_disable_comments_support' );
function custom_jw_disable_comments_support() {
  $post_types = get_post_types();
  foreach ($post_types as $post_type) {
    if(post_type_supports( $post_type, 'comments' )) {
      remove_post_type_support( $post_type, 'comments' );
      remove_post_type_support( $post_type, 'trackbacks' );
    }
  }

  global $pagenow;
  if ($pagenow === 'edit-comments.php') {
    wp_redirect( admin_url() ); exit;
  }
}

// Close comments on the front-end
add_filter( 'comments_open', 'custom_jw_disable_comments_status', 20, 2 );
add_filter( 'pings_open', 'custom_jw_disable_comments_status', 20, 2 );
function custom_jw_disable_comments_status() {
  return false;
}

// Hide existing comments
add_filter( 'comments_array', 'custom_jw_disable_comments_hide', 10, 2 );
function custom_jw_disable_comments_hide($comments) {
  $comments = array();
  return $comments;
}

// Remove comments page in menu
add_action( 'admin_menu', 'custom_jw_disable_comments_admin_menu' );
function custom_jw_disable_comments_admin_menu() {
  remove_menu_page( 'edit-comments.php' );
  remove_submenu_page( 'options-general.php', 'options-discussion.php' );
}

// Remove comments links from admin bar
add_action( 'init', 'custom_jw_disable_comments_admin_bar' );
function custom_jw_disable_comments_admin_bar() {
  if (is_admin_bar_showing()) {
    remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
  }
}