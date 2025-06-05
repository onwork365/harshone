<?php
/**
 * Harshone functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Harshone
 * @since 1.0.0
 */

// Define theme constants
define( 'HARSHONE_VERSION', '1.0.0' );
define( 'HARSHONE_DIR', trailingslashit( get_template_directory() ) );
define( 'HARSHONE_URI', trailingslashit( get_template_directory_uri() ) );

// Load core theme files
require_once HARSHONE_DIR . 'inc/class-harshone-core.php';

/**
 * Initialize the theme
 */
function harshone_run() {
	$harshone_core = new Harshone_Core();
	$harshone_core->run();
}
harshone_run();

// Include maintenance mode file early to catch requests
require_once HARSHONE_DIR . 'inc/maintenance-mode.php';

/**
 * Notice: Function _load_textdomain_just_in_time called incorrectly.
 * This notice often appears because WordPress attempts to process theme metadata
 * (like 'Text Domain' in style.css) before the `after_setup_theme` hook where
 * `load_theme_textdomain()` is typically called. While it indicates an early attempt
 * to load translations, if translations are working correctly, this notice is usually
 * informational and does not signify a functional error. The `load_theme_textdomain`
 * call is correctly placed within the `after_setup_theme` hook.
 */