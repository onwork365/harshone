<?php
/**
 * Redux Framework Configuration for Harshone.
 * Defines all panels, sections, and fields for theme options.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Redux' ) ) {
	return;
}

// This is your option name where all the Redux data is stored.
$opt_name = 'harshone_options';

// This is your theme's text domain for localization.
$theme = wp_get_theme(); // Get the theme object.
$args  = array(
	'display_name'         => $theme->get( 'Name' ),
	'display_version'      => $theme->get( 'Version' ),
	'menu_title'           => esc_html__( 'Harshone Options', 'harshone' ),
	'page_title'           => esc_html__( 'Harshone Options', 'harshone' ),
	'page_slug'            => 'harshone_options',
	'page_priority'        => 60,
	'menu_icon'            => 'dashicons-admin-settings',
	'hide_reset'           => false, // Keep Reset option visible for convenience
	// 'dev_mode'             => true, // Set to false for production
	'database_reject'      => false,
	'allow_tracking'       => false, // Disable Redux usage tracking.

    // --- NEW: Hide default Redux sections from the main menu ---
    // These keys correspond to the default Redux sections.
    // Set to true to hide them.
    'hide_opt_group_menu'  => true, // This hides ALL default sections like "General", "Getting Started", "Import/Export", "Validation", "CSS", "JS", "Raw".
                                    // You then explicitly register YOUR sections which will appear.
                                    // If you only want to hide a specific few, you'd use 'sections' array in setArgs.
                                    // For a premium theme, generally hide all default Redux entries and define your own.

    'welcome_menu'         => false, // Hides the separate "Redux Welcome / Getting Started" menu page.
    'footer_text'          => '',    // Hides "Redux Framework" text in the footer of the options panel.
    'customizer_only'      => false, // Set to true if you only want Redux to work via Customizer. Keep false for dedicated panel.
    'opt_name' => $opt_name,
    'extensions' => array(
        'metaboxes' => array(),
    ),
);

Redux::setArgs( $opt_name, $args );

/*
 * ---> START SECTIONS
 */

// -> General Settings
Redux::setSection(
	$opt_name,
	array(
		'title'            => esc_html__( 'General Settings', 'harshone' ),
		'id'               => 'general_settings',
		'icon'             => 'el el-home',
		'fields'           => array(
			array(
				'id'       => 'harshone_favicon',
				'type'     => 'media',
				'title'    => esc_html__( 'Upload Favicon', 'harshone' ),
				'subtitle' => esc_html__( 'Upload your custom favicon.ico here.', 'harshone' ),
				'desc'     => esc_html__( 'Recommended format: .ico, size: 32x32px.', 'harshone' ),
				'default'  => array(
					'url' => HARSHONE_URI . 'assets/images/favicon.ico',
				),
			),
			array(
				'id'       => 'harshone_layout_type',
				'type'     => 'select',
				'title'    => esc_html__( 'Site Layout', 'harshone' ),
				'subtitle' => esc_html__( 'Choose between boxed or full-width layout.', 'harshone' ),
				'options'  => array(
					'full-width' => esc_html__( 'Full Width', 'harshone' ),
					'boxed'      => esc_html__( 'Boxed', 'harshone' ),
				),
				'default'  => 'full-width',
			),
            array(
                'id'        => 'harshone_enable_mega_menu',
                'type'      => 'switch',
                'title'     => esc_html__( 'Enable Mega Menu Support', 'harshone' ),
                'subtitle'  => esc_html__( 'Adds a body class ("harshone-mega-menu-enabled") to enable theme styles for mega menus. Requires a compatible menu plugin/custom walker.', 'harshone' ),
                'default'   => false,
            ),
			array(
				'id'       => 'harshone_back_to_top_button',
				'type'     => 'switch',
				'title'    => esc_html__( 'Back to Top Button', 'harshone' ),
				'subtitle' => esc_html__( 'Enable or disable the scroll-to-top button.', 'harshone' ),
				'default'  => true,
			),
            // --- Preloader Options Start ---
            array(
                'id'       => 'harshone_enable_preloader',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Preloader', 'harshone' ),
                'subtitle' => esc_html__( 'Show a loading animation before the page fully loads.', 'harshone' ),
                'default'  => false,
            ),
            array(
                'id'       => 'harshone_preloader_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Preloader Background Color', 'harshone' ),
                'default'  => '#ffffff',
                'output'   => array( 'background-color' => '#harshone-preloader' ),
                'required' => array( 'harshone_enable_preloader', '=', true ),
            ),
            array(
                'id'       => 'harshone_preloader_spinner_primary_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Spinner Primary Color', 'harshone' ),
                'subtitle' => esc_html__( 'The main color of the preloader spinner.', 'harshone' ),
                'default'  => '#007bff',
                'output'   => array( 'border-left-color' => '.harshone-preloader-spinner' ),
                'required' => array( 'harshone_enable_preloader', '=', true ),
            ),
            array(
                'id'       => 'harshone_preloader_spinner_secondary_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Spinner Secondary Color', 'harshone' ),
                'subtitle' => esc_html__( 'The background color of the preloader spinner.', 'harshone' ),
                'default'  => 'rgba(0,0,0,0.1)', // Light grey for the border background
                'output'   => array( 'border-color' => '.harshone-preloader-spinner' ),
                'required' => array( 'harshone_enable_preloader', '=', true ),
            ),
            array(
                'id'       => 'harshone_preloader_show_logo',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Logo in Preloader', 'harshone' ),
                'subtitle' => esc_html__( 'Display your site logo inside the preloader.', 'harshone' ),
                'default'  => false,
                'required' => array( 'harshone_enable_preloader', '=', true ),
            ),
             array(
                'id'       => 'harshone_preloader_logo',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Preloader Logo', 'harshone' ),
                'subtitle' => esc_html__( 'Upload a custom logo for the preloader. Max width 150px recommended.', 'harshone' ),
                'default'  => array(
                    'url' => HARSHONE_URI . 'assets/images/logo.png', // Default theme logo
                ),
                'required' => array( array( 'harshone_enable_preloader', '=', true ), array( 'harshone_preloader_show_logo', '=', true ) ),
            ),
            // --- Preloader Options End ---
		),
	)
);

