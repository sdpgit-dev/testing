<?php
/**
 * @package Obspgb Builder
 */
ttfobspgb_load_section_header();

global $ttfobspgb_section_data;
?>

<div class="ttfobspgb-banner-slides">
	<div class="ttfobspgb-banner-slides-stage"></div>
	<div class="ttfobspgb-add-item-wrapper">
		<a href="#" class="ttfobspgb-add-slide ttfobspgb-banner-add-item-link" title="<?php esc_attr_e( 'Add new slide', 'obspgb' ); ?>">
			<span>
				<?php esc_html_e( 'Add new slide', 'obspgb' ); ?>
			</span>
		</a>
	</div>
</div>

<?php ttfobspgb_load_section_footer();