<?php 
/*
* Element Description: Connection Next/Back Links
*/

class CN_Next_Back_Links extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug        = 'cn-next-back-links';
        $this->title       = esc_html__( 'Next/Back Links', 'connections' );
        $this->description = esc_html__( 'Links', 'connections' );

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
                ),
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
                'heading'     => esc_html__( 'Prev Link', 'connections' ),
                'type'        => 'vc_link',
                'param_name'  => 'prev_link',
            ),
            array(
                'heading'     => esc_html__( 'Prev Subtitle', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'prev_subtitle',
            ),
            array(
                'heading'     => esc_html__( 'Next Link', 'connections' ),
                'type'        => 'vc_link',
                'param_name'  => 'next_link',
            ),
            array(
                'heading'     => esc_html__( 'Next Subtitle', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'next_subtitle',
            ),
            
            array(
                'heading'     => esc_html__( 'Title color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'title_color',
                'value'       => cn_get_heading_vc_colors( 'title' ),
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

new CN_Next_Back_Links();