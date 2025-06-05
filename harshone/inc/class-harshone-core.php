<?php
/**
 * Harshone Core Class
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Harshone_Core {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->includes();
	}

	/**
	 * Include necessary theme files.
	 */
	private function includes() {
		require_once HARSHONE_DIR . 'inc/config.php';
		require_once HARSHONE_DIR . 'inc/enqueue.php';
		require_once HARSHONE_DIR . 'inc/template-functions.php';
		require_once HARSHONE_DIR . 'inc/pagination.php';
		require_once HARSHONE_DIR . 'inc/breadcrumbs.php';
		require_once HARSHONE_DIR . 'inc/custom-comments.php';
		require_once HARSHONE_DIR . 'inc/custom-header.php';
		require_once HARSHONE_DIR . 'inc/maintenance-mode.php';
		require_once HARSHONE_DIR . 'inc/widgets.php';
		require_once HARSHONE_DIR . 'inc/elementor-compatibility.php';

		// WooCommerce
		if ( class_exists( 'WooCommerce' ) ) {
			require_once HARSHONE_DIR . 'inc/woocommerce/woocommerce-functions.php';
			require_once HARSHONE_DIR . 'inc/woocommerce/template-hooks.php';
			require_once HARSHONE_DIR . 'inc/woocommerce/class-harshone-woocommerce.php';
		}

		// Redux Framework (as a plugin via TGM for ThemeForest)
		require_once HARSHONE_DIR . 'inc/theme-options/config.php';

        // Redux Metaboxes
        // This check should use the Redux_Metaboxes class name which is only available if the extension is loaded.
        // It's vital that the Redux Framework plugin is active for these to work.
        if ( class_exists( 'Redux' ) && class_exists( 'Redux_Metaboxes' ) ) {
            require_once HARSHONE_DIR . 'inc/metaboxes/page-options.php';
        }


		// TGM Plugin Activation
		require_once HARSHONE_DIR . 'inc/tgm/class-tgm-plugin-activation.php';
		require_once HARSHONE_DIR . 'inc/tgm/config.php';

		// One Click Demo Import
		if ( class_exists( 'OCDI_Plugin' ) ) { // Check if OCDI plugin is active
			require_once HARSHONE_DIR . 'inc/one-click-demo-import/config.php';
		}

		// Theme Updater
		require_once HARSHONE_DIR . 'inc/theme-updater/class-harshone-updater.php';

	}

	/**
	 * Run the theme.
	 */
	public function run() {
		add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
	}

	/**
	 * Set up theme defaults and register support for various WordPress features.
	 */
	public function setup_theme() {
		// Make theme available for translation.
		load_theme_textdomain( 'harshone', HARSHONE_DIR . 'languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Set content-width.
		$GLOBALS['content_width'] = apply_filters( 'harshone_content_width', 840 );

		// Register nav menus.
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary Menu', 'harshone' ),
				'footer-menu'  => esc_html__( 'Footer Menu', 'harshone' ),
			)
		);

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for core block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for custom color palettes.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => esc_html__( 'Primary', 'harshone' ),
					'slug'  => 'primary',
					'color' => '#007bff',
				),
				array(
					'name'  => esc_html__( 'Secondary', 'harshone' ),
					'slug'  => 'secondary',
					'color' => '#6c757d',
				),
				// Add more colors as needed.
			)
		);

		// Add custom editor style.
		add_editor_style( 'assets/css/editor-style.css' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for WooCommerce.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Add custom image sizes.
		add_image_size( 'harshone-thumbnail', 300, 300, true );
		add_image_size( 'harshone-full-width', 1140, 600, true ); // Example custom size

		// Add support for additional theme features.
		add_theme_support( 'custom-logo', array(
			'height'      => 80,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		) );

		// Allow WordPress to manage the body class for better styling options.
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );
	}

	/**
	 * Register widget area.
	 */
	public function widgets_init() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Blog Sidebar', 'harshone' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here to appear in your blog sidebar.', 'harshone' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'WooCommerce Sidebar', 'harshone' ),
				'id'            => 'woocommerce-sidebar',
				'description'   => esc_html__( 'Add widgets here to appear in your WooCommerce shop and product pages.', 'harshone' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);

		// Add footer widget areas
		for ( $i = 1; $i <= 4; $i++ ) { // Example: 4 footer widget columns
			register_sidebar(
				array(
					'name'          => sprintf( esc_html__( 'Footer Column %d', 'harshone' ), $i ),
					'id'            => 'footer-' . $i,
					'description'   => sprintf( esc_html__( 'Add widgets here to appear in your footer column %d.', 'harshone' ), $i ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			);
		}
	}
}