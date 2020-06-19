<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Element Description: Connection Video Multi
*/

class CN_Video_Multi extends CN_Base_Shortcode {

	public function __construct() {
		$this->slug        = 'cn-video-multi';
		$this->title       = esc_html__( 'Video Multi', 'connections' );

		parent::__construct();
	}

	public function get_params() {

		$this->params = array(
			array(
                'heading'     => esc_html__( 'Background Color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'bg_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Title', 'js_composer' ),
                'param_name'  => 'title',
            ),
            array(
                'type'        => 'checkbox',
                'heading'     => esc_html__( 'Underline title', 'js_composer' ),
                'param_name'  => 'underline_title',
            ),
            array(
                'heading'     => esc_html__( 'Title Color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'title_color',
                'value'       => cn_get_heading_vc_colors( 'title' ),
			),
			array(
                'heading'     => esc_html__( 'Button Style', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'btn_style',
                'value'       => array(
                    esc_html__( 'Default', 'connections' ) => 'default',
                    esc_html__( 'Transparent', 'connections' )    => 'transparent',
                ),
            ),
            array(
                'heading'     => esc_html__( 'Button Background colors', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'btn_bg_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
                'dependency'   => array(
                    'element' => 'btn_style',
                    'value'   => 'default'
                ),
			),
			array(
                'heading'     => esc_html__( 'Button Text Style', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'btn_text_style',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),
            array(
                'heading'     => esc_html__( 'Button Transparent colors', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'button_style_color2',
                'value'       => cn_get_bg_vc_colors( 'title' ),
                'dependency'   => array(
                    'element' => 'btn_style',
                    'value'   => 'transparent'
                ),
            ),
			array(
                'type' 			=> 'param_group',
                'heading' 		=> esc_html__( 'Videos', 'js_composer' ),
                'param_name' 	=> 'videos',
                'params' 		=> array(
                	array(
		                'type'        => 'textfield',
		                'heading'     => esc_html__( 'Title', 'js_composer' ),
		                'param_name'  => 'title',
		            ),
		            // TO DO DELETE
              //       array(
		            //     'heading'     => esc_html__( 'Brightcove Video ID', 'connections' ),
		            //     'type'        => 'textfield',
		            //     'param_name'  => 'brightcove_id',
		            // ),
		            array (
		                'heading'     => esc_html__( 'Asset Video Lists', 'connections' ),
		                'type'        => 'dropdown',
		                'param_name'  => 'asset_lists',
		                'value'       => cn_get_asset_posts( true, 'video' ),
		                'dependency' => array(
		                    'element'   => 'type_link',
		                    'value'     => 'asset_library',
		                ),
		            ),
                ),
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

new CN_Video_Multi();