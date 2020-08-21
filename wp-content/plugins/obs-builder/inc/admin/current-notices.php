<?php
/**
 * @package Obspgb Builder
 */

// Bail if this isn't being included inside of a OBSPGB_Admin_NoticeInterface.
if ( ! isset( $this ) || ! $this instanceof OBSPGB_Admin_NoticeInterface ) {
	return;
}