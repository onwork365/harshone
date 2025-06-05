<?php
/**
 * Template part for displaying footer style 1.
 * Layout: 4 widget columns, simple copyright bar.
 *
 * @package Harshone
 * @since 1.0.0
 */

$copyright_text      = harshone_get_theme_option( 'harshone_footer_copyright_text', '© ' . date_i18n( 'Y' ) . ' Harshone. All Rights Reserved.' );
$bottombar_enabled   = harshone_get_theme_option( 'harshone_footer_bottombar_enable', true );
$phone_number        = harshone_get_theme_option( 'harshone_footer_bottombar_phone', '' );
$address             = harshone_get_theme_option( 'harshone_footer_bottombar_address', '' );
$button_text         = harshone_get_theme_option( 'harshone_footer_bottombar_button_text', '' );
$button_link         = harshone_get_theme_option( 'harshone_footer_bottombar_button_link', '#' );
?>

<footer id="colophon" class="site-footer footer-style1">
    <div class="container">
        <div class="footer-widgets row pb-4">
            <div class="col-md-6 col-lg-3">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
            <div class="col-md-6 col-lg-3">
                <?php dynamic_sidebar( 'footer-2' ); ?>
            </div>
            <div class="col-md-6 col-lg-3">
                <?php dynamic_sidebar( 'footer-3' ); ?>
            </div>
            <div class="col-md-6 col-lg-3">
                <?php dynamic_sidebar( 'footer-4' ); ?>
            </div>
        </div><!-- .footer-widgets -->

        <?php if ( $bottombar_enabled ) : ?>
        <div class="site-info bottom-bar row align-items-center py-3">
            <div class="col-md-6 order-md-1 text-center text-md-start">
                <?php if ( ! empty( $copyright_text ) ) : ?>
                    <span class="copyright-text"><?php echo wp_kses_post( $copyright_text ); ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-6 order-md-2 text-center text-md-end">
                <?php harshone_get_social_links( 'footer' ); ?>
            </div>
        </div><!-- .site-info -->
        <?php endif; ?>
    </div>
</footer><!-- #colophon -->