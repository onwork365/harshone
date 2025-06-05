<?php
/**
 * Template part for displaying header style 1.
 * Layout: Logo left, Primary Nav right, Top bar above.
 *
 * @package Harshone
 * @since 1.0.0
 */

$topbar_enabled      = harshone_get_theme_option( 'harshone_header_topbar', true );
$phone_number        = harshone_get_theme_option( 'harshone_topbar_phone', '+1 (123) 456-7890' );
$address             = harshone_get_theme_option( 'harshone_topbar_address', '123 Main St, Anytown' );
$button_text         = harshone_get_theme_option( 'harshone_topbar_button_text', 'Shop Now' );
$button_link         = harshone_get_theme_option( 'harshone_topbar_button_link', '#' );
?>

<header id="masthead" class="site-header header-style1">
    <?php if ( $topbar_enabled ) : ?>
        <div class="top-bar">
            <div class="container d-flex flex-wrap justify-content-between align-items-center">
                <div class="top-bar-info me-auto">
                    <?php if ( ! empty( $phone_number ) ) : ?>
                        <span><i class="fa fa-phone me-1"></i> <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '(', ')', '-' ), '', $phone_number ) ); ?>"><?php echo esc_html( $phone_number ); ?></a></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $address ) ) : ?>
                        <span class="ms-3"><i class="fa fa-map-marker-alt me-1"></i> <?php echo esc_html( $address ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="top-bar-actions">
                    <?php if ( ! empty( $button_text ) && ! empty( $button_link ) ) : ?>
                        <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-sm btn-primary me-3"><?php echo esc_html( $button_text ); ?></a>
                    <?php endif; ?>
                    <?php if ( class_exists( 'WooCommerce' ) ) : // Wrap WooCommerce calls ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="ms-3"><i class="fa fa-user me-1"></i> <?php esc_html_e( 'My Account', 'harshone' ); ?></a>
                        <?php harshone_woocommerce_cart_icon_and_count(); // Displays cart icon with count/total ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <div class="site-branding navbar-brand p-0">
                <?php harshone_get_site_logo( 'header' ); ?>
            </div><!-- .site-branding -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-navbar-collapse" aria-controls="primary-navbar-collapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'harshone' ); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="primary-navbar-collapse">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary-menu',
                        'menu_id'        => 'primary-menu',
                        'depth'          => 3, // For dropdowns
                        'container'      => false, // Handled by outer div
                        'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0', // Bootstrap classes
                        'fallback_cb'    => false, // No fallback
                        // 'walker'      => new WP_Bootstrap_Navwalker(), // If you implement a custom walker for Bootstrap
                    )
                );
                ?>
                <div class="navbar-right-area d-none d-lg-block ms-lg-3">
                    <a href="#" class="search-icon"><i class="fa fa-search"></i></a>
                </div>
            </div>
        </div>
    </nav><!-- .main-navigation -->
</header><!-- #masthead -->