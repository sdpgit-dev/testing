<?php
/**
 * @package Obspgb Builder
 */

/**
 * Class OBSPGB_API
 *
 * Class to manage and provide access to all of the modules that obspgb up the Obspgb API.
 *
 * Access this class via the global Obspgb() function.
 *
 * @since 1.0.0.
 */
final class OBSPGB_API extends OBSPGB_Util_Modules implements OBSPGB_APIInterface, OBSPGB_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.0.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'notice'     => 'OBSPGB_Admin_NoticeInterface',
		'error'      => 'OBSPGB_Error_CollectorInterface',
		'scripts'    => 'OBSPGB_Setup_ScriptsInterface',
		'style'      => 'OBSPGB_Style_ManagerInterface',
		'sanitize'   => 'OBSPGB_Settings_SanitizeInterface',
		'formatting' => 'OBSPGB_Formatting_ManagerInterface',
		'builder'    => 'OBSPGB_Builder_SetupInterface',
		'setup'      => 'OBSPGB_Setup_MiscInterface',
		'sections'   => 'OBSPGB_Sections_SetupInterface',
		'gutenberg'  => 'OBSPGB_Gutenberg_ManagerInterface'
	);

	/**
	 * An associative array of the default classes to use for each dependency.
	 *
	 * @since 1.0.0.
	 *
	 * @var array
	 */
	private $defaults = array(
		'notice'     => 'OBSPGB_Admin_Notice',
		'error'      => 'OBSPGB_Error_Collector',
		'scripts'    => 'OBSPGB_Setup_Scripts',
		'style'      => 'OBSPGB_Style_Manager',
		'sanitize'   => 'OBSPGB_Settings_Sanitize',
		'formatting' => 'OBSPGB_Formatting_Manager',
		'builder'    => 'OBSPGB_Builder_Setup',
		'setup'      => 'OBSPGB_Setup_Misc',
		'sections'   => 'OBSPGB_Sections_Setup',
		'gutenberg'  => 'OBSPGB_GutenberG_Manager'
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
	 * OBSPGB_API constructor.
	 *
	 * @since 1.0.0.
	 *
	 * @param array $modules
	 */
	public function __construct( array $modules = array() ) {
		$modules = wp_parse_args( $modules, $this->get_default_modules() );

		parent::__construct( $this, $modules );
	}

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
	 * Getter for the private defaults array.
	 *
	 * @since 1.0.0.
	 *
	 * @return array
	 */
	private function get_default_modules() {
		return $this->defaults;
	}

	/**
	 * Return the specified module without running its load routine.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $module_name
	 *
	 * @return null
	 */
	public function inject_module( $module_name ) {
		// Module exists.
		if ( $this->has_module( $module_name ) ) {
			return $this->modules[ $module_name ];
		}

		// Module doesn't exist. Use the get_module method to generate an error.
		else {
			return $this->get_module( $module_name );
		}
	}
}
