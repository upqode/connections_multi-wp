<?php 
/*
* Element Description: Banner
*/

class CN_Banner extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug        = 'cn-banner';
        $this->title       = esc_html__( 'Banner', 'connections' );
        $this->description = esc_html__( 'Banner block', 'connections' );

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
                // 'dependency'  => array(
                //     'element'   => 'bg_type',
                //     'value'     => 'image',
                // )
            ),

            array(
                'heading'     => esc_html__( 'Background color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'bg_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
                // 'dependency'  => array(
                //     'element'   => 'bg_type',
                //     'value'     => 'color',
                // ),
            ),

            array(
                'heading' 	  => esc_html__( 'Height banner', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'banner_height',
                'value' 	  => array(
                    esc_html__( '100%', 'connections' ) => '',
                    esc_html__( '50%', 'connections' ) => '50',
                    esc_html__( '33%', 'connections' ) => '33',
                    esc_html__( '25%', 'connections' ) => '25',
                )
            ),

            array(
                'heading'     => esc_html__( 'Overlay Image', 'connections' ),
                'type'        => 'attach_image',
                'param_name'  => 'overlay_img',
            ),

            array(
                'heading'     => esc_html__( 'Overlay opcaity', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'overlay_opacity',
            ),

            array(
                'heading'     => esc_html__( 'Title', 'connections' ),
                'type'        => 'textarea',
                'param_name'  => 'title',
            ),

            array(
                'heading'     => esc_html__( 'Title color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'title_color',
                'value'       => cn_get_heading_vc_colors( 'title' ),
            ),

            array(
                'heading'     => esc_html__( 'Subtitle', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'subtitle',
            ),

            array(
                'heading'     => esc_html__( 'Subtitle color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'subtitle_color',
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
}

new CN_Banner();