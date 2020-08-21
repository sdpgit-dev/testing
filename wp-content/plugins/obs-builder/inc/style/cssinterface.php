<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Style_CSSInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_Style_CSSInterface {
	public function add( array $data );

	public function has_rules();

	public function build();
}