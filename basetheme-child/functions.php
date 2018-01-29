<?php

/**
 * Load a separate functions file.
 * @param  string $filename The filename to load.
 */
function _load_child_include( $filename ) {
  require_once 'includes/' . $filename . '.php';
}

/**
 * Load included files.
 */
_load_child_include( 'enqueue-assets' );
_load_child_include( 'image-sizes' );

/**
 * Setup the theme.
 */
add_action( 'after_setup_theme', 'basetheme_child_setup_theme' );
function basetheme_child_setup_theme() {

	load_theme_textdomain( 'CLIENTNAME' );

	/**
	 * Register menus
	 */
	register_nav_menus( array(
    'header-menu' => __( 'Header Menu' ),
    'footer-menu' => __( 'Footer Menu' ),
    'policies'    => __( 'Policies' ),
  ) );

	/**
	 * Add custom image sizes
	 */
	foreach ( basetheme_child_get_theme_image_sizes() as $crop_name => $crop_values) {
		add_image_size( $crop_name, $crop_values['width'], $crop_values['height'], $crop_values['hard_crop'] );
	}

	/**
	 * Enqueue assets
	 */
	add_filter( 'get_asset_uri', 'basetheme_child_revision_assets', 20, 2 );

	add_action( 'wp_enqueue_scripts', 'basetheme_child_enqueue_styles' );
	add_action( 'wp_enqueue_scripts', 'basetheme_child_enqueue_scripts' );
	add_action( 'wp_enqueue_scripts', 'basetheme_child_enqueue_google_scripts' );

	add_filter( 'page_has_google_map', 'basetheme_child_add_google_map', 20, 2 );
}

/**
 * Replace any revisioned assets with their new revision names.
 * @param  string $uri  The full URI to the asset.
 * @param  string $path The original path relative to the theme directory.
 * @return string
 */
function basetheme_child_revision_assets( $uri, $path ) {
	$manifest_filepath = trailingslashit( get_stylesheet_directory() ) . 'dist/rev-manifest.json';

	if ( file_exists( $manifest_filepath ) && is_readable( $manifest_filepath ) ) {
		$manifest = json_decode( file_get_contents( $manifest_filepath ), true );

		foreach ($manifest as $original_name => $revisioned_name) {
			if ( preg_match( "#" . $original_name . "$#", $uri ) ) {
				$uri = str_replace( $original_name, $revisioned_name, $uri );
				break;
			}
		}
	}

	return $uri;
}

/**
 * Add the Google Maps library to the pages which require it.
 * @param  boolean $return The value being passed to this filter.
 * @param  WP_Post $_post  The current WordPress post object.
 * @return boolean         
 */
function basetheme_child_add_google_map( $return, $_post ) {
	// $return = // some condition

	return $return;
}
