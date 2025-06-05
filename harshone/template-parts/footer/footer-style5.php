<?php
/**
 * Template part for displaying footer style 5.
 * Layout: Centered compact footer with logo, copyright, and social links.
 *
 * @package Harshone
 * @since 1.0.0
 */

$copyright_text      = harshone_get_theme_option( 'harshone_footer_copyright_text', '© ' . date_i18n( 'Y' ) . ' Harshone. All Rights Reserved.' );
$bottombar_enabled   = harshone_get_theme_option( 'harshone_footer_bottombar_enable', true );
?>

<footer id="colophon" class="site-footer footer-style5 bg-primary text-white text-center py-5">
    <div class="container">
        <div class="footer-widgets row justify-content-center mb-4">
            <div class="col-lg-6">
                <div class="footer-logo mb-3">
                    <?php harshone_get_site_logo( 'footer' ); // Should pick dark or light based on Redux options output to this BG ?>
                </div>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-menu',
                        'menu_class'     => 'list-inline mb-4',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    )
                );
                ?>
                <?php harshone_get_social_links( 'footer' ); // Ensure social links are light-themed too ?>
            </div>
        </div><!-- .footer-widgets -->

        <?php if ( $bottombar_enabled ) : ?>
        <div class="site-info bottom-bar pt-3">
            <?php if ( ! empty( $copyright_text ) ) : ?>
                <span class="copyright-text"><?php echo wp_kses_post( $copyright_text ); ?></span>
            <?php endif; ?>
        </div><!-- .site-info -->
        <?php endif; ?>
    </div>
</footer><!-- #colophon -->