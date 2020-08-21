<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Error_CollectorInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_Error_CollectorInterface {
	public function add_error( $code, $message, $data = '' );

	public function has_code( $code );

	public function has_errors();

	public function get_codes();

	public function get_messages( $code = '' );

	public function generate_backtrace( array $ignore_class = array(), $output = 'list' );
}