<?php if( !defined( 'ABSPATH' ) ) exit;
/*
 * Element Description: Connections Tabs Item.
 */

class CN_Tabs_Item extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug             = 'cn_tabs_item';
        $this->title            = esc_html__( 'Tabs Item', 'creon' );
        $this->description      = esc_html__( 'Tabs Item content', 'creon' );
        $this->is_container     = true;
        $this->content_element  = true;
        $this->show_settings_on_create = false;
        $this->as_child = array ( 'only' => 'creon_tabs' );
        $this->as_parent = array ( 'only' => 'cn_table, cn-video-multi, cn-content-block' );

        parent::__construct();
    }

    public function get_params() {
        $this->params = array(
            array(
                'heading'     => esc_html__( 'Title', 'creon' ),
                'type'        => 'textarea',
                'param_name'  => 'title',
                'admin_label' => false,
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

new CN_Tabs_Item();
class WPBakeryShortCode_CN_Tabs_Item extends WPBakeryShortCodesContainer {}
