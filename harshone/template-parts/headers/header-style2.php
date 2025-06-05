<?php
/**
 * Template part for displaying header style 2.
 * Layout: Top bar on full dark background, Main Header with centered logo, nav below.
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

<header id="masthead" class="site-header header-style2">
    <?php if ( $topbar_enabled ) : ?>
        <div class="top-bar bg-dark text-white">
            <div class="container d-flex flex-wrap justify-content-between align-items-center">
                <div class="top-bar-info me-auto">
                    <?php if ( ! empty( $phone_number ) ) : ?>
                        <span><i class="fa fa-phone me-1"></i> <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '(', ')', '-' ), '', $phone_number ) ); ?>" class="text-white"><?php echo esc_html( $phone_number ); ?></a></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $address ) ) : ?>
                        <span class="ms-3"><i class="fa fa-map-marker-alt me-1"></i> <?php echo esc_html( $address ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="top-bar-actions">
                    <?php if ( ! empty( $button_text ) && ! empty( $button_link ) ) : ?>
                        <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-sm btn-outline-light me-3"><?php echo esc_html( $button_text ); ?></a>
                    <?php endif; ?>
                    <?php if ( class_exists( 'WooCommerce' ) ) : // Wrap WooCommerce calls ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="text-white"><i class="fa fa-user me-1"></i> <?php esc_html_e( 'My Account', 'harshone' ); ?></a>
                        <?php harshone_woocommerce_cart_icon_and_count(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="main-header-area py-3">
        <div class="container text-center">
            <div class="site-branding navbar-brand mx-auto p-0 d-inline-block">
                <?php harshone_get_site_logo( 'header' ); // Automatically selects dark logo if set ?>
            </div><!-- .site-branding -->
        </div>

        <nav class="navbar navbar-expand-lg navbar-light p-0 pt-2">
            <div class="container">
                <button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#primary-navbar-collapse" aria-controls="primary-navbar-collapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'harshone' ); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="primary-navbar-collapse">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary-menu',
                            'menu_id'        => 'primary-menu',
                            'depth'          => 3,
                            'container'      => false,
                            'menu_class'     => 'navbar-nav mb-2 mb-lg-0',
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                    <div class="navbar-right-area ms-lg-3 d-none d-lg-block">
                        <a href="#" class="search-icon"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </div>
        </nav><!-- .main-navigation -->
    </div>
</header><!-- #masthead -->