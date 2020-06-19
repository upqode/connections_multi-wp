<?php 
/*
* Element Description: Sheet
*/

class CN_Sheet extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug        = 'cn-sheet';
        $this->title       = esc_html__( 'Sheet', 'connections' );
        $this->description = esc_html__( 'Sheet content', 'connections' );

        parent::__construct();
    }

    public function get_params() {

        $this->params = array(

            array(
                'heading'     => esc_html__( 'Text header', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'text_header',
                'admin_label' => false,
            ),
            array(
                'heading'     => esc_html__( 'Title', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'title',
                'admin_label' => false,
            ),
            array(
                'heading'     => esc_html__( 'Description', 'connections' ),
                'type'        => 'textarea',
                'param_name'  => 'desc',
                'admin_label' => false,
            ),
            array(
                'heading'     => esc_html__( 'Content', 'connections' ),
                'type'        => 'textarea_html',
                'param_name'  => 'content',
                'admin_label' => false,
            ),
            array(
                'heading'     => esc_html__( 'Text Footer', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'text_footer',
                'admin_label' => false,
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

new CN_Sheet();