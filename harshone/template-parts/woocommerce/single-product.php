<?php
/**
 * The template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We recommend you do not modify the actual WooCommerce
 * template files.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

            <div class="container py-5">
                <div class="row">

                    <?php if ( is_active_sidebar( 'woocommerce-sidebar' ) ) : ?>
                        <div class="col-lg-9 order-lg-1">
                    <?php else : ?>
                        <div class="col-lg-12">
                    <?php endif; ?>

                        <?php wc_get_template_part( 'content', 'single-product' ); ?>

                    </div><!-- .col-lg-9 or 12 -->

                    <?php if ( is_active_sidebar( 'woocommerce-sidebar' ) ) : ?>
                        <div class="col-lg-3 order-lg-2">
                            <?php dynamic_sidebar( 'woocommerce-sidebar' ); ?>
                        </div>
                    <?php endif; ?>

                </div><!-- .row -->
            </div><!-- .container -->

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php
get_footer();