<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Settings_SanitizeInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_Settings_SanitizeInterface extends OBSPGB_Util_ModulesInterface {
	public function sanitize_float( $value );

	public function sanitize_image( $value, $raw = false );

	public function sanitize_image_raw( $value );

	public function sanitize_text( $string );
}