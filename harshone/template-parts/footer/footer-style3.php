<?php
/**
 * Template part for displaying footer style 3.
 * Layout: Minimalist, centered columns with email signup form, optional bottom bar.
 *
 * @package Harshone
 * @since 1.0.0
 */

$copyright_text      = harshone_get_theme_option( 'harshone_footer_copyright_text', '© ' . date_i18n( 'Y' ) . ' Harshone. All Rights Reserved.' );
$bottombar_enabled   = harshone_get_theme_option( 'harshone_footer_bottombar_enable', true );
?>

<footer id="colophon" class="site-footer footer-style3 bg-light">
    <div class="container text-center py-5">
        <div class="footer-widgets row justify-content-center">
            <div class="col-lg-5 mb-4">
                <div class="footer-logo mb-3">
                    <?php harshone_get_site_logo( 'footer' ); ?>
                </div>
                <p><?php esc_html_e( 'Stay in touch! Subscribe to our newsletter for updates.', 'harshone' ); ?></p>
                <form class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="<?php esc_attr_e( 'Your Email Address', 'harshone' ); ?>" aria-label="Email Address">
                    <button class="btn btn-primary" type="submit"><?php esc_html_e( 'Subscribe', 'harshone' ); ?></button>
                </form>
            </div>
        </div><!-- .footer-widgets -->

        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <?php harshone_get_social_links( 'footer' ); ?>
            </div>
        </div>

        <?php if ( $bottombar_enabled ) : ?>
        <div class="site-info bottom-bar pt-3 border-top">
            <?php if ( ! empty( $copyright_text ) ) : ?>
                <span class="copyright-text"><?php echo wp_kses_post( $copyright_text ); ?></span>
            <?php endif; ?>
        </div><!-- .site-info -->
        <?php endif; ?>
    </div>
</footer><!-- #colophon -->