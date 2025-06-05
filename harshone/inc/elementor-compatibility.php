<?php
/**
 * Elementor Compatibility for Harshone
 * Contains functions and hooks to ensure smooth integration with Elementor.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'harshone_elementor_init' ) ) {
	/**
	 * Initialize Elementor compatibility.
	 */
	function harshone_elementor_init() {
		// Remove default Elementor wrapper if needed (often used if theme has its own content wrapper)
		add_action( 'elementor/page_templates/canvas/after_content', 'harshone_elementor_end_body_canvas_wrapper', 10 );
		add_action( 'elementor/page_templates/header_footer/after_content', 'harshone_elementor_end_body_header_footer_wrapper', 10 );

		// Modify Elementor default content_width if desired
		add_filter( 'elementor/utils/content_width_render_css_property', 'harshone_elementor_content_width_css_property', 10, 2 );

		// Enqueue editor styles for Elementor preview
		add_action( 'elementor/editor/after_enqueue_styles', 'harshone_elementor_editor_styles' );

		// Ensure Elementor templates use proper header/footer
		add_action( 'template_redirect', 'harshone_elementor_template_compatibility' );
	}
	add_action( 'init', 'harshone_elementor_init' );
}

if ( ! function_exists( 'harshone_elementor_end_body_canvas_wrapper' ) ) {
	/**
	 * Elementor `Canvas` template for themes.
	 * Ends the body and html tags.
	 */
	function harshone_elementor_end_body_canvas_wrapper() {
		?>
		</body>
		</html>
		<?php
	}
}

if ( ! function_exists( 'harshone_elementor_end_body_header_footer_wrapper' ) ) {
	/**
	 * Elementor `Header/Footer` template for themes.
	 * Ends the body and html tags.
	 */
	function harshone_elementor_end_body_header_footer_wrapper() {
		?>
		</body>
		</html>
		<?php
	}
}

if ( ! function_exists( 'harshone_elementor_content_width_css_property' ) ) {
	/**
	 * Filters Elementor's content width rendering to match theme's container.
	 *
	 * @param string $css_property The CSS property to render.
	 * @param string $width_type   The width type to use (e.g., 'px', '%', 'vw').
	 * @return string Modified CSS property.
	 */
	function harshone_elementor_content_width_css_property( $css_property, $width_type ) {
		// Example: If your theme uses Bootstrap's container-fluid or a custom max-width.
		// This filter can be complex based on your specific layout.
		// For now, let Elementor handle it unless a specific conflict arises.
		// If you need to force a specific width, e.g., '1140px', you might do:
		// return 'max-width: 1140px;';
		return $css_property;
	}
}

if ( ! function_exists( 'harshone_elementor_editor_styles' ) ) {
	/**
	 * Enqueue styles for Elementor editor.
	 * This helps Elementor's preview to look closer to the front-end.
	 */
	function harshone_elementor_editor_styles() {
		wp_enqueue_style( 'harshone-bootstrap-editor', HARSHONE_URI . 'assets/css/bootstrap.min.css', array(), '5.3.0' );
		wp_enqueue_style( 'harshone-editor-style', HARSHONE_URI . 'assets/css/harshone.css', array(), HARSHONE_VERSION );
		wp_enqueue_style( 'harshone-woocommerce-editor', HARSHONE_URI . 'assets/css/woocommerce.css', array(), HARSHONE_VERSION );
	}
}

if ( ! function_exists( 'harshone_elementor_template_compatibility' ) ) {
	/**
	 * Adjust global query object for Elementor.
	 * Elementor can sometimes override `single.php` or `page.php` with its own blank template.
     * This ensures theme's header/footer logic applies when Elementor is used for content.
	 */
	function harshone_elementor_template_compatibility() {
		if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            // In Elementor edit mode, ensure is_singular() or is_page() context is correctly recognized
            // to allow theme's header/footer templates to load correctly.
            // This is largely handled by using `get_header()/get_footer()` in header.php/footer.php
            // instead of direct inclusion of theme parts.
            // Elementor will load `header.php` and `footer.php` by default.
            // No specific action usually needed here unless deep template overrides are required.
		}
	}
}

add_action( 'elementor/theme/register_locations', 'harshone_register_elementor_location' );
if ( ! function_exists( 'harshone_register_elementor_location' ) ) {
    /**
     * Register Elementor locations for theme builder compatibility.
     * Allows users to create Elementor templates for header, footer, single page, etc.
     *
     * @param \Elementor\Theme_Core $theme_manager The Theme Core instance.
     */
    function harshone_register_elementor_location( $theme_manager ) {
        $theme_manager->register_all_core_location(); // Register all core locations (header, footer, single, archive)
    }
}
