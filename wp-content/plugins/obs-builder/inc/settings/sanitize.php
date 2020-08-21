<?php
/**
 * @package Obspgb Builder
 */

/**
 * Class OBSPGB_Settings_Sanitize
 *
 * Methods for sanitizing setting values.
 *
 * @since 1.0.0.
 */
final class OBSPGB_Settings_Sanitize extends OBSPGB_Util_Modules implements OBSPGB_Settings_SanitizeInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.0.0.
	 *
	 * @var array
	 */
	protected $dependencies = array();

	/**
	 * Sanitize a string to ensure that it is a float number.
	 *
	 * @since 1.0.0.
	 *
	 * @param  string|float    $value    The value to sanitize.
	 *
	 * @return float                     The sanitized value.
	 */
	public function sanitize_float( $value ) {
		return floatval( $value );
	}

	/**
	 * Sanitize the value of an image setting.
	 *
	 * If the given value is a URL instead of an attachment ID, this tries to find the URL's associated attachment.
	 *
	 * @since 1.0.0.
	 *
	 * @param      $value
	 * @param bool $raw
	 *
	 * @return int|string    The attachment ID, or a sanitized URL if the attachment can't be found.
	 */
	public function sanitize_image( $value, $raw = false ) {
		if ( is_string( $value ) && 0 === strpos( $value, 'http' ) ) {
			// Value is URL. Try to find the attachment ID.
			$find_attachment = attachment_url_to_postid( $value );
			if ( 0 !== $find_attachment ) {
				return $find_attachment;
			}

			// Attachment ID is unavailable. Return sanitized URL.
			if ( true === $raw ) {
				return esc_url_raw( $value );
			} else {
				return esc_url( $value );
			}
		} else {
			// Value is not URL. Treat as attachment ID.
			return absint( $value );
		}
	}

	/**
	 * Wrapper for using the sanitize_image method with raw set to true.
	 *
	 * @since 1.0.0.
	 *
	 * @param $value
	 *
	 * @return int|string
	 */
	public function sanitize_image_raw( $value ) {
		return $this->sanitize_image( $value, true );
	}

	/**
	 * Allow only certain tags and attributes in a string.
	 *
	 * @since 1.0.0.
	 *
	 * @param  string    $string    The unsanitized string.
	 *
	 * @return string               The sanitized string.
	 */
	public function sanitize_text( $string ) {
		global $allowedtags;
		$expandedtags = $allowedtags;

		// span
		$expandedtags['span'] = array();

		// Enable id, class, and style attributes for each tag
		foreach ( $expandedtags as $tag => $attributes ) {
			$expandedtags[ $tag ]['id']    = true;
			$expandedtags[ $tag ]['class'] = true;
			$expandedtags[ $tag ]['style'] = true;
		}

		// br (doesn't need attributes)
		$expandedtags['br'] = array();

		/**
		 * Customize the tags and attributes that are allowed during text sanitization.
		 *
		 * @since 1.0.0.
		 *
		 * @param array     $expandedtags    The list of allowed tags and attributes.
		 * @param string    $string          The text string being sanitized.
		 */
		$expandedtags = apply_filters( 'obspgb_sanitize_text_allowed_tags', $expandedtags, $string );

		return wp_kses( $string, $expandedtags );
	}
}