<?php
/**
 * @package Obspgb Builder
 */
global $ttfobspgb_section_data;

$ttfobspgb_section_data['config'] = isset( $ttfobspgb_section_data['config'] ) ? $ttfobspgb_section_data['config']: array();
$ttfobspgb_section_data['label'] = isset( $ttfobspgb_section_data['label'] ) ? $ttfobspgb_section_data['label']: '';

$links = array(
	100 => array(
		'href'  => '#',
		'class' => 'ttfobspgb-section-remove',
		'label' => __( 'Trash section', 'obspgb' ),
		'title' => __( 'Trash section', 'obspgb' ),
	)
);

if ( ! empty( $ttfobspgb_section_data['config'] ) ) {
	$links[25] = array(
		'href'  => '#',
		'class' => 'ttfobspgb-section-configure ttfobspgb-overlay-open',
		'label' => __( 'Configure section', 'obspgb' ),
		'title' => __( 'Configure section', 'obspgb' ),
	);
}

/**
 * Deprecated: Filter the definitions for the links that appear in each Builder section's footer.
 *
 * This filter is deprecated. Use obspgb_builder_section_links instead.
 *
 * @deprecated 1.1.0.
 *
 * @param array    $links    The link definition array.
 */
$links = apply_filters( 'ttfobspgb_builder_section_footer_links', $links );

/**
 * Filter the definitions for the buttons that appear in each Builder section's header.
 *
 * @since 1.0.0.
 *
 * @param array    $links    The button definition array.
 */
$links = apply_filters( 'obspgb_builder_section_links', $links );
ksort( $links );

/**
 * Filters the rendered HTML class of the section in the Builder.
 *
 * @since 1.0.0.
 *
 * @param string   $class   The current HTML class.
 *
* @return string            The filtered HTML class.
 */
$section_classes = apply_filters( 'obspgb_builder_section_class', '' );
?>

<div class="ttfobspgb-section {{ 'closed' === data.get('state') ? '' : 'ttfobspgb-section-open' }} ttfobspgb-section-{{ data.get('section-type') }} <?php echo $section_classes; ?>" data-id="{{ data.get('id') }}" data-section-type="{{ data.get('section-type') }}">
	<?php
	/**
	 * Execute code before the section header is displayed.
	 *
	 * @since 1.0.0.
	 */
	do_action( 'obspgb_before_section_header' );
	?>
	<div class="ttfobspgb-section-header">
		<h3{{ (data.get('title')) ? ' class=has-title' : '' }}>
			<span class="ttfobspgb-section-header-title">{{ data.get('title') }}</span><em><?php echo ( esc_html( $ttfobspgb_section_data['label'] ) ); ?></em>
			<?php
			/**
			 * Display custom badges.
			 *
			 * @since 1.0.0.
			 */
			do_action( 'obspgb_section_header_badges' );
			?>
		</h3>
		<div class="ttf-obspgb-section-header-button-wrapper">
			<?php foreach ( $links as $link ) : ?>
				<?php
				$href  = ( isset( $link['href'] ) ) ? ' href="' . esc_url( $link['href'] ) . '"' : '';
				$id    = ( isset( $link['id'] ) ) ? ' id="' . esc_attr( $link['id'] ) . '"' : '';
				$label = ( isset( $link['label'] ) ) ? esc_html( $link['label'] ) : '';
				$title = ( isset( $link['title'] ) ) ? ' title="' . esc_html( $link['title'] ) . '"' : '';

				// Set up the class value with a base class
				$class_base = ' class="ttfobspgb-builder-section-link';
				$class      = ( isset( $link['class'] ) ) ? $class_base . ' ' . esc_attr( $link['class'] ) . '"' : '"';
				?>
				<a<?php echo $href . $id . $class . $title; ?>>
					<span>
						<?php echo $label; ?>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
		<a href="#" class="ttfobspgb-section-toggle" title="<?php esc_attr_e( 'Click to toggle', 'obspgb' ); ?>">
			<div class="ttfobspgb-section-toggle__wrapper">
				<span class="ttfobspgb-section-toggle__indicator"></span>
			</div>
		</a>
	</div>
	<div class="clear"></div>
	<div class="ttfobspgb-section-body">
