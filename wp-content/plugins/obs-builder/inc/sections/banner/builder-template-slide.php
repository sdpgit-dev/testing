<?php
/**
 * @package Obspgb Builder
 */

$section_name = "ttfobspgb-section[{{ data.get('parentID') }}][banner-slides][{{ data.get('id') }}]";
$combined_id = "{{ data.get('parentID') }}-{{ id }}";
$overlay_id  = "ttfobspgb-overlay-" . $combined_id;
?>

<div class="ttfobspgb-banner-slide" id="ttfobspgb-banner-slide-{{ data.get('parentID') }}" data-id="{{ data.get('id') }}" data-section-type="banner-slide">

	<div title="<?php esc_attr_e( 'Drag-and-drop this slide into place', 'obspgb' ); ?>" class="ttfobspgb-sortable-handle">
		<div class="sortable-background"></div>

		<a href="#" class="ttfobspgb-configure-item-button" title="Configure banner">
			<span>Configure options</span>
		</a>
	</div>

	<?php
	$configuration_buttons = array(
		100 => array(
			'label'              => __( 'Edit content', 'obspgb' ),
			'href'               => '#',
			'class'              => 'edit-content-link ttfobspgb-icon-pencil {{ (data.get("content") && data.get("content").length) ? "item-has-content" : "" }}',
			'title'              => __( 'Edit content', 'obspgb' ),
		),
		200 => array(
			'label'				 => __( 'Configure slide', 'obspgb' ),
			'href'				 => '#',
			'class'				 => 'ttfobspgb-icon-cog ttfobspgb-banner-slide-configure ttfobspgb-overlay-open',
			'title'				 => __( 'Configure slide', 'obspgb' ),
		),
		1000 => array(
			'label'              => __( 'Trash slide', 'obspgb' ),
			'href'               => '#',
			'class'              => 'ttfobspgb-icon-trash ttfobspgb-banner-slide-remove',
			'title'              => __( 'Trash slide', 'obspgb' )
		)
	);

	$configuration_buttons = apply_filters( 'obspgb_banner_slide_buttons', $configuration_buttons, 'slide' );
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

	<?php echo ttfobspgb_get_builder_base()->add_uploader( $section_name, 0, __( 'Set banner image', 'obspgb' ), 'background-image-url' ); ?>
	<?php ttfobspgb_get_builder_base()->add_frame( '', 'content', '', '', false ); ?>
</div>
