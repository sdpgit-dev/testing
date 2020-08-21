<?php
/**
 * @package Obspgb Builder
 */

ttfobspgb_load_section_header();

global $ttfobspgb_section_data;

/**
 * Execute code before the columns select input is displayed.
 *
 * @since 1.0.0.
 *
 * @param array    $ttfobspgb_section_data    The data for the section.
 */
do_action( 'obspgb_section_text_before_columns_select', $ttfobspgb_section_data );

/**
 * Execute code after the columns select input is displayed.
 *
 * @since 1.0.0.
 *
 * @param array    $ttfobspgb_section_data    The data for the section.
 */
do_action( 'obspgb_section_text_after_columns_select', $ttfobspgb_section_data );

/**
 * Execute code after the section title is displayed.
 *
 * @since 1.0.0.
 *
 * @param array    $ttfobspgb_section_data    The data for the section.
 */
do_action( 'obspgb_section_text_after_title', $ttfobspgb_section_data ); ?>

<div class="ttfobspgb-text-columns-stage ttfobspgb-text-columns-{{ data.get('columns-number') }}">
	<?php
	/**
	 * Execute code after all columns are displayed.
	 *
	 * @since 1.0.0.
	 *
	 * @param array    $ttfobspgb_section_data    The data for the section.
	 */
	do_action( 'obspgb_section_text_after_columns', $ttfobspgb_section_data );
	?>
</div>

<div class="clear"></div>

<div class="ttfobspgb-add-item-wrapper">
	<a href="#" class="ttfobspgb-add-slide ttfobspgb-text-columns-add-column-link" title="<?php esc_attr_e( 'Add new column', 'obspgb' ); ?>">
		<span>
			<?php esc_html_e( 'Add new item', 'obspgb' ); ?>
		</span>
	</a>
</div>

<?php ttfobspgb_load_section_footer();
