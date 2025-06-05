<?php
/**
 * Theme configuration and setup.
 * Contains constants, setup functions, and theme-specific configurations.
 *
 * @package Harshone
 * @Since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Function to get theme options from Redux.
// This function will be called throughout the theme to retrieve settings.
if ( ! function_exists( 'harshone_get_theme_option' ) ) {
	function harshone_get_theme_option( $option_name, $default_value = '' ) {
		// 'harshone_options' is assumed to be the opt_name defined in theme-options/config.php
		global $harshone_options;

		// Check if Redux is loaded and the option exists
		if ( ! empty( $harshone_options ) && isset( $harshone_options[ $option_name ] ) && $harshone_options[ $option_name ] !== '' ) {
			return apply_filters( 'harshone_theme_option_' . $option_name, $harshone_options[ $option_name ] );
		}
		return apply_filters( 'harshone_theme_option_' . $option_name, $default_value );
	}
}

// Global content width for oEmbeds and images.
if ( ! isset( $content_width ) ) {
	$content_width = 840; // Pixels
}

// Add Custom Body Classes
if ( ! function_exists( 'harshone_body_classes' ) ) {
	function harshone_body_classes( $classes ) {
		// Add "has-sidebar" class if sidebar is active
		if ( is_active_sidebar( 'sidebar-1' ) && ( is_single() || is_archive() || is_home() ) ) {
			$classes[] = 'has-sidebar';
		}

		// Add class for header style
		$header_style = harshone_get_theme_option( 'harshone_header_style', 'style1' );
		$classes[] = 'harshone-header-' . $header_style;

		// Add class for footer style
		$footer_style = harshone_get_theme_option( 'harshone_footer_style', 'style1' );
		$classes[] = 'harshone-footer-' . $footer_style;

        // Add class for mega menu support
        if ( harshone_get_theme_option( 'harshone_enable_mega_menu', false ) ) {
            $classes[] = 'harshone-mega-menu-enabled';
        }

		return $classes;
	}
	add_filter( 'body_class', 'harshone_body_classes' );
}

// Custom excerpt length
if ( ! function_exists( 'harshone_custom_excerpt_length' ) ) {
	function harshone_custom_excerpt_length( $length ) {
		return 30; // 30 words
	}
	add_filter( 'excerpt_length', 'harshone_custom_excerpt_length', 999 );
}

// Custom excerpt more string
if ( ! function_exists( 'harshone_excerpt_more' ) ) {
	function harshone_excerpt_more( $more ) {
		return '...';
	}
	add_filter( 'excerpt_more', 'harshone_excerpt_more' );
}

// Enable shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );


// Add SEO improvements
if ( ! function_exists( 'harshone_add_schema_markup' ) ) {
    function harshone_add_schema_markup() {
        if ( is_singular() ) {
            global $post;
            $schema_type = 'Article';
            if ( is_page() ) {
                $schema_type = 'WebPage';
            } elseif ( is_product() && class_exists( 'WooCommerce' ) ) {
                $schema_type = 'Product';
            } elseif ( is_home() || is_archive() || is_search() ) {
                $schema_type = 'BlogPosting'; // For lists of posts
            }

            echo '<script type="application/ld+json">' . "\n";
            echo '{' . "\n";
            echo '  "@context": "http://schema.org",' . "\n";
            echo '  "@type": "' . esc_attr( $schema_type ) . '",' . "\n";
            echo '  "mainEntityOfPage": {' . "\n";
            echo '    "@type": "WebPage",' . "\n";
            echo '    "@id": "' . esc_url( get_permalink() ) . '"' . "\n";
            echo '  },' . "\n";
            echo '  "headline": "' . esc_attr( get_the_title() ) . '",' . "\n";
            if ( has_post_thumbnail() ) {
                echo '  "image": {' . "\n";
                echo '    "@type": "ImageObject",' . "\n";
                echo '    "url": "' . esc_url( get_the_post_thumbnail_url( $post->ID, 'full' ) ) . '",' . "\n";
                echo '    "width": "' . absint( get_post_thumbnail_id() ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[1] : '' ) . '",' . "\n";
                echo '    "height": "' . absint( get_post_thumbnail_id() ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[2] : '' ) . '"' . "\n";
                echo '  },' . "\n";
            }
            echo '  "datePublished": "' . esc_attr( get_the_time( 'c' ) ) . '",' . "\n";
            echo '  "dateModified": "' . esc_attr( get_the_modified_time( 'c' ) ) . '",' . "\n"; // THIS IS LINE 113, NOW CORRECTED
            echo '  "author": {' . "\n";
            echo '    "@type": "Person",' . "\n";
            echo '    "name": "' . esc_attr( get_the_author() ) . '"' . "\n";
            echo '  },' . "\n";
            echo '  "publisher": {' . "\n";
            echo '    "@type": "Organization",' . "\n";
            echo '    "name": "' . esc_attr( get_bloginfo( 'name' ) ) . '",' . "\n";
            
            // --- FIX FOR TypeError: parse_url() - Start ---
            // This section retrieves the primary logo URL and dimensions for schema.org markup.
            // It first tries to get a specific header logo from Redux, then falls back to WordPress's custom logo.
            $schema_logo_url    = '';
            $schema_logo_width  = '';
            $schema_logo_height = '';

            // Attempt to get the header's light logo from Redux options, as a primary source for schema
            $redux_header_logo_light_option = harshone_get_theme_option( 'harshone_header_logo_light', array() );
            if ( is_array( $redux_header_logo_light_option ) && ! empty( $redux_header_logo_light_option['url'] ) ) {
                $schema_logo_url    = $redux_header_logo_light_option['url'];
                $schema_logo_width  = isset( $redux_header_logo_light_option['width'] ) ? $redux_header_logo_light_option['width'] : '';
                $schema_logo_height = isset( $redux_header_logo_light_option['height'] ) ? $redux_header_logo_light_option['height'] : '';
            } elseif ( has_custom_logo() ) { // Fallback to WordPress Customizer site logo if Redux option is not set
                $custom_logo_id   = get_theme_mod( 'custom_logo' );
                $custom_logo_info = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                if ( $custom_logo_info ) {
                    $schema_logo_url    = $custom_logo_info[0];
                    $schema_logo_width  = $custom_logo_info[1];
                    $schema_logo_height = $custom_logo_info[2];
                }
            }

            // Only output logo schema if a valid URL is found
            if ( ! empty( $schema_logo_url ) ) {
                echo '    "logo": {' . "\n";
                echo '      "@type": "ImageObject",' . "\n";
                echo '      "url": "' . esc_url( $schema_logo_url ) . '",' . "\n";
                if( $schema_logo_width && $schema_logo_height ) {
                     echo '      "width": "' . absint( $schema_logo_width ) . '",' . "\n";
                     echo '      "height": "' . absint( $schema_logo_height ) . '"' . "\n";
                }
                echo '    }' . "\n";
            }
            // --- FIX FOR TypeError: parse_url() - End ---

            echo '  },' . "\n";
            echo '  "description": "' . esc_attr( get_the_excerpt() ) . '"' . "\n";
            echo '}' . "\n";
            echo '</script>' . "\n";
        }
    }
}
// For advanced SEO, recommending a plugin like Yoast SEO or Rank Math is typical.
// This is a basic implementation.
add_action( 'wp_head', 'harshone_add_schema_markup' );