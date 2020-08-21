<?php
/**
 * @package Obspgb Builder
 */

if ( ! class_exists( 'OBSPGB_Sections_Gallery_Definition' ) ) :
/**
 * Section definition for Columns
 *
 * Class OBSPGB_Sections_Gallery_Definition
 */
class OBSPGB_Sections_Gallery_Definition {
	/**
	 * The one instance of OBSPGB_Sections_Gallery_Definition.
	 *
	 * @var   OBSPGB_Sections_Gallery_Definition
	 */
	private static $instance;

	public static function register() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		if ( is_admin() ) {
			add_filter( 'obspgb_section_choices', array( $this, 'section_choices' ), 10, 3 );
			add_filter( 'obspgb_sections_settings', array( $this, 'section_settings' ) );
			add_filter( 'obspgb_sections_defaults', array( $this, 'section_defaults' ) );
			add_filter( 'obspgb_get_section_json', array( $this, 'get_section_json' ), 10, 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 20 );
			add_action( 'admin_footer', array( $this, 'print_templates' ) );
		}

		add_filter( 'obspgb_section_html_class', array( $this, 'html_class' ), 10, 3 );
		add_filter( 'obspgb_section_html_style', array( $this, 'html_style' ), 10, 3 );
		add_filter( 'obspgb_section_item_html_class', array( $this, 'item_html_class' ), 10, 3 );

