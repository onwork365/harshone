<?php
/**
 * Template part for displaying header style 4.
 * Layout: Full-width top CTA bar, Logo left, Primary nav right, search/cart icons integrated.
 *
 * @package Harshone
 * @since 1.0.0
 */

$topbar_enabled      = harshone_get_theme_option( 'harshone_header_topbar', true );
$phone_number        = harshone_get_theme_option( 'harshone_topbar_phone', '+1 (123) 456-7890' );
$button_text         = harshone_get_theme_option( 'harshone_topbar_button_text', 'Shop Now' );
$button_link         = harshone_get_theme_option( 'harshone_topbar_button_link', '#' );
?>

<header id="masthead" class="site-header header-style4">
    <?php if ( $topbar_enabled ) : ?>
        <div class="top-bar bg-primary text-white text-center py-2">
            <div class="container d-flex flex-wrap justify-content-center align-items-center">
                <?php if ( ! empty( $phone_number ) ) : ?>
                    <span class="me-3"><i class="fa fa-phone me-1"></i> <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '(', ')', '-' ), '', $phone_number ) ); ?>" class="text-white"><?php echo esc_html( $phone_number ); ?></a></span>
                <?php endif; ?>
                <?php if ( ! empty( $button_text ) && ! empty( $button_link ) ) : ?>
                    <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-sm btn-outline-light"><?php echo esc_html( $button_text ); ?></a>
                <?php endif; ?>
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
                        'depth'          => 3,
                        'container'      => false,
                        'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                        'fallback_cb'    => false,
                    )
                );
                ?>
                <div class="navbar-right-area ms-lg-3">
                    <a href="#" class="search-icon"><i class="fa fa-search"></i></a>
                    <?php if ( class_exists( 'WooCommerce' ) ) : // Wrap WooCommerce calls ?>
                        <?php harshone_woocommerce_cart_icon_and_count(); ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="d-none d-lg-inline-block ms-3"><i class="fa fa-user me-1"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav><!-- .main-navigation -->
</header><!-- #masthead -->