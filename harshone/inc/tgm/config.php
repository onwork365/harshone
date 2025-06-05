<?php
/**
 * TGM Plugin Activation configuration for Harshone.
 * Defines required and recommended plugins.
 *
 * @link http://tgmpluginactivation.com/
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'harshone_register_required_plugins' ) ) {
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register plugins that are either directly required or highly recommended
	 * for the Harshone theme's functionality.
	 */
	function harshone_register_required_plugins() {
		$plugins = array(
			// Elementor Website Builder (required for page building)
			array(
				'name'     => 'Elementor Website Builder',
				'slug'     => 'elementor',
				'required' => true,
				'version'  => '3.0.0', // Minimum version required for compatibility.
			),
			// WooCommerce (required for eCommerce functionality)
			array(
				'name'     => 'WooCommerce',
				'slug'     => 'woocommerce',
				'required' => true,
				'version'  => '8.0.0', // Minimum version required for compatibility.
			),
			// Redux Framework (required for theme options)
			array(
				'name'     => 'Redux Framework',
				'slug'     => 'redux-framework',
				'required' => true,
				'version'  => '4.0.0', // Minimum version required for stability.
			),
			// One Click Demo Import (required for easy demo content setup)
			array(
				'name'     => 'One Click Demo Import',
				'slug'     => 'one-click-demo-import',
				'required' => true,
				'version'  => '3.0.0', // Minimum version required.
			),
            // Example of an optional, recommended plugin
            array(
                'name'      => 'Contact Form 7',
                'slug'      => 'contact-form-7',
                'required'  => false, // This plugin is only recommended.
                'reason'    => esc_html__( 'Contact Form 7 is a popular plugin for creating contact forms.', 'harshone' ),
            ),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * @link http://tgmpluginactivation.com/configuration/
		 */
		$config = array(
			'id'           => 'harshone-tgmpa',          // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                             // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins',        // Menu slug.
			'parent_slug'  => 'themes.php',                   // Parent menu slug. (e.g., 'themes.php', 'plugins.php', 'options-general.php').
            'capability'   => 'edit_theme_options',           // Capability needed to view plugin install page, should be a big enough capability.
			'has_notices'  => true,                           // Show admin notices or not.
			'dismissable'  => true,                           // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                             // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                          // Automatically activate plugins after installation or not.
			'message'      => '',                             // Message to output right before the plugins table.
			'strings'      => array(                          // Custom strings for the plugin activation page.
				'page_title'                      => esc_html__( 'Install Required Plugins', 'harshone' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'harshone' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'harshone' ),
				'updating'                        => esc_html__( 'Updating Plugin: %s', 'harshone' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'harshone' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'harshone'
				),
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'harshone'
				),
				'notice_cannot_install'           => _n_noop(
					'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
					'harshone'
				),
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'harshone'
				),
				'notice_cannot_update'            => _n_noop(
					'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
					'harshone'
				),
				'notice_ask_to_activate'          => _n_noop(
					'The following plugin needs to be activated to use its functionality: %1$s.',
					'The following plugins need to be activated to use their functionality: %1$s.',
					'harshone'
				),
				'notice_cannot_activate'          => _n_noop(
					'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
					'harshone'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'harshone'
				),
				'update_link'                     => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'harshone'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'harshone'
				),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'harshone' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'harshone' ),
				'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'harshone' ),
				'plugin_already_active'           => esc_html__( 'No changes were made. The plugin was already active.', 'harshone' ),
				'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'harshone' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'harshone' ),
				'dismiss'                         => esc_html__( 'Dismiss this notice', 'harshone' ),
				'notice_cannot_uninstall'         => _n_noop(
					'Sorry, but you do not have the correct permissions to uninstall the %1$s plugin. Contact the administrator of this site for help on that.',
					'Sorry, but you do not have the correct permissions to uninstall the %1$s plugins. Contact the administrator of this site for help on that.',
					'harshone'
				),
				'must_use_in_theme'               => esc_html__( 'This plugin is a "Must Use" plugin and cannot be uninstalled.', 'harshone' ),
            ),
		);

		tgmpa( $plugins, $config );
	}
	add_action( 'tgmpa_register', 'harshone_register_required_plugins' );
}