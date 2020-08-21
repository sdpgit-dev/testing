<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_APIInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_APIInterface extends OBSPGB_Util_ModulesInterface {
	public function inject_module( $module_name );
}