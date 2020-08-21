<?php
/**
 * @package Obspgb Builder
 */

final class OBSPGB_Gutenberg_Manager implements OBSPGB_Gutenberg_ManagerInterface, OBSPGB_Util_HookInterface {

	protected $dependencies = array(
		'notice' => 'OBSPGB_Admin_NoticeInterface',
	);

	private static $hooked = false;

	private $editor_parameter = 'block-editor';

	private $editor_meta = '_ttfobspgb_block_editor';

	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		if ( is_admin() ) {
			add_action( 'obspgb_notice_loaded', array( $this, 'admin_notice' ) );
			add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
			add_filter( 'use_block_editor_for_post', array( $this, 'use_block_editor_for_post' ), 10, 2 );
		}

		self::$hooked = true;
	}

	public function is_hooked() {
		return self::$hooked;
	}

	public function save_post( $post_id, $post ) {
		if ( isset( $_GET[$this->editor_parameter] ) ) {
			update_post_meta( $post_id, $this->editor_meta, true );
		}
	}

	public function has_block_editor() {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		global $wp_version;

		$is_50 = version_compare( $wp_version, '5.0-alpha', '>=' );
		$has_plugin = is_plugin_active( 'gutenberg/gutenberg.php' );
		$has_block_editor = $is_50 || $has_plugin;

		return $has_block_editor;
	}

	public function is_block_editor() {
		$current_screen = get_current_screen();
		$is_block_editor =
			method_exists( $current_screen, 'is_block_editor' )
			&& $current_screen->is_block_editor();

		return $is_block_editor;
	}

	private function use_block_editor( $post_id = 0 ) {
		global $pagenow;

		$use = false;

		if ( 'post-new.php' === $pagenow ) {
			$use = isset( $_GET[$this->editor_parameter] );
		} else {
			$use = get_post_meta( $post_id, $this->editor_meta, true );
		}

		return $use;
	}

	public function use_block_editor_for_post( $use, $post ) {
		return $this->use_block_editor( $post->ID );
	}

	public function admin_notice( OBSPGB_Admin_NoticeInterface $notice ) {
		global $pagenow;

		if ( $this->use_block_editor() || 'post-new.php' !== $pagenow ) {
			return;
		}

		$post_type = get_post_type();

		$new_post_link = add_query_arg( array(
			$this->editor_parameter => '',
			'post_type' => $post_type,
		), admin_url( 'post-new.php' ) );

		$guide_link = 'https://thethemefoundry.com/tutorials/getting-ready-for-wordpress-5-0-theme-bundle/';

		$notice->register_admin_notice(
			'obspgb-block-editor',
			sprintf(
				__( '<div>Obspgb Builder requires the classic editor to work, but you can replace the builder with the Gutenberg editor for this particular %1s.<br>Read through our guide about <a href="%2s" target="_blank">getting ready for WordPress 5.0</a> to find out why.</div><div><a href="%3s" class="button">Use Gutenberg on this %1s</a></div>', 'obspgb-builder' ),
				$post_type, $guide_link, $new_post_link, $post_type
			),
			array(
				'cap' => 'edit_pages',
				'dismiss' => false,
				'screen' => array( 'post', 'page', 'edit-post', 'edit-page' ),
				'type' => 'info',
			)
		);
	}
}