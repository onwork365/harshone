<?php
/**
 * One Click Demo Import (OCDI) configuration for Harshone.
 *
 * @link https://github.com/proteusthemes/one-click-demo-import/
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure OCDI plugin is active before trying to use its filters.
// The TGM Plugin Activation handles ensuring this is recommended/required.
if ( ! class_exists( 'OCDI_Plugin' ) ) {
	return;
}

if ( ! function_exists( 'harshone_ocdi_import_files' ) ) {
	/**
	 * Register the demo import files.
	 *
	 * @return array The array of import files.
	 */
	function harshone_ocdi_import_files() {
		$base_demo_url = 'https://punsys.com/themes-data/harshone/demo-files/';
		$base_preview_url = 'https://punsys.com/themes/harshone/';

		return array(
			// Harshone Demo 01
			array(
				'import_file_name'             => esc_html__( 'Harshone Demo 01', 'harshone' ),
				'import_file_url'              => $base_demo_url . 'demo-01/content.xml',
				'import_widget_file_url'       => $base_demo_url . 'demo-01/widgets.wie',
				'import_redux_file_url'        => $base_demo_url . 'demo-01/redux_options.json',
				'import_redux_options_name'    => 'harshone_options', // Must match your Redux opt_name
				'import_preview_image_url'     => $base_demo_url . 'demo-01/preview.jpg',
				'import_notice'                => esc_html__( 'This demo offers a clean, modern design. Importing will replace your content, widgets, menus, and theme options.', 'harshone' ),
				'preview_url'                  => $base_preview_url . 'demo-01',
			),
			// Harshone Demo 02
			array(
				'import_file_name'             => esc_html__( 'Harshone Demo 02', 'harshone' ),
				'import_file_url'              => $base_demo_url . 'demo-02/content.xml',
				'import_widget_file_url'       => $base_demo_url . 'demo-02/widgets.wie',
				'import_redux_file_url'        => $base_demo_url . 'demo-02/redux_options.json',
				'import_redux_options_name'    => 'harshone_options',
				'import_preview_image_url'     => $base_demo_url . 'demo-02/preview.jpg',
				'import_notice'                => esc_html__( 'This demo is perfect for a more boutique look and feel. Importing will replace your content, widgets, menus, and theme options.', 'harshone' ),
				'preview_url'                  => $base_preview_url . 'demo-02',
			),
			// Harshone Demo 03
			array(
				'import_file_name'             => esc_html__( 'Harshone Demo 03', 'harshone' ),
				'import_file_url'              => $base_demo_url . 'demo-03/content.xml',
				'import_widget_file_url'       => $base_demo_url . 'demo-03/widgets.wie',
				'import_redux_file_url'        => $base_demo_url . 'demo-03/redux_options.json',
				'import_redux_options_name'    => 'harshone_options',
				'import_preview_image_url'     => $base_demo_url . 'demo-03/preview.jpg',
				'import_notice'                => esc_html__( 'This demo provides a bold and vibrant design. Importing will replace your content, widgets, menus, and theme options.', 'harshone' ),
				'preview_url'                  => $base_preview_url . 'demo-03',
			),
			// Harshone Demo 04
			array(
				'import_file_name'             => esc_html__( 'Harshone Demo 04', 'harshone' ),
				'import_file_url'              => $base_demo_url . 'demo-04/content.xml',
				'import_widget_file_url'       => $base_demo_url . 'demo-04/widgets.wie',
				'import_redux_file_url'        => $base_demo_url . 'demo-04/redux_options.json',
				'import_redux_options_name'    => 'harshone_options',
				'import_preview_image_url'     => $base_demo_url . 'demo-04/preview.jpg',
				'import_notice'                => esc_html__( 'This demo is suited for minimalist and clean shops. Importing will replace your content, widgets, menus, and theme options.', 'harshone' ),
				'preview_url'                  => $base_preview_url . 'demo-04',
			),
			// Harshone Demo 05
			array(
				'import_file_name'             => esc_html__( 'Harshone Demo 05', 'harshone' ),
				'import_file_url'              => $base_demo_url . 'demo-05/content.xml',
				'import_widget_file_url'       => $base_demo_url . 'demo-05/widgets.wie',
				'import_redux_file_url'        => $base_demo_url . 'demo-05/redux_options.json',
				'import_redux_options_name'    => 'harshone_options',
				'import_preview_image_url'     => $base_demo_url . 'demo-05/preview.jpg',
				'import_notice'                => esc_html__( 'This demo offers a classic layout with strong imagery. Importing will replace your content, widgets, menus, and theme options.', 'harshone' ),
				'preview_url'                  => $base_preview_url . 'demo-05',
			),
		);
	}
	add_filter( 'ocdi/import_files', 'harshone_ocdi_import_files' );
}

