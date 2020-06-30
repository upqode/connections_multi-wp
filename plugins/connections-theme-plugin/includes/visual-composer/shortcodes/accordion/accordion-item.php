<?php if( !defined( 'ABSPATH' ) ) exit;
/*
 * Element Description: Connection drawer item
 */

class CN_Accordion_Item extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug            = 'cn_accordion_item';
        $this->title           = esc_html__( 'Accordion Item', 'connections' );
        $this->description     = esc_html__( 'Accordion Item content.', 'connections' );
        $this->is_container  = true;
        $this->content_element = true;
        $this->show_settings_on_create = false;
        $this->as_child = array( 'only' => 'cn_accordion' );
        $this->as_parent = array( 'only' => 'cn_table, cn-case-file-slider, cn-video-multi, cn-content-block' );

        parent::__construct();
    }

    public function get_params() {
        $this->params = array(
            array(
                'heading'     => esc_html__( 'Title', 'connections' ),
                'type'        => 'textarea',
                'param_name'  => 'title',
                'admin_label' => false,
            ),
        );

        $this->add_extras();
    }

    public function before_output( $atts, &$content ) {

        global $cn_items;

        $counter = count( $cn_items );

        if ( $atts && is_array( $atts ) ) {
            foreach ( $atts as $key => $item_atts ) {
                $cn_items[ $counter ][ $key ] = $item_atts;
            }
        }
        $cn_items[ $counter ]['content'] = $content;

        return $atts;
    }

}

new CN_Accordion_Item();
class WPBakeryShortCode_CN_Accordion_Item extends WPBakeryShortCodesContainer {}
