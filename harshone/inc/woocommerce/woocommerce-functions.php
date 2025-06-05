<?php
/**
 * WooCommerce functions and definitions for Harshone.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'harshone_woocommerce_setup' ) ) {
    /**
     * Integrate WooCommerce with theme features.
     */
    function harshone_woocommerce_setup() {
        // Enqueue WooCommerce specific stylesheet - MOVED TO inc/enqueue.php/harshone_scripts()
        // The line below should be commented out or removed if it's causing the warning.
        // wp_enqueue_style( 'harshone-woocommerce-style', HARSHONE_URI . 'assets/css/woocommerce.css', array(), HARSHONE_VERSION );

        // Declare WooCommerce support
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        // Add additional image sizes for WooCommerce if needed.
        add_image_size( 'harshone_product_thumbnail', 300, 300, true );
        add_image_size( 'harshone_product_single', 600, 600, true );

        // Remove default WooCommerce stylesheet (if you're providing all styles via your woocommerce.css)
        add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
    }
    add_action( 'after_setup_theme', 'harshone_woocommerce_setup' );
}

/**
 * Custom function to display star ratings.
 * Can be called in template overrides like `template-parts/woocommerce/loop/rating.php`.
 */
if ( ! function_exists( 'harshone_woocommerce_star_rating' ) ) {
    function harshone_woocommerce_star_rating() {
        if ( post_type_supports( 'product', 'comments' ) ) {
            wc_get_template( 'loop/rating.php' );
        }
    }
}

/**
 * Custom function to display add to cart button.
 * Can be called in template overrides like `template-parts/woocommerce/loop/add-to-cart.php`.
 */
if ( ! function_exists( 'harshone_woocommerce_add_to_cart_button' ) ) {
    function harshone_woocommerce_add_to_cart_button() {
        wc_get_template( 'loop/add-to-cart.php' );
    }
}

/**
 * Adjust number of products per row on shop/archive pages.
 */
if ( ! function_exists( 'harshone_woocommerce_loop_columns' ) ) {
    function harshone_woocommerce_loop_columns() {
        return 4; // 4 products per row
    }
    add_filter( 'loop_shop_columns', 'harshone_woocommerce_loop_columns' );
}

/**
 * Adjust number of products per page.
 */
if ( ! function_exists( 'harshone_woocommerce_products_per_page' ) ) {
    function harshone_woocommerce_products_per_page() {
        return 12; // 12 products per page
    }
    add_filter( 'loop_shop_per_page', 'harshone_woocommerce_products_per_page', 20 );
}

/**
 * Ensure cart contents update when products are removed in the cart.
 */
if ( ! function_exists( 'harshone_woocommerce_cart_refresh' ) ) {
    function harshone_woocommerce_cart_refresh() {
        if ( is_cart() ) {
            wc_enqueue_js( 'jQuery(document.body).on("removed_from_cart", function(){ jQuery("div.woocommerce-page-wrapper").load(document.location.href + " div.woocommerce-page-wrapper"); });' );
        }
    }
    add_action( 'wp_footer', 'harshone_woocommerce_cart_refresh' );
}

/**
 * Display number of items in cart next to menu.
 */
if ( ! function_exists( 'harshone_woocommerce_cart_icon_and_count' ) ) {
    function harshone_woocommerce_cart_icon_and_count() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            return;
        }
        ob_start();
        ?>
        <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'harshone' ); ?>">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <span class="count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            <span class="amount"><?php echo WC()->cart->get_cart_total(); ?></span>
        </a>
        <?php
        $output = ob_get_clean();
        echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    add_action( 'harshone_header_right_area', 'harshone_woocommerce_cart_icon_and_count', 20 );
    add_filter( 'woocommerce_add_to_cart_fragments', 'harshone_woocommerce_cart_handle_ajax' );
}

/**
 * Ensure cart contents update when products are added to cart via AJAX.
 *
 * @param array $fragments Fragments to refresh.
 * @return array Fragments to refresh.
 */
if ( ! function_exists( 'harshone_woocommerce_cart_handle_ajax' ) ) {
    function harshone_woocommerce_cart_handle_ajax( $fragments ) {
        ob_start();
        harshone_woocommerce_cart_icon_and_count();
        $fragments['a.cart-contents'] = ob_get_clean();
        return $fragments;
    }
}

/**
 * Filter WooCommerce wrapper divs to match theme's container.
 * This is already handled by `woocommerce.php` but an explicit filter can be used.
 */
if ( ! function_exists( 'harshone_woocommerce_wrapper_start' ) ) {
	function harshone_woocommerce_wrapper_start() {
		echo '<div id="primary" class="content-area"><main id="main" class="site-main container py-5">';
	}
}
if ( ! function_exists( 'harshone_woocommerce_wrapper_end' ) ) {
	function harshone_woocommerce_wrapper_end() {
		echo '</main></div>';
	}
}
// Remove default WooCommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
// Add theme's wrappers
// add_action( 'woocommerce_before_main_content', 'harshone_woocommerce_wrapper_start', 10 );
// add_action( 'woocommerce_after_main_content', 'harshone_woocommerce_wrapper_end', 10 );
// The custom woocommerce.php already handles the layout, so these specific wrapper functions may not be required.
