<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Setup_ModeInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_Setup_ModeInterface {
	public function get_mode();

	public function is_obspgb_active_theme();

	public function get_obspgb_version();

	public function has_obspgb_api();

	public function is_plugin_active( $plugin_relative_path );
}