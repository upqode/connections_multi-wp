<?php if( ! defined( 'ABSPATH' ) ) exit;
/*
* Element Description: Connections Landing
*/

class CN_Landing extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug             = 'cn_landing';
        $this->title            = esc_html__( 'Landing', 'connection' );
        $this->description      = esc_html__( 'Landing content', 'connection' );
        $this->is_container     = true;
        $this->content_element  = true;
        $this->show_settings_on_create = false;
        $this->as_parent = array ( 'only' => 'cn_landing_item' );

        parent::__construct();
    }

    public function get_params() {

        $this->params = array(
			array(
				'heading'     => esc_html__( 'Image Top Background', 'connections' ),
				'type'        => 'attach_image',
				'param_name'  => 'image_top',
			),
			array(
				'heading'     => esc_html__( 'Image Bottom Background', 'connections' ),
				'type'        => 'attach_image',
				'param_name'  => 'image_bottom',
			),
			array(
				'heading'     => esc_html__( 'Image Logo', 'connections' ),
				'type'        => 'attach_image',
				'param_name'  => 'image_logo',
			),
			array(
				'heading'     => esc_html__( 'Title Select', 'connections' ),
				'type'        => 'textfield',
				'param_name'  => 'title_select',
			),
			array(
				'heading'     => esc_html__( 'Button 1', 'connections' ),
				'type'        => 'vc_link',
				'param_name'  => 'btn_link_first',
			),
			array(
				'heading'     => esc_html__( 'Button 2', 'connections' ),
				'type'        => 'vc_link',
				'param_name'  => 'btn_link_second',
			),
			array(
				'heading'     => esc_html__( 'Button background color', 'connections' ),
				'type'        => 'dropdown',
				'param_name'  => 'btn_bg_color',
				'value'       => cn_get_bg_vc_colors( 'title' ),
			),
			array(
				'heading'     => esc_html__( 'Button border color', 'connections' ),
				'type'        => 'dropdown',
				'param_name'  => 'btn_b_color',
				'value'       => cn_get_border_vc_colors( 'title' ),
			),
			array(
				'heading'     => esc_html__( 'Button text color', 'connections' ),
				'type'        => 'dropdown',
				'param_name'  => 'btn_text_color',
				'value'       => cn_get_heading_vc_colors( 'title' ),
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

        global $creon_items;

        $creon_items = array();

        do_shortcode( $content );

        $atts['items'] = $creon_items;

        return $atts;
    }

}

new CN_Landing();
class WPBakeryShortCode_CN_Landing extends WPBakeryShortCodesContainer {}

// Landing Item
include_once 'landing-item.php';