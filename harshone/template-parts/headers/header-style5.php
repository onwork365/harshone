<?php
/**
 * Template part for displaying header style 5.
 * Layout: Off-canvas navigation (mobile-first approach), simple logo and actions.
 * Note: Requires custom JS for off-canvas, Bootstrap's offcanvas can be used though.
 *
 * @package Harshone
 * @since 1.0.0
 */
?>

<header id="masthead" class="site-header header-style5">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <div class="header-actions-left d-lg-none">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="<?php esc_attr_e( 'Toggle navigation', 'harshone' ); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="site-branding navbar-brand mx-auto me-lg-auto ms-lg-0 p-0">
            <?php harshone_get_site_logo( 'header' ); ?>
        </div><!-- .site-branding -->

        <nav class="navbar navbar-expand-lg d-none d-lg-block p-0">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary-menu',
                    'menu_id'        => 'primary-menu-desktop',
                    'depth'          => 3,
                    'container'      => false,
                    'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                    'fallback_cb'    => false,
                )
            );
            ?>
        </nav>

        <div class="header-actions-right ms-auto ms-lg-3">
            <a href="#" class="search-icon me-3"><i class="fa fa-search"></i></a>
            <?php if ( class_exists( 'WooCommerce' ) ) : // Wrap WooCommerce calls ?>
                <?php harshone_woocommerce_cart_icon_and_count(); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Offcanvas Navbar for Mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php esc_html_e( 'Menu', 'harshone' ); ?></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="<?php esc_attr_e( 'Close', 'harshone' ); ?>"></button>
        </div>
        <div class="offcanvas-body">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary-menu',
                    'menu_id'        => 'primary-menu-offcanvas',
                    'depth'          => 3,
                    'container'      => false,
                    'menu_class'     => 'navbar-nav justify-content-end flex-grow-1 pe-3',
                    'fallback_cb'    => false,
                )
            );
            ?>
            <div class="offcanvas-bottom-actions mt-4 text-center">
                 <?php if ( class_exists( 'WooCommerce' ) ) : // Wrap WooCommerce calls ?>
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="btn btn-outline-primary w-100 mb-2"><i class="fa fa-user me-1"></i> <?php esc_html_e( 'My Account', 'harshone' ); ?></a>
                 <?php endif; ?>
                 <?php // Add more actions like login/register if needed ?>
            </div>
        </div>
    </div>
</header><!-- #masthead -->