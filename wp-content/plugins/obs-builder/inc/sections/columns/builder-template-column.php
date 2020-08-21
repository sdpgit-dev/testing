<?php
global $ttfobspgb_section_data;

$section_name   = 'ttfobspgb-section[{{ data.get("parentID") }}][columns][{{ data.get("id") }}]';
$combined_id = "{{ data.get('parentID') }}-{{ data.get('id') }}";
$overlay_id  = "ttfobspgb-overlay-" . $combined_id;

	$column_name = $section_name . '[columns][{{ data.get("id") }}]';
	$iframe_id = 'ttfobspgb-iframe-'. $combined_id;
	$textarea_id = 'ttfobspgb-content-'. $combined_id;
	$content     = '{{ data.get("content") }}';

	$column_buttons = array(
		100 => array(
			'label'              => __( 'Edit content', 'obspgb' ),
			'href'               => '#',
			'class'              => "edit-text-column-link edit-content-link ttfobspgb-icon-pencil {{ (data.get('content')) ? 'item-has-content' : '' }}",
			'title'              => __( 'Edit content', 'obspgb' )
		),
		600 => array(
			'label'              => __( 'Trash column', 'obspgb' ),
			'href'               => '#',
			'class'              => 'ttfobspgb-text-column-remove ttfobspgb-icon-trash',
			'title'              => __( 'Trash column', 'obspgb' )
		)
	);

	/**
	 * Filter the buttons added to a text column.
	 *
	 * @since 1.0.0.
	 *
	 * @param array    $column_buttons          The current list of buttons.
	 * @param string   $item_type 			    Item type, in this case 'column'.
	 */
	$column_buttons = apply_filters( 'obspgb_column_buttons', $column_buttons, 'column' );
	ksort( $column_buttons );

	/**
	 * Filter the classes applied to each column in a Columns section.
	 *
	 * @since 1.0.0.
	 *
	 * @param string    $column_classes          The classes for the column.
	 * @param int       $i                       The column number.
	 * @param array     $ttfobspgb_section_data    The array of data for the section.
	 */
	$column_classes = apply_filters( 'ttfobspgb-text-column-classes', 'ttfobspgb-text-column', $ttfobspgb_section_data );
?>

<div class="ttfobspgb-text-column{{ (data.get('size')) ? ' ttfobspgb-column-width-'+data.get('size') : '' }}" data-id="{{ data.get('id') }}">
	<div title="<?php esc_attr_e( 'Drag-and-drop this column into place', 'obspgb' ); ?>" class="ttfobspgb-sortable-handle">
		<div class="sortable-background column-sortable-background"></div>
		<a href="#" class="ttfobspgb-configure-item-button" title="Configure column">
			<span>Configure options</span>
		</a>
	</div>
	<?php
	/**
	 * Execute code before an individual text column is displayed.
	 *
	 * @since 1.0.0.
	 *
	 * @param array    $ttfobspgb_section_data    The data for the section.
	 */
	do_action( 'obspgb_section_text_before_column', $ttfobspgb_section_data );
	?>
	<ul class="configure-item-dropdown">
		<?php foreach ( $column_buttons as $button ) : ?>
			<li>
				<a href="<?php echo esc_url( $button['href'] ); ?>" class="column-buttons <?php echo $button['class']; ?>" title="<?php echo $button['title']; ?>">
					<?php echo $button['label']; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php ttfobspgb_get_builder_base()->add_frame( '', 'content', '', $content ); ?>
	<?php
	/**
	 * Execute code after an individual text column is displayed.
	 *
	 * @since 1.0.0.
	 *
	 * @param array    $ttfobspgb_section_data    The data for the section.
	 */
	do_action( 'obspgb_section_text_after_column', $ttfobspgb_section_data );
	?>
</div>