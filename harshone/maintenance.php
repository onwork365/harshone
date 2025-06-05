<?php
/**
 * Template for the theme's maintenance mode page.
 * Displays when maintenance mode is active.
 *
 * @package Harshone
 * @version 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e( 'Under Maintenance', 'harshone' ); ?></title>
    <?php wp_head(); // Enqueue custom styles for maintenance page if any ?>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f8f8;
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
        }
        .maintenance-container {
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
        }
        .maintenance-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #007bff;
        }
        .maintenance-container p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .maintenance-container .logo {
            margin-bottom: 30px;
        }
        .maintenance-container .logo img {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body class="harshone-maintenance-mode">
    <div class="maintenance-container">
        <?php
        // Get maintenance mode logo from Redux options
        $maintenance_logo_option = harshone_get_theme_option( 'maintenance_mode_logo', array( 'url' => HARSHONE_URI . 'assets/images/logo.png' ) );
        
        // Extract the URL from the Redux option, ensuring it's a string
        $logo_url = '';
        if ( is_string( $maintenance_logo_option ) && ! empty( $maintenance_logo_option ) ) {
            $logo_url = $maintenance_logo_option; // Case where it might be a simple URL string
        } elseif ( is_array( $maintenance_logo_option ) && isset( $maintenance_logo_option['url'] ) && ! empty( $maintenance_logo_option['url'] ) ) {
            $logo_url = $maintenance_logo_option['url']; // Case where it's a Redux media array
        } else {
            $logo_url = HARSHONE_URI . 'assets/images/logo.png'; // Fallback to default theme logo
        }

        if ( ! empty( $logo_url ) ) : ?>
            <div class="logo">
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?> Logo">
            </div>
        <?php endif; ?>

        <h1><?php echo esc_html( harshone_get_theme_option('maintenance_mode_heading', esc_html__( 'We are currently under maintenance!', 'harshone' )) ); ?></h1>
        <p><?php echo wp_kses_post( harshone_get_theme_option('maintenance_mode_text', esc_html__( 'Sorry for the inconvenience. Our website is currently undergoing planned maintenance and will be back shortly. Thank you for your patience!', 'harshone' )) ); ?></p>
        <?php
        // Optionally display a countdown or social media links from theme options
        // $countdown_text = harshone_get_theme_option('maintenance_countdown_text');
        // if (!empty($countdown_text)) { echo '<p>' . esc_html($countdown_text) . '</p>'; }
        ?>
    </div>
    <?php wp_footer(); ?>
</body>
</html>