if ( ! function_exists( 'harshone_ocdi_after_import_setup' ) ) {
	/**
	 * Define actions that happen after import.
	 *
	 * @param array $selected_import The selected import option.
	 */
	function harshone_ocdi_after_import_setup( $selected_import ) {
		// Assign menus to locations after import.
        // These menu names should exist in your demo content XML file.
		$main_menu_name   = 'Main Menu'; // Replace with actual menu name from your demo content
		$footer_menu_name = 'Footer Menu'; // Replace with actual menu name from your demo content

		$main_menu   = get_term_by( 'name', $main_menu_name, 'nav_menu' );
		$footer_menu = get_term_by( 'name', $footer_menu_name, 'nav_menu' );

		$locations = get_theme_mod( 'nav_menu_locations' );
		if ( $main_menu ) {
			$locations['primary-menu'] = $main_menu->term_id;
		}
		if ( $footer_menu ) {
			$locations['footer-menu'] = $footer_menu->term_id;
		}
		set_theme_mod( 'nav_menu_locations', $locations );

		// Assign front page and posts page (if they exist in demo content).
        // These page titles should exist in your demo content XML file.
		$front_page_title = 'Home'; // Replace with actual homepage title from your demo content
		$blog_page_title  = 'Blog';  // Replace with actual blog page title from your demo content

		$front_page = get_page_by_title( $front_page_title );
		$blog_page  = get_page_by_title( $blog_page_title );

		if ( $front_page && $blog_page ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $front_page->ID );
			update_option( 'page_for_posts', $blog_page->ID );
		}

		// Set WooCommerce pages after import (if WooCommerce is active and pages exist in demo content).
		if ( class_exists( 'WooCommerce' ) ) {
			$shop_page_title      = 'Shop';
			$cart_page_title      = 'Cart';
			$checkout_page_title  = 'Checkout';
			$my_account_page_title = 'My account';

			$shop_page   = get_page_by_title( $shop_page_title );
			$cart_page   = get_page_by_title( $cart_page_title );
			$checkout_page = get_page_by_title( $checkout_page_title );
			$my_account_page = get_page_by_title( $my_account_page_title );

			if ( $shop_page ) {
				update_option( 'woocommerce_shop_page_id', $shop_page->ID );
			}
			if ( $cart_page ) {
				update_option( 'woocommerce_cart_page_id', $cart_page->ID );
			}
			if ( $checkout_page ) {
				update_option( 'woocommerce_checkout_page_id', $checkout_page->ID );
			}
			if ( $my_account_page ) {
				update_option( 'woocommerce_myaccount_page_id', $my_account_page->ID );
			}
		}

		// Update permalink structure to a common pretty permalink.
		update_option( 'permalink_structure', '/%postname%/' );
		flush_rewrite_rules(); // Flush rewrite rules after changing permalink structure.
	}
	add_action( 'ocdi/after_import_setup', 'harshone_ocdi_after_import_setup' );
}

if ( ! function_exists( 'harshone_ocdi_confirmation_dialog_options' ) ) {
	/**
	 * Custom confirmation dialog for import.
	 *
	 * @param array $options Confirmation options.
	 * @return array Filtered options.
	 */
	function harshone_ocdi_confirmation_dialog_options( $options ) {
		return array_merge( $options, array(
			'width'        => 500,
			'dialog_title' => esc_html__( 'Are you sure?', 'harshone' ),
			'dialog_text'  => esc_html__( 'Importing demo content will overwrite your existing site content, widgets, menus, and theme options. We recommend doing this on a fresh WordPress installation. Are you sure you want to proceed?', 'harshone' ),
		));
	}
	add_filter( 'ocdi/confirmation_dialog_options', 'harshone_ocdi_confirmation_dialog_options' );
}

// Optional: Disable OCDI notices that appear after import (if you handle them yourself).
// add_filter( 'ocdi/disable_import_notice', '__return_true' );
// add_filter( 'ocdi/disable_plugin_page_notice', '__return_true' );
