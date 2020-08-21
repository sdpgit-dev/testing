<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Formatting_ManagerInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_Formatting_ManagerInterface extends OBSPGB_Util_ModulesInterface {
	public function add_format( $format_name, $script_uri, $script_version = '' );

	public function remove_format( $format_name );
}