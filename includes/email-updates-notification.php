<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Disable WP core updates email notification via customizer settings
$disable_core_email = get_theme_mod( 'htc_core_email_setting' );
$disable_plugin_email = get_theme_mod( 'htc_plugin_email_setting' );
$disable_theme_email = get_theme_mod( 'htc_theme_email_setting' );

$disable_core_email_option = true;
$disable_plugin_email_option = true;
$disable_theme_email_option = true;

if( "no" == $disable_core_email ){
  $disable_core_email_option = false;
}

if( "no" == $disable_plugin_email ){
  $disable_plugin_email_option = false;
}

if( "no" == $disable_theme_email ){
  $disable_theme_email_option = false;
}

if( true == $disable_core_email_option ){
	add_filter( 'auto_core_update_send_email', '__return_false' );
}

if( true == $disable_plugin_email_option ){
	add_filter( 'auto_plugin_update_send_email', '__return_false' );
}

if( true == $disable_theme_email_option ){
	add_filter( 'auto_theme_update_send_email', '__return_false' );
}