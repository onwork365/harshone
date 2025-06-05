<?php
/**
 * Show success messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/success.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We recommend you do not modify the actual WooCommerce
 * template files.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

?>
<ul class="woocommerce-message alert alert-success" role="alert">
	<?php foreach ( $notices as $notice ) : ?>
		<li><?php echo wc_kses_notice( $notice ); ?></li>
	<?php endforeach; ?>
</ul>