<?php
/**
 * Redux Framework Loader for Harshone
 *
 * This file is responsible for loading the Redux Framework.
 * IMPORTANT: For ThemeForest submissions, it is highly recommended
 * to include Redux Framework as a *recommended plugin* via TGM Plugin Activation,
 * rather than bundling it directly within the theme.
 *
 * If you choose to bundle, you must download the Redux Framework plugin
 * from WordPress.org and place its contents (specifically the 'ReduxCore' folder
 * and other main Redux files) inside this 'inc/redux/' directory.
 *
 * @package Harshone
 * @subpackage Admin
 * @since 1.0.0
 */

// If Redux Framework is already loaded, don't load again.
if ( ! class_exists( 'ReduxFramework' ) ) {
    
    // Path to the main ReduxCore class.
    // Assuming you've copied the 'ReduxCore' folder from the plugin into this directory.
    // Example: inc/redux/ReduxCore/ReduxCore.php
    $redux_core_path = trailingslashit( dirname( __FILE__ ) ) . 'ReduxCore/ReduxCore.php';

    // Verify the file exists before including.
    if ( file_exists( $redux_core_path ) ) {
        require_once $redux_core_path;
    } else {
        // Fallback message if Redux Core is not found.
        // This might indicate the files were not copied correctly.
        error_log( 'Harshone Theme: Redux Framework Core files not found at ' . $redux_core_path );
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error is-dismissible">';
            echo '<p><strong>' . esc_html__( 'Harshone Theme Warning:', 'harshone' ) . '</strong> ' . esc_html__( 'Redux Framework is not properly installed. Please ensure its core files are located in the "inc/redux/" directory as per theme documentation.', 'harshone' ) . '</p>';
            echo '</div>';
        });
        return; // Stop further Redux processing.
    }
} else {
    // Redux Framework is already active (e.g., as a plugin).
    // In this case, our bundled version won't interfere.
}

// Any other Redux initialization code (e.g., custom extensions if bundled).
// For the primary theme options config, it's included in class-harshone-core.php.
// require_once HARSHONE_DIR . 'inc/theme-options/config.php'; // Already included in class-harshone-core.php
