<?php
/**
 * Custom Header feature
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'harshone_custom_header_setup' ) ) {
	/**
	 * Set up the WordPress core custom header feature.
	 *
	 * @uses harshone_header_style()
	 */
	function harshone_custom_header_setup() {
		add_theme_support(
			'custom-header',
			apply_filters(
				'harshone_custom_header_args',
				array(
					'default-image'      => '',
					'default-text-color' => '000000',
					'width'              => 1920,
					'height'             => 250,
					'flex-height'        => true,
					'wp-head-callback'   => 'harshone_header_style',
				)
			)
		);
	}
	add_action( 'after_setup_theme', 'harshone_custom_header_setup' );
}

if ( ! function_exists( 'harshone_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see harshone_custom_header_setup().
	 */
	function harshone_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: add_theme_support( 'custom-header' ) is default,
		 * so it is always present.
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;