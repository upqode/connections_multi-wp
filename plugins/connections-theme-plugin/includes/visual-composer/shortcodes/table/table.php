<?php if( ! defined( 'ABSPATH' ) ) exit;
/*
* Element Description: Connections Table
*/

class CN_Table extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug        = 'cn_table';
        $this->title       = esc_html__( 'Table', 'connections' );
        $this->description = esc_html__( 'Table content', 'connections' );
        $this->is_container = true;
        $this->content_element = true;
        $this->show_settings_on_create = false;
        $this->as_parent   = array( 'only' => 'vc_table, vc_column_text' );

        parent::__construct();
    }

    public function get_params() {

        $this->params = array(
            array(
                'heading' 	  => esc_html__( 'Background Color', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'bg_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),

            array(
                'heading'     => esc_html__( 'Title', 'connections' ),
                'type'        => 'textarea',
                'param_name'  => 'title',
                'admin_label' => false,
            ),

            array(
                'heading' 	  => esc_html__( 'Title Color', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'title_color',
                'value'       => cn_get_heading_vc_colors( 'title' ),
            ),
            array(
                'heading' 	  => esc_html__( 'Title Tag', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'title_tag',
                'value' 	  => array(
                    esc_html__( 'H1', 'connections' ) => 'h1',
                    esc_html__( 'H2', 'connections' ) => 'h2',
                    esc_html__( 'H3', 'connections' ) => 'h3',
                    esc_html__( 'H4', 'connections' ) => 'h4',
                    esc_html__( 'H5', 'connections' ) => 'h5',
                    esc_html__( 'H6', 'connections' ) => 'h6',
                )
            ),
            array(
                'heading'     => esc_html__( 'Title underline', 'connections' ),
                'type'        => 'checkbox',
                'param_name'  => 'title_underline',
            ),

            array(
                'heading' 	  => esc_html__( 'Link', 'connections' ),
                'type' 		  => 'vc_link',
                'param_name'  => 'link',
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
        return $atts;
    }

}

new CN_Table();
class WPBakeryShortCode_CN_Table extends WPBakeryShortCodesContainer {}
