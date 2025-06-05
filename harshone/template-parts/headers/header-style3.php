<?php
/**
 * Template part for displaying header style 3.
 * Layout: Top bar hidden by default, Logo centered, Main nav split left/right around logo. Search and cart at ends.
 *
 * @package Harshone
 * @since 1.0.0
 */
?>

<header id="masthead" class="site-header header-style3">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container d-flex flex-wrap align-items-center">

            <div class="navbar-left-area d-none d-lg-block me-auto">
                 <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary-menu',
                        'menu_id'        => 'primary-menu-left',
                        'depth'          => 3,
                        'container'      => false,
                        'menu_class'     => 'navbar-nav mb-2 mb-lg-0',
                        'fallback_cb'    => false,
                        'walker' => null, // Your custom walker or null. If null, use Bootstrap's default handling.
                    )
                );
                ?>
            </div>

            <div class="site-branding navbar-brand mx-auto p-0">
                <?php harshone_get_site_logo( 'header' ); ?>
            </div><!-- .site-branding -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-navbar-collapse" aria-controls="primary-navbar-collapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'harshone' ); ?>">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-lg-none" id="primary-navbar-collapse">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary-menu',
                        'menu_id'        => 'primary-menu-mobile',
                        'depth'          => 3,
                        'container'      => false,
                        'menu_class'     => 'navbar-nav text-center mb-2 mb-lg-0',
                        'fallback_cb'    => false,
                    )
                );
                ?>
            </div>

            <div class="navbar-right-area ms-auto">
                <a href="#" class="search-icon me-3"><i class="fa fa-search"></i></a>
                <?php if ( class_exists( 'WooCommerce' ) ) : // Wrap WooCommerce calls ?>
                    <?php harshone_woocommerce_cart_icon_and_count(); ?>
                <?php endif; ?>
            </div>
        </div>
    </nav><!-- .main-navigation -->
</header><!-- #masthead -->