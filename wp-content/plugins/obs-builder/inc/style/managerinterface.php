<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Style_ManagerInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_Style_ManagerInterface extends OBSPGB_Util_ModulesInterface {
	public function get_styles_as_inline();

	public function get_file_url();
}