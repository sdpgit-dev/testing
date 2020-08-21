<?php
/**
 * @package Obspgb Builder
 */

global $ttfobspgb_section_data, $ttfobspgb_gallery_id;

$section_name = "ttfobspgb-section[{{ data.get('parentID') }}][gallery-items][{{ data.get('id') }}]";
$combined_id = "{{ data.get('parentID') }}-{{ id }}";
$overlay_id  = "ttfobspgb-overlay-" . $combined_id;
?>

<div class="ttfobspgb-gallery-item" data-id="{{ data.get('id') }}" data-section-type="gallery-item">
	<div title="<?php esc_attr_e( 'Drag-and-drop this item into place', 'obspgb' ); ?>" class="ttfobspgb-sortable-handle">
		<div class="sortable-background"></div>

		<a href="#" class="ttfobspgb-configure-item-button" title="Configure item">
			<span>Configure options</span>
		</a>
	</div>

	<?php
	$configuration_buttons = array(
		100 => array(
			'label'              => __( 'Edit content', 'obspgb' ),
			'href'               => '#',
			'class'              => 'edit-content-link ttfobspgb-icon-pencil {{ (data.get("content")) ? "item-has-content" : "" }}',
			'title'              => __( 'Edit content', 'obspgb' ),
		),
		200 => array(
			'label'				 => __( 'Configure item', 'obspgb' ),
			'href'				 => '#',
			'class'				 => 'ttfobspgb-icon-cog ttfobspgb-overlay-open ttfobspgb-gallery-item-configure',
			'title'				 => __( 'Configure item', 'obspgb' ),
		),
		1000 => array(
			'label'              => __( 'Trash item', 'obspgb' ),
			'href'               => '#',
			'class'              => 'ttfobspgb-icon-trash ttfobspgb-gallery-item-remove',
			'title'              => __( 'Trash item', 'obspgb' )
		)
	);

	$configuration_buttons = apply_filters( 'obspgb_gallery_item_buttons', $configuration_buttons, 'item' );
	ksort( $configuration_buttons );
	?>

	<ul class="configure-item-dropdown">
		<?php foreach( $configuration_buttons as $button ) : ?>
			<li>
				<a href="<?php echo esc_url( $button['href'] ); ?>" class="<?php echo $button['class']; ?>" title="<?php echo $button['title']; ?>">
					<?php echo esc_html( $button['label'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php echo ttfobspgb_get_builder_base()->add_uploader( '', 0, __( 'Set gallery image', 'obspgb' ), 'background-image-url' ); ?>
	<?php ttfobspgb_get_builder_base()->add_frame( '', 'description', '', '', false ); ?>
</div>
