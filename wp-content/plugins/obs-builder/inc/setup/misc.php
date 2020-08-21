<?php
/**
 * @package Obspgb Builder
 */

/**
 * Class OBSPGB_Setup_Misc
 *
 * Miscellaneous theme setup routines.
 *
 * @since 1.0.0.
 */
final class OBSPGB_Setup_Misc extends OBSPGB_Util_Modules implements OBSPGB_Setup_MiscInterface, OBSPGB_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.0.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'scripts'  => 'OBSPGB_Setup_ScriptsInterface',
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

		// Embed container
		add_filter( 'embed_handler_html', array( $this, 'embed_container' ), 10, 3 );
		add_filter( 'embed_oembed_html' , array( $this, 'embed_container' ), 10, 3 );

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
	 * Modify the excerpt suffix
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter excerpt_more
	 *
	 * @return string
	 */
	public function excerpt_more() {
		return ' &hellip;';
	}

	/**
	 * Add a wrapper div to the output of oembeds and the [embed] shortcode.
	 *
	 * Also enqueues FitVids, since the embed might be a video.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter embed_handler_html
	 * @hooked filter embed_oembed_html
	 *
	 * @param string $html    The generated HTML of the embed handler.
	 * @param string $url     The embed URL.
	 * @param array  $attr    The attributes of the embed shortcode.
	 *
	 * @return string         The wrapped HTML.
	 */
	public function embed_container( $html, $url, $attr ) {
		// Bail if this is the admin or an RSS feed
		if ( is_admin() || is_feed() ) {
			return $html;
		}

		if ( isset( $attr['width'] ) ) {
			// Add FitVids as a dependency for the Frontend script
			$this->scripts()->add_dependency( 'obspgb-frontend', 'fitvids', 'script' );

			// Get classes
			$default_class = 'ttfobspgb-embed-wrapper';
			$align_class = 'aligncenter';
			if ( isset( $attr['obspgb_align'] ) ) {
				$align = trim( $attr['obspgb_align'] );
				if ( in_array( $align, array( 'left', 'right', 'center', 'none' ) ) ) {
					$align_class = 'align' . $align;
				}
			}
			$class = trim( "$default_class $align_class" );

			// Get style
			$style = 'max-width: ' . absint( $attr['width'] ) . 'px;';

			// Build wrapper
			$wrapper = "<div class=\"$class\" style=\"$style\">%s</div>";
			$html = sprintf( $wrapper, $html );
		}

		return $html;
	}
}