		ttfobspgb_add_section(
			'gallery',
			__( 'Gallery', 'obspgb' ),
			obspgb_get_plugin_directory_uri() . 'css/builder/sections/images/gallery.png',
			__( 'Display your images in various grid combinations.', 'obspgb' ),
			array( $this, 'save' ),
			array(
				'gallery' => 'sections/gallery/builder-template',
				'gallery-item' => 'sections/gallery/builder-template-item'
			),
			'sections/gallery/frontend-template',
			400,
			get_template_directory() . '/inc/builder/'
		);
	}

	public function get_settings() {
		return array(
			100 => array(
				'type'    => 'divider',
				'label'   => __( 'General', 'obspgb' ),
				'name'    => 'divider-general',
				'class'   => 'ttfobspgb-configuration-divider open',
			),
			200 => array(
				'type'  => 'section_title',
				'name'  => 'title',
				'label' => __( 'Enter section title', 'obspgb' ),
				'class' => 'ttfobspgb-configuration-title ttfobspgb-section-header-title-input',
				'default' => ttfobspgb_get_section_default( 'title', 'gallery' )
			),
			400 => array(
				'type'    => 'select',
				'name'    => 'columns',
				'label'   => __( 'Columns', 'obspgb' ),
				'class'   => 'ttfobspgb-gallery-columns',
				'default' => ttfobspgb_get_section_default( 'columns', 'gallery' ),
				'options' => ttfobspgb_get_section_choices( 'columns', 'gallery' ),
			),
			500 => array(
				'type'    => 'select',
				'name'    => 'aspect',
				'label'   => __( 'Aspect ratio', 'obspgb' ),
				'default' => ttfobspgb_get_section_default( 'aspect', 'gallery' ),
				'options' => ttfobspgb_get_section_choices( 'aspect', 'gallery' ),
			),
			600 => array(
				'type'    => 'select',
				'name'    => 'captions',
				'label'   => __( 'Caption style', 'obspgb' ),
				'default' => ttfobspgb_get_section_default( 'captions', 'gallery' ),
				'options' => ttfobspgb_get_section_choices( 'captions', 'gallery' ),
			),
			700 => array(
				'type'    => 'select',
				'name'    => 'caption-color',
				'label'   => __( 'Caption color', 'obspgb' ),
				'default' => ttfobspgb_get_section_default( 'caption-color', 'gallery' ),
				'options' => ttfobspgb_get_section_choices( 'caption-color', 'gallery' ),
			),
			800 => array(
				'type'  => 'divider',
				'label' => __( 'Background', 'obspgb' ),
				'name'  => 'divider-background',
				'class' => 'ttfobspgb-configuration-divider',
			),
			900 => array(
				'type'  => 'image',
				'name'  => 'background-image',
				'label' => __( 'Background image', 'obspgb' ),
				'class' => 'ttfobspgb-configuration-media',
				'default' => ttfobspgb_get_section_default( 'background-image', 'gallery' )
			),
			1000 => array(
				'type'  => 'select',
				'name'  => 'background-position',
				'label' => __( 'Position', 'obspgb' ),
				'class' => 'ttfobspgb-configuration-media-related',
				'default' => ttfobspgb_get_section_default( 'background-position', 'gallery' ),
				'options' => ttfobspgb_get_section_choices( 'background-position', 'gallery' ),
			),
			1100 => array(
				'type'    => 'select',
				'name'    => 'background-style',
				'label'   => __( 'Display', 'obspgb' ),
				'class'   => 'ttfobspgb-configuration-media-related',
				'default' => ttfobspgb_get_section_default( 'background-style', 'gallery' ),
				'options' => ttfobspgb_get_section_choices( 'background-style', 'gallery' ),
			),
			1200 => array(
				'type'    => 'checkbox',
				'label'   => __( 'Darken', 'obspgb' ),
				'name'    => 'darken',
				'default' => ttfobspgb_get_section_default( 'darken', 'gallery' ),
			),
			1300 => array(
				'type'    => 'color',
				'label'   => __( 'Background color', 'obspgb' ),
				'name'    => 'background-color',
				'class'   => 'ttfobspgb-gallery-background-color ttfobspgb-configuration-color-picker',
				'default' => ttfobspgb_get_section_default( 'background-color', 'gallery' )
			),
		);
	}

	public function get_item_settings() {
		/**
		 * Filter the definitions of the Gallery item configuration inputs.
		 *
		 * @since 1.0.0.
		 *
		 * @param array    $inputs    The input definition array.
		 */
		$inputs = apply_filters( 'obspgb_gallery_item_configuration', array(
			100 => array(
				'type'    => 'section_title',
				'name'    => 'title',
				'label'   => __( 'Enter item title', 'obspgb' ),
				'default' => ttfobspgb_get_section_default( 'title', 'gallery-item' ),
				'class'   => 'ttfobspgb-configuration-title',
			),
			200 => array(
				'type'    => 'text',
				'name'    => 'link',
				'label'   => __( 'Item link URL', 'obspgb' ),
				'default' => ttfobspgb_get_section_default( 'link', 'gallery-item' ),
			),
			300 => array(
				'type'    => 'checkbox',
				'name'    => 'open-new-tab',
				'label'   => __( 'Open link in a new tab', 'obspgb' ),
				'default' => ttfobspgb_get_section_default( 'open-new-tab', 'gallery-item' ),
			),
		) );

		// Sort the config in case 3rd party code added another input
		ksort( $inputs, SORT_NUMERIC );

		return $inputs;
	}

	/**
	 * Define settings for this section
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter obspgb_sections_settings
	 *
	 * @param array $settings   The existing array of section settings.
	 *
	 * @return array             The modified array of section settings.
	 */
	public function section_settings( $settings ) {
		$settings['gallery'] = $this->get_settings();
		$settings['gallery-item'] = $this->get_item_settings();

		return $settings;
	}

	/**
	 * Add new section choices.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter obspgb_section_choices
	 *
	 * @param array  $choices         The existing choices.
	 * @param string $key             The key for the section setting.
	 * @param string $section_type    The section type.
	 *
	 * @return array                  The choices for the particular section_type / key combo.
	 */
	public function section_choices( $choices, $key, $section_type ) {
		if ( count( $choices ) > 1 || ! in_array( $section_type, array( 'gallery' ) ) ) {
			return $choices;
		}

		$choice_id = "$section_type-$key";

		switch ( $choice_id ) {
			case 'gallery-columns':
				$choices = array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
				);
				break;

			case 'gallery-aspect' :
				$choices = array(
					'square' => __( 'Square', 'obspgb' ),
					'landscape' => __( 'Landscape', 'obspgb' ),
					'portrait' => __( 'Portrait', 'obspgb' ),
					'none' => __( 'None', 'obspgb' ),
				);
				break;

			case 'gallery-captions':
				$choices = array(
					'reveal' => __( 'Reveal', 'obspgb' ),
					'overlay' => __( 'Overlay', 'obspgb' ),
					'none' => __( 'None', 'obspgb' ),
				);
				break;

			case 'gallery-caption-color' :
				$choices = array(
					'light' => __( 'Light', 'obspgb' ),
					'dark' => __( 'Dark', 'obspgb' ),
				);
				break;

			case 'gallery-background-position' :
				$choices = array(
					'center-top'  => __( 'Top', 'obspgb' ),
					'center-center' => __( 'Center', 'obspgb' ),
					'center-bottom' => __( 'Bottom', 'obspgb' ),
					'left-center'  => __( 'Left', 'obspgb' ),
					'right-center' => __( 'Right', 'obspgb' )
				);
				break;

			case 'gallery-background-style' :
				$choices = array(
					'tile'  => __( 'Tile', 'obspgb' ),
					'cover' => __( 'Cover', 'obspgb' ),
					'contain' => __( 'Contain', 'obspgb' ),
				);
				break;
		}

		return $choices;
	}

	/**
	 * Get default values for gallery section
	 *
	 * @since 1.0.0.
	 *
	 * @return array
	 */
	public function get_defaults() {
		return array(
			'section-type' => 'gallery',
			'title' => '',
			'state' => 'open',
			'columns' => 3,
			'aspect' => 'square',
			'captions' => 'reveal',
			'caption-color' => 'light',
			'background-image' => '',
			'background-position' => 'center-center',
			'darken' => 0,
			'background-style' => 'cover',
			'background-color' => '',
		);
	}

	/**
	 * Get default values for gallery item
	 *
	 * @since 1.0.0.
	 *
	 * @return array
	 */
	public function get_item_defaults() {
		return array(
			'section-type' => 'gallery-item',
			'title' => '',
			'link' => '',
			'description' => '',
			'content' => '',
			'background-image' => '',
			'open-new-tab' => 0
		);
	}

	/**
	 * Extract the setting defaults and add them to Obspgb's section defaults system.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter obspgb_sections_defaults
	 *
	 * @param array $defaults    The existing array of section defaults.
	 *
	 * @return array             The modified array of section defaults.
	 */
	public function section_defaults( $defaults ) {
		$defaults['gallery'] = $this->get_defaults();
		$defaults['gallery-item'] = $this->get_item_defaults();

		return $defaults;
	}

	/**
	 * Filter the json representation of this section.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter obspgb_get_section_json
	 *
	 * @param array $defaults    The array of data for this section.
	 *
	 * @return array             The modified array to be jsonified.
	 */
	public function get_section_json( $data ) {
		if ( $data['section-type'] == 'gallery' ) {
			$data = wp_parse_args( $data, $this->get_defaults() );
			$image = ttfobspgb_get_image_src( $data['background-image'], 'large' );

			if ( isset( $image[0] ) ) {
				$data['background-image-url'] = $image[0];
			} else {
				$data['background-image'] = '';
			}

			if ( isset( $data['gallery-items'] ) && is_array( $data['gallery-items'] ) ) {
				foreach ( $data['gallery-items'] as $s => $item ) {
					$item = wp_parse_args( $item, $this->get_item_defaults() );

					// Handle legacy data layout
					$id = isset( $item['id'] ) ? $item['id']: $s;
					$item['id'] = $id;

					if ( isset( $item['image-id'] ) && '' !== $item['image-id'] ) {
						$item['background-image'] = $item['image-id'];
					}

					$item_image = ttfobspgb_get_image_src( $item['background-image'], 'large' );

					if( isset( $item_image[0] ) ) {
						$item['background-image-url'] = $item_image[0];
					} else {
						$item['background-image'] = '';
					}

					$data['gallery-items'][$s] = $item;
				}

				if ( isset( $data['gallery-item-order'] ) ) {
					$ordered_items = array();

					foreach ( $data['gallery-item-order'] as $item_id ) {
						array_push( $ordered_items, $data['gallery-items'][$item_id] );
					}

					$data['gallery-items'] = $ordered_items;
					unset( $data['gallery-item-order'] );
				}
			}
		}

		return $data;
	}

	/**
	 * Save the data for the section.
	 *
	 * @param  array    $data    The data from the $_POST array for the section.
	 * @return array             The cleaned data.
	 */
	public function save( $data ) {
		$data = wp_parse_args( $data, $this->get_defaults() );
		$clean_data = array(
			'id' => $data['id'],
			'section-type' => $data['section-type'],
			'state' => $data['state'],
		);

		if ( isset( $data['columns'] ) ) {
			$clean_data['columns'] = ttfobspgb_sanitize_section_choice( $data['columns'], 'columns', $data['section-type'] );
		}

		if ( isset( $data['caption-color'] ) ) {
			$clean_data['caption-color'] = ttfobspgb_sanitize_section_choice( $data['caption-color'], 'caption-color', $data['section-type'] );
		}

		if ( isset( $data['captions'] ) ) {
			$clean_data['captions'] = ttfobspgb_sanitize_section_choice( $data['captions'], 'captions', $data['section-type'] );
		}

		if ( isset( $data['aspect'] ) ) {
			$clean_data['aspect'] = ttfobspgb_sanitize_section_choice( $data['aspect'], 'aspect', $data['section-type'] );
		}

		if ( isset( $data['background-image'] ) && '' !== $data['background-image'] ) {
			$clean_data['background-image'] = ttfobspgb_sanitize_image_id( $data['background-image'] );
		} else {
			$clean_data['background-image'] = '';
		}

		if ( isset( $data['background-image-url'] ) && '' !== $data['background-image-url'] ) {
			$clean_data['background-image-url'] = esc_url_raw( $data['background-image-url'] );
		}

		if ( isset( $data['title'] ) ) {
			$clean_data['title'] = $clean_data['label'] = apply_filters( 'title_save_pre', $data['title'] );
		}

		if ( isset( $data['darken'] ) && 1 === absint( $data['darken'] ) ) {
			$clean_data['darken'] = 1;
		} else {
			$clean_data['darken'] = 0;
		}

		if ( isset( $data['background-color'] ) ) {
			$clean_data['background-color'] = maybe_hash_hex_color( $data['background-color'] );
		}

		if ( isset( $data['background-style'] ) ) {
			$clean_data['background-style'] = ttfobspgb_sanitize_section_choice( $data['background-style'], 'background-style', $data['section-type'] );
		}

		if ( isset( $data['background-position'] ) ) {
			$clean_data['background-position'] = ttfobspgb_sanitize_section_choice( $data['background-position'], 'background-position', $data['section-type'] );
		}

		if ( isset( $data['gallery-items'] ) && is_array( $data['gallery-items'] ) ) {
			$clean_data['gallery-items'] = array();

			foreach ( $data['gallery-items'] as $i => $item ) {
				$item = wp_parse_args( $item, $this->get_item_defaults() );

				// Handle legacy data layout
				$id = isset( $item['id'] ) ? sanitize_title_with_dashes( $item['id'] ): $i;

				$clean_item_data = array(
					'id' => $id,
					'section-type' => sanitize_title_with_dashes( $item['section-type'] ),
				);

				if ( isset( $item['title'] ) ) {
					$clean_item_data['title'] = apply_filters( 'title_save_pre', $item['title'] );
				}

				if ( isset( $item['link'] ) ) {
					$clean_item_data['link'] = esc_url_raw( $item['link'] );
				}

				if ( isset( $item['description'] ) ) {
					$clean_item_data['description'] = sanitize_post_field( 'post_content', $item['description'], ( get_post() ) ? get_the_ID() : 0, 'db' );
				}

				if ( isset( $item['background-image'] ) ) {
					$clean_item_data['background-image'] = ttfobspgb_sanitize_image_id( $item['background-image'] );
				}

				if ( isset( $item['background-image'] ) && '' !== $item['background-image'] ) {
					$clean_item_data['background-image'] = ttfobspgb_sanitize_image_id( $item['background-image'] );
				} else {
					$clean_item_data['background-image'] = '';
				}

				if ( isset( $item['background-image-url'] ) && '' !== $item['background-image-url'] ) {
					$clean_item_data['background-image-url'] = esc_url_raw( $item['background-image-url'] );
				} else {
					$clean_item_data['background-image-url'] = '';
				}

				if ( isset( $item['open-new-tab'] ) && 1 === absint( $item['open-new-tab'] ) ) {
					$clean_item_data['open-new-tab'] = 1;
				} else {
					$clean_item_data['open-new-tab'] = 0;
				}

				array_push( $clean_data['gallery-items'], $clean_item_data );
			}
		}

		return $clean_data;
	}

	public function admin_enqueue_scripts( $hook_suffix ) {
		// Only load resources if they are needed on the current page
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) || ! ttfobspgb_post_type_supports_builder( get_post_type() ) ) {
			return;
		}

		/**
		 * Filter any available extensions for the Obspgb builder JS.
		 *
		 * @since 1.0.0.
		 *
		 * @param array    $dependencies    The list of dependencies.
		 */
		$dependencies = apply_filters( 'obspgb_builder_js_extensions', array(
			'ttfobspgb-builder', 'ttfobspgb-builder-overlay'
		) );

		wp_enqueue_script(
			'builder-section-gallery',
			obspgb_get_plugin_directory_uri() . 'js/builder/sections/gallery.js',
			$dependencies,
			TTFOBSPGB_VERSION,
			true
		);
	}

	public function print_templates() {
		global $hook_suffix, $typenow, $ttfobspgb_section_data;

		// Only show when adding/editing pages
		if ( ! ttfobspgb_post_type_supports_builder( $typenow ) || ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )) {
			return;
		}

		$section_definitions = ttfobspgb_get_sections();
		$ttfobspgb_section_data = $section_definitions[ 'gallery' ];
		?>
		<script type="text/template" id="tmpl-ttfobspgb-section-gallery">
		<?php require_once( obspgb_get_plugin_directory() . '/inc/sections/gallery/builder-template.php' ); ?>
		</script>
		<?php $ttfobspgb_section_data = array(); ?>
		<script type="text/template" id="tmpl-ttfobspgb-section-gallery-item">
		<?php require_once( obspgb_get_plugin_directory() . '/inc/sections/gallery/builder-template-item.php' ); ?>
		</script>
		<?php
	}

	public function html_class( $classes, $section_data, $sections ) {
		if ( 'gallery' === $section_data['section-type'] ) {
			// Columns
			$gallery_columns = ( isset( $section_data['columns'] ) ) ? absint( $section_data['columns'] ) : 1;
			$classes  .= ' builder-gallery-columns-' . $gallery_columns;

			// Captions
			if ( isset( $section_data['captions'] ) && ! empty( $section_data['captions'] ) ) {
				$classes .= ' builder-gallery-captions-' . esc_attr( $section_data['captions'] );
			}

			// Caption color
			if ( isset( $section_data['caption-color'] ) && ! empty( $section_data['caption-color'] ) ) {
				$classes .= ' builder-gallery-captions-' . esc_attr( $section_data['caption-color'] );
			}

			// Aspect Ratio
			if ( isset( $section_data['aspect'] ) && ! empty( $section_data['aspect'] ) ) {
				$classes .= ' builder-gallery-aspect-' . esc_attr( $section_data['aspect'] );
			}

			/**
			 * Filter the class applied to a gallery.
			 *
			 * @since 1.0.0.
			 *
			 * @param string    $gallery_class           The class applied to the gallery.
			 * @param array     $section_data            The section data.
			 * @param array     $sections                The list of sections.
			 */
			$classes = apply_filters( 'obspgb_gallery_class', $classes, $section_data, $sections );
		}

		return $classes;
	}

	public function html_style( $style, $section_data, $sections ) {
		if ( 'gallery' === $section_data['section-type'] ) {
			/**
			 * Filter the style added to a gallery section.
			 *
			 * @since 1.0.0.
			 *
			 * @param string    $gallery_style           The style applied to the gallery.
			 * @param array     $ttfobspgb_section_data    The section data.
			 */
			$style = apply_filters( 'obspgb_builder_get_gallery_style', $style, $section_data );
		}

		return $style;
	}

	public function item_html_class( $classes, $item, $section_data ) {
		if ( 'gallery-item' === $item['section-type'] ) {
			// Index
			$i = 0;

			while ( $section_data['gallery-items'][$i]['id'] !== $item['id'] ) {
				$i ++;
			}

			// Link
			$has_link = ( isset( $item['link'] ) && ! empty( $item['link'] ) ) ? true : false;

			if ( true === $has_link ) {
				$classes .= ' has-link';
			}

			// Columns
			$gallery_columns = ( isset( $section_data['columns'] ) ) ? absint( $section_data['columns'] ) : 1;

			if ( $gallery_columns > 1 && $i > 0 && 0 === ( $i + 1 ) % $gallery_columns ) {
				$classes .= ' last-' . $gallery_columns;
			}

			/**
			 * Filter the class used for a gallery item.
			 *
			 * @since 1.0.0.
			 *
			 * @param string    $classes                 The computed gallery class.
			 * @param array     $item                    The item's data.
			 * @param array     $section_data            The section data.
			 * @param int       $i                       The current gallery item number.
			 */
			$classes = apply_filters( 'obspgb_builder_get_gallery_item_class', $classes, $item, $section_data, $i );
		}

		return $classes;
	}
}
endif;

