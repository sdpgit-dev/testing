<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Util_ModulesInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_Util_ModulesInterface {
	public function get_module( $module_name );

	public function has_module( $module_name );
}