// -> Header Settings
Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Header', 'harshone' ),
		'id'         => 'header_settings',
		'icon'       => 'el el-creditcard',
		'subsection' => false,
		'fields'     => array(
            array(
                'id'          => 'harshone_header_logo_show',
                'type'        => 'switch',
                'title'       => esc_html__( 'Show Header Logo', 'harshone' ),
                'default'     => true,
            ),
            array(
                'id'       => 'harshone_header_logo_type',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Header Logo Type', 'harshone' ),
                'options'  => array(
                    'default'      => esc_html__( 'Site Title', 'harshone' ),
                    'custom_image' => esc_html__( 'Custom Image', 'harshone' ),
                ),
                'default'  => 'custom_image',
                'required' => array( 'harshone_header_logo_show', '=', true ),
            ),
            array(
                'id'       => 'harshone_header_logo_light',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Light Logo', 'harshone' ),
                'subtitle' => esc_html__( 'Logo for light header backgrounds.', 'harshone' ),
                'desc'     => esc_html__( 'Recommended size: 200x80 pixels.', 'harshone' ),
                'default'  => array( 'url' => HARSHONE_URI . 'assets/images/logo.png', ),
                'required' => array( array( 'harshone_header_logo_show', '=', true ), array( 'harshone_header_logo_type', '=', 'custom_image' ) ),
            ),
            array(
                'id'       => 'harshone_header_logo_dark',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Dark Logo', 'harshone' ),
                'subtitle' => esc_html__( 'Logo for dark header backgrounds.', 'harshone' ),
                'desc'     => esc_html__( 'Recommended size: 200x80 pixels.', 'harshone' ),
                'default'  => array( 'url' => HARSHONE_URI . 'assets/images/logo-dark.png', ),
                'required' => array( array( 'harshone_header_logo_show', '=', true ), array( 'harshone_header_logo_type', '=', 'custom_image' ) ),
            ),
            array(
                'id'       => 'harshone_header_logo_mobile',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Mobile Logo', 'harshone' ),
                'subtitle' => esc_html__( 'Logo for mobile viewports. If empty, uses main logo.', 'harshone' ),
                'desc'     => esc_html__( 'Recommended size: 120x50 pixels.', 'harshone' ),
                'required' => array( array( 'harshone_header_logo_show', '=', true ), array( 'harshone_header_logo_type', '=', 'custom_image' ) ),
            ),
            array(
                'id'       => 'harshone_header_logo_width',
                'type'     => 'text',
                'title'    => esc_html__( 'Logo Width (px)', 'harshone' ),
                'subtitle' => esc_html__( 'Set custom width for the logo.', 'harshone' ),
                'desc'     => esc_html__( 'Enter value in pixels, e.g., 200.', 'harshone' ),
                'validate' => 'numeric',
                'required' => array( array( 'harshone_header_logo_show', '=', true ), array( 'harshone_header_logo_type', '=', 'custom_image' ) ),
            ),
            array(
                'id'       => 'harshone_header_logo_height',
                'type'     => 'text',
                'title'    => esc_html__( 'Logo Height (px)', 'harshone' ),
                'subtitle' => esc_html__( 'Set custom height for the logo.', 'harshone' ),
                'desc'     => esc_html__( 'Enter value in pixels, e.g., 80.', 'harshone' ),
                'validate' => 'numeric',
                'required' => array( array( 'harshone_header_logo_show', '=', true ), array( 'harshone_header_logo_type', '=', 'custom_image' ) ),
            ),
		),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Header Layouts', 'harshone' ),
		'id'         => 'header_layouts',
		'icon'       => 'el el-picture',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'harshone_header_style',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Select Header Style', 'harshone' ),
				'subtitle' => esc_html__( 'Choose from 5 distinct header designs.', 'harshone' ),
				'options'  => array(
					'style1' => array(
						'alt' => 'Header Style 1',
						'img' => HARSHONE_URI . 'assets/images/placeholders/header-style1-preview.jpg', // Placeholder image
					),
					'style2' => array(
						'alt' => 'Header Style 2',
						'img' => HARSHONE_URI . 'assets/images/placeholders/header-style2-preview.jpg', // Placeholder image
					),
                    'style3' => array(
						'alt' => 'Header Style 3',
						'img' => HARSHONE_URI . 'assets/images/placeholders/header-style3-preview.jpg', // Placeholder image
					),
                    'style4' => array(
						'alt' => 'Header Style 4',
						'img' => HARSHONE_URI . 'assets/images/placeholders/header-style4-preview.jpg', // Placeholder image
					),
                    'style5' => array(
						'alt' => 'Header Style 5',
						'img' => HARSHONE_URI . 'assets/images/placeholders/header-style5-preview.jpg', // Placeholder image
					),
				),
				'default'  => 'style1',
			),
		),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Header Top Bar', 'harshone' ),
		'id'         => 'header_top_bar',
		'icon'       => 'el el-lines',
		'subsection' => true,
        'fields'     => array(
			array(
				'id'       => 'harshone_header_topbar',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Topbar', 'harshone' ),
                'subtitle' => esc_html__( 'Show or hide the top information bar.', 'harshone' ),
				'default'  => true,
			),
            array(
                'id'       => 'harshone_topbar_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Top Bar Background Color', 'harshone' ),
                'default'  => '#f8f8f8',
                'output'   => array( 'background-color' => '.top-bar' ),
                'required' => array( 'harshone_header_topbar', '=', true ),
            ),
            array(
                'id'       => 'harshone_topbar_text_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Top Bar Text Color', 'harshone' ),
                'default'  => '#666666',
                'output'   => array( 'color' => '.top-bar, .top-bar span' ),
                'required' => array( 'harshone_header_topbar', '=', true ),
            ),
            array(
                'id'       => 'harshone_topbar_link_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Top Bar Link Color', 'harshone' ),
                'default'  => '#333333',
                'output'   => array( 'color' => '.top-bar a' ),
                'required' => array( 'harshone_header_topbar', '=', true ),
            ),
            array(
                'id'       => 'harshone_topbar_font',
                'type'     => 'typography',
                'title'    => esc_html__( 'Top Bar Typography', 'harshone' ),
                'subtitle' => esc_html__( 'Set font styles for top bar text.', 'harshone' ),
                'google'   => true,
                'output'   => array( '.top-bar' ),
                'default'  => array(
                    'font-family' => 'Arial',
                    'font-size'   => '14px',
                    'line-height' => '1.5',
                ),
                'required' => array( 'harshone_header_topbar', '=', true ),
            ),
			array(
				'id'       => 'harshone_topbar_phone',
				'type'     => 'text',
				'title'    => esc_html__( 'Phone Number', 'harshone' ),
				'default'  => '+1 (123) 456-7890',
				'required' => array( 'harshone_header_topbar', '=', true ),
			),
            array(
                'id'       => 'harshone_topbar_address',
                'type'     => 'text',
                'title'    => esc_html__( 'Address', 'harshone' ),
                'default'  => '123 Main St, Anytown',
                'required' => array( 'harshone_header_topbar', '=', true ),
            ),
            array(
                'id'       => 'harshone_topbar_button_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Button Text', 'harshone' ),
                'default'  => 'Shop Now',
                'required' => array( 'harshone_header_topbar', '=', true ),
            ),
            array(
                'id'       => 'harshone_topbar_button_link',
                'type'     => 'text',
                'title'    => esc_html__( 'Button Link', 'harshone' ),
                'default'  => '#',
                'validate' => 'url',
                'required' => array( 'harshone_topbar_button_text', '!=', '' ),
            ),
        ),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Main Header', 'harshone' ),
		'id'         => 'header_main_bar',
		'icon'       => 'el el-minus',
		'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'harshone_main_header_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Main Header Background Color', 'harshone' ),
                'default'  => '#ffffff',
                'output'   => array( 'background-color' => '.site-header .navbar' ),
            ),
            array(
                'id'       => 'harshone_main_header_text_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Main Header Text Color', 'harshone' ),
                'default'  => '#333333',
                'output'   => array( 'color' => '.main-navigation, .main-navigation a, .site-branding .site-title-text, .site-branding .site-description' ),
            ),
            array(
                'id'       => 'harshone_main_header_link_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Main Header Link Color', 'harshone' ),
                'default'  => '#007bff',
                'output'   => array( 'color' => '.main-navigation a:hover, .main-navigation a.active, .main-navigation .navbar-nav .nav-item.current-menu-item .nav-link, .main-navigation .navbar-nav .nav-item.current_page_item .nav-link' ),
            ),
            array(
                'id'       => 'harshone_main_header_font',
                'type'     => 'typography',
                'title'    => esc_html__( 'Main Header Typography', 'harshone' ),
                'subtitle' => esc_html__( 'Set font styles for main header text and navigation.', 'harshone' ),
                'google'   => true,
                'output'   => array( '.main-navigation' ),
                'default'  => array(
                    'font-family' => 'Roboto',
                    'font-size'   => '16px',
                    'line-height' => '1.5',
                ),
            ),
        ),
	)
);

