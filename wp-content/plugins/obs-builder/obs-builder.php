<?php
/**
 * @package Obspgb Builder
 */

/**
 * Plugin Name: Obs Page Builder
 * Plugin URI:  #
 * Description: Wordpress page builder only for OBS themes.
 * Author:      Online brothers
 * Version:     1.0.0
 * Author URI:  #
 * Upgrade URI: #
 */

/**
 * Get the path to the Obspgb Builder directory. Includes trailing slash.
 *
 * @since 1.0.0.
 *
 * @param bool $relative    Set to true to return Obspgb Builder's path relative to the plugins directory.
 *
 * @return string           Absolute or relative path to Obspgb Builder.
 */
function obspgb_get_plugin_directory( $relative = false ) {
	if ( $relative ) {
		return trailingslashit( dirname( plugin_basename( __FILE__ ) ) );
	}

	return plugin_dir_path( __FILE__ );
}

/**
 * Get the URL to the Obspgb Builder directory. Includes trailing slash.
 *
 * @since 1.0.0.
 *
 * @return string
 */
function obspgb_get_plugin_directory_uri() {
	return plugin_dir_url( __FILE__ );
}

/**
 * Get the URL to the Obspgb Builder directory. Includes trailing slash.
 *
 * @since 1.0.0.
 *
 * @return string
 */
function obspgb_get_plugin_basename() {
	return plugin_basename( __FILE__ );
}

//require_once( obspgb_get_plugin_directory() . 'plugins-screen.php' );

// Let the Obspgb theme take over in case it's already active.
if ( 'obspgb' === get_template() ) {
	return;
}

/**
 * Kick things off.
 *
 * @since 1.0.0.
 *
 * @hooked action plugins_loaded
 *
 * @return void
 */
function obspgb_builder_initialize_plugin() {
	// Return immediately if Obspgb is being previewed in Customizer.
	global $wp_customize;

	if ( isset( $wp_customize ) && ( 'obspgb' === $wp_customize->theme()->template ) ) {
		return;
	}

	/**
	 * The current version of the plugin.
	 */
	define( 'TTFOBSPGB_VERSION', '1.0.0' );

	/**
	 * The minimum version of WordPress required for the plugin.
	 */
	define( 'TTFOBSPGB_MIN_WP_VERSION', '4.7' );

	// Include autoloader here, to avoid
	// replacing Obspgb's default autoloader.
	require_once obspgb_get_plugin_directory() . 'autoload.php';

	// Configure the global Obspgb object.
	global $Obspgb;

	$Obspgb = new OBSPGB_API;
	$Obspgb->hook();

	/**
	 * Action: Fire when the Obspgb Builder API has finished loading.
	 *
	 * @since 1.0.0.
	 *
	 * @param OBSPGB_API $Obspgb
	 */
	do_action( 'obspgb_api_loaded', $Obspgb );
}

add_action( 'plugins_loaded', 'obspgb_builder_initialize_plugin' );

if ( ! function_exists( 'Obspgb' ) ) :

/**
 * Get the global Obspgb API object.
 *
 * @since 1.0.0.
 *
 * @return OBSPGB_API|null
 */
function Obspgb() {
	global $Obspgb;

	if ( ! did_action( 'obspgb_api_loaded' ) || ! $Obspgb instanceof OBSPGB_APIInterface ) {
		trigger_error(
			__( 'The Obspgb() function should not be called before the obspgb_api_loaded action has fired.', 'obspgb' ),
			E_USER_WARNING
		);
		return null;
	}

	return $Obspgb;
}

endif;
