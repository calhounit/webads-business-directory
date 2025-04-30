(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    $(document).ready(function(){


        $('#business_website').keyup(function () {
            $("#business_website_link").attr("href", $('#business_website').val());
        });

        $('#business_facebook').keyup(function () {
            $("#business_facebook_link").attr("href", $('#business_facebook').val());
        });

        $('#business_x').keyup(function () {
            $("#business_x_link").attr("href", $('#business_x').val());
        });

        $('#business_instagram').keyup(function () {
            $("#business_instagram_link").attr("href", $('#business_instagram').val());
        });

        $('#business_youtube').keyup(function () {
            $("#business_youtube_link").attr("href", $('#business_youtube').val());
        });


        });



})( jQuery );