// --> New Section: Page Title Bar Settings
Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Page Title Bar', 'harshone' ),
		'id'         => 'harshone_page_title_bar_settings',
		'icon'       => 'el el-lines', // Using lines icon for now, consider el-map-marker or el-file-alt
		'fields'     => array(
            array(
                'id'       => 'harshone_page_title_bar_enable',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Page Title Bar', 'harshone' ),
                'subtitle' => esc_html__( 'Globally enable or disable the page title section on relevant pages.', 'harshone' ),
                'default'  => true,
            ),
            array(
                'id'       => 'harshone_page_title_bar_background_type',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Background Type', 'harshone' ),
                'options'  => array(
                    'color' => esc_html__( 'Color', 'harshone' ),
                    'image' => esc_html__( 'Image', 'harshone' ),
                ),
                'default'  => 'color',
                'required' => array( 'harshone_page_title_bar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_page_title_bar_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Background Color', 'harshone' ),
                'default'  => '#f8f8f8',
                'output'   => array( 'background-color' => '.page-title-section' ),
                'required' => array( array( 'harshone_page_title_bar_enable', '=', true ), array( 'harshone_page_title_bar_background_type', '=', 'color' ) ),
            ),
            array(
                'id'       => 'harshone_page_title_bar_bg_image',
                'type'     => 'media',
                'title'    => esc_html__( 'Background Image', 'harshone' ),
                'subtitle' => esc_html__( 'Upload a background image for the page title bar.', 'harshone' ),
                'default'  => array( 'url' => '' ), // No default image
                'required' => array( array( 'harshone_page_title_bar_enable', '=', true ), array( 'harshone_page_title_bar_background_type', '=', 'image' ) ),
            ),
            array(
                'id'       => 'harshone_page_title_bar_overlay_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Background Overlay Color', 'harshone' ),
                'subtitle' => esc_html__( 'Set an overlay color and opacity over the background image.', 'harshone' ),
                'default'  => array(
                    'color' => '#000000',
                    'alpha' => '0.5',
                ),
                'output'   => array( 'background-color' => '.page-title-section-overlay' ),
                'required' => array( array( 'harshone_page_title_bar_enable', '=', true ), array( 'harshone_page_title_bar_background_type', '=', 'image' ) ),
            ),
            array(
                'id'       => 'harshone_page_title_bar_min_height',
                'type'     => 'text',
                'title'    => esc_html__( 'Minimum Height (px)', 'harshone' ),
                'subtitle' => esc_html__( 'Set the minimum height of the page title bar in pixels.', 'harshone' ),
                'default'  => '150',
                'validate' => 'numeric',
                'output'   => array( 'min-height' => '.page-title-section' ),
                'required' => array( 'harshone_page_title_bar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_page_title_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Page Title Color', 'harshone' ),
                'default'  => '#333333',
                'output'   => array( 'color' => '.page-title-section h1.entry-title' ),
                'required' => array( 'harshone_page_title_bar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_page_title_font',
                'type'     => 'typography',
                'title'    => esc_html__( 'Page Title Typography', 'harshone' ),
                'subtitle' => esc_html__( 'Set font styles for the page title.', 'harshone' ),
                'google'   => true,
                'output'   => array( '.page-title-section h1.entry-title' ),
                'default'  => array(
                    'font-family' => 'Roboto',
                    'font-size'   => '36px',
                    'font-weight' => '700',
                    'line-height' => '1.2',
                ),
                'required' => array( 'harshone_page_title_bar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_page_title_bar_show_breadcrumbs',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Breadcrumbs in Title Bar', 'harshone' ),
                'default'  => true,
                'required' => array( 'harshone_page_title_bar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_page_title_breadcrumbs_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Breadcrumbs Color', 'harshone' ),
                'default'  => '#666666',
                'output'   => array( 'color' => '.page-title-section .harshone-breadcrumbs, .page-title-section .harshone-breadcrumbs a' ),
                'required' => array( array( 'harshone_page_title_bar_enable', '=', true ), array( 'harshone_page_title_bar_show_breadcrumbs', '=', true ) ),
            ),
		),
	)
); // End Page Title Bar Section


