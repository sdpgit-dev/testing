<?php
/**
 * @package Obspgb Builder
 */

/**
 * Class OBSPGB_Error_Display
 *
 * Handle the display of error messages collected by OBSPGB_Error_Collector.
 *
 * @since 1.0.0.
 */
final class OBSPGB_Error_Display extends OBSPGB_Util_Modules implements OBSPGB_Error_DisplayInterface, OBSPGB_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.0.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'error' => 'OBSPGB_Error_CollectorInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.0.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.0.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Add a button to the Admin Bar
		add_action( 'admin_bar_menu', array( $this, 'admin_bar' ), 500 );

		// Render the error markup for the Admin Bar in the page footer.
		if ( is_admin() ) {
			add_action( 'admin_footer', array( $this, 'render_adminbar_errors' ), 99 );
		} else {
			add_action( 'wp_footer', array( $this, 'render_adminbar_errors' ), 99 );
		}

		// Add a section to the Customizer and print the data
		add_action( 'customize_register', array( $this, 'add_section' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'render_customizer_errors' ), 99 );

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.0.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Add a node to the Admin Bar for showing the error notification.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action admin_bar_menu
	 *
	 * @param WP_Admin_Bar $wp_admin_bar
	 */
	public function admin_bar( WP_Admin_Bar $wp_admin_bar ) {
		$wp_admin_bar->add_menu( array(
			'id'     => 'obspgb-errors',
			'title'  => '',
			'href'   => '#',
			'parent' => 'top-secondary',
			'meta'   => array(
				'html' => '
					<div id="obspgb-error-detail-wrapper" class="obspgb-error-detail-wrapper"></div>
				',
			),
		) );
	}

	/**
	 * Render the CSS for the Obspgb Errors button in the Admin Bar and the overlay.
	 *
	 * @since 1.0.0.
	 *
	 * @return void
	 */
	private function render_adminbar_css() {
		?>
		<style type="text/css">
			#wpadminbar .obspgb-error-detail-head {
				background: #fcfcfc;
				border-bottom: 1px solid #dfdfdf;
				padding: 0;
				min-height: 36px;
				position: fixed;
				z-index: 1;
				width: 100%;
				max-width: 1200px;
			}
			#wpadminbar .obspgb-error-detail-body {
				background: #ffffff;
				margin-top: 36px;
				padding: 16px;
			}
			#wpadminbar .obspgb-error-detail-body a {
				color: #0073aa;
				text-decoration: underline;
			}
			#wpadminbar .obspgb-error-detail-body a:hover {
				color: #00a0d2;
			}
			#wpadminbar #wp-admin-bar-obspgb-errors {
				display: list-item;
				background-color: #ffb900;
			}
			#wpadminbar #wp-admin-bar-obspgb-errors > .ab-item .ab-icon:before {
				content: "\f534";
				top: 2px;
			}
			#wpadminbar .obspgb-error-detail-wrapper {
				display: none;
				-webkit-box-pack: center;-webkit-justify-content: center;-ms-flex-pack: center;justify-content: center;
				position: fixed;
				top: 0;
				left: 0;
				bottom: 0;
				right: 0;
				z-index: 9999;
				background-color: rgba(0, 0, 0, .8);
				-webkit-font-smoothing: subpixel-antialiased; /*fix font-weight bug with transparent backgrounds*/
			}
			#wpadminbar .obspgb-error-detail-wrapper--active {
				display: -webkit-box;display: -webkit-flex;display: -ms-flexbox;display: flex;
			}
			#obspgb-error-detail-close {
				border: 0;
				top: 0;
				right: 0;
				width: 36px;
				height: 36px;
				line-height: 36px;
				text-align: center;
				cursor: pointer;
			}
			#wpadminbar .obspgb-error-detail__close {
				display: block;
				float: right;
				margin: 0;
				font: 17px/17px "Open Sans",sans-serif;
				background: #fff;
				z-index: 1000;
			}
			#wpadminbar .obspgb-error-detail__close .ab-icon {
				margin: 0;
				padding: 0;
				width: 100%;
			}
			#wpadminbar .obspgb-error-detail__close .ab-icon:before {
				content: "\f158";
				color: #666 !important;
			}
			#wpadminbar .obspgb-error-detail__close:hover .ab-icon:before {
				color: #00a0d2 !important;
			}
			#wpadminbar .obspgb-error-detail {
				-webkit-align-self: center;-ms-flex-item-align: center;align-self: center;
				z-index: 999;
				width: 100%;
				max-width: 1200px;
				max-height: 90%;
				margin: 24px;
				background: #ffffff;
				box-sizing: border-box;
				overflow-x: auto;
				overflow-y: scroll;
				color: black;
				position: relative;
			}
			#wpadminbar .callout-warning {
				padding: 10px 20px;
				color: #444;
				border-left: 4px solid #ffb900;
				background-color: #fff8e5;
			}
			#wpadminbar .callout-warning p,
			#wpadminbar .callout-warning a {
				font-family: 'Open Sans', sans-serif;
				font-size: 13px !important;
				font-weight: 600 !important;
			}
			#wpadminbar .callout-warning p strong {
				display: block;;
				font-size: 18px;
				font-weight: 600;
				line-height: 18px;
				padding: 9px 0;
			}
			#wpadminbar .obspgb-error-detail h2 {
				float: left;
				font: bold 18px/36px "Open Sans",sans-serif;
				color: #444;
				margin: 0;
				padding: 0 36px 0 16px
			}
			#wpadminbar .obspgb-error-detail h3 {
				font: bold 20px/32px "Open Sans",sans-serif;
				margin-top: 1em;
				margin-bottom: 1em;
			}
			#wpadminbar .obspgb-error-detail p {
				margin-bottom: 0.5em;
			}
			#wpadminbar .obspgb-error-detail p + p,
			#wpadminbar .obspgb-error-detail p + ol {
				margin-bottom: 1em;
			}
			#wpadminbar .obspgb-error-detail p,
			#wpadminbar .obspgb-error-detail ol,
			#wpadminbar .obspgb-error-detail li,
			#wpadminbar .obspgb-error-detail a,
			#wpadminbar .obspgb-error-detail em,
			#wpadminbar .obspgb-error-detail strong {
				font: 16px/20px "Open Sans",sans-serif;
			}
			#wpadminbar .obspgb-error-detail a {
				display: inline;
				padding: 0;
			}
			#wpadminbar .obspgb-error-detail em {
				font-style: italic;
			}
			#wpadminbar .obspgb-error-detail strong {
				font-weight: bold;
			}
			#wpadminbar .obspgb-error-detail pre,
			#wpadminbar .obspgb-error-detail code {
				font: 16px/20px monospace;
				padding: 2px 6px;
			}
			#wpadminbar .obspgb-error-detail ol {
				list-style: decimal outside;
				clear: both;
				padding: 0 16px;
			}
			#wpadminbar .obspgb-error-detail li {
				display: list-item;
				float: none;
				list-style-type: decimal;
			}
			#obspgb-error-detail-container {
				display: none;
			}
			@media screen and (max-width: 1400px) {
				#wpadminbar .obspgb-error-detail-wrapper--active {
					-webkit-flex-direction: column;flex-direction: column;
				}
				#wpadminbar .quicklinks .obspgb-error-detail__close {
					-webkit-align-self: center;-ms-flex-item-align: center;align-self: center;
					position: static;
				}
				#wpadminbar .obspgb-error-detail {
					margin: 0 24px;
				}
			}
			@media screen and (max-width: 782px) {
				#wpadminbar .quicklinks .obspgb-error-detail__close {
					font: 36px/1 "Open Sans",sans-serif;
					margin-right: 16px;
				}
			}
		</style>
	<?php
	}

	/**
	 * Render the CSS for the Obspgb Errors button in the Admin Bar when there are no errors to display.
	 *
	 * @since 1.0.0.
	 *
	 * @return void
	 */
	private function render_adminbar_css_no_errors() {
		?>
		<style type="text/css">
			#wpadminbar #wp-admin-bar-obspgb-errors {
				display: none;
			}
		</style>
	<?php
	}

	/**
	 * Render the error messages within a container, include help text.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action admin_footer
	 * @hooked action wp_footer
	 *
	 * @return void
	 */
	public function render_adminbar_errors() {
		// Bail if this is in the Customizer preview pane.
		if ( is_customize_preview() ) {
			return;
		}

		// Bail if there aren't any errors.
		if ( ! $this->error()->has_errors() ) {
			$this->render_adminbar_css_no_errors();
			return;
		}

		// CSS
		$this->render_adminbar_css();

		// HTML
		?>
		<div id="obspgb-error-detail-container">
			<?php $this->render_errors(); ?>
		</div>
	<?php

		// JavaScript
		$this->render_adminbar_js();
	}

	/**
	 * Render the JavaScript for handling the Obspgb Errors button in the Admin Bar.
	 *
	 * @since 1.0.0.
	 *
	 * @return void
	 */
	private function render_adminbar_js() {
		?>
		<script type="application/javascript">
			if ('undefined' !== typeof jQuery) {
				(function($) {
					$(document).ready(function() {
						var $container   = $('#wp-admin-bar-obspgb-errors'),
							$barbutton   = $container.find('> .ab-item'),
							$overlay     = $('#obspgb-error-detail-wrapper'),
							$content     = $('#obspgb-error-detail-container');

						$barbutton.html('<span class="ab-icon"></span><span class="ab-label"><?php echo $this->get_errors_title(); ?></span>');
						$overlay.append($content.html());

						$barbutton.on('click', function(evt) {
							evt.preventDefault();
							$overlay.addClass('obspgb-error-detail-wrapper--active');
						});

						$overlay.on('click', '#obspgb-error-detail-close', function(evt) {
							evt.preventDefault();
							$overlay.removeClass('obspgb-error-detail-wrapper--active');
						});
					});
				})(jQuery);
			}
		</script>
	<?php
	}

	/**
	 * Add a section to the Customizer to display a notice about Obspgb errors.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action customize_register
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function add_section( WP_Customize_Manager $wp_customize ) {
		// Create a section instance
		$section = new OBSPGB_Error_Section(
			$wp_customize,
			'obspgb_error',
			array(
				'priority' => 9999,
			)
		);

		$wp_customize->add_section( $section );
	}

	/**
	 * Output a Customizer JS template for the Obspgb Errors section.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action customize_controls_print_footer_scripts
	 *
	 * @return void
	 */
	public function render_customizer_errors() {
		// Bail if there aren't any errors.
		if ( ! $this->error()->has_errors() ) {
			return;
		}
		?>
		<div id="obspgb-error-detail-container">
			<h3 class="accordion-section-title">
				<?php echo $this->get_errors_title(); ?>
				<button id="obspgb-show-errors" type="button" class="button" tabindex="0">
					<?php esc_html_e( 'Show notices', 'obspgb' ); ?>
				</button>
			</h3>
			<div id="obspgb-error-detail-wrapper">
				<?php $this->render_errors(); ?>
			</div>
		</div>
	<?php
	}

	/**
	 * Return a string showing the number of "Obspgb errors".
	 *
	 * @since 1.0.0.
	 *
	 * @return string
	 */
	private function get_errors_title() {
		// Get the error message count.
		$error_count = count( $this->error()->get_messages() );
		return sprintf(
			esc_html( _n( '%s Obspgb Notice', '%s Obspgb Notices', $error_count, 'obspgb' ) ),
			number_format_i18n( $error_count )
		);
	}

	/**
	 * Sanitize an error message.
	 *
	 * @since 1.0.0.
	 *
	 * @param  string    $message    The message string to sanitize.
	 * @return string                The sanitized message string.
	 */
	private function sanitize_message( $message ) {
		$allowedtags = array_merge(
			wp_kses_allowed_html(),
			array(
				'a'   => array(
					'href' => true,
					'target' => true,
				),
				'ol'  => true,
				'li'  => true,
				'pre' => true,
				'br'  => true,
			)
		);

		return wp_kses( $message, $allowedtags );
	}

	/**
	 * Render the error messages within a container, include help text.
	 *
	 * @since 1.0.0.
	 *
	 * @return void
	 */
	private function render_errors() {
		?>
		<div class="obspgb-error-detail">
			<div class="obspgb-error-detail-head">
				<h2><?php echo esc_html( $this->get_errors_title() ); ?></h2>
				<button id="obspgb-error-detail-close" class="obspgb-error-detail__close" href="#">
					<span class="ab-icon"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Close', 'obspgb' ); ?></span>
				</button>
			</div>
			<div class="obspgb-error-detail-body">
				<div class="callout-warning">
					<p><strong><?php esc_html_e( 'What is a Obspgb notice?', 'obspgb' ); ?></strong></p>
					<p>
						<?php echo $this->sanitize_message( __( '
							Obspgb notices occur when Obspgb\'s functionality is used incorrectly. Often these notices are
							triggered by code errors in a child theme or plugin that extends the theme. The notice
							messages help you to identify the cause of the errors so they can be fixed.
						', 'obspgb' ) ); ?>
					</p>
					<p><strong><?php esc_html_e( 'Is it important to fix these notices?', 'obspgb' ); ?></strong></p>
					<p>
						<?php echo $this->sanitize_message( __( '
							Absolutely! These notices may indicate that some part of your site is not working correctly.
							We don\'t want that.
						', 'obspgb' ) ); ?>
					</p>
					<p><strong><?php esc_html_e( 'How do I fix a Obspgb notice?', 'obspgb' ); ?></strong></p>
					<p>
						<?php echo $this->sanitize_message( sprintf( __( '
							Check to see if your child theme or plugin has an update available, as a new version may
							include changes that fix the errors. If it is caused by custom code, you will need to modify
							the code to fix the errors. Check out our article about <a href="%s" target="_blank">dealing
							with Obspgb Notices</a> to learn more.
						', 'obspgb' ), 'https://thethemefoundry.com/docs/obspgb-docs/guides/obspgb-notices/' ) ); ?>
					</p>
					<p><strong><?php esc_html_e( 'How can I hide this notification?', 'obspgb' ); ?></strong></p>
					<p>
						<?php echo $this->sanitize_message( sprintf( __( '
							This notification is only visible to users who are logged in and have the capability to
							install themes. To hide it completely, add this code to your functions.php file: %s
						', 'obspgb' ), '
							<code>add_filter( \'obspgb_show_errors\', \'__return_false\' );</code>
						' ) ); ?>
					</p>
				</div>
				<?php foreach ( $this->error()->get_codes() as $code ) : ?>
					<h3><?php printf( esc_html__( 'Error code: %s', 'obspgb' ), esc_html( $code ) ); ?></h3>
					<?php foreach ( $this->error()->get_messages( $code ) as $message ) : ?>
						<?php echo wpautop( $this->sanitize_message( $message ) ); ?>
					<?php endforeach; ?>
					<hr />
				<?php endforeach; ?>
			</div>
		</div>
	<?php
	}
}