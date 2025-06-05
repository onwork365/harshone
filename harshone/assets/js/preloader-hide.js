/**
 * Preloader Hiding Script for Harshone.
 * This script ensures the preloader fades out when the page is fully loaded.
 *
 * @package Harshone
 */

(function($) {
    'use strict';

    // Function to handle preloader hiding
    function hideHarshonePreloader() {
        var $preloader = $('#harshone-preloader');
        if ($preloader.length) { // Check if the preloader element exists on the page
            console.log('Harshone Preloader: Element found, attempting to hide.'); // Debugging log
            $preloader.addClass('fade-out'); // Add class to trigger CSS fade-out
            // Remove preloader completely after the transition duration
            setTimeout(function() {
                $preloader.hide(); 
                console.log('Harshone Preloader: Hidden successfully.'); // Debugging log
            }, 500); // Must match the transition duration in CSS (approx .harshone-preloader transition)
        } else {
            console.log('Harshone Preloader: Element not found in DOM.'); // Debugging log
        }
    }

    // Run when the DOM is ready (all HTML parsed, but images/assets might still be loading)
    $(window).on('load', function() {
        console.log('Harshone Preloader: Window loaded event triggered.'); // Debugging log
        hideHarshonePreloader();
    });

    // Fallback: If for some reason 'load' doesn't fire or script hangs, try to hide after a delay.
    // This is a safety net to prevent infinite preloader in case of script errors or very slow loading assets.
    setTimeout(function() {
        console.log('Harshone Preloader: Fallback hide triggered after 5 seconds.'); // Debugging log
        hideHarshonePreloader();
    }, 5000); // Hide after 5 seconds if 'load' event doesn't trigger it earlier.

})(jQuery);