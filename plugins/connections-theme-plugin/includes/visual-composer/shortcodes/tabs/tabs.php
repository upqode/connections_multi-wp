<?php if( ! defined( 'ABSPATH' ) ) exit;
/*
* Element Description: Connections Tabs
*/

class CN_Tabs extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug             = 'cn_tabs';
        $this->title            = esc_html__( 'Tabs', 'connection' );
        $this->description      = esc_html__( 'Tabs content', 'connection' );
        $this->is_container     = true;
        $this->content_element  = true;
        $this->show_settings_on_create = false;
        $this->as_parent = array ( 'only' => 'cn_tabs_item' );

        parent::__construct();
    }

    public function get_params() {

        $this->params = array(
            array(
                'heading' 	  => esc_html__( 'Background Color Tab', 'connection' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'bg_color_tab',
                'value' 	  => cn_get_bg_vc_colors( 'title' ),
            ),
            array(
                'heading' 	  => esc_html__( 'Background Color Active Tab', 'connection' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'bg_color_tab_active',
                'value' 	  => cn_get_bg_vc_colors( 'title' ),
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

new CN_Tabs();
class WPBakeryShortCode_CN_Tabs extends WPBakeryShortCodesContainer {}

// Tabs Item
include_once 'tabs-item.php';