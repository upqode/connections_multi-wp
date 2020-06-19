<?php

/**
 * Create values for select
 * @return array
 */
if ( ! function_exists( 'cn_get_row_offset' ) ) {
    function cn_get_row_offset( $pref, $suf, $max = 50, $step = 5 ) {
        $ar = array();
        for ( $i = 0; $i < $max + $step; $i += $step ) {
            $ar[ $i . 'px' ] = $pref . '-' . $i . $suf;
        }

        return array_merge( array( 'Default' => 'none' ), $ar );
    }
}


/**
 * Create responsive margins and paddings
 * @return array
 */
if ( ! function_exists( 'cn_create_responsive_retreats' ) ) {
    function cn_create_responsive_retreats() {
        $responsive_options = array(
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Desktop margin top ( >= 1200px)', 'liquid-knowledge' ),
                'param_name' => 'desctop_mt',
                'value'      => cn_get_row_offset( 'margin-xl', 't', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Desktop margin bottom ( >= 1200px)', 'liquid-knowledge' ),
                'param_name' => 'desctop_mb',
                'value'      => cn_get_row_offset( 'margin-xl', 'b', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Large desktop margin top ( < 1200px)', 'liquid-knowledge' ),
                'param_name' => 'desctop_lg_mt',
                'value'      => cn_get_row_offset( 'margin-lg', 't', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Large desktop margin bottom ( < 1200px)', 'liquid-knowledge' ),
                'param_name' => 'desctop_lg_mb',
                'value'      => cn_get_row_offset( 'margin-lg', 'b', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Tablets margin top ( < 991px)', 'liquid-knowledge' ),
                'param_name' => 'tablets_mt',
                'value'      => cn_get_row_offset( 'margin-md', 't', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Tablets margin bottom ( < 991px)', 'liquid-knowledge' ),
                'param_name' => 'tablets_mb',
                'value'      => cn_get_row_offset( 'margin-md', 'b', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Small Tablets margin top ( < 767px)', 'liquid-knowledge' ),
                'param_name' => 'tablets_sm_mt',
                'value'      => cn_get_row_offset( 'margin-sm', 't', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Small Tablets margin bottom ( < 767px)', 'liquid-knowledge' ),
                'param_name' => 'tablets_sm_mb',
                'value'      => cn_get_row_offset( 'margin-sm', 'b', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Mobile margin top ( < 575px)', 'liquid-knowledge' ),
                'param_name' => 'mobile_mt',
                'value'      => cn_get_row_offset( 'margin-xs', 't', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Mobile margin bottom ( < 575px)', 'liquid-knowledge' ),
                'param_name' => 'mobile_mb',
                'value'      => cn_get_row_offset( 'margin-xs', 'b', 200 ),
                'group'      => __( 'Responsive Margins', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Desktop padding top ( >= 1200px)', 'liquid-knowledge' ),
                'param_name' => 'desctop_pt',
                'value'      => cn_get_row_offset( 'padding-xl', 't', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Desktop padding bottom ( >= 1200px)', 'liquid-knowledge' ),
                'param_name' => 'desctop_pb',
                'value'      => cn_get_row_offset( 'padding-xl', 'b', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Large desktop padding top ( < 1200px)', 'liquid-knowledge' ),
                'param_name' => 'desctop_lg_pt',
                'value'      => cn_get_row_offset( 'padding-lg', 't', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Large desktop padding bottom ( < 1200px)', 'liquid-knowledge' ),
                'param_name' => 'desctop_lg_pb',
                'value'      => cn_get_row_offset( 'padding-lg', 'b', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Tablets padding top ( < 991px)', 'liquid-knowledge' ),
                'param_name' => 'tablets_pt',
                'value'      => cn_get_row_offset( 'padding-md', 't', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Tablets padding bottom ( < 991px)', 'liquid-knowledge' ),
                'param_name' => 'tablets_pb',
                'value'      => cn_get_row_offset( 'padding-md', 'b', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Small Tablets padding top ( < 767px)', 'liquid-knowledge' ),
                'param_name' => 'tablets_sm_pt',
                'value'      => cn_get_row_offset( 'padding-sm', 't', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Small Tablets padding bottom ( < 767px)', 'liquid-knowledge' ),
                'param_name' => 'tablets_sm_pb',
                'value'      => cn_get_row_offset( 'padding-sm', 'b', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Mobile padding top ( < 575px)', 'liquid-knowledge' ),
                'param_name' => 'mobile_pt',
                'value'      => cn_get_row_offset( 'padding-xs', 't', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => __( 'Mobile padding bottom ( < 575px)', 'liquid-knowledge' ),
                'param_name' => 'mobile_pb',
                'value'      => cn_get_row_offset( 'padding-xs', 'b', 200 ),
                'group'      => __( 'Responsive paddings', 'liquid-knowledge' ),
            ),
        );

        return $responsive_options;
    }
}


/**
 * Create responsive css classes for shortcode container
 * @param array $atts - shortcode options
 * @return string
 */
if ( ! function_exists( 'cn_create_responsive_classes' ) ) {
    function cn_create_responsive_classes( $atts ) {
        $resp_classes = '';
        $css_classes = array(
            'desctop_mt',
            'desctop_mb',
            'desctop_lg_mt',
            'desctop_lg_mb',
            'tablets_mt',
            'tablets_mb',
            'tablets_sm_mt',
            'tablets_sm_mb',
            'mobile_mt',
            'mobile_mb',
            'desctop_pt',
            'desctop_pb',
            'desctop_lg_pt',
            'desctop_lg_pb',
            'tablets_pt',
            'tablets_pb',
            'tablets_sm_pt',
            'tablets_sm_pb',
            'mobile_pt',
            'mobile_pb',
        );

        foreach ( $css_classes as $value ) {

            if ( isset( $atts[ $value ] ) && $atts[ $value ] != 'none' ) {
                $resp_classes .= ' ' . $atts[ $value ];
            }

        }

        return $resp_classes;
    }
}

// TO DO DELETE
/**
 * Create responsive css classes for shortcode container
 * @param array $atts - shortcode options
 * @return string
 */
// if ( ! function_exists( 'cn_create_responsive_classes_item' ) ) {
//     function cn_create_responsive_classes_item( $atts ) {
//         $resp_classes = '';
//         $css_classes = array(
//             'desctop_mb_item',
//             'desctop_md_mb_item',
//             'tablets_mb_item',
//             'mobile_mb_item',
//         );

//         foreach ( $css_classes as $value ) {
//             if ( isset( $atts[ $value ] ) && $atts[ $value ] != 'none' ) {
//                 $resp_classes .= ' ' . $atts[ $value ];
//             }
//         }

//         return $resp_classes;
//     }
// }
