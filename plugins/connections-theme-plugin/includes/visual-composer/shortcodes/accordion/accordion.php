<?php if( ! defined( 'ABSPATH' ) ) exit;
/*
* Element Description: Connection Accordion
*/

class CN_Accordion extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug        = 'cn_accordion';
        $this->title       = esc_html__( 'Drawer', 'connections' );
        $this->description = esc_html__( 'Drawer content', 'connections' );
        $this->is_container  = true;
        $this->content_element  = true;
        $this->show_settings_on_create = false;
        $this->as_parent = array ( 'only' => 'cn_accordion_item' );

        parent::__construct();
    }

    public function get_params() {

        $this->params = array(
            array(
                'heading' 	  => esc_html__( 'Background Color', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'row_bg',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),
            array(
                'heading' 	  => esc_html__( 'Drawer Background color', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'bg_drawer_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),
            array(
                'heading' 	  => esc_html__( 'Drawer Background tite color', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'bg_drawer_title_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),

        );

        /* Add responsive options to shortcode */
        $responsive_options = cn_create_responsive_retreats();
        if ( ! empty( $responsive_options ) ) {
            $this->params = array_merge( $this->params, $responsive_options );
        }

        $this->add_extras();

    }

    public function before_output( $atts, &$content ) {

        global $cn_items;

        $cn_items = array();

        do_shortcode( $content );

        $atts['items'] = $cn_items;

        return $atts;
    }

}

new CN_Accordion();
class WPBakeryShortCode_CN_Accordion extends WPBakeryShortCodesContainer {}

// Accordion Item
include_once 'accordion-item.php';