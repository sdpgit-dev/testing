<div class="<?php echo $ttfobspgb_overlay_class; ?>" id="<?php echo $ttfobspgb_overlay_id; ?>">
	<div class="ttfobspgb-overlay-wrapper">
		<div class="ttfobspgb-overlay-dialog">
			<div class="ttfobspgb-overlay-header">
				<div class="ttfobspgb-overlay-window-head">
					<div class="ttfobspgb-overlay-title"><?php echo $ttfobspgb_overlay_title; ?></div>
					<button type="button" class="media-modal-close ttfobspgb-overlay-close-discard">
						<span class="media-modal-icon">
					</button>
				</div>
			</div>
			<div class="ttfobspgb-overlay-body">
				<?php
				/**
				 * Action: Fires before the overlay body gets rendered.
				 *
				 * This action gives a developer the opportunity to output additional
				 * content before an overlay body.
				 *
				 * @since 1.1.4.
				 *
				 * @param string $ttfobspgb_overlay_id The html id of the overlay.
				 */
				do_action( 'obspgb_overlay_body_before', $ttfobspgb_overlay_id ); ?>