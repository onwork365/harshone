<?php
/**
 * WooCommerce Hooks and Filters for Harshone.
 * This file removes and adds default WooCommerce hooks to customize the layout.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ===========================================
// Shop / Archive Pages
// ===========================================

// Remove default WooCommerce breadcrumbs (theme will use its own)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
// Add theme breadcrumbs (if you want them displayed on WC pages before content)
// add_action( 'woocommerce_before_main_content', 'harshone_breadcrumbs', 15 );


// Remove default WooCommerce loop actions that will be re-added or handled in custom template parts
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );


// Change product listing grid layout
// add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 ); // Default is already there
// add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 ); // Default is already there
// add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); // Default is already there

// Re-add product title with custom wrapper for styling
if ( ! function_exists( 'harshone_woocommerce_shop_loop_item_title' ) ) {
    function harshone_woocommerce_shop_loop_item_title() {
        echo '<h2 class="woocommerce-loop-product__title"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h2>';
    }
}
add_action( 'woocommerce_shop_loop_item_title', 'harshone_woocommerce_shop_loop_item_title', 10 );

// Adjust star rating position/display
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'harshone_woocommerce_star_rating', 6 ); // Defined in woocommerce-functions.php

// Customize "add to cart" in product loop.
// Could be removed entirely and handled in template-parts/woocommerce/content-product.php
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
// add_action( 'woocommerce_after_shop_loop_item', 'harshone_woocommerce_add_to_cart_button', 10 );


// ===========================================
// Single Product Pages
// ===========================================

// Move product title outside the summary (if custom layout)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );

// Remove default product tabs
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
// If you want to put them back in a custom area, use:
// add_action( 'harshone_single_product_after_image', 'woocommerce_output_product_data_tabs', 10 );

// Change default product meta display
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 35 ); // Move it up

// Relate products & upsells. Handled in custom template overrides
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
// You can re-add them in your template-parts/woocommerce/single-product.php
// or create custom hooks to place them.
// add_action( 'harshone_single_product_after_main_content', 'woocommerce_upsell_display', 5 );
// add_action( 'harshone_single_product_after_main_content', 'woocommerce_output_related_products', 10 );


// ===========================================
// Cart / Checkout
// ===========================================

// Customize number of cross-sells displayed on cart page
add_filter( 'woocommerce_cross_sells_total', 'harshone_cross_sells_total' );
add_filter( 'woocommerce_cross_sells_columns', 'harshone_cross_sells_columns' );

if ( ! function_exists( 'harshone_cross_sells_total' ) ) {
	function harshone_cross_sells_total( $limit ) {
		return 4; // Show 4 cross-sells
	}
}

if ( ! function_exists( 'harshone_cross_sells_columns' ) ) {
	function harshone_cross_sells_columns( $columns ) {
		return 4; // Display 4 columns
	}
}


// Filter out default WooCommerce notices to replace with custom styled ones
remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_checkout_form', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_cart', 'wc_print_notices', 10 );
// Instead, use wc_print_notices() within the custom templates `notices/error.php`, `notices/success.php`
// or place them via `add_action`:
// add_action( 'harshone_before_content', 'wc_print_notices', 10 );

