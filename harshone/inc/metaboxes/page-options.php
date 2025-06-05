<?php
/**
 * Redux MetaBox for Page Options (Post/Page/Product)
 * Manages per-page/post settings like custom header/footer, custom page title.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Redux_Metaboxes' ) ) {
	return; // Exit if Redux Metaboxes class is not available
}

// Global variable that stores the Redux instance for theme options.
global $harshone_options; 

// Define the arguments for the metabox.
$metaboxes = array();

// --- Main Page Options Metabox ---
$metaboxes[] = array(
	'id'         => 'harshone_page_metabox', // This ID is used to retrieve post meta value (e.g., get_post_meta($post_id, 'harshone_page_metabox', true))
	'title'      => esc_html__( 'Harshone Page Options', 'harshone' ), // Clearer title for the metabox
	'post_types' => array( 'post', 'page', 'product' ), // Apply to posts, pages, and products
	'position'   => 'normal', // 'high', 'core', 'low', 'default'
	'priority'   => 'high',   // 'high', 'core', 'low', 'default'
	'fields'     => array(
        array(
            'id'       => 'harshone_page_override_info',
            'type'     => 'info',
            'style'    => 'normal',
            'title'    => esc_html__( 'Page/Post Specific Overrides', 'harshone' ),
            'desc'     => esc_html__( 'These settings will override the global theme options for this specific page or post. Select "Default" for any option to revert to its global theme option setting.', 'harshone' ),
        ),
		array(
			'id'       => 'harshone_custom_header_style',
			'type'     => 'select',
			// Use underscore as a placeholder for the default key in options array for Redux to correctly handle (empty string not always reliable)
			'title'    => esc_html__( 'Custom Header Style', 'harshone' ),
			'subtitle' => esc_html__( 'Override global header style for this page.', 'harshone' ),
			'desc'     => esc_html__( 'Select "Default" to use the setting from Theme Options.', 'harshone' ),
			'options'  => array(
				''       => esc_html__( 'Default', 'harshone' ), // Using empty string as default key for consistent handling with theme logic
				'style1' => esc_html__( 'Header Style 1', 'harshone' ),
				'style2' => esc_html__( 'Header Style 2', 'harshone' ),
				'style3' => esc_html__( 'Header Style 3', 'harshone' ),
				'style4' => esc_html__( 'Header Style 4', 'harshone' ),
				'style5' => esc_html__( 'Header Style 5', 'harshone' ),
			),
			'default'  => '', // Default selected value is the empty string (which means "use global")
		),
		array(
			'id'       => 'harshone_custom_footer_style',
			'type'     => 'select',
			'title'    => esc_html__( 'Custom Footer Style', 'harshone' ),
			'subtitle' => esc_html__( 'Override global footer style for this page.', 'harshone' ),
			'desc'     => esc_html__( 'Select "Default" to use the setting from Theme Options.', 'harshone' ),
			'options'  => array(
				''       => esc_html__( 'Default', 'harshone' ), // Using empty string as default key
				'style1' => esc_html__( 'Footer Style 1', 'harshone' ),
				'style2' => esc_html__( 'Footer Style 2', 'harshone' ),
				'style3' => esc_html__( 'Footer Style 3', 'harshone' ),
				'style4' => esc_html__( 'Footer Style 4', 'harshone' ),
				'style5' => esc_html__( 'Footer Style 5', 'harshone' ),
			),
			'default'  => '', // Default selected value is the empty string
		),
        array(
            'id'       => 'harshone_page_show_title_section_override', // Renamed for clarity to avoid confusion with global setting
            'type'     => 'switch',
            'title'    => esc_html__( 'Page Title Section Display Override', 'harshone' ),
            'subtitle' => esc_html__( 'Set to "Override to Show" to force display, or "Override to Hide" to force hide. Leave "Default" to use global theme options setting.', 'harshone' ),
            'default'  => '0', // 0 = Use Theme Default, 1 = Override ON (TRUE), 2 = Override OFF (FALSE)
            'on'       => esc_html__( 'Override to Show', 'harshone' ),
            'off'      => esc_html__( 'Override to Hide', 'harshone' ),
        ),
        array(
            'id'       => 'harshone_page_custom_title_text',
            'type'     => 'text',
            'title'    => esc_html__( 'Custom Page Title Text', 'harshone' ),
            'subtitle' => esc_html__( 'Enter a custom title for this page (overrides default/post title).', 'harshone' ),
            'desc'     => esc_html__( 'Leave empty to use the default post/page title. This field is visible when the page title section is set to show.', 'harshone' ),
            // Dependency: This field will only show if the override switch is set to '1' (Override to Show)
            'required' => array( 'harshone_page_show_title_section_override', '=', '1' ), 
        ),
	), // End fields array
); // End Metabox array definition


// Add the metaboxes to Redux
if ( isset( $metaboxes ) && is_array( $metaboxes ) && class_exists( 'Redux' ) ) {
	foreach ( $metaboxes as $metabox ) {
		// Pass the Redux Opt Name ('harshone_options') as the first argument, and the metabox config array as the second.
		Redux_Metaboxes::set_box( 'harshone_options', $metabox ); 
	}
}