// --> Old Visibility Settings (Moved Breadcrumbs Edit Options Here)
Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Visibility Settings', 'harshone' ),
		'id'         => 'harshone_visibility_settings',
		'icon'       => 'el el-eye-open',
		'fields'     => array(
            array(
                'id'   => 'info_blog_visibility',
                'type' => 'info',
                'style'=> 'normal',
                'title'=> esc_html__('Blog/Post Visibility', 'harshone'),
                'desc' => esc_html__('Control elements related to blog posts and archives.', 'harshone'),
            ),
            array(
                'id'       => 'harshone_show_post_date',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Post Date', 'harshone' ),
                'default'  => true,
            ),
            array(
                'id'       => 'harshone_show_post_author',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Post Author', 'harshone' ),
                'default'  => true,
            ),
            array(
                'id'       => 'harshone_show_post_categories_tags',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Post Categories & Tags', 'harshone' ),
                'default'  => true,
            ),
            array(
                'id'       => 'harshone_show_comments',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Comments Section', 'harshone' ),
                'subtitle' => esc_html__( 'Globally enable or disable comments on posts and pages.', 'harshone' ),
                'default'  => true, // Default to true if you typically want comments shown
            ),
            array(
                'id'   => 'info_global_elements_visibility',
                'type' => 'info',
                'style'=> 'normal',
                'title'=> esc_html__('Global Elements Visibility', 'harshone'),
                'desc' => esc_html__('Control visibility of utility elements across the site.', 'harshone'),
            ),
            array(
                'id'       => 'harshone_show_breadcrumbs_global', // Changed ID to differentiate from page title bar setting
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Breadcrumbs (Global)', 'harshone' ),
                'subtitle' => esc_html__( 'Show/hide breadcrumbs outside of the page title bar.', 'harshone' ),
                'default'  => true,
            ),
            array(
                'id'       => 'harshone_breadcrumbs_separator',
                'type'     => 'text',
                'title'    => esc_html__( 'Breadcrumbs Separator', 'harshone' ),
                'default'  => '/',
                'required' => array( 'harshone_show_breadcrumbs_global', '=', true ),
            ),
            array(
                'id'       => 'harshone_breadcrumbs_show_home',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Home Link in Breadcrumbs', 'harshone' ),
                'default'  => true,
                'required' => array( 'harshone_show_breadcrumbs_global', '=', true ),
            ),
            array(
                'id'       => 'harshone_header_search_icon_enable', // Renamed for clarity
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Header Search Icon', 'harshone' ),
                'default'  => true,
            ),
		),
	)
); // End Visibility Settings Section


