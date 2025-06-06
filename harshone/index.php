<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Harshone
 * @since 1.0.0
 */

get_header();
?>

<?php get_template_part( 'template-parts/page-title-section' ); // NEW: Include page title section ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main container py-5">
        <?php
        if ( have_posts() ) :

            // Removed conditional header here, handled globally by page-title-section
            // if ( is_home() && ! is_front_page() ) :
            //     ?>
            //     <header>
            //         <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
            //     </header>
            //     <?php
            // endif;

            // Start the loop.
            while ( have_posts() ) :
                the_post();

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part( 'template-parts/content/content', get_post_format() );

            endwhile;

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