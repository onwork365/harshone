<?php
/**
 * Template part for displaying footer style 2.
 * Layout: Dark footer, Logo/About section, Quick Links, Widget Areas, Social Icons.
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

<footer id="colophon" class="site-footer footer-style2">
    <div class="container">
        <div class="footer-upper row pb-4">
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                <div class="footer-logo mb-3">
                    <?php harshone_get_site_logo( 'footer' ); ?>
                </div>
                <p><?php esc_html_e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'harshone' ); ?></p>
                <?php harshone_get_social_links( 'footer' ); ?>
            </div>
            <div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
                <h4 class="footer-heading"><?php esc_html_e( 'Quick Links', 'harshone' ); ?></h4>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-menu', // Assuming a 'footer-menu' location
                        'menu_class'     => 'list-unstyled',
                        'container'      => false,
                        'depth'          => 1,
                    )
                );
                ?>
            </div>
            <div class="col-md-6 col-lg-3 mb-4 mb-md-0">
                <?php dynamic_sidebar( 'footer-2' ); ?>
            </div>
            <div class="col-md-6 col-lg-3">
                <?php dynamic_sidebar( 'footer-3' ); ?>
            </div>
        </div><!-- .footer-upper -->

        <?php if ( $bottombar_enabled ) : ?>
        <div class="site-info bottom-bar row align-items-center py-3">
            <div class="col-md-6 text-center text-md-start">
                <?php if ( ! empty( $copyright_text ) ) : ?>
                    <span class="copyright-text"><?php echo wp_kses_post( $copyright_text ); ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <?php if ( ! empty( $phone_number ) ) : ?>
                    <span><i class="fa fa-phone me-1"></i> <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '(', ')', '-' ), '', $phone_number ) ); ?>"><?php echo esc_html( $phone_number ); ?></a></span>
                <?php endif; ?>
                <?php if ( ! empty( $button_text ) && ! empty( $button_link ) ) : ?>
                    <a href="<?php echo esc_url( $button_link ); ?>" class="btn btn-sm btn-outline-light ms-3"><?php echo esc_html( $button_text ); ?></a>
                <?php endif; ?>
            </div>
        </div><!-- .site-info -->
        <?php endif; ?>
    </div>
</footer><!-- #colophon -->