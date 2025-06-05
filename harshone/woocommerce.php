<?php
/**
 * The template for displaying WooCommerce pages.
 *
 * This template is used to override WooCommerce's default template hierarchy.
 * It's crucial for most themes that implement custom WooCommerce styling.
 *
 * @link https://woocommerce.com/document/template-structure/
 *
 * @package Harshone
 * @since 1.0.0
 */

get_header();

// Display custom page title section for WooCommerce pages if enabled
// Be mindful of WooCommerce's own titles on shop/archive pages to avoid duplicates.
// You might need to remove default WC titles in inc/woocommerce/template-hooks.php
harshone_display_page_title_section();

?>

<div id="woocommerce-primary" class="content-area woocommerce-page">
    <main id="woocommerce-main" class="site-main container py-5">
        <?php
        // A common issue: WooCommerce might automatically output the Shop page title (e.g., "Shop")
        // To avoid duplicate titles, you might want to remove WooCommerce's default if harshone_display_page_title_section() handles it.
        // This is done via hooks in inc/woocommerce/template-hooks.php, e.g.:
        // remove_action( 'woocommerce_before_main_content', 'woocommerce_page_title', 25 );
        // The woocommerce_page_title() function is typically hooked directly to 'woocommerce_archive_description'.
        // If the theme's page title handles it, it might need removing.

        if ( is_singular( 'product' ) ) {
            woocommerce_content();
        } else {
            // For all other WooCommerce pages (shop, archives, cart, checkout, etc.)
            ?>
            <div class="row">
                <div class="col-lg-9 content-column">
                    <?php woocommerce_content(); ?>
                </div>
                <div class="col-lg-3 sidebar-column">
                    <?php
                    // Display WooCommerce sidebar if active
                    if ( is_active_sidebar( 'woocommerce-sidebar' ) ) {
                        dynamic_sidebar( 'woocommerce-sidebar' );
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </main><!-- #woocommerce-main -->
</div><!-- #woocommerce-primary -->

<?php get_footer(); ?>