/**
 * MISSING DOCS
 */
function ttfobspgb_builder_get_gallery_item_onclick( $item ) {
	$link = $item['link'];

	if ( '' === $link ) {
		return '';
	}

	$external = isset( $item['open-new-tab'] ) && $item['open-new-tab'] === 1;
	$url = esc_js( esc_url( $link ) );
	$open_function = $external ? 'window.open(\'' . $url . '\')': 'window.location.href = \'' . $url . '\'';
	$onclick = ' onclick="event.preventDefault(); '. $open_function . ';"';

	/**
	 * Filter the class used for a gallery item.
	 *
	 * @since 1.0.0.
	 *
	 * @param string    $onclick                 The computed gallery onclick attribute.
	 * @param string    $link                    The item.
	 */
	return apply_filters( 'obspgb_builder_get_gallery_item_onclick', $onclick, $item );
}

/**
 * Get the image for the gallery item.
 *
 * @since 1.0.0.
 *
 * @param  array     $item      The item's data.
 * @param  string    $aspect    The aspect ratio for the section.
 * @return string               The HTML or CSS for the item's image.
 */
function ttfobspgb_builder_get_gallery_item_image( $item ) {
	global $ttfobspgb_section_data;

	$image = '';
	$aspect = $ttfobspgb_section_data['aspect'];

	if ( 0 !== ttfobspgb_sanitize_image_id( $item[ 'background-image' ] ) ) {
		$image_style = '';
		$image_src = ttfobspgb_get_image_src( $item[ 'background-image' ], 'large' );
		if ( isset( $image_src[0] ) ) {
			$image_style .= 'background-image: url(\'' . addcslashes( esc_url_raw( $image_src[0] ), '"' ) . '\');';
		}
		if ( 'none' === $aspect && isset( $image_src[1] ) && isset( $image_src[2] ) ) {
			$image_ratio = ( $image_src[2] / $image_src[1] ) * 100;
			$image_style .= 'padding-bottom: ' . $image_ratio . '%;';
		}
		if ( '' !== $image_style ) {
			$image .= '<figure class="builder-gallery-image" style="' . esc_attr( $image_style ) . '"></figure>';
		}
	}

	/**
	 * Alter the generated gallery image.
	 *
	 * @since 1.0.0.
	 *
	 * @param string    $image     The image HTML.
	 * @param array     $item      The item's data.
	 * @param string    $aspect    The aspect ratio for the section.
	 */
	return apply_filters( 'obspgb_builder_get_gallery_item_image', $image, $item, $aspect );
}
