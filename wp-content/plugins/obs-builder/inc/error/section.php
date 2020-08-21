<?php
/**
 * @package Obspgb Builder
 */

/**
 * Class OBSPGB_Error_Section
 *
 * Customizer section for surfacing Obspgb errors within the Customizer interface.
 *
 * @since 1.0.0.
 */
class OBSPGB_Error_Section extends WP_Customize_Section {
	/**
	 * The section type.
	 *
	 * @since 1.0.0.
	 *
	 * @var string
	 */
	public $type = 'obspgb_error';

	/**
	 * Output a JS template for the Obspgb Errors section.
	 *
	 * @since 1.0.0.
	 *
	 * @return void
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
			<h3 class="accordion-section-title">
				<?php esc_html_e( 'No Obspgb Notices', 'obspgb' ); ?>
			</h3>
		</li>
	<?php
	}
}