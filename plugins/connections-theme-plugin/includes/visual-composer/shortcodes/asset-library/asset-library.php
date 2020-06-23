<?php if( ! defined( 'ABSPATH' ) ) exit;
/*
* Element Description: Connection Asset Library
*/

class CN_Asset_Library extends CN_Base_Shortcode {

    public function __construct() {
        $this->slug        = 'cn-asset-library';
        $this->title       = esc_html__( 'Asset Library', 'connections' );
        $this->description = esc_html__( 'Asset Library content', 'connections' );

        parent::__construct();
    }

    public function get_params() {

        $assets_cats = cn_get_terms_field( 'cn-asset-category', 'slug', 'name' );

        $this->params = array(
            array(
                'heading' 	  => esc_html__( 'Title Tag', 'connections' ),
                'type' 		  => 'dropdown',
                'param_name'  => 'title_tag',
                'value' 	  => array(
                    esc_html__( 'H1', 'connections' ) => 'h1',
                    esc_html__( 'H2', 'connections' ) => 'h2',
                    esc_html__( 'H3', 'connections' ) => 'h3',
                    esc_html__( 'H4', 'connections' ) => 'h4',
                    esc_html__( 'H5', 'connections' ) => 'h5',
                    esc_html__( 'H6', 'connections' ) => 'h6',
                )
            ),
	        array(
		        'heading'     => esc_html__( 'Title Color', 'connections' ),
		        'type'        => 'dropdown',
		        'param_name'  => 'title_color',
		        'value'       => cn_get_heading_vc_colors( 'title' ),
	        ),
            array(
                'heading'     => esc_html__( 'Posts Per Page', 'connections' ),
                'type'        => 'textfield',
                'param_name'  => 'posts_per_page',
                'admin_label' => false,
            ),
            array(
                'heading'     => esc_html__( 'Select Categories', 'connections' ),
                'type'        => 'vc_efa_chosen',
                'param_name'  => 'categories',
                'value'       => is_array( $assets_cats ) ? $assets_cats : [],
                'placeholder' => 'Choose category (optional)',
                'admin_label' => true,
            ),
            array(
                'heading'     => esc_html__( 'Order by', 'americold' ),
                'type'        => 'dropdown',
                'param_name'  => 'orderby',
                'value'       => array(
                    esc_html__( 'Date', 'js_composer' ) => 'date',
                    esc_html__( 'ID', 'js_composer' ) => 'ID',
                    esc_html__( 'Author', 'js_composer' ) => 'author',
                    esc_html__( 'Title', 'js_composer' ) => 'title',
                    esc_html__( 'Modified', 'js_composer' ) => 'modified',
                    esc_html__( 'Random', 'js_composer' ) => 'rand',
                    esc_html__( 'Comment count', 'js_composer' ) => 'comment_count',
                    esc_html__( 'Menu order', 'js_composer' ) => 'menu_order',
                ),
                'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
            ),
            array(
                'heading'     => esc_html__( 'Sort order', 'americold' ),
                'type'        => 'dropdown',
                'param_name'  => 'order',
                'value'       => array(
                    esc_html__( 'Descending', 'js_composer' ) => 'DESC',
                    esc_html__( 'Ascending', 'js_composer' ) => 'ASC',
                ),
                'description' => sprintf( __( 'Select ascending or descending order. More at %s.', 'js_composer' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
            ),
            array(
                'heading'     => esc_html__( 'Fixed Left Navigation', 'connections' ),
                'type'        => 'checkbox',
                'param_name'  => 'fixed_nav',
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

new CN_Asset_Library();