// -> Footer Settings
Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Footer', 'harshone' ),
		'id'         => 'footer_settings',
		'icon'       => 'el el-road',
		'subsection' => false,
		'fields'     => array(
            array(
                'id'          => 'harshone_footer_logo_show',
                'type'        => 'switch',
                'title'       => esc_html__( 'Show Footer Logo', 'harshone' ),
                'default'     => true,
            ),
            array(
                'id'       => 'harshone_footer_logo_type',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Footer Logo Type', 'harshone' ),
                'options'  => array(
                    'default'      => esc_html__( 'Site Title', 'harshone' ),
                    'custom_image' => esc_html__( 'Custom Image', 'harshone' ),
                ),
                'default'  => 'custom_image',
                'required' => array( 'harshone_footer_logo_show', '=', true ),
            ),
            array(
                'id'       => 'harshone_footer_logo_light',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Light Footer Logo', 'harshone' ),
                'subtitle' => esc_html__( 'Logo for light footer backgrounds.', 'harshone' ),
                'default'  => array( 'url' => HARSHONE_URI . 'assets/images/footer-logo.png', ),
                'required' => array( array( 'harshone_footer_logo_show', '=', true ), array( 'harshone_footer_logo_type', '=', 'custom_image' ) ),
            ),
            array(
                'id'       => 'harshone_footer_logo_dark',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Dark Footer Logo', 'harshone' ),
                'subtitle' => esc_html__( 'Logo for dark footer backgrounds.', 'harshone' ),
                'default'  => array( 'url' => HARSHONE_URI . 'assets/images/footer-logo-dark.png', ),
                'required' => array( array( 'harshone_footer_logo_show', '=', true ), array( 'harshone_footer_logo_type', '=', 'custom_image' ) ),
            ),
            array(
                'id'       => 'harshone_footer_logo_mobile',
                'type'     => 'media',
                'title'    => esc_html__( 'Upload Mobile Footer Logo', 'harshone' ),
                'subtitle' => esc_html__( 'Logo for mobile viewports. If empty, uses main footer logo.', 'harshone' ),
                'required' => array( array( 'harshone_footer_logo_show', '=', true ), array( 'harshone_footer_logo_type', '=', 'custom_image' ) ),
            ),
            array(
                'id'       => 'harshone_footer_logo_width',
                'type'     => 'text',
                'title'    => esc_html__( 'Footer Logo Width (px)', 'harshone' ),
                'validate' => 'numeric',
                'required' => array( array( 'harshone_footer_logo_show', '=', true ), array( 'harshone_footer_logo_type', '=', 'custom_image' ) ),
            ),
            array(
                'id'       => 'harshone_footer_logo_height',
                'type'     => 'text',
                'title'    => esc_html__( 'Footer Logo Height (px)', 'harshone' ),
                'validate' => 'numeric',
                'required' => array( array( 'harshone_footer_logo_show', '=', true ), array( 'harshone_footer_logo_type', '=', 'custom_image' ) ),
            ),
		),
	)
); // End Footer Settings Main Section

Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Footer Layouts', 'harshone' ),
		'id'         => 'footer_layouts',
		'icon'       => 'el el-picture',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'harshone_footer_style',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Select Footer Style', 'harshone' ),
				'subtitle' => esc_html__( 'Choose from 5 distinct footer designs.', 'harshone' ),
				'options'  => array(
					'style1' => array(
						'alt' => 'Footer Style 1',
						'img' => HARSHONE_URI . 'assets/images/placeholders/footer-style1-preview.jpg', // Placeholder image
					),
					'style2' => array(
						'alt' => 'Footer Style 2',
						'img' => HARSHONE_URI . 'assets/images/placeholders/footer-style2-preview.jpg', // Placeholder image
					),
                    'style3' => array(
						'alt' => 'Footer Style 3',
						'img' => HARSHONE_URI . 'assets/images/placeholders/footer-style3-preview.jpg', // Placeholder image
					),
                    'style4' => array(
						'alt' => 'Footer Style 4',
						'img' => HARSHONE_URI . 'assets/images/placeholders/footer-style4-preview.jpg', // Placeholder image
					),
                    'style5' => array(
						'alt' => 'Footer Style 5',
						'img' => HARSHONE_URI . 'assets/images/placeholders/footer-style5-preview.jpg', // Placeholder image
					),
				),
				'default'  => 'style1',
			),
		),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Footer Main Area', 'harshone' ),
		'id'         => 'footer_main_area',
		'icon'       => 'el el-minus',
		'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'harshone_footer_main_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Main Footer Background Color', 'harshone' ),
                'default'  => '#f8f8f8',
                'output'   => array( 'background-color' => '.site-footer.footer-style1, .site-footer.footer-style2 .footer-upper, .site-footer.footer-style3, .site-footer.footer-style4, .site-footer.footer-style5' ), // Adjust based on your HTML
            ),
            array(
                'id'       => 'harshone_footer_main_text_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Main Footer Text Color', 'harshone' ),
                'default'  => '#666666',
                'output'   => array( 'color' => '.site-footer.footer-style1, .site-footer.footer-style2 .footer-upper, .site-footer.footer-style3, .site-footer.footer-style4, .site-footer.footer-style5' ),
            ),
            array(
                'id'       => 'harshone_footer_main_link_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Main Footer Link Color', 'harshone' ),
                'default'  => '#333333',
                'output'   => array( 'color' => '.site-footer.footer-style1 a, .site-footer.footer-style2 .footer-upper a, .site-footer.footer-style3 a, .site-footer.footer-style4 a, .site-footer.footer-style5 a' ),
            ),
            array(
                'id'       => 'harshone_footer_main_font',
                'type'     => 'typography',
                'title'    => esc_html__( 'Main Footer Typography', 'harshone' ),
                'subtitle' => esc_html__( 'Set font styles for main footer content.', 'harshone' ),
                'google'   => true,
                'output'   => array( '.site-footer.footer-style1, .site-footer.footer-style2 .footer-upper, .site-footer.footer-style3, .site-footer.footer-style4, .site-footer.footer-style5' ),
                'default'  => array(
                    'font-family' => 'Arial',
                    'font-size'   => '14px',
                    'line-height' => '1.6',
                ),
            ),
			array(
				'id'       => 'harshone_footer_copyright_text',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Copyright Text', 'harshone' ),
				'default'  => '© ' . date_i18n( 'Y' ) . ' Harshone. All Rights Reserved.',
				'sanitize_callback' => 'wp_kses_post', // Sanitize text for HTML tags
			),
        ),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Footer Bottom Bar', 'harshone' ),
		'id'         => 'footer_bottom_bar',
		'icon'       => 'el el-lines',
		'subsection' => true,
        'fields'     => array(
			array(
				'id'       => 'harshone_footer_bottombar_enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Bottom Bar', 'harshone' ),
                'subtitle' => esc_html__( 'Show or hide the absolutely bottom bar of the footer.', 'harshone' ),
				'default'  => true,
			),
            array(
                'id'       => 'harshone_footer_bottombar_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Bottom Bar Background Color', 'harshone' ),
                'default'  => '#333333',
                'output'   => array( 'background-color' => '#colophon .bottom-bar, #colophon .site-info' ),
                'required' => array( 'harshone_footer_bottombar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_footer_bottombar_text_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Bottom Bar Text Color', 'harshone' ),
                'default'  => '#aaaaaa',
                'output'   => array( 'color' => '#colophon .bottom-bar, #colophon .site-info' ),
                'required' => array( 'harshone_footer_bottombar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_footer_bottombar_link_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Bottom Bar Link Color', 'harshone' ),
                'default'  => '#ffffff',
                'output'   => array( 'color' => '#colophon .bottom-bar a, #colophon .site-info a' ),
                'required' => array( 'harshone_footer_bottombar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_footer_bottombar_font',
                'type'     => 'typography',
                'title'    => esc_html__( 'Bottom Bar Typography', 'harshone' ),
                'subtitle' => esc_html__( 'Set font styles for bottom bar text.', 'harshone' ),
                'google'   => true,
                'output'   => array( '#colophon .bottom-bar, #colophon .site-info' ),
                'default'  => array(
                    'font-family' => 'Arial',
                    'font-size'   => '13px',
                    'line-height' => '1.5',
                ),
                'required' => array( 'harshone_footer_bottombar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_footer_bottombar_phone',
                'type'     => 'text',
                'title'    => esc_html__( 'Phone Number (Bottom Bar)', 'harshone' ),
                'required' => array( 'harshone_footer_bottombar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_footer_bottombar_address',
                'type'     => 'text',
                'title'    => esc_html__( 'Address (Bottom Bar)', 'harshone' ),
                'required' => array( 'harshone_footer_bottombar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_footer_bottombar_button_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Button Text (Bottom Bar)', 'harshone' ),
                'required' => array( 'harshone_footer_bottombar_enable', '=', true ),
            ),
            array(
                'id'       => 'harshone_footer_bottombar_button_link',
                'type'     => 'text',
                'title'    => esc_html__( 'Button Link (Bottom Bar)', 'harshone' ),
                'validate' => 'url',
                'required' => array( 'harshone_footer_bottombar_enable', '=', true ),
            ),
        ),
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'      => esc_html__( 'Social Media', 'harshone' ),
		'id'         => 'social_media',
		'icon'       => 'el el-group',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'harshone_social_links_enable',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Social Links', 'harshone' ),
				'default'  => true,
			),
			array(
				'id'          => 'harshone_social_links',
				'type'        => 'repeater',
				'title'       => esc_html__( 'Social Media Links', 'harshone' ),
				'subtitle'    => esc_html__( 'Add your social media profiles. Font Awesome 5 Free icons are supported.', 'harshone' ),
				'item_name'   => 'Platform',
				'add_button'  => esc_html__( 'Add New Social Link', 'harshone' ),
				'limits'      => array( 'min_rows' => 0, 'max_rows' => 10 ),
				'fields'      => array(
					array(
						'id'    => 'title',
						'type'  => 'text',
						'title' => esc_html__( 'Platform Name', 'harshone' ),
                        'default' => 'Facebook',
					),
					array(
						'id'    => 'url',
						'type'  => 'text',
						'title' => esc_html__( 'Profile URL', 'harshone' ),
						'validate' => 'url',
						'default' => '#',
					),
					array(
						'id'    => 'icon_class',
						'type'  => 'text',
						'title' => esc_html__( 'Font Awesome Icon Class', 'harshone' ),
						
						'desc'  => sprintf(
                            wp_kses(
                                /* translators: %s: Font Awesome Icons website */
                                __( 'E.g., <code>fab fa-facebook-f</code>, <code>fab fa-twitter</code>. Find more at %s', 'harshone' ),
                                array(
                                    'code' => array(),
                                    'a'    => array( 'href' => array(), 'target' => array(), 'rel' => array() ),
                                )
                            ),
                            '<a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" rel="noopener noreferrer">Font Awesome Icons</a>'
                        ),
						'default' => 'fab fa-facebook-f',
					),
				),
				'required' => array( 'harshone_social_links_enable', '=', true ),
			),
		),
	)
);

