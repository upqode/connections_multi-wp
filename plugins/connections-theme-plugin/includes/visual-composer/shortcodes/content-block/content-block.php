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
                'param_name'  => 'bg_text_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),

            array(
                'heading'     => esc_html__( 'Title', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'title',
            ),
            array(
                'heading'     => esc_html__( 'Text', 'connections' ),
                'type'        => 'textarea',
                'param_name'  => 'text',
            ),
            array(
                'heading'     => esc_html__( 'Image', 'connections' ),
                'type'        => 'attach_image',
                'param_name'  => 'image',
            ),
            array(
                'heading'     => esc_html__( 'Button', 'connections' ),
                'type'        => 'vc_link',
                'param_name'  => 'btn_link',
            ),
            
            array(
                'heading'     => esc_html__( 'Image align block', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'align_img',
                'value'       => array(
                    esc_html__( 'Left',  'connections' )    => 'left',
                    esc_html__( 'Center', 'connections' )   => 'center',
                    esc_html__( 'Right', 'connections' )    => 'right',
                )
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