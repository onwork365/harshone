<?php
/**
 * Custom Sanitize Callbacks for Redux Framework
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Example custom sanitize function for a text field to ensure it is always uppercase.
if ( ! function_exists( 'harshone_redux_sanitize_uppercase' ) ) {
    function harshone_redux_sanitize_uppercase( $value ) {
        return strtoupper( $value );
    }
}

// Example custom sanitize function for a numeric field to ensure it's a positive integer.
if ( ! function_exists( 'harshone_redux_sanitize_positive_int' ) ) {
    function harshone_redux_sanitize_positive_int( $value ) {
        return absint( $value );
    }
}

// You would then apply these in `config.php`:
/*
    array(
        'id'                => 'my_text_field',
        'type'              => 'text',
        'title'             => esc_html__( 'My Text Field', 'harshone' ),
        'sanitize_callback' => 'harshone_redux_sanitize_uppercase',
    ),
    array(
        'id'                => 'my_number_field',
        'type'              => 'text',
        'title'             => esc_html__( 'My Number Field', 'harshone' ),
        'validate'          => 'numeric',
        'sanitize_callback' => 'harshone_redux_sanitize_positive_int',
    ),
*/