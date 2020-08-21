<?php
/**
 * @package Obspgb Builder
 */

$class = ( 'c' === get_user_setting( 'ttfobspgbmt' . get_the_ID() ) ) ? 'closed' : 'opened';
?>

<div class="ttfobspgb-menu ttfobspgb-menu-<?php echo esc_attr( $class ); ?>" id="ttfobspgb-menu">
	<div class="ttfobspgb-menu-pane">
		<ul class="ttfobspgb-menu-list">
			<?php
			/**
			 * Execute code before the builder menu items are displayed.
			 *
			 * @since 1.0.0.
			 */
			do_action( 'obspgb_before_builder_menu' );
			?>
			<?php foreach ( ttfobspgb_get_sections_by_order() as $key => $item ) : ?>
				<li class="ttfobspgb-menu-list-item">
                    <a href="#" title="<?php echo esc_html( $item['description'] ); ?>" class="ttfobspgb-menu-list-item-link" id="ttfobspgb-menu-list-item-link-<?php echo esc_attr( $item['id'] ); ?>" data-section="<?php echo esc_attr( $item['id'] ); ?>">
						<div class="ttfobspgb-menu-list-item-link-icon-wrapper clear">
							<i class="material-icons"><?php echo $item['icon'];?></i>
							<div class="section-type-description">
								<?php echo esc_html( $item['label'] ); ?>
							</div>
						</div>
                    </a>
				</li>				
			<?php endforeach; ?>
			<?php
			/**
			 * Execute code after the builder menu items are displayed.
			 *
			 * @since 1.0.0.
			 */
			do_action( 'obspgb_after_builder_menu' );
			?>
		</ul>
	</div>
</div>
