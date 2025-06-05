<?php
/**
 * Harshone WooCommerce Class
 * Centralizes WooCommerce specific functionality.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Harshone_WooCommerce' ) ) {

	class Harshone_WooCommerce {

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Initialize hooks.
		 */
		private function init_hooks() {
			// Add custom WooCommerce body classes.
			add_filter( 'body_class', array( $this, 'woocommerce_body_classes' ) );

			// Adjust wrapper for product archives.
			// This is largely handled by woocommerce.php, but if needed, can add filters here.
			// add_action( 'woocommerce_before_main_content', array( $this, 'start_content_wrapper' ), 5 );
			// add_action( 'woocommerce_after_main_content', array( $this, 'end_content_wrapper' ), 20 );
		}

		/**
		 * Add WooCommerce-specific classes to the body tag.
		 *
		 * @param array $classes Array of body classes.
		 * @return array Modified array of body classes.
		 */
		public function woocommerce_body_classes( $classes ) {
			if ( class_exists( 'WooCommerce' ) ) {
				$classes[] = 'woocommerce-active';

				if ( is_shop() || is_product_category() || is_product_tag() || is_archive() ) {
					$classes[] = 'woocommerce-archive';
				}

				if ( is_product() ) {
					$classes[] = 'woocommerce-single-product';
				}

				if ( is_cart() ) {
                    $classes[] = 'woocommerce-cart-page';
                }

                if ( is_checkout() ) {
                    $classes[] = 'woocommerce-checkout-page';
                }

                if ( is_account_page() ) {
                    $classes[] = 'woocommerce-myaccount-page';
                }
			}
			return $classes;
		}

		/**
		 * Start the content wrapper for WooCommerce pages.
		 */
		public function start_content_wrapper() {
			echo '<div id="primary" class="content-area container"><main id="main" class="site-main">';
		}

		/**
		 * End the content wrapper for WooCommerce pages.
		 */
		public function end_content_wrapper() {
			echo '</main></div>';
		}
	} // End class Harshone_WooCommerce

	// Instantiate the class
	new Harshone_WooCommerce();

} // End if class exists
