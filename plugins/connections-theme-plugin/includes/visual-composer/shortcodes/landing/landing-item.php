<?php if( !defined( 'ABSPATH' ) ) exit;
/*
 * Element Description: Connections Landing Item.
 */

class CN_Landing_Item extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug             = 'cn_landing_item';
        $this->title            = esc_html__( 'Landing Item', 'creon' );
        $this->description      = esc_html__( 'Landing Item content', 'creon' );


        parent::__construct();
    }

    public function get_params() {
        $this->params = array(
			array(
				'heading'     => esc_html__( 'Block color', 'connections' ),
				'type'        => 'dropdown',
				'param_name'  => 'block_color',
				'value'       => cn_get_bg_vc_colors( 'title' ),
			),
			array(
				'heading'     => esc_html__( 'Text color', 'connections' ),
				'type'        => 'dropdown',
				'param_name'  => 'block_text_color',
				'value'       => cn_get_heading_vc_colors( 'title' ),
			),
            array(
                'heading'     => esc_html__( 'Title', 'creon' ),
                'type'        => 'textarea',
                'param_name'  => 'title',
                'admin_label' => false,
            ),
			array(
				'heading'     => esc_html__( 'Button', 'connections' ),
				'type'        => 'vc_link',
				'param_name'  => 'btn_link',
			),
			array(
                'heading' 	  => esc_html__( 'Columns', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'column',
                'value' 	  => array(
                    esc_html__( 'Column 1', 'connections' ) => '1',
                    esc_html__( 'Column 2', 'connections' ) => '2',
                    esc_html__( 'Column 3', 'connections' ) => '3',
                    esc_html__( 'Column 4', 'connections' ) => '4',
                )
            ),
			array(
				'type' 			=> 'param_group',
				'heading' 		=> esc_html__( 'Items', 'js_composer' ),
				'param_name' 	=> 'items',
				'params' 		=> array(

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title', 'js_composer' ),
						'param_name'  => 'title',
					),
					array(
						'heading'     => esc_html__( 'Image', 'connections' ),
						'type'        => 'attach_image',
						'param_name'  => 'image',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'URL', 'js_composer' ),
						'param_name'  => 'url',
					),
				),
			),
        );

        $this->add_extras();
    }

    public function before_output( $atts, &$content ) {

        global $creon_items;

        $counter = count( $creon_items );
        
        if ( $atts && is_array( $atts ) ) {
            foreach ( $atts as $key => $item_atts ) {
                $creon_items[ $counter ][ $key ] = $item_atts;
            }
        }
        $creon_items[ $counter ]['content'] = $content;

        return $atts;
    }

}

new CN_Landing_Item();
class WPBakeryShortCode_CN_Landing_Item extends WPBakeryShortCodesContainer {}
