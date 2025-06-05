<?php
/**
 * Template part for displaying footer style 4.
 * Layout: Multi-row footer, Top section with quick links, middle section with address/contact, bottom bar.
 *
 * @package Harshone
 * @since 1.0.0
 */

$copyright_text      = harshone_get_theme_option( 'harshone_footer_copyright_text', '© ' . date_i18n( 'Y' ) . ' Harshone. All Rights Reserved.' );
$bottombar_enabled   = harshone_get_theme_option( 'harshone_footer_bottombar_enable', true );
$phone_number        = harshone_get_theme_option( 'harshone_footer_bottombar_phone', '' );
$address             = harshone_get_theme_option( 'harshone_footer_bottombar_address', '' );
?>

<footer id="colophon" class="site-footer footer-style4 bg-dark text-white">
    <div class="container py-5">
        <div class="row footer-top-section pb-4 mb-4 border-bottom border-light opacity-25">
            <div class="col-md-4">
                <h5 class="text-white"><?php esc_html_e( 'About Harshone', 'harshone' ); ?></h5>
                <p><?php esc_html_e( 'We are dedicated to providing the best products and services for our customers.', 'harshone' ); ?></p>
            </div>
            <div class="col-md-4">
                <h5 class="text-white"><?php esc_html_e( 'Categories', 'harshone' ); ?></h5>
                <?php
                if ( class_exists( 'WooCommerce' ) ) { // Wrap WooCommerce calls
                    // Example: List WooCommerce categories
                    wp_list_categories( array(
                        'taxonomy'     => 'product_cat',
                        'hide_empty'   => 0,
                        'title_li'     => '',
                        'show_count'   => 0,
                        'depth'        => 1,
                        // 'walker'       => new Harshone_Custom_List_Walker(), // A simple <ul> walker for lists
                        'echo'         => 1,
                    ) );
                }
                ?>
            </div>
            <div class="col-md-4">
                <h5 class="text-white"><?php esc_html_e( 'Customer Service', 'harshone' ); ?></h5>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-menu',
                        'menu_class'     => 'list-unstyled',
                        'container'      => false,
                        'depth'          => 1,
                    )
                );
                ?>
            </div>
        </div><!-- .footer-top-section -->

        <div class="row footer-main-widgets pb-4 mb-4">
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
        </div>

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
                <?php if ( ! empty( $address ) ) : ?>
                    <span class="ms-3"><i class="fa fa-map-marker-alt me-1"></i> <?php echo esc_html( $address ); ?></span>
                <?php endif; ?>
            </div>
        </div><!-- .site-info -->
        <?php endif; ?>
    </div>
</footer><!-- #colophon -->

<?php
// Example for a simple list walker (could be in inc/template-functions.php)
if ( ! class_exists( 'Harshone_Custom_List_Walker' ) ) {
    class Harshone_Custom_List_Walker extends Walker_Category {
        function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
            $output .= '<li class="cat-item-' . $category->term_id . '">';
            $output .= '<a href="' . esc_url( get_term_link( $category->term_id, $category->taxonomy ) ) . '">' . $category->name;
            if ( ! empty( $args['show_count'] ) ) { // Check for show_count argument
                $output .= ' (' . $category->count . ')';
            }
            $output .= '</a>';
        }

        function end_el( &$output, $category, $depth = 0, $args = array() ) {
            $output .= '</li>';
        }
    }
}
?>