// -> Typography Settings (Moved for better organization of similar sections)
Redux::setSection(
	$opt_name,
	array(
		'title' => esc_html__( 'Typography', 'harshone' ),
		'id'    => 'typography_settings',
		'icon'  => 'el el-font',
		'fields' => array(
			array(
				'id'       => 'harshone_body_font',
				'type'     => 'typography',
				'title'    => esc_html__( 'Body Font', 'harshone' ),
				'subtitle' => esc_html__( 'Select the font for the body content.', 'harshone' ),
				'google'   => true,
				'output'   => array( 'body' ),
				'units'    => 'px',
				'default'  => array(
					'color'       => '#333333',
					'font-family' => 'Arial',
					'google'      => false,
					'font-size'   => '16px',
					'line-height' => '1.6',
				),
			),
			array(
				'id'       => 'harshone_heading_font',
				'type'     => 'typography',
				'title'    => esc_html__( 'Heading Font', 'harshone' ),
				'subtitle' => esc_html__( 'Select the font for H1-H6 headings.', 'harshone' ),
				'google'   => true,
				'output'   => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ),
				'units'    => 'px',
				'default'  => array(
					'color'       => '#222222',
					'font-family' => 'Roboto',
					'google'      => true,
					'font-weight' => '700',
                    'line-height' => '1.2',
				),
			),
		),
	)
);

