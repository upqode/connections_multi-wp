<?php if( !defined( 'ABSPATH' ) ) exit;
/*
 * Element Description: Connection Featured Links Item.
 */


class CN_Featured_Links_Item extends CN_Base_Shortcode {

    public function __construct() {

        // Properties
        $this->slug            = 'cn_featured_links_item';
        $this->title           = esc_html__( 'Featured Links Item', 'connections' );
        $this->description     = esc_html__( 'Create Featured Links Item.', 'connections' );
        $this->content_element = true;
        $this->show_settings_on_create = true;
        $this->as_child        = array( 'only' => 'cn_featured_links' );

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
		        'heading'     => esc_html__( 'Border Color', 'connections' ),
		        'type'        => 'dropdown',
		        'param_name'  => 'border_color',
                'value'       => cn_get_border_vc_colors( 'title' ),
                'dependency'  => array( 
                    'element'   => 'underline_title', 
                    'value'     => 'true', 
                ),
            ),

            array(
                'heading'     => esc_html__( 'Title', 'connections' ),
                'type'        => 'textarea',
                'param_name'  => 'title',
                'admin_label' => false,
            ),

	        array(
		        'heading'     => esc_html__( 'Title Color', 'connections' ),
		        'type'        => 'dropdown',
		        'param_name'  => 'title_color',
		        'value'       => cn_get_heading_vc_colors( 'title' ),
            ),            
            
            array (
                'heading'     => esc_html__( 'Body Copy', 'connections' ),
                'type'        => 'textarea_html',
                'param_name'  => 'content',
                'value'       => '',
            ),
            array(
		        'heading'     => esc_html__( 'Body Copy Color', 'connections' ),
		        'type'        => 'dropdown',
		        'param_name'  => 'text_color',
		        'value'       => cn_get_heading_vc_colors( 'title' ),
            ),
            
            array (
                'heading'     => esc_html__( 'Type Link', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'type_link',
                'value'       => array(
                    'Asset Library' => 'asset_library',
                    'Custom'        => 'custom',
                ),
                'std'         => 'custom',
            ),
            array (
                'heading'     => esc_html__( 'Asset Lists', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'asset_lists',
                'value'       => cn_get_asset_posts( true ),
                'dependency' => array(
                    'element'   => 'type_link',
                    'value'     => 'asset_library',
                ),
            ),

            array(
                'heading' 	  => esc_html__( 'Button', 'connections' ),
                'type' 		  => 'vc_link',
                'param_name'  => 'link',
                'dependency' => array(
                    'element'   => 'type_link',
                    'value'     => 'custom',
                ),
            ),
            array(
                'heading'     => esc_html__( 'Button background color', 'connections' ),
                'type'        => 'dropdown',
                'param_name'  => 'btn_bg_color',
                'value'       => cn_get_bg_vc_colors( 'title' ),
            ),
            array(
		        'heading'     => esc_html__( 'Button text color', 'connections' ),
		        'type'        => 'dropdown',
		        'param_name'  => 'btn_text_color',
		        'value'       => cn_get_heading_vc_colors( 'title' ),
            ),
        );

        $this->add_extras();
    }

    public function render( $atts, $content = '' ) {

        global $cn_items;

        $atts = vc_map_get_attributes( $this->slug, $atts );
        $atts = $this->before_output( $atts, $content );
        $atts['_id'] = uniqid( $this->slug .'_' );
        $atts['content'] = $content;

        $cn_items[]  = $atts;
    }

}

new CN_Featured_Links_Item();