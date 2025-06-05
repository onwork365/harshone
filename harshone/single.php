<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Harshone
 * @since 1.0.0
 */

get_header();

// Display custom page title section for single posts if enabled
harshone_display_page_title_section();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container py-5">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content/content-single' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( harshone_get_theme_option('harshone_show_comments', true) && ( comments_open() || get_comments_number() ) ) :
				comments_template();
			endif;

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'harshone' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'harshone' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();