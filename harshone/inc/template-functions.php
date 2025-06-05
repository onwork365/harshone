<?php
/**
 * Custom template functions for Harshone.
 * This file contains functions that are used by various template files.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper function to retrieve options from Redux Metaboxes.
 *
 * @param int    $post_id    The ID of the post to retrieve options for.
 * @param string $key        The option key.
 * @param mixed  $default    Default value if option is not set.
 * @return mixed             The option value.
 */
if ( ! function_exists( 'harshone_get_meta_option' ) ) {
    function harshone_get_meta_option( $post_id, $key, $default = '' ) {
        if ( ! $post_id ) {
            return $default;
        }

        // Metavalue from Redux Metabox. Assumes metabox ID is 'harshone_page_metabox'
        $meta_data = get_post_meta( $post_id, 'harshone_page_metabox', true );

        if ( isset( $meta_data[ $key ] ) && $meta_data[ $key ] !== '' ) {
            // Special handling for switch overrides (0=default, 1=on, 2=off)
            if ( $key === 'harshone_page_show_title_section' && $meta_data[ $key ] === '1' ) { // Redux switch uses '1' for ON override
                 return '1'; // Return as string '1' to match validation for switch field
            } elseif ( $key === 'harshone_page_show_title_section' && $meta_data[ $key ] === '2' ) { // Redux switch uses '2' for OFF override
                 return '2'; // Return as string '2'
            }
            return $meta_data[ $key ];
        }

        return $default;
    }
}

