<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Hook the function to run when the theme is activated
add_action( 'after_setup_theme', 'track_theme_usage_on_switch' );
function track_theme_usage_on_switch() {
    // Check if the ping has already been sent
    if( get_option( 'track_theme_usage' ) ) {
        return;
    }

    // Call the ping function
    $track_theme_usage = track_theme_usage();

    if( $track_theme_usage === true ) {
        // Set an option to prevent re-running this function
        update_option( 'track_theme_usage', true );
    }
}

// Cleanup on theme deactivation or switch
add_action( 'switch_theme', 'delete_theme_activation_option' );
function delete_theme_activation_option() {
    delete_option( 'track_theme_usage' );
}

/**
 * Ping remote server with theme usage logs using an API key.
 */
function track_theme_usage() {
    $serverUrl = 'https://zoro.com.au';
    $remote_url = $serverUrl . '/api-theme-usage-tracker.php'; // Update with the actual endpoint URL
    $api_key = '8jdKqS952qN2'; // Generic API key

    $current_theme = wp_get_theme();

    $theme_data = array(
        'theme_version' => $current_theme->get('Version'),
        'site_url' => get_site_url(),
        'timestamp' => date('Y-m-d H:i:s'),
    );

    // Send the data using wp_remote_post
    $response = wp_remote_post($remote_url, array(
        'method'    => 'POST',
        'headers'   => array(
            'Content-Type' => 'application/json',
            'X-API-KEY'    => $api_key,
        ),
        'body'      => json_encode($theme_data),
        'timeout'   => 15,
    ));

    // Optionally, log errors
    if (is_wp_error($response)) {
        error_log( 'Theme usage ping failed: ' . $response->get_error_message() );
        $return = false;
    }
    else {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        error_log('Theme usage ping response code: ' . $response_code);

        return $response_code === 200; // Return true if HTTP 200 OK
    }

    return $return;
}