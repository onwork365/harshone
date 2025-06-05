<?php
/**
 * Maintenance Mode Logic
 * Allows activating and displaying a custom maintenance page.
 *
 * @package Harshone
 * @version 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'harshone_activate_maintenance_mode' ) ) {
    /**
     * Activate maintenance mode and display maintenance.php template.
     */
    function harshone_activate_maintenance_mode() {
        // Get maintenance mode status from Redux theme options
        $is_maintenance_mode_active = harshone_get_theme_option( 'harshone_maintenance_mode', false );

        // Allow access to logged-in administrators
        if ( $is_maintenance_mode_active && ! current_user_can( 'manage_options' ) ) {
            // Set friendly HTTP status code
            header( 'HTTP/1.1 503 Service Unavailable' );
            header( 'Retry-After: 3600' ); // Retry after 1 hour

            // Render maintenance page
            status_header( 503 );
            include_once HARSHONE_DIR . 'maintenance.php';
            exit();
        }
    }
    // Hook early enough to prevent loading other content.
    add_action( 'template_redirect', 'harshone_activate_maintenance_mode' );
}