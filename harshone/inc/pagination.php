<?php
/**
 * Custom post navigation and pagination functions.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'harshone_the_posts_navigation' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 * Can be used for archive pages, search results, etc.
	 */
	function harshone_the_posts_navigation() {
		the_posts_navigation(
			array(
				'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Older posts', 'harshone' ) . '</span>',
				'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Newer posts', 'harshone' ) . '</span>',
			)
		);
	}
endif;

if ( ! function_exists( 'harshone_numeric_posts_pagination' ) ) :
	/**
	 * Display numeric pagination.
	 *
	 * @param array $args Optional. Arguments for paginate_links().
	 */
	function harshone_numeric_posts_pagination( $args = array() ) {
		global $wp_query;

		$big = 999999999; // Need this to uniquely identify a URL parameter.

		$paginate_links_args = wp_parse_args( $args, array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
            'type'      => 'list', // Change to 'array' if you want to apply more custom markup.
            'prev_next' => true,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
            'end_size'  => 1,
            'mid_size'  => 2,
		) );

        $links = paginate_links( $paginate_links_args );

        if ( $links ) {
            echo '<nav class="harshone-pagination my-4" aria-label="' . esc_attr__( 'Page navigation', 'harshone' ) . '">';
            echo wp_kses_post( $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links is safe.
            echo '</nav>';
        }
	}
endif;