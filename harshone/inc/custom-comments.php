<?php
/**
 * Custom template for comments callbacks.
 *
 * @package Harshone
 * @since 1.0.0
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Harshone_Custom_Comment_Walker' ) ) {
	/**
	 * Custom walker for comments.
	 * Modifies comment output to match theme's design.
	 */
	class Harshone_Custom_Comment_Walker extends Walker_Comment {
		/**
		 * Starts the list before the elements are added.
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::start_lvl()
		 * @global int $comment_depth
		 *
		 * @param string $output Used to append additional content (passed by reference).
		 * @param int    $depth  The depth of the current comment in the 댓글 hierarchy.
		 * @param array  $args   An array of arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 1;
			$output                   .= '<ul class="children list-unstyled m-0 ps-4">'; // Example: Add Bootstrap classes
		}

		/**
		 * Ends the list of items after the elements are added.
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::end_lvl()
		 * @global int $comment_depth
		 *
		 * @param string $output Used to append additional content (passed by reference).
		 * @param int    $depth  The depth of the current comment in the 댓글 hierarchy.
		 * @param array  $args   An array of arguments.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 1;
			$output                  .= '</ul>';
		}

		/**
		 * Displays a comment.
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::display_element()
		 * @see wp_list_comments()
		 *
		 * @param WP_Comment $element   Comment to display.
		 * @param array      &$children_elements  Array of children (passed by reference - MUST MATCH PARENT SIG).
		 * @param int        $max_depth The maximum depth.
		 * @param int        $depth     The depth of the current comment.
		 * @param WP_Comment_Query $args    An array of arguments.
		 * @param string     &$output   Used to append additional content (passed by reference - MUST MATCH PARENT SIG).
		 */
		// The signature below correctly matches Walker_Comment::display_element for compatibility.
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return;
			}

			// Call the parent method with the correct parameters
			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Starts the element output.
		 *
		 * @since 2.7.0
		 * @since 5.9.0 The `$comment` parameter accepts `WP_Comment|null`.
		 *
		 * @see Walker::start_el()
		 * @see wp_list_comments()
		 * @global int        $comment_depth
		 * @global WP_Comment $comment
		 *
		 * @param string         $output  Used to append additional content (passed by reference).
		 * @param WP_Comment|null $data_object The comment object (matches parent Walker_Comment parameter name).
		 * @param int            $depth   The depth of the current comment.
		 * @param array          $args    An array of arguments.
		 * @param int            $current_object_id      Element ID (matches parent Walker_Comment parameter name).
		 */
		// IMPORTANT: This method signature (parameter names and default values) MUST EXACTLY MATCH
		// the parent Walker_Comment::start_el signature to avoid a fatal `Declaration compatible` error.
		// This will likely trigger the PHP 8.1+ deprecation warning about optional parameters
		// before required ones, as it's a known PHP quirk with this specific Walker signature.
		// This notice is informational and functionality is not affected.
		public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) { // THIS IS LINE 66
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment']       = $data_object; // Assign to global for legacy functions
			$comment                  = $data_object; // Assign to local variable

			if ( ! empty( $args['callback'] ) ) {
				ob_start();
				call_user_func( $args['callback'], $data_object, $args, $depth );
				$output .= ob_get_clean();
				return;
			}

			if ( ( 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type ) ) {
				$output .= '<li class="post pingback">';
				/* translators: %s: Comment author. */
				$output .= '<p>' . sprintf( esc_html__( 'Pingback: %s', 'harshone' ), get_comment_author_link() ) . '</p>';
				return;
			}

			// When extending Walker_Comment, you typically provide the entire HTML output for each comment here
			// and do NOT call parent::start_el, as Walker does not have a start_el method. The content is
			// built directly into $output.

			$comment_class = 'comment-body';
			if ( get_comment_author_email() === get_bloginfo( 'admin_email' ) ) {
				$comment_class .= ' comment-author-admin';
			}

			$output .= '<li ' . comment_class( '', $comment, $depth, false ) . ' id="comment-' . get_comment_ID() . '">';
			$output .= '<div id="div-comment-' . get_comment_ID() . '" class="' . esc_attr( $comment_class ) . ' card mb-3">';
			$output .= '<div class="card-body">';

			$output .= '<div class="comment-author vcard d-flex align-items-center">';
			$output .= get_avatar( $comment, $args['avatar_size'] );
			$output .= '<div class="comment-metadata ms-3">';
			$output .= '<b class="fn">' . get_comment_author_link() . '</b>';
			$output .= '<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '" class="comment-date small text-muted d-block">';
			/* translators: 1: date, 2: time */
			$output .= sprintf( esc_html__( '%1$s at %2$s', 'harshone' ), get_comment_date(), get_comment_time() );
			$output .= '</a>';
			$output .= '</div>'; // End .comment-metadata
			$output .= '</div>'; // End .comment-author

			if ( '0' === $comment->comment_approved ) {
				$output .= '<p class="comment-awaiting-moderation alert alert-info mt-3 mb-0">' . esc_html__( 'Your comment is awaiting moderation.', 'harshone' ) . '</p>';
			}

			$output .= '<div class="comment-content mt-3">';
			$output .= get_comment_text();
			$output .= '</div>';

			$output .= '<div class="reply mt-3 pt-3 border-top">';
			$output .= get_comment_reply_link(
				array_merge(
					$args,
					array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<span class="reply-link">',
						'after'     => '</span>',
					)
				)
			);
			$output .= '</div>'; // End .reply

			$output .= '</div>'; // End .card-body
			$output .= '</div>'; // End .comment-body
		}

		/**
		 * Ends the element output, if necessary.
		 *
		 * @since 2.7.0
		 *
		 * @see Walker::end_el()
		 * @see wp_list_comments()
		 * @param string       $output  Used to append additional content (passed by reference).
		 * @param WP_Comment   $comment The current comment object.
		 * @param int          $depth   Depth of the current comment.
		 * @param array        $args    An array of arguments.
		 */
		public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
			$output .= '</li><!-- #comment-' . get_comment_ID() . ' -->';
		}
	}
}