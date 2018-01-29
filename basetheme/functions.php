<?php

/**
 * Load a separate functions file.
 * @param  string $filename The filename to load.
 */
function _load_include( $filename ) {
  require_once 'includes/' . $filename . '.php';
}

/**
 * Load included files.
 */
_load_include( 'class-wp-image' );
_load_include( 'asset-paths' );
_load_include( 'dom-classes' );

/**
 * Set up the theme
 */
add_action( 'after_setup_theme', 'basetheme_setup_theme' );
function basetheme_setup_theme() {
	load_theme_textdomain( 'basetheme' );

	// Turn off the admin bar. Opinionated.
	show_admin_bar( false );
}

/**
 * Gets a template part allowing use of variables from the calling context.
 * @param  string $slug   The slug name for the generic template.
 * @param  string $name   Optional. The name of the specialised template.
 * @param  array  $params An array of variables that will be available in the template part.
 *                        The array keys will become variable names.
 */
function get_derived_template_part( $slug, $name = null, $params = array() ) {
	// Unpack the params for our custom function
	if ( count( $params ) > 0 ) {
		/**
	   * Fires before the specified params are unpacked.
	   *
	   * The dynamic portion of the hook name, `$slug`, refers to the slug name
	   * for the generic template part.
	   *
	   * @param array       $params The params passed to the function.
	   * @param string      $slug   The slug name for the generic template.
	   * @param string|null $name   The name of the specialized template.
	   */
	  $params = apply_filters( "get_derived_template_part_params", $params, $slug, $name );
	  $params = apply_filters( "get_derived_template_part_params_{$slug}", $params, $slug, $name );

		extract( $params );
	}

	// From WordPress's get_template_part()

	/**
   * Fires before the specified template part file is loaded.
   *
   * The dynamic portion of the hook name, `$slug`, refers to the slug name
   * for the generic template part.
   *
   * @since 3.0.0
   *
   * @param string      $slug The slug name for the generic template.
   * @param string|null $name The name of the specialized template.
   */
  do_action( "get_template_part_{$slug}", $slug, $name );

  $templates = array();
  $name = (string) $name;
  if ( '' !== $name ) {	
    $templates[] = "{$slug}-{$name}.php";
  }

  $templates[] = "{$slug}.php";

  locate_template($templates, true, false);
}
