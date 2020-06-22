<?php if( ! defined( 'ABSPATH' ) ) exit;
/*
* Element Description: Connections Featured Links
*/

class CN_Featured_Links extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug             = 'cn_featured_links';
        $this->title            = esc_html__( 'Featured Links', 'connections' );
        $this->description      = esc_html__( 'Featured Links content', 'connections' );
        $this->is_container     = true;
        $this->content_element  = true;
        $this->show_settings_on_create = false;
        $this->as_parent        = array ( 'only' => 'cn_featured_links_item, vc_column_text' );

        parent::__construct();
    }

    public function get_params() {

        $this->params = array(

            array(
                'heading' 	  => esc_html__( 'Background type', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'bg_type',
                'value' 	  => array(
                    esc_html__( 'Image', 'connections' ) => 'image',
                    esc_html__( 'Color', 'connections' ) => 'color',
                )
            ),

            array(
                'heading'     => esc_html__( 'Image', 'connections' ),
                'type'        => 'attach_image',
                'param_name'  => 'bg_img',
                'dependency'  => array(
                    'element'   => 'bg_type',
                    'value'     => 'image',
                )
            ),

            array(
                'heading'     => esc_html__( 'Background color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'bg_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
                'dependency'  => array(
                    'element'   => 'bg_type',
                    'value'     => 'color',
                ),
            ),

	        array(
		        'heading'     => esc_html__( 'Title', 'connections' ),
		        'type'        => 'textfield',
		        'param_name'  => 'title',
		        'admin_label' => false,
	        ),
	        array(
		        'heading'     => esc_html__( 'Title Color', 'connections' ),
		        'type'        => 'dropdown',
		        'param_name'  => 'title_color',
		        'value'       => cn_get_heading_vc_colors( 'title' ),
            ),
	        
            array(
                'type'        => 'checkbox',
                'heading'     => esc_html__( 'Underline title', 'js_composer' ),
                'param_name'  => 'underline_title',
            ),
            array(
		        'heading'     => esc_html__( 'Underline Color', 'connections' ),
		        'type'        => 'dropdown',
		        'param_name'  => 'underline_color',
                'value'       => cn_get_border_vc_colors( 'title' ),
                'dependency'  => array( 
                    'element'   => 'underline_title', 
                    'value'     => 'true', 
                ),
            ),
            
	        array(
		        'heading'     => esc_html__( 'Subtitle', 'connections' ),
		        'type'        => 'textfield',
		        'param_name'  => 'subtitle',
		        'admin_label' => false,
            ),
	        array(
		        'heading'     => esc_html__( 'Subtitle Color', 'connections' ),
		        'type'        => 'dropdown',
		        'param_name'  => 'subtitle_color',
		        'value'       => cn_get_heading_vc_colors( 'title' ),
            ),
            
			array(
                'heading'     => esc_html__( 'Column', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'column',
                'value'       => array(
                    esc_html__( '1', 'connections' ) => '1',
                    esc_html__( '2', 'connections' ) => '2',
                    esc_html__( '3', 'connections' ) => '3',
                    esc_html__( '4', 'connections' ) => '4',
                ),
            ),

        );

        $this->add_extras();

        /* Add responsive options to shortcode */
        $responsive_options = cn_create_responsive_retreats();
        if ( ! empty( $responsive_options ) ) {
            $this->params = array_merge( $this->params, $responsive_options );
        }

    }

    public function before_output( $atts, &$content ) {

        global $cn_items;

        $cn_items = array();

        do_shortcode( $content );

        $atts['items'] = $cn_items;

        return $atts;
    }

}

new CN_Featured_Links();
class WPBakeryShortCode_CN_Featured_Links extends WPBakeryShortCodesContainer {}

// Featured Links Item
include_once 'featured-links-item.php';

// TO DO DELETE
// include_once 'featured-links-text.php';