// -> WooCommerce Settings
if ( class_exists( 'WooCommerce' ) ) {
	Redux::setSection(
		$opt_name,
		array(
			'title' => esc_html__( 'WooCommerce', 'harshone' ),
			'id'    => 'woocommerce_settings',
			'icon'  => 'el el-shopping-cart',
            'fields' => array(
                array(
                    'id'   => 'info_woocommerce_general',
                    'type' => 'info',
                    'style'=> 'normal',
                    'title'=> esc_html__('General WooCommerce Options', 'harshone'),
                    'desc' => esc_html__('Settings affecting overall WooCommerce functionality.', 'harshone'),
                ),
                array(
                    'id'       => 'harshone_shop_layout',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Shop & Archive Layout', 'harshone' ),
                    'options'  => array(
                        'right-sidebar' => esc_html__( 'Right Sidebar', 'harshone' ),
                        'left-sidebar'  => esc_html__( 'Left Sidebar', 'harshone' ),
                        'full-width'    => esc_html__( 'No Sidebar', 'harshone' ),
                    ),
                    'default'  => 'right-sidebar',
                ),
                array(
                    'id'       => 'harshone_shop_products_per_page',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Products per page (Shop)', 'harshone' ),
                    'subtitle' => esc_html__( 'Number of products to display on shop and archive pages.', 'harshone' ),
                    'validate' => 'numeric',
                    'default'  => '12',
                ),
                array(
                    'id'       => 'harshone_shop_products_per_row',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Products per row (Desktop)', 'harshone' ),
                    'subtitle' => esc_html__( 'Number of product columns on desktop view for shop/archive pages.', 'harshone' ),
                    'options'  => array(
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    ),
                    'default'  => '4',
                ),
                array(
                    'id'       => 'harshone_shop_display_style',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Shop Page Display', 'harshone' ),
                    'subtitle' => esc_html__( 'Choose what is shown on the main shop page.', 'harshone' ),
                    'options'  => array(
                        'products'   => esc_html__( 'Show products', 'harshone' ),
                        'categories' => esc_html__( 'Show categories', 'harshone' ),
                        'both'       => esc_html__( 'Show categories & products', 'harshone' ),
                    ),
                    'default'  => 'products',
                ),
                array(
                    'id'       => 'harshone_shop_pagination_type',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Shop Pagination Style', 'harshone' ),
                    'options'  => array(
                        'numeric'         => esc_html__( 'Numeric', 'harshone' ),
                        'load_more'       => esc_html__( 'Load More Button', 'harshone' ), // Requires custom JS/AJAX logic
                        'infinite_scroll' => esc_html__( 'Infinite Scroll', 'harshone' ), // Requires custom JS/AJAX logic
                    ),
                    'default'  => 'numeric',
                ),
                array(
                    'id'       => 'harshone_quick_view_enabled',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Product Quick View', 'harshone' ),
                    'subtitle' => esc_html__( 'Adds a quick view button in product loops (requires complementary plugin/JS).', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_wishlist_enabled',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Wishlist', 'harshone' ),
                    'subtitle' => esc_html__( 'Adds wishlist functionality (requires compatible plugin).', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_compare_enabled',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Product Compare', 'harshone' ),
                    'subtitle' => esc_html__( 'Adds product comparison functionality (requires compatible plugin).', 'harshone' ),
                    'default'  => false,
                ),
                array(
                    'id'   => 'info_single_product',
                    'type' => 'info',
                    'style'=> 'normal',
                    'title'=> esc_html__('Single Product Page Options', 'harshone'),
                    'desc' => esc_html__('Settings for individual product pages.', 'harshone'),
                ),
                array(
                    'id'       => 'harshone_single_product_gallery_zoom',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Product Gallery Zoom', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_single_product_gallery_lightbox',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Product Gallery Lightbox', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_single_product_tabs',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Product Data Tabs', 'harshone' ),
                    'subtitle' => esc_html__( 'Displays description, reviews, and additional info tabs.', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_single_product_meta',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Product Meta (SKU, Categories, Tags)', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_single_product_related_products',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Related Products', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_single_product_related_count',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Number of Related Products', 'harshone' ),
                    'validate' => 'numeric',
                    'default'  => '4',
                    'required' => array( 'harshone_single_product_related_products', '=', true ),
                ),
                array(
                    'id'       => 'harshone_single_product_upsells',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Up-Sells', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_single_product_upsells_count',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Number of Up-Sells', 'harshone' ),
                    'validate' => 'numeric',
                    'default'  => '4',
                    'required' => array( 'harshone_single_product_upsells', '=', true ),
                ),
                array(
                    'id'   => 'info_cart_checkout',
                    'type' => 'info',
                    'style'=> 'normal',
                    'title'=> esc_html__('Cart & Checkout Options', 'harshone'),
                    'desc' => esc_html__('Settings for cart and checkout pages.', 'harshone'),
                ),
                array(
                    'id'       => 'harshone_cart_cross_sells',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Show Cross-Sells on Cart Page', 'harshone' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'harshone_cart_cross_sells_count',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Number of Cross-Sells', 'harshone' ),
                    'validate' => 'numeric',
                    'default'  => '4',
                    'required' => array( 'harshone_cart_cross_sells', '=', true ),
                ),
                array(
                    'id'       => 'harshone_distraction_free_checkout',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Enable Distraction Free Checkout', 'harshone'
 ),
                    'subtitle' => esc_html__( 'Removes header, footer, and sidebar for a clean checkout flow.', 'harshone' ),
                    'default'  => false,
                ),
                array(
                    'id'   => 'info_product_styling',
                    'type' => 'info',
                    'style'=> 'normal',
                    'title'=> esc_html__('Product Display Styling', 'harshone'),
                    'desc' => esc_html__('Visual options for products.', 'harshone'),
                ),
                array(
                    'id'       => 'harshone_product_sale_badge_style',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Sale Badge Style', 'harshone' ),
                    'options'  => array(
                        'circle' => esc_html__( 'Circle', 'harshone' ),
                        'square' => esc_html__( 'Square', 'harshone' ),
                        'hidden' => esc_html__( 'Hidden', 'harshone' ),
                    ),
                    'default'  => 'circle',
                ),
                array(
                    'id'       => 'harshone_product_out_of_stock_badge_style',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Out of Stock Badge Style', 'harshone' ),
                    'options'  => array(
                        'text'   => esc_html__( 'Text Badge', 'harshone' ),
                        'hidden' => esc_html__( 'Hidden', 'harshone' ),
                    ),
                    'default'  => 'text',
                ),
                array(
                    'id'       => 'harshone_product_primary_color',
                    'type'     => 'color',
                    'title'    => esc_html__( 'WooCommerce Primary Color', 'harshone' ),
                    'subtitle' => esc_html__( 'Mostly affects buttons and links. This color is used for action buttons, links, and highlights.', 'harshone' ),
                    'default'  => '#007bff',
                    'output'   => array(
                        'background-color' => '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
                                           .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
                                           .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle',
                        'color'            => '.woocommerce-product-rating .star-rating span:before, .woocommerce-loop-product__title:hover, .woocommerce ul.products li.product .price',
                        'border-color'     => '.woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt'
                    )
                ),
            ),
		)
	);
}

