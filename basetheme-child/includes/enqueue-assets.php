<?php

// These functions will be used by basetheme_child_setup_theme() in functions.php

/**
 * Get your Google API Credentials from https://console.developers.google.com/apis/
 * Make sure to set up restrictions so that the key can only be used from certain HTTP Referrers.
 */
define( 'GOOGLE_API_KEY', '' );

/**
 * Registers and enqueues the stylesheets that the theme requires.
 */
function basetheme_child_enqueue_styles() {	
	if( !is_admin() ) {	
		/**
		 * Load default theme stylesheet.
		 * false -> No dependancies.
		 */
		wp_register_style( 'theme_css', get_asset_uri( 'dist/css/style.min.css' ), false );
		wp_enqueue_style( 'theme_css' );
	}
}

/**
 * Registers and enqueues the scripts that the theme requires.
 */
function basetheme_child_enqueue_scripts() {
	if ( !is_admin() ) {

		// Load specific jQuery library from CDN, in noConflict mode ($ not defined)
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', apply_filters( 'basetheme_jquery_url', '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js' ), false, false, true );
		wp_enqueue_script( 'jquery' );
		wp_add_inline_script( 'jquery', 'jQuery.noConflict();' );

		/**
		 * Load header scripts.
		 * No dependancies, in header -> default for wp_register_script().
		 */
		wp_register_script ( 'head_js', get_asset_uri( 'dist/js/head.min.js' ) );
		wp_enqueue_script ( 'head_js' );
		
		/**
		 * Load footer scripts
		 * Dependancies: jQuery
		 * false -> No version string (versions will be revisioned by Gulp.js)
		 * true  -> Load in footer
		 */
		wp_register_script ( 'footer_js', get_asset_uri( 'dist/js/footer.min.js' ), array( 'jquery' ), false, true );
		wp_enqueue_script ( 'footer_js' );

	}
}

/**
 * Register and enqueue Google Maps scripts for pages that require it.
 */
function basetheme_child_enqueue_google_scripts() {
	global $post;

	if ( 
		!is_admin() && 
		'' !== GOOGLE_API_KEY && 
		apply_filters( 'page_has_google_map', false, $post ) 
	) {

		/**
		 * Load Google Maps JavaScript API.
		 * No dependancies
		 * false -> No version string
		 * true  -> Load in footer
		 */
		wp_register_script ("google-maps-api", "https://maps.googleapis.com/maps/api/js?libraries=places&key=" . GOOGLE_API_KEY, array(), false, true);
		wp_enqueue_script ("google-maps-api");

		/**
		 * Load script to initialise all maps on page.
		 * Dependancies: jQuery
		 * false -> No version string
		 * true  -> Load in footer
		 */
		wp_register_script ("initialise-google-maps", get_asset_uri( 'dist/js/googlemaps.min.js' ), array( 'jquery' ), false, true);
		wp_enqueue_script ("initialise-google-maps");

	}
}

/**
 * Add the Google API key to the Advanced Custom Fields plugin.
 * @param  array $api  The API credentials in use.
 * @return array
 */
add_filter( 'acf/fields/google_map/api', 'basetheme_child_add_acf_api_creds' );
function basetheme_child_add_acf_api_creds( $api ) {
	if ( '' !== GOOGLE_API_KEY ) {
		$api['key'] = GOOGLE_API_KEY;
	}

	return $api;
}
