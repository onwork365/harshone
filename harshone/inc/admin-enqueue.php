<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Function to enqueue scripts and styles for the FRONTEND
if ( ! function_exists( 'harshone_scripts' ) ) {
	/**
	 * Enqueue scripts and styles for the frontend.
	 */
	function harshone_scripts() {

		// Styles
		wp_enqueue_style( 'harshone-bootstrap', HARSHONE_URI . 'assets/css/bootstrap.min.css', array(), '5.3.0' );
		wp_enqueue_style( 'harshone-font-awesome', HARSHONE_URI . 'assets/css/font-awesome.min.css', array(), '6.0.0' ); // Adjust version

        // Enqueue WooCommerce specific stylesheet ONLY IF WooCommerce is active and on relevant pages.
        if ( class_exists( 'WooCommerce' ) ) {
		    wp_enqueue_style( 'harshone-woocommerce-style', HARSHONE_URI . 'assets/css/woocommerce.css', array(), HARSHONE_VERSION );
        }

		wp_enqueue_style( 'harshone-style', HARSHONE_URI . 'assets/css/harshone.css', array(), HARSHONE_VERSION );
        wp_enqueue_style( 'harshone-main-style', get_stylesheet_uri(), array(), HARSHONE_VERSION ); // Loads style.css itself

		// Font from Google Fonts (e.g., Roboto and Arial)
        wp_enqueue_style( 'harshone-google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Arial:wght@400;700&display=swap', array(), null );


		// Scripts
		wp_enqueue_script( 'harshone-bootstrap-bundle', HARSHONE_URI . 'assets/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.3.0', true );
		wp_enqueue_script( 'harshone-skip-link-focus-fix', HARSHONE_URI . 'assets/js/skip-link-focus-fix.js', array(), HARSHONE_VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Main theme custom script (frontend specific methods)
		wp_enqueue_script( 'harshone-main-script', HARSHONE_URI . 'assets/js/harshone.js', array( 'jquery' ), HARSHONE_VERSION, true );

        // Preloader hiding script (frontend specific)
        if ( harshone_get_theme_option('harshone_enable_preloader', false) ) {
            wp_enqueue_script( 'harshone-preloader-hide', HARSHONE_URI . 'assets/js/preloader-hide.js', array( 'jquery' ), HARSHONE_VERSION, true );
        }
	}
	add_action( 'wp_enqueue_scripts', 'harshone_scripts' );
}

// Function to enqueue scripts and styles for the ADMIN PANEL
if ( ! function_exists( 'harshone_admin_scripts' ) ) {
    /**
     * Enqueue scripts and styles for the admin panel, specifically for post/page/product edit screens.
     *
     * @param string $hook The current admin page hook.
     */
    function harshone_admin_scripts( $hook ) {
        if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
             $screen = get_current_screen();
             if ( ! in_array( $screen->post_type, array( 'post', 'page', 'product' ) ) ) {
                 // error_log('D: Admin JS - Hook ' . $hook . ', Post Type ' . $screen->post_type . ' skipped.'); // Debug log
                 return;
             }
        } else {
             // error_log('D: Admin JS - Hook ' . $hook . ' skipped.'); // Debug log
            return;
        }
        
        // error_log('D: Admin JS - Conditions met for hook: ' . $hook); // Debug log

        // --- MANUALLY ENQUEUE REDUX CORE JS ---
        // This is THE core Redux JS file. It must load and run without error first.
        // Its handles are often 'redux-js' or 'redux', but we custom register it here.
        $redux_core_js_file_rel_path = 'redux-framework/redux-core/assets/js/redux' . (is_admin() && SCRIPT_DEBUG ? '' : '.min') . '.js';
        $redux_core_js_url = plugins_url( $redux_core_js_file_rel_path );
        $redux_core_js_path_abs = WP_PLUGIN_DIR . '/' . $redux_core_js_file_rel_path;

        if ( file_exists( $redux_core_js_path_abs ) ) {
            wp_enqueue_script( 'redux-core-js-manual', $redux_core_js_url, array( 'jquery' ), '4.0.0', true ); // Register
            // error_log('D: Admin JS - Enqueued redux-core-js-manual: ' . $redux_core_js_url); // Debug log
        } else {
            // error_log('D: Admin JS - Redux Core JS file NOT FOUND: ' . $redux_core_js_path_abs); // Debug log
        }

        // --- MANUALLY ENQUEUE REDUX METABOXES' SPECIFIC JS ---
        // This file depends on Redux Core JS (`redux-core-js-manual`)
        $redux_metaboxes_js_file_rel_path = 'redux-framework/redux-core/inc/extensions/metaboxes/redux-extension-metaboxes' . (is_admin() && SCRIPT_DEBUG ? '' : '.min') . '.js';
        $redux_metaboxes_js_url = plugins_url( $redux_metaboxes_js_file_rel_path );
        $redux_metaboxes_js_path_abs = WP_PLUGIN_DIR . '/' . $redux_metaboxes_js_file_rel_path;

        if ( file_exists( $redux_metaboxes_js_path_abs ) ) {
            // IMPORTANT: 'redux-core-js-manual' as dependency. This ensures it loads after Redux core.
            wp_enqueue_script( 'redux-metaboxes-ext-js', $redux_metaboxes_js_url, array( 'jquery', 'redux-core-js-manual' ), '1.0.0', true ); 
            // error_log('D: Admin JS - Enqueued redux-metaboxes-ext-js: ' . $redux_metaboxes_js_url); // Debug log
        } else {
            // error_log('D: Admin JS - Redux Metaboxes JS file NOT FOUND: ' . $redux_metaboxes_js_path_abs); // Debug log
        }

        // --- ENQUEUE Harshone's custom admin JS (depends on Redux core) ---
        // This script will now run after Redux core and its extension JS are loaded (by dependency).
        wp_enqueue_script( 'harshone-admin-specific', HARSHONE_URI . 'assets/js/harshone.js', array( 'jquery', 'redux-core-js-manual' ), HARSHONE_VERSION, true );
        // error_log('D: Admin JS - Enqueued harshone-admin-specific: ' . HARSHONE_URI . 'assets/js/harshone.js'); // Debug log

    }
    // Set a priority of 10 to ensure it gets a reasonable chance to run, after most core WP scripts.
    add_action( 'admin_enqueue_scripts', 'harshone_admin_scripts', 10 );
}