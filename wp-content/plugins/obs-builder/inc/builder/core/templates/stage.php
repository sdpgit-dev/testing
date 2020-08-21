<?php
/**
 * @package Obspgb Builder
 */

global $ttfobspgb_sections;

/**
 * Execute code before the builder stage is displayed.
 *
 * @since 1.0.0.
 */
do_action( 'obspgb_before_builder_stage' );
?>

<div class="ttfobspgb-stage ttfobspgb-stage-closed" id="ttfobspgb-stage"></div>

<input type="hidden" name="ttfobspgb-section-layout" id="ttfobspgb-section-layout" style="display: none;" />

<?php
/**
 * Execute code after the builder stage is displayed.
 *
 * @since 1.0.0.
 */
do_action( 'obspgb_after_builder_stage' );
?>