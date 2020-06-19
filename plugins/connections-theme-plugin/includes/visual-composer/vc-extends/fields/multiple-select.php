<?php
/**
 * Multi Select
 */
function ch_vc_efa_chosen( $settings, $value ) {

    $css_option = vc_get_dropdown_option( $settings, $value );
    $value = explode( ',', $value );

    $output  = '<select name="'. $settings['param_name'] .'" data-placeholder="'. $settings['placeholder'] .'" multiple="multiple" class="wpb_vc_param_value wpb_chosen chosen wpb-input wpb-efa-select '. $settings['param_name'] .' '. $settings['type'] .' '. $css_option .'" data-option="'. $css_option .'">';

    foreach ( $settings['value'] as $values => $option ) {
        $selected = ( in_array( $option, $value ) ) ? ' selected="selected"' : '';
        $output .= '<option value="'. $option .'"'. $selected .'>'. htmlspecialchars( $values ).'</option>';
    }

    $output .= '</select>' . "\n";

    return $output;
}

vc_add_shortcode_param( 'vc_efa_chosen', 'ch_vc_efa_chosen' );