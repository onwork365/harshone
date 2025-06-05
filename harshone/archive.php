<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Harshone
 * @since 1.0.0
 */

get_header();

// Display custom page title section for archives if enabled
harshone_display_page_title_section();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container py-5">

		<?php if ( have_posts() ) : ?>

			<?php
			// The archive title and description is now handled by harshone_display_page_title_section(),
			// so the default output is commented out here.
			/*
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			*/
			?>

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content/content', get_post_format() );

			endwhile; // End of the loop.

			// Display pagination.
			harshone_the_posts_navigation();

		else :

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();