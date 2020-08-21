<?php
/**
 * @package Obspgb Builder
 */

global $ttfobspgb_section_data;

ttfobspgb_load_section_header();
?>

<div class="ttfobspgb-gallery-items">
	<div class="ttfobspgb-gallery-items-stage ttfobspgb-gallery-columns-{{ data.get('columns') }}"></div>
	<div class="ttfobspgb-add-item-wrapper">
		<a href="#" class="ttfobspgb-add-item ttfobspgb-gallery-add-item-link" title="<?php esc_attr_e( 'Add new item', 'obspgb' ); ?>">
			<span>
				<?php esc_html_e( 'Add new item', 'obspgb' ); ?>
			</span>
		</a>
	</div>
</div>

<?php ttfobspgb_load_section_footer();