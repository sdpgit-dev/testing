<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Admin_NoticeInterface
 *
 * @since 1.0.0.
 */
interface OBSPGB_Admin_NoticeInterface {
	public function register_admin_notice( $id, $message, array $args = array() );

	public function register_one_time_admin_notice( $message, WP_User $user = null, array $args = array() );
}