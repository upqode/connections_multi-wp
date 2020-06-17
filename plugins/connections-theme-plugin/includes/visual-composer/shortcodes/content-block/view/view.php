<?php
/**
 * Return html shortcode.
 */
    global $brightcove_user_id, $brightcove_player_id;

    extract( $atts );

    $el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

    $class = ( ! empty( $el_class ) ) ? $el_class : '';
    $class .= vc_shortcode_custom_css_class( $class );

    /* Add responsive options to container */
    $responsive_classes = cn_create_responsive_classes( $atts );
    if ( ! empty( $responsive_classes ) ) {
        $class .= $responsive_classes;
    }

    // Background
    $class .= isset( $bg_color ) && $bg_color == ' lk-bg-pink' ? ' lk-bg-pink' : ' ' . $bg_color;
?>

<div class="cn-content-block">

</div>