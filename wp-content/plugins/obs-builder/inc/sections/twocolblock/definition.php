<?php
/**
 * @package Obspgb Builder
 */
if ( ! class_exists( 'OBSPGB_Sections_twocolblock_Definition' ) ) :
    class OBSPGB_Sections_twocolblock_Definition{
        /**
        * The one instance of OBSPGB_Sections_twocolblock_Definition.
        *
        * @var   OBSPGB_Sections_twocolblock_Definition
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
                //add_filter( 'obspgb_get_section_json', array( $this, 'embed_column_images' ), 20, 1 );
                add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 20 );
                add_action( 'admin_footer', array( $this, 'print_templates' ) );
            }
            else{
                add_action( 'obspgb_builder_twocolblock_css', array( $this, 'style_rules' ), 10, 3 );
            }
            
            ttfobspgb_add_section(
                'twocolblock',
                __( 'Two blocks', 'obspgb' ),
                '',
                __( 'Display two vol block content either image or text block.', 'obspgb' ),
                array( $this, 'save' ),
                array(
                    'twoblock' => 'sections/twocolblock/builder-template',
                    'twoblock-item' => 'sections/twocolblock/builder-template-twoblock'
                ),
                'sections/twocolblock/frontend-template',
                300,
                get_template_directory() . '/inc/builder/'
            );
        }
    }
endif;

