/**
 * Helps with keyboard navigation for skip links.
 *
 * This file is inspired by the Twenty Twenty-One theme's `skip-link-focus-fix.js`.
 * It ensures that when a skip-to-content link is activated, keyboard focus
 * is properly moved to the target element.
 *
 * @package Harshone
 */

( function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener(
			'hashchange',
			function() {
				var id = location.hash.substring( 1 );

				if ( ! id ) {
					// Hash removed, return to the top of the page.
					return;
				}

				var element = document.getElementById( id );

				if ( element ) {
					if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
						element.tabIndex = -1;
					}

					element.focus();
				}
			},
			false
		);
	}
})();