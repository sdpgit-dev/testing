<?php
/**
 * @package Obspgb Builder
 */

/**
 * Class OBSPGB_Setup_Scripts
 *
 * Methods for managing and enqueueing script and style assets.
 *
 * @since 1.0.0.
 */
final class OBSPGB_Setup_Scripts extends OBSPGB_Util_Modules implements OBSPGB_Setup_ScriptsInterface, OBSPGB_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.0.0.
	 *
	 * @var array
	 */
	protected $dependencies = array();

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

		// Register style and script libs
		add_action( 'wp_enqueue_scripts', array( $this, 'register_libs' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_libs' ), 1 );

		// Enqueue front end styles and scripts.
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ), 20 );

		add_action( 'admin_enqueue_scripts', array( $this, 'add_editor_styles' ) );

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
	 * Wrapper for getting the path to the theme's CSS directory.
	 *
	 * @since 1.0.0.
	 *
	 * @return string
	 */
	public function get_css_directory() {
		return obspgb_get_plugin_directory() . '/css';
	}

	/**
	 * Wrapper for getting the URL for the theme's CSS directory.
	 *
	 * @since 1.0.0.
	 *
	 * @return string
	 */
	public function get_css_directory_uri() {
		return obspgb_get_plugin_directory_uri() . 'css';
	}

	/**
	 * Wrapper for getting the path to the theme's JS directory.
	 *
	 * @since 1.0.0.
	 *
	 * @return string
	 */
	public function get_js_directory() {
		return obspgb_get_plugin_directory() . '/js';
	}

	/**
	 * Wrapper for getting the URL for the theme's JS directory.
	 *
	 * @since 1.0.0.
	 *
	 * @return string
	 */
	public function get_js_directory_uri() {
		return obspgb_get_plugin_directory_uri() . 'js';
	}

	/**
	 * Wrapper function to register style and script libraries for usage throughout the site.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action wp_enqueue_scripts
	 * @hooked action admin_enqueue_scripts
	 * @hooked action customize_controls_enqueue_scripts
	 * @hooked action customize_preview_init
	 *
	 * @return void
	 */
	public function register_libs() {
		$this->register_style_libs();
		$this->register_script_libs();
	}

	/**
	 * Register style libraries.
	 *
	 * @since 1.0.0.
	 *
	 * @return void
	 */
	private function register_style_libs() {
		// Editor styles
		wp_register_style(
			'obspgb-editor',
			$this->get_css_directory_uri() . '/editor-style.css',
			array(),
			TTFOBSPGB_VERSION,
			'screen'
		);

		// Font Awesome
		wp_register_style(
			'font-awesome',
			$this->get_css_directory_uri() . '/libs/font-awesome/css/font-awesome.min.css',
			array(),
			'4.6.1'
		);
	}

	/**
	 * Register JavaScript libraries.
	 *
	 * @since 1.0.0.
	 *
	 * @return void
	 */
	private function register_script_libs() {
		// Cycle2
		if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) {
			// Core script
			wp_register_script(
				'cycle2',
				$this->get_js_directory_uri() . '/libs/cycle2/jquery.cycle2.js',
				array( 'jquery' ),
				'2.1.6',
				true
			);

			// Vertical centering
			wp_register_script(
				'cycle2-center',
				$this->get_js_directory_uri() . '/libs/cycle2/jquery.cycle2.center.js',
				array( 'cycle2' ),
				'20140121',
				true
			);

			// Swipe support
			wp_register_script(
				'cycle2-swipe',
				$this->get_js_directory_uri() . '/libs/cycle2/jquery.cycle2.swipe.js',
				array( 'cycle2' ),
				'20121120',
				true
			);
		} else {
			wp_register_script(
				'cycle2',
				$this->get_js_directory_uri() . '/libs/cycle2/jquery.cycle2.min.js',
				array( 'jquery' ),
				'2.1.6',
				true
			);
		}

		// FitVids
		wp_register_script(
			'fitvids',
			$this->get_js_directory_uri() . '/libs/fitvids/jquery.fitvids.js',
			array( 'jquery' ),
			'1.1-d028a22',
			true
		);
	}

	/**
	 * Enqueue styles for the front end of the site.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action wp_enqueue_scripts
	 *
	 * @return void
	 */
	/*public function enqueue_frontend_styles() {
		wp_enqueue_style(
			'obspgb-sections',
			$this->get_css_directory_uri() . '/sections.css',
			array(),
			TTFOBSPGB_VERSION
		);

		wp_enqueue_style(
			'obspgb-fontawesome',
			$this->get_css_directory_uri() . '/libs/font-awesome/css/font-awesome.min.css',
			array( 'obspgb-sections' ),
			TTFOBSPGB_VERSION
		);
	}*/

	/**
	 * Add stylesheet URLs to be loaded into the Visual Editor's iframe.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action admin_enqueue_scripts
	 *
	 * @return void
	 */
	public function add_editor_styles() {
		$editor_styles = array();

		foreach ( array(
			'font-awesome',
			'obspgb-editor'
		) as $lib ) {
			if ( $this->is_registered( $lib, 'style' ) ) {
				$editor_styles[] = $this->get_url( $lib, 'style' );
			}
		}

		add_editor_style( $editor_styles );
	}

	/**
	 * Enqueue scripts for the front end of the site.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action wp_enqueue_scripts
	 *
	 * @return void
	 */
	public function enqueue_frontend_scripts() {
		// Main script
		wp_enqueue_script(
			'obspgb-frontend',
			$this->get_js_directory_uri() . '/frontend.js',
			array( 'jquery' ),
			TTFOBSPGB_VERSION,
			true
		);

		// Define JS data
		$data = array(
			'fitvids' => $this->get_fitvids_selectors()
		);

		// Add JS data
		wp_localize_script(
			'obspgb-frontend',
			'ObspgbFrontEnd',
			$data
		);

		// Comment reply script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Get the URL of a theme file.
	 *
	 * Looks for the file in a child theme first, then in the parent theme.
	 *
	 * @since 1.0.0.
	 *
	 * @uses locate_template()
	 *
	 * @param string|array $file_names    File(s) to search for, in order.
	 *
	 * @return string                     The file URL if one is located.
	 */
	public function get_located_file_url( $file_names ) {
		$url = '';

		$located = locate_template( $file_names );
		if ( '' !== $located ) {
			if ( 0 === strpos( $located, get_stylesheet_directory() ) ) {
				$url = str_replace( get_stylesheet_directory(), get_stylesheet_directory_uri(), $located );
			} else if ( 0 === strpos( $located, obspgb_get_plugin_directory() ) ) {
				$url = str_replace( obspgb_get_plugin_directory(), obspgb_get_plugin_directory_uri(), $located );
			}
		}

		/**
		 * Filter: Modify the URL the theme will use to attempt to access a particular file.
		 *
		 * This can be used to set the URL for a file if the get_located_file_url() method is not
		 * determining the correct URL.
		 *
		 * @since 1.0.0.
		 *
		 * @param string       $url
		 * @param string|array $file_names
		 */
		return apply_filters( 'obspgb_located_file_url', $url, $file_names );
	}

	/**
	 * Return a specified style or script object.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $dependency_id The ID of the dependency object.
	 * @param string $type          The type of dependency object. Valid options are style and script.
	 *
	 * @return _WP_Dependency|null
	 */
	private function get_dependency_object( $dependency_id, $type ) {
		switch ( $type ) {
			case 'style' :
				global $wp_styles;
				if ( $wp_styles instanceof WP_Styles ) {
					$style = $wp_styles->query( $dependency_id, 'registered' );
					if ( $style instanceof _WP_Dependency ) {
						return $style;
					}
				}
				break;

			case 'script' :
				global $wp_scripts;
				if ( $wp_scripts instanceof WP_Scripts ) {
					$script = $wp_scripts->query( $dependency_id, 'registered' );
					if ( $script instanceof _WP_Dependency ) {
						return $script;
					}
				}
				break;
		}

		return null;
	}

	/**
	 * Check if a specified style or script object has been registered.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $dependency_id The ID of the dependency object.
	 * @param string $type          The type of dependency object. Valid options are style and script.
	 *
	 * @return bool                 True if the object has been registered.
	 */
	public function is_registered( $dependency_id, $type ) {
		return ! is_null( $this->get_dependency_object( $dependency_id, $type ) );
	}

	/**
	 * Add a dependency to a specified style or script object.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $recipient_id  The ID of the object to add a dependency to.
	 * @param string $dependency_id The ID of the object to add as a dependency.
	 * @param string $type          The type of dependency object. Valid options are style and script.
	 *
	 * @return bool                 True if a dependency was successfully added. Otherwise false.
	 */
	public function add_dependency( $recipient_id, $dependency_id, $type ) {
		if ( $this->is_registered( $recipient_id, $type ) && $this->is_registered( $dependency_id, $type ) ) {
			$obj = $this->get_dependency_object( $recipient_id, $type );
			if ( ! in_array( $dependency_id, $obj->deps ) ) {
				$obj->deps[] = $dependency_id;
				return true;
			}
		}

		return false;
	}

	/**
	 * Remove a dependency from a specified style or script object.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $recipient_id  The ID of the object to remove a dependency from.
	 * @param string $dependency_id The ID of the dependency object to remove.
	 * @param string $type          The type of dependency object. Valid options are style and script.
	 *
	 * @return bool                 True if the dependency existed and was removed. Otherwise false.
	 */
	public function remove_dependency( $recipient_id, $dependency_id, $type ) {
		if ( $this->is_registered( $recipient_id, $type ) ) {
			$obj = $this->get_dependency_object( $recipient_id, $type );
			if ( false !== $key = array_search( $dependency_id, $obj->deps ) ) {
				unset( $obj->deps[ $key ] );
				return true;
			}
		}

		return false;
	}

	/**
	 * Update the version property of a specified style or script object.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $recipient_id The ID of the object to update.
	 * @param string $version      The new version to add to the object.
	 * @param string $type         The type of dependency object. Valid options are style and script.
	 *
	 * @return bool                True if the version was successfully updated. Otherwise false.
	 */
	public function update_version( $recipient_id, $version, $type ) {
		if ( $this->is_registered( $recipient_id, $type ) ) {
			$obj = $this->get_dependency_object( $recipient_id, $type );
			$obj->ver = $this->sanitize_version( $version );
			return true;
		}

		return false;
	}

	/**
	 * Return the URL of a specified registered style or script.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $dependency_id The ID of the style or script to determine the URL of.
	 * @param string $type          The type of dependency object. Valid options are style and script.
	 *
	 * @return string               The URL, or an empty string.
	 */
	public function get_url( $dependency_id, $type ) {
		$url = '';

		if ( $this->is_registered( $dependency_id, $type ) ) {
			$obj = $this->get_dependency_object( $dependency_id, $type );
			$url = add_query_arg( 'ver', $obj->ver, $obj->src );
		}

		return $url;
	}

	/**
	 * Restrict the characters allowed in a version string.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $version The version string to sanitize.
	 *
	 * @return string         The sanitized version string.
	 */
	private function sanitize_version( $version ) {
		return preg_replace( '/[^A-Za-z0-9\-_\.]+/', '', $version );
	}

	/**
	 * Generate a string of jQuery selectors used by the FitVids.js script.
	 *
	 * @since 1.0.0.
	 *
	 * @return array
	 */
	private function get_fitvids_selectors() {
		/**
		 * Filter: Allow customization of the selectors that are used to apply FitVids.
		 *
		 * @since 1.0.0.
		 *
		 * @param array $selector_array    The selectors used by FitVids.
		 */
		$selector_array = apply_filters( 'obspgb_fitvids_custom_selectors', array() );

		// Compile selectors
		return array(
			'selectors' => implode( ',', $selector_array )
		);
	}
}