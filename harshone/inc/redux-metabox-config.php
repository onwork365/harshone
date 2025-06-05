<?php
/**
 * Redux Metaboxes for Harshone.
 * @package Harshone
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('redux/extensions/harshone_options/register', function() {
    error_log('HARSHONE DEBUG: redux/extensions/harshone_options/register hook fired');

    if ( ! class_exists('Redux_Metaboxes') ) {
        error_log('HARSHONE DEBUG: Redux_Metaboxes class does NOT exist!');
        return;
    }

    error_log('HARSHONE DEBUG: Registering Harshone metabox with Redux_Metaboxes::set_box');

    Redux_Metaboxes::set_box('harshone_options', [
        'id'         => 'harshone_page_metabox',
        'title'      => esc_html__( 'Harshone Page Options', 'harshone' ),
        'post_types' => [ 'post', 'page', 'product' ],
        'position'   => 'normal',
        'priority'   => 'high',
        'fields'     => [
            [
                'id'    => 'harshone_page_override_info',
                'type'  => 'info',
                'style' => 'normal',
                'title' => esc_html__( 'Page/Post Specific Overrides', 'harshone' ),
                'desc'  => esc_html__( 'These settings override global theme options for this item. "Default" uses the global setting.', 'harshone' ),
            ],
            [
                'id'       => 'harshone_custom_header_style',
                'type'     => 'select',
                'title'    => esc_html__( 'Custom Header Style', 'harshone' ),
                'options'  => [
                    ''       => esc_html__( 'Default', 'harshone' ),
                    'style1' => esc_html__( 'Header Style 1', 'harshone' ),
                    'style2' => esc_html__( 'Header Style 2', 'harshone' ),
                    'style3' => esc_html__( 'Header Style 3', 'harshone' ),
                    'style4' => esc_html__( 'Header Style 4', 'harshone' ),
                    'style5' => esc_html__( 'Header Style 5', 'harshone' ),
                ],
                'default'  => '',
            ],
            [
                'id'       => 'harshone_custom_footer_style',
                'type'     => 'select',
                'title'    => esc_html__( 'Custom Footer Style', 'harshone' ),
                'options'  => [
                    ''       => esc_html__( 'Default', 'harshone' ),
                    'style1' => esc_html__( 'Footer Style 1', 'harshone' ),
                    'style2' => esc_html__( 'Footer Style 2', 'harshone' ),
                    'style3' => esc_html__( 'Footer Style 3', 'harshone' ),
                    'style4' => esc_html__( 'Footer Style 4', 'harshone' ),
                    'style5' => esc_html__( 'Footer Style 5', 'harshone' ),
                ],
                'default'  => '',
            ],
            [
                'id'       => 'harshone_page_show_title_section',
                'type'     => 'switch',
                'title'    => esc_html__( 'Page Title Section Display Override', 'harshone' ),
                'default'  => '0',
                'on'       => esc_html__( 'Override to Show', 'harshone' ),
                'off'      => esc_html__( 'Override to Hide', 'harshone' ),
            ],
            [
                'id'       => 'harshone_page_custom_title_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Page Title Text', 'harshone' ),
                'desc'     => esc_html__( 'Leave empty to use the default post/page title. Visible when title section set to show.', 'harshone' ),
                'required' => [ 'harshone_page_show_title_section', '=', '1' ],
            ],
        ],
    ]);
    error_log('HARSHONE DEBUG: Redux_Metaboxes::set_box called!');
});