if ( ! function_exists( 'harshone_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function harshone_posted_on() {
        if ( ! harshone_get_theme_option( 'harshone_show_post_date', true ) ) {
            return;
        }
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'harshone' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'harshone_posted_by' ) ) {
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function harshone_posted_by() {
        if ( ! harshone_get_theme_option( 'harshone_show_post_author', true ) ) {
            return;
        }
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'harshone' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'harshone_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function harshone_entry_footer() {
        if ( ! harshone_get_theme_option( 'harshone_show_post_categories_tags', true ) ) {
            return;
        }
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( esc_html__( ', ', 'harshone' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'harshone' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma. */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'harshone' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'harshone' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'harshone' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'harshone' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>',
			get_the_ID(),
		);
	}
}

if ( ! function_exists( 'harshone_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function harshone_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail( 'post-thumbnail', array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) );
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
}

/**
 * Custom function to display breadcrumbs.
 * Uses Redux options for customization.
 */
// This function will be called by harshone_display_page_title_section() and potentially directly in other templates
if ( ! function_exists( 'harshone_breadcrumbs' ) ) {
	/**
	 * Display breadcrumbs.
	 * Based on Yoast SEO breadcrumbs behavior.
	 *
	 * @param bool $in_page_title_bar True if displaying in page title bar, to use specific colors.
	 */
	function harshone_breadcrumbs( $in_page_title_bar = false ) {
        // Get global breadcrumb settings
        $show_global = harshone_get_theme_option( 'harshone_show_breadcrumbs_global', true );
        $separator   = harshone_get_theme_option( 'harshone_breadcrumbs_separator', '/' );
        $show_home   = harshone_get_theme_option( 'harshone_breadcrumbs_show_home', true );

        // If not in page title bar, check global visibility.
        // If in page title bar, its own setting controls visibility.
        if ( ! $show_global && ! $in_page_title_bar ) {
            return;
        }
        // If specifically in page title bar context, check its setting first.
        if ( $in_page_title_bar && ! harshone_get_theme_option( 'harshone_page_title_bar_show_breadcrumbs', true ) ) {
            return;
        }

		if ( function_exists( 'yoast_breadcrumb' ) ) {
			// Use Yoast SEO breadcrumbs if available
            echo '<div class="harshone-breadcrumbs ' . ( $in_page_title_bar ? 'in-page-title-bar' : 'global-breadcrumbs' ) . '">';
            // Yoast doesn't have args for separator or home link, rely on Yoast settings for these
			yoast_breadcrumb( '<ol class="breadcrumb mb-0 py-2 px-0 bg-transparent rounded-0">', '</ol>' );
            echo '</div>';
			return;
		}

		// Fallback manual breadcrumbs if Yoast SEO is not active
		global $post;

		$output       = array();
		$output[]     = '<div class="harshone-breadcrumbs ' . ( $in_page_title_bar ? 'in-page-title-bar' : 'global-breadcrumbs' ) . '">';
		$output[]     = '<ol class="breadcrumb mb-0 py-2 px-0 bg-transparent rounded-0">';
		
        if ( $show_home ) {
            $output[]     = '<li class="breadcrumb-item"><a href="' . esc_url( home_url() ) . '">' . esc_html__( 'Home', 'harshone' ) . '</a></li>';
        }

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
            if ( $show_home && get_queried_object() && get_queried_object()->parent ) {
                $category = get_queried_object();
                $parent_id = $category->parent;
                $parent_category = get_category( $parent_id );
                $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $parent_id, 'category' ) ) . '">' . esc_html( $parent_category->name ) . '</a><span class="breadcrumb-separator">' . esc_html( $separator ) . '</span></li>';
            }
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . single_cat_title( '', false ) . '</li>';
		} elseif ( is_tag() ) {
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . single_tag_title( '', false ) . '</li>';
		} elseif ( is_single() || is_page() ) {
			if ( is_singular( 'product' ) && class_exists( 'WooCommerce' ) ) {
                if ( wc_get_page_id( 'shop' ) && $show_home ) { // Include shop link if home is shown
                    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( $shop_page_url ) . '">' . esc_html__( 'Shop', 'harshone' ) . '</a><span class="breadcrumb-separator">' . esc_html( $separator ) . '</span></li>';
                }
                $terms = get_the_terms( $post->ID, 'product_cat' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    $main_term = $terms[0]; // Get the first term
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_term_link( $main_term ) ) . '">' . esc_html( $main_term->name ) . '</a><span class="breadcrumb-separator">' . esc_html( $separator ) . '</span></li>';
                }
            } elseif ( get_post_type() !== 'post' && get_post_type() !== 'page' ) {
                $post_type_obj = get_post_type_object( get_post_type() );
                if ( $post_type_obj->has_archive ) {
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '">' . esc_html( $post_type_obj->labels->singular_name ) . '</a><span class="breadcrumb-separator">' . esc_html( $separator ) . '</span></li>';
                }
            } elseif ( is_singular( 'post' ) ) {
                $categories = get_the_category( $post->ID );
                if ( ! empty( $categories ) ) {
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a><span class="breadcrumb-separator">' . esc_html( $separator ) . '</span></li>';
                }
            }

            if ( $post->post_parent ) {
                $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
                foreach ( $ancestors as $ancestor ) {
                    $output[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a><span class="breadcrumb-separator">' . esc_html( $separator ) . '</span></li>';
                }
            }
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
		} elseif ( is_home() && ! is_front_page() ) {
            $output[] = '<li class="breadcrumb-item active" aria-current="page">' . single_post_title( '', false ) . '</li>';
		} elseif ( is_search() ) {
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . sprintf( esc_html__( 'Search results for "%s"', 'harshone' ), get_search_query() ) . '</li>';
		} elseif ( is_404() ) {
			$output[] = '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( '404 Not Found', 'harshone' ) . '</li>';
		}

		$output[] = '</ol>';
		$output[] = '</div>';

		echo implode( "\n", $output ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Gets the custom logo based on theme options.
 *
 * @param string $context 'header' or 'footer' to determine logo type (light/dark etc.)
 */
if ( ! function_exists( 'harshone_get_site_logo' ) ) {
    function harshone_get_site_logo( $context = 'header' ) {
        $logo_show  = harshone_get_theme_option( 'harshone_' . $context . '_logo_show', true ); // Global show/hide

        if ( ! $logo_show ) {
            return; // Don't display logo if option is hidden
        }

        $logo_type  = harshone_get_theme_option( 'harshone_' . $context . '_logo_type', 'custom_image' );


        $logo_url = '';
        // Determine which logo to use based on context and potential light/dark/mobile settings
        if ( $context === 'header' ) {
            // Retrieve values for light, dark, and mobile logos
            $header_logo_light  = harshone_get_theme_option( 'harshone_header_logo_light', array() );
            $header_logo_dark   = harshone_get_theme_option( 'harshone_header_logo_dark', array() );
            $header_logo_mobile = harshone_get_theme_option( 'harshone_header_logo_mobile', array() );

            // Determine which header style is active to potentially pick logo
            $header_style = harshone_get_theme_option( 'harshone_header_style', 'style1' );

            // Initial choice based on current header style
            if ( in_array( $header_style, array( 'style2', 'style4', 'style5' ), true ) ) { // Assuming some styles have dark background or specific needs for a dark logo
                $logo_url = ( is_array( $header_logo_dark ) && isset( $header_logo_dark['url'] ) ) ? $header_logo_dark['url'] : '';
            } else {
                $logo_url = ( is_array( $header_logo_light ) && isset( $header_logo_light['url'] ) ) ? $header_logo_light['url'] : '';
            }

            // Could add specific mobile logo override if desired by design
            // For now, if mobile logo is set, it will be the default on smaller screens via CSS.
            // PHP-side check might be needed for specific scenarios.
            // if ( wp_is_mobile() && is_array( $header_logo_mobile ) && isset( $header_logo_mobile['url'] ) ) {
            //     $logo_url = $header_logo_mobile['url'];
            // }

            // Fallback to light logo if specific (dark) logo not set
            if ( empty( $logo_url ) && is_array( $header_logo_light ) && isset( $header_logo_light['url'] ) ) {
                $logo_url = $header_logo_light['url'];
            }

            // Fallback to WP Customizer logo if theme options are empty
            if ( empty( $logo_url ) && has_custom_logo() ) {
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $custom_logo_info = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                if ( $custom_logo_info ) {
                    $logo_url = $custom_logo_info[0];
                }
            }


        } elseif ( $context === 'footer' ) {
            $footer_logo_light = harshone_get_theme_option( 'harshone_footer_logo_light', array() );
            $footer_logo_dark  = harshone_get_theme_option( 'harshone_footer_logo_dark', array() );
            $footer_style      = harshone_get_theme_option( 'harshone_footer_style', 'style1' );

            if ( in_array( $footer_style, array( 'style2', 'style4', 'style5' ), true ) ) { // Assuming some styles have dark background
                $logo_url = ( is_array( $footer_logo_dark ) && isset( $footer_logo_dark['url'] ) ) ? $footer_logo_dark['url'] : '';
            } else {
                $logo_url = ( is_array( $footer_logo_light ) && isset( $footer_logo_light['url'] ) ) ? $footer_logo_light['url'] : '';
            }

            // Fallback to light logo if specific (dark) logo not set
            if ( empty( $logo_url ) && is_array( $footer_logo_light ) && isset( $footer_logo_light['url'] ) ) {
                $logo_url = $footer_logo_light['url'];
            }
            // Fallback to WP Customizer logo if theme options are empty
            if ( empty( $logo_url ) && has_custom_logo() ) {
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $custom_logo_info = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                if ( $custom_logo_info ) {
                    $logo_url = $custom_logo_info[0];
                }
            }
        }


        $logo_width  = harshone_get_theme_option( 'harshone_' . $context . '_logo_width', '' );
        $logo_height = harshone_get_theme_option( 'harshone_' . $context . '_logo_height', '' );

        $style_attrs = '';
        if ( ! empty( $logo_width ) ) {
            $style_attrs .= 'width: ' . esc_attr( $logo_width ) . 'px;';
        }
        if ( ! empty( $logo_height ) ) {
            $style_attrs .= 'height: ' . esc_attr( $logo_height ) . 'px;';
        }

        $site_name = get_bloginfo( 'name' );
        $site_description = get_bloginfo( 'description', 'display' );

        echo '<a class="site-logo-link" href="' . esc_url( home_url( '/' ) ) . '" rel="home">';
        if ( 'default' === $logo_type || ( 'custom_image' === $logo_type && empty( $logo_url ) ) ) {
            // Display site title as text logo (default type or custom image not set)
            echo '<span class="site-title-text">' . esc_html( $site_name ) . '</span>';
            if ( $site_description && ( is_home() || is_front_page() ) ) {
                echo '<p class="site-description">' . esc_html( $site_description ) . '</p>';
            }
        } else {
            // Display image logo (custom image type and URL exists)
            printf( '<img src="%s" alt="%s" class="site-logo" style="%s">',
                esc_url( $logo_url ),
                esc_attr( $site_name ),
                esc_attr( $style_attrs )
            );
        }
        echo '</a>';
    }
}


/**
 * Function to display the customizable Page Title Section.
 * This should be called directly in main templates (page.php, single.php, archive.php, woocommerce.php)
 * after get_header().
 */
if ( ! function_exists( 'harshone_display_page_title_section' ) ) {
    function harshone_display_page_title_section() {
        // Get global settings for page title bar
        $global_enable = harshone_get_theme_option( 'harshone_page_title_bar_enable', true );
        $global_bg_type = harshone_get_theme_option( 'harshone_page_title_bar_background_type', 'color' );
        $global_bg_color = harshone_get_theme_option( 'harshone_page_title_bar_bg_color', '#f8f8f8' );
        $global_bg_image_data = harshone_get_theme_option( 'harshone_page_title_bar_bg_image', array() );
        $global_bg_image_url = is_array( $global_bg_image_data ) && isset( $global_bg_image_data['url'] ) ? $global_bg_image_data['url'] : '';
        $global_overlay_color = harshone_get_theme_option( 'harshone_page_title_bar_overlay_color', array('color' => '#000000', 'alpha' => '0.5') );
        $global_min_height = harshone_get_theme_option( 'harshone_page_title_bar_min_height', '150' );
        $global_show_breadcrumbs = harshone_get_theme_option( 'harshone_page_title_bar_show_breadcrumbs', true );

        // 1. Determine if Page Title Section should be shown on this specific page/post
        $show_this_page_title_section = $global_enable; // Start with global setting

        if ( is_singular() ) {
            $post_id = get_the_ID();
            $override_show_title_section = harshone_get_meta_option( $post_id, 'harshone_page_show_title_section', '0' ); // 0=default, 1=on, 2=off
            
            if ( $override_show_title_section === '1' ) { // Explicitly override to show
                $show_this_page_title_section = true;
            } elseif ( $override_show_title_section === '2' ) { // Explicitly override to hide
                $show_this_page_title_section = false;
            } else { // Use global setting (already assigned above)
                // no change needed
            }

            // Always hide title section for Elementor canvas/full width templates as they handle it.
            // This is a common practice to avoid duplicate title bars with page builders.
            if ( class_exists( 'Elementor\Plugin' ) ) {
                $current_page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
                if ( in_array( $current_page_template, array( 'elementor_canvas', 'elementor_full_width' ), true ) ) {
                    $show_this_page_title_section = false;
                }
            }
            
            // Further conditions:
            // For example, if it's the blog posts page (set in settings > reading) that uses a custom title.
            if ( is_home() && ! is_front_page() && ! empty( single_post_title('', false) ) ) {
                // If it's the actual blog posts page, and it has a title, we might choose not to duplicate.
                // Or you can choose to show it. This is a stylistic choice.
                // For now, let's keep it visible.
            }

        } elseif ( is_front_page() ) {
            // Usually hide the page title bar on the front page as hero sections often replace it.
            $show_this_page_title_section = false; 
        }

        if ( ! $show_this_page_title_section ) {
            return; // Exit if not enabled for this page
        }

        // 2. Determine actual title text
        $title_text = '';
        if ( is_singular() ) {
            $custom_title_text = harshone_get_meta_option( get_the_ID(), 'harshone_page_custom_title_text', '' );
            $title_text = ! empty( $custom_title_text ) ? $custom_title_text : get_the_title();
        } elseif ( is_archive() ) {
            $title_text = get_the_archive_title();
        } elseif ( is_search() ) {
            $title_text = sprintf( esc_html__( 'Search Results for: %s', 'harshone' ), '<span>' . get_search_query() . '</span>' );
        } elseif ( is_home() && ! is_front_page() ) {
            $title_text = single_post_title( '', false );
        } elseif ( is_404() ) {
             $title_text = esc_html__( 'Page Not Found', 'harshone' );
        } else {
            $title_text = get_the_title(); // Fallback for other pages
        }


        // 3. Prepare inline styles for background image/color and height
        $wrapper_styles = '';
        $overlay_styles = '';
        
        $current_bg_type = harshone_get_theme_option( 'harshone_page_title_bar_background_type', 'color' );
        $current_bg_color = harshone_get_theme_option( 'harshone_page_title_bar_bg_color', '#f8f8f8' );
        $current_bg_image_data = harshone_get_theme_option( 'harshone_page_title_bar_bg_image', array() );
        $current_bg_image_url = is_array( $current_bg_image_data ) && isset( $current_bg_image_data['url'] ) ? $current_bg_image_data['url'] : '';
        $current_overlay_color = harshone_get_theme_option( 'harshone_page_title_bar_overlay_color', array('color' => '#000000', 'alpha' => '0.5') );
        $current_min_height = harshone_get_theme_option( 'harshone_page_title_bar_min_height', '150' );

        if ( $current_bg_type === 'image' && ! empty( $current_bg_image_url ) ) {
            $wrapper_styles .= 'background-image: url(' . esc_url( $current_bg_image_url ) . '); background-size: cover; background-position: center center;';
            if ( ! empty( $current_overlay_color['alpha'] ) && $current_overlay_color['alpha'] > 0 ) {
                $overlay_rgba = 'rgba(' . harshone_hex_to_rgb($current_overlay_color['color']) . ',' . esc_attr( $current_overlay_color['alpha'] ) . ')';
                $overlay_styles .= 'background-color: ' . $overlay_rgba . ';';
            }
        } elseif ( $current_bg_type === 'color' && ! empty( $current_bg_color ) ) {
            $wrapper_styles .= 'background-color: ' . esc_attr( $current_bg_color ) . ';';
        }
        $wrapper_styles .= 'min-height: ' . absint( $current_min_height ) . 'px;';

        ?>
        <section class="page-title-section py-5" style="<?php echo esc_attr( $wrapper_styles ); ?>">
            <?php if ( $current_bg_type === 'image' && ! empty( $current_bg_image_url ) ) : ?>
                <div class="page-title-section-overlay" style="<?php echo esc_attr( $overlay_styles ); ?>"></div>
            <?php endif; ?>
            <div class="container text-center position-relative">
                <h1 class="entry-title"><?php echo wp_kses_post( $title_text ); ?></h1>
                <?php
                // Display breadcrumbs if enabled
                if ( $global_show_breadcrumbs ) {
                    harshone_breadcrumbs( true ); // Pass true to indicate it's in the page title bar
                }
                ?>
            </div>
        </section><!-- .page-title-section -->
        <?php
    }
}

// Helper for color-rgba output in inline styles
if ( ! function_exists( 'harshone_hex_to_rgb' ) ) {
    function harshone_hex_to_rgb( $hex ) {
        if ( empty( $hex ) ) {
            return '0,0,0';
        }
        // Remove # if present
        $hex = str_replace( '#', '', $hex );

        // Handle 3-character hex (e.g., "FFF")
        if ( strlen( $hex ) == 3 ) {
            $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
            $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
            $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
        } else {
            // Handle 6-character hex (e.g., "FFFFFF")
            $r = hexdec( substr( $hex, 0, 2 ) );
            $g = hexdec( substr( $hex, 2, 2 ) );
            $b = hexdec( substr( $hex, 4, 2 ) );
        }
        return $r . ',' . $g . ',' . $b;
    }
}


/**
 * Displays social media icons with links from Redux options.
 *
 * @param string $location 'header' or 'footer' (optional, for future differentiation).
 */
if ( ! function_exists( 'harshone_get_social_links' ) ) {
    function harshone_get_social_links( $location = 'footer' ) {
        $social_links_enabled = harshone_get_theme_option('harshone_social_links_enable', true);

        if ( !$social_links_enabled ) {
            return;
        }

        $social_icons = harshone_get_theme_option( 'harshone_social_links', array() );

        if ( ! empty( $social_icons ) && is_array( $social_icons ) ) {
            echo '<div class="harshone-social-links social-links ' . esc_attr( $location ) . '-social-links">';
            foreach ( $social_icons as $social_icon ) {
                if ( ! empty( $social_icon['url'] ) && ! empty( $social_icon['icon_class'] ) ) {
                    printf(
                        '<a href="%s" target="_blank" rel="noopener noreferrer" class="social-icon %s"><i class="%s"></i></a>',
                        esc_url( $social_icon['url'] ),
                        esc_attr( sanitize_title( str_replace( 'fa-','', $social_icon['icon_class'] ) ) ), // Clean class for specific styling
                        esc_attr( $social_icon['icon_class'] )
                    );
                }
            }
            echo '</div>';
        }
    }
}