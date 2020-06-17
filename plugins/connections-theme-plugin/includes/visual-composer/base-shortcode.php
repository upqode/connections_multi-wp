<?php
/**
 * Connections Shortcode Base
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'CN_Base_Shortcode' ) ) :

    class CN_Base_Shortcode extends WPBakeryShortCode {

        /**
         * Shortcode slug.
         * @var string
         */
        public $slug = '';

        /**
         * Title shortcode.
         * @var string
         */
        public $title = '';

        /**
         * List of shortcode attributes. Array which holds your shortcode params, these params will be editable in shortcode settings page.
         * @var array
         */
        public $params = array();

        /**
         * Category which best suites to describe functionality of this shortcode.
         * @var string
         */
        public $category = null;

        public function __construct() {
            // validate
            if( ! isset( $this->slug ) && empty( $this->slug ) ) {
                wp_die( esc_html__( 'Please define slug', 'connections' ), esc_html__( 'Variable Missing', 'connections' ) );
            }

            // Add shortcode
            if ( ! shortcode_exists( $this->slug ) ) {
                add_shortcode( $this->slug, array( &$this, 'render' ) );
            }

            // Prepare shortcode data
            $this->get_params();

            // Prepare VC data
            $this->set_config();

            // Map shortcode to VC
            vc_map( $this->settings );

            add_action( 'connection_shortcodes_styles', array( $this, 'enqueue_styles' ) );
            add_action( 'connection_shortcodes_styles', array( $this, 'enqueue_scripts' ) );
        }

        /**
         * Set config.
         */
        protected function set_config() {

            $keys = array(
                'description', 'icon', 'is_container', 'js_view', 'php_class_name', 'content_element', 'show_settings_on_create', 'custom_markup', 'deprecated',
                'default_content', 'allowed_container_element', 'admin_enqueue_js', 'as_parent', 'as_child'
            );

            // Required
            $shortcode = array(
                'base'     => $this->slug,
                'name'     => $this->title,
                'params'   => $this->params,
                'category' => ( ! empty( $this->category ) ) ? $this->category : esc_html__( 'Connections', 'connections' )
            );

            foreach( $keys as $key ) {
                switch( $key ) {
                    case 'is_container' :

                        if ( ! empty( $this->is_container ) ) {
                            $shortcode['is_container'] = $this->is_container;
                            $shortcode['js_view'] = 'VcColumnView';
                        } else {
                            $shortcode['php_class_name'] = get_class( $this );
                        }
                        break;

                    default :
                        if ( ! empty( $this->{$key} ) ) {
                            $shortcode[ $key ] = $this->{$key};
                        }
                        break;
                }
            }

            $this->settings = $shortcode;
            $this->shortcode = $this->settings['base'];
        }

        /**
         * Get params.
         */
        public function get_params() {}

        /**
         * Enqueue styles.
         */
        public function enqueue_styles() {

            if ( empty( $this->enqueue_styles ) ) {
                return;
            }

            global $post;

            if ( ! is_404() && ! is_search() && ! is_archive() && has_shortcode( $post->post_content, $this->slug ) ) {
                foreach( (array)$this->enqueue_styles as $handle ) {
                    wp_enqueue_style( $handle );
                }
            }
        }

        /**
         * Enqueue scripts.
         */
        public function enqueue_scripts( $args = array() ) {

            if ( empty( $this->enqueue_scripts ) ) {
                return;
            }

            if ( ! empty( $args ) ) {
                foreach( (array)$this->enqueue_scripts as $handle ) {
                    if( in_array( $handle, $args ) ) {
                        wp_enqueue_script( $handle );
                    }
                }
            } else {
                foreach( (array)$this->enqueue_scripts as $handle ) {
                    wp_enqueue_script( $handle );
                }
            }
        }

        /**
         * Output html.
         */
        public function render( $atts, $content = '' ) {

            $atts = $this->prepareAtts( $atts );
            $atts = vc_map_get_attributes( $this->slug, $atts );
            $atts = $this->before_output( $atts, $content );
            $atts['_id'] = uniqid( $this->slug .'_' );

            // Locate template file
            $located = $this->locate_template( $atts );

            // If no file throw error
            if ( ! $located ) {
                trigger_error( sprintf( esc_html__( 'Template file is missing for `%s` shortcode. Make sure you have `%s` file in your theme folder or default folder.', 'connections' ), $this->title, 'view.php' ) );
                return;
            }

            $this->atts = $atts;
            $this->atts['content'] = $content;

            // Generate Output
            ob_start();

            include $located;

            return ob_get_clean();
        }

        /**
         * Before output html.
         */
        public function before_output( $atts, &$content ) {
            return $atts;
        }

        /**
         * Locate the shortcode view file.
         */
        private function locate_template( $atts ) {

            $located = $template_name = false;

            // Check in shortcode directory
            if ( ! $located ) {
                $template_name = false;
                $path = $this->get_shortcode_dir();

                if ( isset( $atts['template'] ) && ! empty( $atts['template'] ) ) {
                    $template_name = "view/templates/{$atts['template']}.php";
                }

                if ( $template_name && file_exists( $path . $template_name ) ) {
                    $located = $path . $template_name;
                } elseif ( file_exists( $path . 'view/view.php' ) ) {
                    $located = $path . 'view/view.php';
                }
            }

            return $located;
        }

        // Build the string of values in an Array
        protected function get_fonts_data( $fontsString ) {

            // Font data Extraction
            $googleFontsParam = new Vc_Google_Fonts();
            $fieldSettings = array();
            $fontsData = strlen( $fontsString ) > 0 ? $googleFontsParam->_vc_google_fonts_parse_attributes( $fieldSettings, $fontsString ) : '';
            return $fontsData;

        }

        // Build the inline style starting from the data
        protected function google_fonts_style( $fontsData ) {

            // Inline styles
            $fontFamily = explode( ':', $fontsData['values']['font_family'] );
            $styles['font-family'] = $fontFamily[0] . '!important';
            $fontStyles = explode( ':', $fontsData['values']['font_style'] );
            $styles['font-weight'] = $fontStyles[1] . '!important';
            $styles['font-style'] = $fontStyles[2] . '!important';

            /*
                $inline_style = '';
                foreach( $styles as $attribute ){
                    $inline_style .= $attribute.'; ';
                }
            */

            return $styles;

        }

        // Enqueue right google font from Googleapis
        protected function enqueue_google_fonts( $fontsData ) {

            // Get extra subsets for settings (latin/cyrillic/etc)
            $settings = get_option( 'wpb_js_google_fonts_subsets' );
            if ( is_array( $settings ) && ! empty( $settings ) ) {
                $subsets = '&subset=' . implode( ',', $settings );
            } else {
                $subsets = '';
            }

            // We also need to enqueue font from googleapis
            if ( isset( $fontsData['values']['font_family'] ) ) {
                wp_enqueue_style(
                    'vc_google_fonts_' . vc_build_safe_css_class( $fontsData['values']['font_family'] ),
                    '//fonts.googleapis.com/css?family=' . $fontsData['values']['font_family'] . $subsets
                );
            }

        }

        /**
         * Extract params.
         */
        public function add_extras() {
            $this->params = array_merge( $this->params, array(
                array(
                    'type'        => 'textfield',
                    'param_name'  => 'el_id',
                    'heading'     => esc_html__( 'Element ID', 'connections' ),
                    'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add unique id and then refer to it in your css file.', 'connections' ),
                    'group'       => esc_html__( 'Extras', 'connections' )
                ),
                array(
                    'type'        => 'textfield',
                    'param_name'  => 'el_class',
                    'heading'     => esc_html__( 'Extra class name', 'connections' ),
                    'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'connections' ),
                    'group'       => esc_html__( 'Extras', 'connections' )
                )
            ));
        }

        /**
         * Get id.
         */
        protected function get_id( $atts = array(), $custom = true ) {

            $atts = empty( $atts ) ? $this->atts : $atts;

            if( !empty( $atts['el_id'] ) ) {
                return $atts['el_id'];
            }

            if( $custom && !empty( $atts['_id'] ) ) {
                return $atts['_id'];
            }
        }

        /**
         * Get animation.
         */
        protected function get_animation() {

            $output = '';
            $css_animation = $this->atts['css_animation'];
            if ( '' !== $css_animation && 'none' !== $css_animation ) {
                wp_enqueue_script( 'waypoints' );
                wp_enqueue_style( 'animate-css' );
                $output = ' wpb_animate_when_almost_visible wpb_' . $css_animation . ' ' . $css_animation;
            }

            return $output;
        }

        /**
         * Get shortcode URL.
         */
        protected function get_shortcode_url() {
            return plugins_url('', __FILE__);
        }

        /**
         * Get shortcode dir path.
         */
        protected function get_shortcode_dir() {
            $dir_path = new ReflectionClass( get_class( $this ) );
            return trailingslashit( dirname( $dir_path->getFilename() ) );
        }
    }

endif;