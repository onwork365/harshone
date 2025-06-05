<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Harshone
 * @since 1.0.0
 */
?>
    </div><!-- #content -->

    <?php
    $footer_style = harshone_get_theme_option( 'harshone_footer_style', 'style1' ); // Get global default from Redux

    // Check for per-page/post override for footer style
    if ( is_singular() ) {
        $custom_footer_style = harshone_get_meta_option( get_the_ID(), 'harshone_custom_footer_style', '' );
        if ( ! empty( $custom_footer_style ) ) {
            $footer_style = $custom_footer_style; // Use custom style if set
        }
    }
    
    get_template_part( 'template-parts/footers/footer', $footer_style );
    ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>