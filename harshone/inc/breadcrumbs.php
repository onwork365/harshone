<?php
/**
 * Custom breadcrumbs functions for Harshone.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'harshone_breadcrumbs' ) ) {
	/**
	 * Display breadcrumbs.
	 * Based on Yoast SEO breadcrumbs behavior.
     * Conditionally displays based on theme option.
	 */
	function harshone_breadcrumbs() {
        if ( ! harshone_get_theme_option('harshone_breadcrumb_enable', true) ) {
            return;
        }

		if ( function_exists( 'yoast_breadcrumb' ) ) {
			// Use Yoast SEO breadcrumbs if available
			yoast_breadcrumb( '<p id="breadcrumbs" class="harshone-breadcrumbs">', '</p>' );
			return;
		}

		// Fallback manual breadcrumbs if Yoast SEO is not active
		global $post;

		$output       = array();
		$output[]     = '<div class="harshone-breadcrumbs">';
		$output[]     = '<ol class="breadcrumb mb-0 py-2 px-0 bg-transparent rounded-0">';
		$output[]     = '<li class="breadcrumb-item"><a href="' . esc_url( home_url() ) . '">' . esc_html__( 'Home', 'harshone' ) . '</a></li>';

		if ( is_archive() && ! is_tax() && ! is_category() && ! is_tag() ) {
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . post_type_archive_title( '', false ) . '</li>';
		} elseif ( is_archive() && is_tax() && ! is_category() && ! is_tag() ) {
			$term = get_query_var( 'term' );
			$post_type = get_query_var( 'post_type' );
			if ( $post_type ) {
				$output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_post_type_archive_link( $post_type ) ) . '">' . esc_html( post_type_archive_title( '', false ) ) . '</a></li>';
			}
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . single_term_title( '', false ) . '</li>';
		} elseif ( is_category() ) {
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . single_cat_title( '', false ) . '</li>';
		} elseif ( is_tag() ) {
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . single_tag_title( '', false ) . '</li>';
		} elseif ( is_single() || is_page() ) {
			if ( is_singular( 'product' ) && class_exists( 'WooCommerce' ) ) {
                if ( wc_get_page_id( 'shop' ) ) {
                    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( $shop_page_url ) . '">' . esc_html__( 'Shop', 'harshone' ) . '</a></li>';
                }
                $terms = get_the_terms( $post->ID, 'product_cat' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    $main_term = $terms[0]; // Get the first term
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $main_term ) ) . '">' . esc_html( $main_term->name ) . '</a></li>';
                }
            } elseif ( get_post_type() !== 'post' && get_post_type() !== 'page' ) {
                $post_type_obj = get_post_type_object( get_post_type() );
                if ( $post_type_obj->has_archive ) {
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '">' . esc_html( $post_type_obj->labels->singular_name ) . '</a></li>';
                }
            } elseif ( is_singular( 'post' ) ) {
                $categories = get_the_category( $post->ID );
                if ( ! empty( $categories ) ) {
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></li>';
                }
            }

            if ( $post->post_parent ) {
                $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
                foreach ( $ancestors as $ancestor ) {
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a></li>';
                }
            }
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
		} elseif ( is_home() || is_search() || is_404() ) {
			if ( is_home() && ! is_front_page() ) {
				$output[] = '<li class="breadcrumb-item active" aria-current="page">' . single_post_title( '', false ) . '</li>';
			} elseif ( is_search() ) {
				$output[] = '<li class="breadcrumb-item active" aria-current="page">' . sprintf( esc_html__( 'Search results for "%s"', 'harshone' ), get_search_query() ) . '</li>';
			} elseif ( is_404() ) {
				$output[] = '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( '404 Not Found', 'harshone' ) . '</li>';
			}
		}

		$output[] = '</ol>';
		$output[] = '</div>';

		echo implode( "\n", $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}