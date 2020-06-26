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
                'heading'     => esc_html__( 'Video alignment', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'video_align',
                'value'       => array(
                    esc_html__( 'Left', 'connections' )      => 'left',
                    esc_html__( 'Right', 'connections' )     => 'right',
                    esc_html__( 'Center', 'connections' )    => 'center',
                ),
            ),

			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Title', 'js_composer' ),
                'param_name'  => 'title',
            ),

            array(
                'heading'     => esc_html__( 'Title Color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'title_color',
                'value'       => cn_get_heading_vc_colors( 'title' ),
            ),

            array(
                'type'        => 'checkbox',
                'heading'     => esc_html__( 'Underline title', 'js_composer' ),
                'param_name'  => 'underline_title',
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
                'type' 			=> 'param_group',
                'heading' 		=> esc_html__( 'Videos', 'js_composer' ),
                'param_name' 	=> 'videos',
                'params' 		=> array(
                	array(
		                'type'        => 'textfield',
		                'heading'     => esc_html__( 'Title', 'js_composer' ),
		                'param_name'  => 'title',
		            ),
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