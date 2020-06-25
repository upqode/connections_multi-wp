<?php if( !defined( 'ABSPATH' ) ) exit;
/*
 * Element Description: Connections Featured Links Item
 */

class CN_Featured_Links_Text extends CN_Base_Shortcode {

    public function __construct() {

        // Properties
        $this->slug            = 'cn_featured_links_text';
        $this->title           = esc_html__( 'Featured Links Text', 'connections' );
        $this->description     = esc_html__( 'Create Featured Links Text.', 'connections' );
        $this->content_element = true;
        $this->show_settings_on_create = true;
        $this->as_child        = array( 'only' => 'cn_featured_links' );

        parent::__construct();
    }

    public function get_params() {
        $this->params = array(

            array (
                'heading'     => esc_html__( 'Body Copy', 'connections' ),
                'type'        => 'textarea_html',
                'param_name'  => 'content',
                'value'       => '',
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

		// option for define different between two subshortcodes
        $atts['item_text'] = true;

        $cn_items[]  = $atts;
    }

}
new CN_Featured_Links_Text();