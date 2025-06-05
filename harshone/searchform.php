<?php
/**
 * Template for displaying search forms in Harshone
 *
 * @package Harshone
 * @since 1.0.0
 */

$harshone_unique_id = esc_attr( uniqid( 'search-form-' ) );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $harshone_unique_id; ?>">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'harshone' ); ?></span>
	</label>
	<input type="search" id="<?php echo $harshone_unique_id; ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'harshone' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'harshone' ); ?></span></button>
</form>