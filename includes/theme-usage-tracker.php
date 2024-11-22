<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Ping theme usage on code update for existing installations.
 */
add_action( 'init', 'track_theme_usage_on_update' );
function track_theme_usage_on_update() {
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

/**
 * Ping remote server with theme usage logs using an API key.
 */
function track_theme_usage() {
    $serverUrl = 'https://zoro.com.au';
    $remote_url = $serverUrl . '/api-track.php'; // Update with the actual endpoint URL
    $api_key = 'your-secure-api-key-1'; // Replace with the site's unique API key

    $current_theme = wp_get_theme();

    $theme_data = array(
        'theme_name' => $current_theme->get('Name'),
        'theme_version' => $current_theme->get('Version'),
        'author' => $current_theme->get('Author'),
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
        $return = true;
    }

    return $return;
}