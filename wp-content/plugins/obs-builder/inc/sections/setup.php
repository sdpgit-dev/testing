<?php
/**
 * @package Obspgb Builder
 */

/**
 * Class OBSPGB_Sections_Setup
 *
 * @since 1.0.0.
 */
class OBSPGB_Sections_Setup extends OBSPGB_Util_Modules implements OBSPGB_Sections_SetupInterface, OBSPGB_Util_HookInterface {
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
	 * OBSPGB_Sections_Setup constructor.
	 *
	 * @since 1.0.0.
	 *
	 * @param OBSPGB_APIInterface|null $api
	 * @param array                  $modules
	 */
	public function __construct( OBSPGB_APIInterface $api, array $modules = array() ) {
		parent::__construct( $api, $modules );
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

		// Register base sections
		add_action( 'after_setup_theme', array( $this, 'register_sections'), 11 );

		// Add base sections styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Hooking has occurred.
		self::$hooked = true;
	}

	public function register_sections() {
		OBSPGB_Sections_Columns_Definition::register();
		//OBSPGB_Sections_Banner_Definition::register();
		//OBSPGB_Sections_Gallery_Definition::register();

		if ( is_admin()) {
			add_filter( 'obspgb_section_settings', array( $this, 'master_demo_setting' ), 40, 2 );
			add_filter( 'obspgb_section_settings', array( $this, 'section_draft_demo_setting' ), 50, 2 );
			add_filter( 'obspgb_section_settings', array( $this, 'section_code_demo_setting' ), 60, 2 );
		}
	}

	/**
	 * TODO
	 */
	public function master_demo_setting( $settings, $section_type ) {
		if ( ! in_array( $section_type, array(
			'text', 'banner', 'gallery', 'panels', 'postlist', 'productgrid', 'downloads'
			) ) ) {
			return $settings;
		}

		$index = max( array_keys( $settings ) );

		/*$settings[$index + 100] = array(
			'type' => 'divider',
			'label' => __( 'Master', 'obspgb' ),
			'name' => 'divider-master',
			'class' => 'ttfobspgb-configuration-divider',
		);*/

		return $settings;
	}

	/**
	 * TODO
	 */
	public function section_draft_demo_setting( $settings, $section_type ) {
		if ( ! in_array( $section_type, array(
			'text', 'banner', 'gallery', 'panels', 'postlist', 'productgrid', 'downloads'
			) ) ) {
			return $settings;
		}

		$index = array_search( 'divider-background', wp_list_pluck( $settings, 'name' ) );
		return $settings;
	}

	/**
	 * TODO
	 */
	public function section_code_demo_setting( $settings, $section_type ) {
		if ( ! in_array( $section_type, array(
			'text', 'banner', 'gallery', 'panels', 'postlist', 'productgrid', 'downloads'
			) ) ) {
			return $settings;
		}

		$index = max( array_keys( $settings ) );

		/*$settings[ $index + 50 ] = array(
			'type'	  => 'divider',
			'name'	  => 'divider-code',
			'label'	  => __( 'Code', 'obspgb' ),
			'class'	  => 'ttfobspgb-configuration-divider'
		);*/
		return $settings;
	}

	/**
	 * Enqueue base section styles.
	 *
	 * @since 1.0.0.
	 *
	 * @param  string    $hook_suffix    The suffix for the screen.
	 * @return void
	 */
	public function admin_enqueue_scripts( $hook_suffix ) {
		// Only load resources if they are needed on the current page
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) || ! ttfobspgb_post_type_supports_builder( get_post_type() ) ) {
			return;
		}

		// Add the section CSS
		wp_enqueue_style(
			'ttfobspgb-sections/css/sections.css',
			Obspgb()->scripts()->get_css_directory_uri() . '/builder/sections/sections.css',
			array(),
			TTFOBSPGB_VERSION,
			'all'
		);
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
}
