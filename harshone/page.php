<?php
/**
 * The template for displaying all pages
 *
 * This is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Harshone
 * @since 1.0.0
 */

get_header();

// Display custom page title section if enabled
harshone_display_page_title_section();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container py-5">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content-page' ); // Content part calls the content

				// If comments are open or we have at least one comment, load up the comment template.
				if ( harshone_get_theme_option('harshone_show_comments', true) && ( comments_open() || get_comments_number() ) ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();