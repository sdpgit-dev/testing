<?php
/**
 * Plugin Name: Extend Blocks
 * Description: Advanced Page Building Blocks for Gutenberg.
 * Author: Online brothers
 * Author URI: #
 * Version: 1.0.0
 * Text Domain: kadence-blocks
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Kadence Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KT_BLOCKS_PATH', realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR );
define( 'KT_BLOCKS_URL', plugin_dir_url( __FILE__ ) );
define( 'KT_BLOCKS_VERSION', '1.0.0' );

/**
 * Add a check before redirecting
 */
function kadence_blocks_activate() {
    add_option( 'kadence_blocks_redirect_on_activation', true );
}
register_activation_hook( __FILE__, 'kadence_blocks_activate' );


/**
 * Load Plugin
 */
function kadence_blocks_init() {
	require_once KT_BLOCKS_PATH . 'dist/init.php';
	require_once KT_BLOCKS_PATH . 'dist/class-kadence-blocks-frontend.php';
	require_once KT_BLOCKS_PATH . 'dist/settings/class-kadence-blocks-settings.php';
}
add_action( 'plugins_loaded', 'kadence_blocks_init' );

/**
 * Load the plugin textdomain
 */
function kadence_blocks_lang() {
	load_plugin_textdomain( 'kadence-blocks', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'kadence_blocks_lang' );