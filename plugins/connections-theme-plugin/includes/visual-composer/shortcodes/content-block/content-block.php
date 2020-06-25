<?php 
/*
* Element Description: Connection Content Block
*/

class CN_Content_Block extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug        = 'cn-content-block';
        $this->title       = esc_html__( 'Content Block', 'connections' );
        $this->description = esc_html__( 'Content Block content', 'connections' );

        parent::__construct();
    }

    public function get_params() {

        $this->params = array(

            array(
                'heading'     => esc_html__( 'Background color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'bg_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),
            array(
                'heading'     => esc_html__( 'Content Layout Width', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'content_layout_width',
                'value'       => array(
                    esc_html__( '1/1',  'connections' )  => '100',
                    esc_html__( '1/2',  'connections' )  => '50',
                    esc_html__( '3/4',  'connections' )  => '75',
                    esc_html__( '1/4',  'connections' )  => '25',
                )
            ),

            array(
                'heading'     => esc_html__( 'Title', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'title',
            ),

            array(
                'heading'     => esc_html__( 'Title color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'title_color',
                'value'       => cn_get_heading_vc_colors( 'title' ),
                'dependency'  => array( 
                    'element'       => 'title', 
                    'not_empty'     => true,
                ),
            ),

            array(
                'type'        => 'checkbox',
                'heading'     => esc_html__( 'Underline title', 'js_composer' ),
                'param_name'  => 'underline_title',
                'dependency'  => array( 
                    'element'   => 'title', 
                    'not_empty'     => true,
                ),
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
                'heading'     => esc_html__( 'Body Copy', 'connections' ),
                'type'        => 'textarea_html',
                'param_name'  => 'content',
            ),
            array(
                'heading'     => esc_html__( 'Image', 'connections' ),
                'type'        => 'attach_image',
                'param_name'  => 'image',
            ),
            array(
                'heading'     => esc_html__( 'Type Image', 'creon' ),
                'type'        => 'dropdown',
                'param_name'  => 'type_image',
                'value'       => array(
                    esc_html__( 'Default', 'creon' )       => '',
                    esc_html__( 'Round',  'creon' )        => 'img-round',
                ),
            ),

            array(
                'heading'     => esc_html__( 'Image align block', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'align_img',
                'value'       => array(
                    esc_html__( 'Left',  'connections' )    => 'left',
                    esc_html__( 'Right', 'connections' )    => 'right',
                    esc_html__( 'Full', 'connections' )     => 'full',
                ),
                'dependency' => array(
                    'element'               => 'content_layout_width',
                    'value_not_equal_to'    => '100',
                ),
            ),

            array(
                'heading'     => esc_html__( 'Button', 'connections' ),
                'type'        => 'vc_link',
                'param_name'  => 'btn_link',
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

new CN_Content_Block();