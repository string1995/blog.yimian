/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
( function($) {
	// $('.widget-area').stick_in_parent();

	$('.content-area, .widget-area').theiaStickySidebar({
      // Settings
      additionalMarginTop: 30,
      additionalMarginBottom: 30
    });

	$('.menu-toggle').on('click', function (e) {
		e.preventDefault();

		var menu = $("#primary-menu"),
			header = $('.site-header');

		header.toggleClass("menu-active");
	});
} )( jQuery );
