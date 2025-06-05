<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Harshone
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php
    // Output Favicon from Redux options
    $harshone_favicon_data = harshone_get_theme_option( 'harshone_favicon' );
    if ( is_array( $harshone_favicon_data ) && ! empty( $harshone_favicon_data['url'] ) ) {
        echo '<link rel="icon" href="' . esc_url( $harshone_favicon_data['url'] ) . '" sizes="32x32" />';
        echo '<link rel="icon" href="' . esc_url( $harshone_favicon_data['url'] ) . '" sizes="192x192" />';
        echo '<link rel="apple-touch-icon" href="' . esc_url( $harshone_favicon_data['url'] ) . '" />';
        // Optionally add a general favicon fallback
        if ( ! has_site_icon() ) { // Only if site icon is not set via Customizer
            echo '<link rel="icon" href="' . esc_url( $harshone_favicon_data['url'] ) . '" />';
        }
    } elseif ( has_site_icon() ) {
        // Fallback to WordPress Site Icon if Redux favicon is empty
        wp_site_icon();
    }
    ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// Add Preloader HTML if enabled in theme options
if ( harshone_get_theme_option('harshone_enable_preloader', false) ) :
    $preloader_show_logo = harshone_get_theme_option('harshone_preloader_show_logo', false);
    $preloader_logo_data = harshone_get_theme_option('harshone_preloader_logo', array());
    $preloader_logo_url  = is_array($preloader_logo_data) && isset($preloader_logo_data['url']) ? $preloader_logo_data['url'] : '';
?>
<div id="harshone-preloader">
    <?php if ( $preloader_show_logo && ! empty( $preloader_logo_url ) ) : ?>
        <img class="harshone-preloader-logo" src="<?php echo esc_url( $preloader_logo_url ); ?>" alt="<?php esc_attr_e( 'Loading...', 'harshone' ); ?>">
    <?php else : ?>
        <div class="harshone-preloader-spinner"></div>
    <?php endif; ?>
</div>
<?php endif; ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'harshone' ); ?></a>

    <?php
    $header_style = harshone_get_theme_option( 'harshone_header_style', 'style1' ); // Get global default from Redux
    
    // Check for per-page/post override for header style
    if ( is_singular() ) {
        $custom_header_style = harshone_get_meta_option( get_the_ID(), 'harshone_custom_header_style', '' );
        if ( ! empty( $custom_header_style ) ) {
            $header_style = $custom_header_style; // Use custom style if set
        }
    }
    
    get_template_part( 'template-parts/headers/header', $header_style );
    ?>

    <div id="content" class="site-content">