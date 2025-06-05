<?php
/**
 * Harshone Theme Updater Class
 * Handles theme updates directly from punsys.com.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Harshone_Theme_Updater' ) ) {

	class Harshone_Theme_Updater {

		private $theme_slug;
		private $update_url;
		private $license_key; // For potential license key validation

		/**
		 * Constructor.
		 *
		 * @param string $theme_slug The slug of the theme.
		 * @param string $update_url The URL of the update server API endpoint.
		 * @param string $license_key Optional. License key for validation.
		 */
		public function __construct( $theme_slug, $update_url, $license_key = null ) {
			$this->theme_slug  = $theme_slug;
			$this->update_url  = trailingslashit( $update_url ); // Ensure trailing slash
			$this->license_key = $license_key; // Get this from theme options, e.g., harshone_get_theme_option('license_key')

			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_for_update' ) );
			add_filter( 'upgrader_process_complete', array( $this, 'after_update' ), 10, 2 );
			add_filter( 'themes_api', array( $this, 'themes_api' ), 10, 3 );
		}

		/**
		 * Check for theme updates by querying the update server.
		 *
		 * @param object $transient The update transient.
		 * @return object Modified transient.
		 */
		public function check_for_update( $transient ) {
			if ( empty( $transient->checked ) ) {
				return $transient;
			}

			// Get theme data from style.css
			$theme_data = wp_get_theme( $this->theme_slug );
			$current_version = $theme_data->get( 'Version' );

			$args = array(
				'action'      => 'get_theme_update', // Action for the update API
				'theme_slug'  => $this->theme_slug,
				'version'     => $current_version,
				'license_key' => $this->license_key, // Pass license key for validation (if applicable)
			);

            // Prepare request body (serialized PHP data)
            $request_body = array( 'body' => array( 'request' => serialize( $args ) ) );

			// Query the update server for new information
			$response = wp_remote_post(
				$this->update_url,
				array_merge(
                    array(
                        'timeout'     => 15, // Max time to wait for response
                        'sslverify'   => false, // Set to true for production once SSL is correctly configured on update server
                                                 // For local development with self-signed SSL or certain environments, might need false temporarily
                    ),
                    $request_body // Merge the body parameter
                )
			);

            if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
                // Log error if debugging is active.
                if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                    error_log( sprintf( 'Harshone theme update check failed: %s', is_wp_error( $response ) ? $response->get_error_message() : 'HTTP Error ' . wp_remote_retrieve_response_code( $response ) ) );
                }
				return $transient; // Return transient unchanged on error
			}

			$theme_update_data = @unserialize( wp_remote_retrieve_body( $response ) ); // @ to suppress warnings from malformed serialized data

			if ( empty( $theme_update_data ) || ! is_array( $theme_update_data ) || ! isset( $theme_update_data['new_version'] ) ) {
                // Log error if debugging is active.
                if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                    error_log( sprintf( 'Harshone theme update data invalid/empty: %s', wp_remote_retrieve_body( $response ) ) );
                }
				return $transient; // No valid update data
			}

            // If a new version is available.
			if ( version_compare( $current_version, $theme_update_data['new_version'], '<' ) ) {
				$transient->response[ $this->theme_slug ] = array(
					'new_version' => $theme_update_data['new_version'],
					'url'         => $theme_update_data['url'], // URL to the theme details page
					'package'     => $theme_update_data['package'], // URL to the theme ZIP file
				);
			}

			return $transient;
		}

        /**
         * Hooks into the themes_api function to provide detailed information about the theme.
         * This allows the "View Version x.x details" modal to show up on the themes page.
         *
         * @param false|object|array $result The result object or array. Default false.
         * @param string             $action The type of API request.
         * @param object             $args   API arguments.
         * @return object Modified API request result.
         */
        public function themes_api( $result, $action, $args ) {
            if ( 'theme_information' !== $action || $this->theme_slug !== $args->slug ) {
                return $result;
            }

            $theme_data = wp_get_theme( $this->theme_slug );
            $current_version = $theme_data->get( 'Version' );

            $request_args = array(
                'action'              => 'get_theme_info', // Action for the info API
                'theme_slug'          => $this->theme_slug,
                'version'             => $current_version,
                'license_key'         => $this->license_key,
            );

            // Prepare request body (serialized PHP data)
            $request_body = array( 'body' => array( 'request' => serialize( $request_args ) ) );

            $response = wp_remote_post(
                $this->update_url,
                array_merge(
                    array(
                        'timeout'     => 15,
                        'sslverify'   => false, // Set to true for production once SSL is correctly configured on update server
                    ),
                    $request_body
                )
            );

            if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
                // Log error if debugging is active.
                if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                    error_log( sprintf( 'Harshone theme info API call failed: %s', is_wp_error( $response ) ? $response->get_error_message() : 'HTTP Error ' . wp_remote_retrieve_response_code( $response ) ) );
                }
                return $result; // Return result unchanged on error
            }

            $theme_info = @unserialize( wp_remote_retrieve_body( $response ) ); // @ to suppress warnings from malformed serialized data

            if ( ! empty( $theme_info ) && is_array( $theme_info ) ) {
                // Construct the object response for WordPress
                $result = (object) array(
                    'slug'            => $this->theme_slug,
                    'name'            => $theme_data->get( 'Name' ),
                    'version'         => isset( $theme_info['new_version'] ) ? $theme_info['new_version'] : $current_version,
                    'author'          => isset( $theme_info['author'] ) ? $theme_info['author'] : $theme_data->get( 'Author' ),
                    'homepage'        => isset( $theme_info['url'] ) ? $theme_info['url'] : $theme_data->get( 'ThemeURI' ),
                    'requires'        => isset( $theme_info['requires_wp'] ) ? $theme_info['requires_wp'] : $theme_data->get( 'RequiresWP' ),     // WP Version it requires
                    'tested'          => isset( $theme_info['tested_wp'] ) ? $theme_info['tested_wp'] : $theme_data->get( 'TestedWP' ),       // WP Version tested up to
                    'requires_php'    => isset( $theme_info['requires_php'] ) ? $theme_info['requires_php'] : $theme_data->get( 'RequiresPHP' ), // PHP Version it requires
                    'sections'        => array(
                        'description' => isset( $theme_info['description'] ) ? $theme_info['description'] : $theme_data->get( 'Description' ),
                        'changelog'   => isset( $theme_info['changelog'] ) ? $theme_info['changelog'] : sprintf( '%s: %s', esc_html__( 'No changelog available for', 'harshone' ), $this->theme_slug ),
                    ),
                    'download_link'   => isset( $theme_info['package'] ) ? $theme_info['package'] : '',
                    'external_url'    => isset( $theme_info['url'] ) ? $theme_info['url'] : '',
                );
            }

            return $result;
        }

		/**
		 * Actions to take after theme update is complete.
		 *
		 * @param WP_Upgrader $upgrader_object   WP_Upgrader instance.
		 * @param array       $options Array of bulk update data.
		 */
		public function after_update( $upgrader_object, $options ) {
			if ( 'update' === $options['action'] && 'theme' === $options['type'] && isset( $options['themes'] ) ) {
				foreach ( $options['themes'] as $theme_slug ) {
					if ( $theme_slug === $this->theme_slug ) {
						// Clear theme update caches after success.
						delete_site_transient( 'update_themes' );
					}
				}
			}
		}
	} // End class Harshone_Theme_Updater

	// Initialize the updater with the NEW API URL
	$harshone_updater_api_url = 'https://punsys.com/themes-data/harshone/update/index.php'; // NEW API ENDPOINT
	$harshone_license_key = ''; // Implement logic to retrieve actual license key if needed from theme options

	new Harshone_Theme_Updater( 'harshone', $harshone_updater_api_url, $harshone_license_key );
}