/**
 * harshone.js
 *
 * Theme-specific JavaScript for Harshone.
 *
 * @package Harshone
 */

(function($) {
    'use strict';

    // Function to attempt Redux Metabox field rendering
    function initializeReduxMetaboxFields() {
        // Only proceed if the global 'redux' object is available and accessible
        // And ensure it's fully initialized for our opt_name 'harshone_options'
        if (typeof redux !== 'undefined' && typeof redux.optName !== 'undefined' && redux.optName === 'harshone_options') {
            console.log('harshone.js: Redux object found and matches opt_name. Attempting to initialize fields via Redux.initFields().');
            
            // Trigger the postbox-init event that WordPress uses for metaboxes
            console.log('harshone.js: Triggering postbox-init event for harshone_page_metabox.');
            $(document).trigger('postbox-init', ['harshone_page_metabox']);

            // For good measure, also trigger a resize, which can sometimes force Redux/WP to redraw.
            $(window).trigger('resize');

        } else {
            console.log('harshone.js: Redux object not fully defined for metabox processing in admin. (Expected redux.optName to be harshone_options)');
        }
    }


    $(document).ready(function() {

        console.log('Document ready (harshone.js).');

        // Check if we are in the admin area and potentially on a post/page/product edit screen
        if ( $('body').hasClass('wp-admin') && ( $('body').hasClass('post-type-post') || $('body').hasClass('post-type-page') || $('body').hasClass('post-type-product') ) ) {
            console.log('harshone.js: Admin edit screen detected. Running metabox specific JS detection.');

            // Listen for Redux's own 'ready' event (most robust if Redux fires it reliably)
            $(document).on('redux/ready', initializeReduxMetaboxFields);
            console.log('harshone.js: Listening for Redux ready event.');

            // Fallback aggressive timed retry (if Redux ready event is not reliable or you need earlier init)
            var retryCount = 0;
            var maxRetries = 10;
            var retryInterval = setInterval(function() {
                if (typeof redux !== 'undefined' && typeof redux.optName !== 'undefined' && redux.optName === 'harshone_options') {
                    console.log('harshone.js: Redux object found on retry. Initializing fields.');
                    initializeReduxMetaboxFields();
                    clearInterval(retryInterval); // Stop retrying once found
                } else if (retryCount >= maxRetries) {
                    console.warn('harshone.js: Max retriesReached. Redux object not found during aggressive retry attempt.');
                    clearInterval(retryInterval);
                }
                retryCount++;
            }, 500); // Check every 500ms for up to 10 times (5 seconds total)


            // Also, attach to a WordPress action that fires when metaboxes are sorted/toggled
            // This can ensure Redux fields are re-initialized if the box is dragged or collapsed/expanded.
            $('#poststuff').on('postbox-toggled', function() {
                console.log('harshone.js: Postbox toggled event detected. Re-initializing fields.');
                setTimeout(initializeReduxMetaboxFields, 100);
            });

        } else {
            console.log('harshone.js: Frontend or non-edit admin screen. Running frontend JS.');
            // Example: Smooth scrolling for anchor links (frontend only)
            $('a[href*="#"]:not([href="#"])').on('click', function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 1000);
                        return false;
                    }
                }
            });

            // Example: Dynamic copyright year in footer (frontend only)
            var currentYear = new Date().getFullYear();
            $('.harshone-current-year').text(currentYear);

            // Example: Add class to body on scroll for sticky header effects (frontend only)
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('body').addClass('scrolled');
                } else {
                    $('body').removeClass('scrolled');
                }
            });

            // Toggle mobile navigation (if using a custom one) (frontend only)
            $('.navbar-toggler').on('click', function() {
                $('.main-navigation').toggleClass('active');
            });

            // WooCommerce quantity buttons (frontend only)
            if (typeof wc_add_to_cart_params !== 'undefined') { // Check if WooCommerce is active
                $(document).on('click', '.quantity .plus', function (e) {
                    var $qty = $(this).closest('.quantity').find('.qty');
                    var currentVal = parseFloat($qty.val());
                    var max = parseFloat($qty.attr('max'));
                    if (!currentVal || currentVal === '' || currentVal === 'NaN') {
                        currentVal = 0;
                    }
                    if (max === '' || max === 'NaN') {
                        max = '';
                    }
                    if (max && (max === currentVal || currentVal > max)) {
                        $qty.val(max);
                    } else {
                        $qty.val(currentVal + 1);
                    }
                    $qty.trigger('change');
                });

                $(document).on('click', '.quantity .minus', function (e) {
                    var $qty = $(this).closest('.quantity').find('.qty');
                    var currentVal = parseFloat($qty.val());
                    var min = parseFloat($qty.attr('min'));
                    if (!currentVal || currentVal === '' || currentVal === 'NaN') {
                        currentVal = 0;
                    }
                    if (min === '' || min === 'NaN') {
                        min = 0;
                    }
                    if (currentVal <= min) {
                        $qty.val(min);
                    } else {
                        $qty.val(currentVal - 1);
                    }
                    $qty.trigger('change');
                });
            }
        }
    });

    // Preloader logic handled in preloader-hide.js

})(jQuery);