// -> Maintenance Mode
Redux::setSection(
	$opt_name,
	array(
		'title' => esc_html__( 'Maintenance Mode', 'harshone' ),
		'id'    => 'maintenance_mode',
		'icon'  => 'el el-wrench',
		'fields' => array(
			array(
				'id'       => 'harshone_maintenance_mode',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Maintenance Mode', 'harshone' ),
				'subtitle' => esc_html__( 'Puts your site into maintenance mode, displaying a custom page to non-logged-in users.', 'harshone' ),
				'default'  => false,
			),
			array(
				'id'       => 'maintenance_mode_logo',
				'type'     => 'media',
				'title'    => esc_html__( 'Maintenance Mode Logo', 'harshone' ),
				'subtitle' => esc_html__( 'Upload a logo to display on the maintenance page.', 'harshone' ),
				'default'  => array(
					'url' => HARSHONE_URI . 'assets/images/logo.png',
				),
				'required' => array( 'harshone_maintenance_mode', '=', true ),
			),
			array(
				'id'       => 'maintenance_mode_heading',
				'type'     => 'text',
				'title'    => esc_html__( 'Maintenance Page Heading', 'harshone' ),
				'default'  => esc_html__( 'We are currently under maintenance!', 'harshone' ),
				'required' => array( 'harshone_maintenance_mode', '=', true ),
			),
			array(
				'id'       => 'maintenance_mode_text',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Maintenance Page Text', 'harshone' ),
				'default'  => esc_html__( 'Sorry for the inconvenience. Our website is currently undergoing planned maintenance and will be back shortly. Thank you for your patience!', 'harshone' ),
				'sanitize_callback' => 'wp_kses_post',
				'required' => array( 'harshone_maintenance_mode', '=', true ),
			),
		),
	)
);

/*
 * <--- END SECTIONS
 */