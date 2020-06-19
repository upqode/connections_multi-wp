<?php

/**
 * Helper functions
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package connections
 */

 /**
 * Generate url to brightcove
 * @param string $source_type (video or audio)
 * @param int $user_id
 * @param int $player_id
 * @param string $src_id
 * @param string $post_id
 * @param string $attributes
 * @param string $classes
 * @param bool $lazy_load
 * @return string
 */
function conn_get_brightcove_source_code( $source_type, $user_id, $player_id, $src_id, $post_id, $attributes = '', $classes = '', $lazy_load = true ) {

    if ( $source_type === "video" ) {

        if ( $lazy_load ) {
            $source_format = '<div id="'. $src_id .'" class="js-lazy-load-BC" data-video-id="'. $src_id .'" data-class="video-js lk-video '. $classes .'" '. $attributes .'></div>';
        } else {
            $source_format = '<video-js data-account="%s" data-player="%s" data-video-id="%s" id="%s" data-embed="default" '. $attributes .' data-application-id class="video-js js-video-BC lk-video '. $classes .'" controls ></video-js>';
        }
        
    }
    else {

        if ( $lazy_load ) {
            $source_format = '<div id="'. $src_id .'" class="js-lazy-load-BC" data-video-id="'. $src_id .'" data-class="video-js lk-video '. $classes .'"'. $attributes .'></div>';
        } else {
            $source_format = '<video-js data-test="uruie" data-account="%s" data-player="%s" data-video-id="%s" id="%s" data-embed="default" '. $attributes .' data-application-id class="video-js js-video-BC lk-video '. $classes .'" controls></video-js>';
        }
        
    }

    $source_code = sprintf( $source_format, $user_id, $player_id, $src_id, $post_id );

    echo $source_code;
}


/**
 * Get color scheme
 * @param bool $echo
 * @return string
 */
function conn_get_color_scheme( $echo = false ) {

    $colors = function_exists( 'cn_get_colors' ) ? cn_get_colors() : [];
    $paragraph_colors = function_exists( 'cn_get_colors' ) ? cn_get_colors( 'p_main_color', 3 ) : [];

    $colors = array_merge( $colors, $paragraph_colors );

    $output = '';

    foreach ( $colors as $key => $color ) {
        $output .= sprintf( '--%s: %s;', $key, $color );
    }

    if ( $output ) {
        $output = "style='{$output}'";
    }

    if ( $echo ) {
        echo $output;
    } else {
        return $output;
    }

}

/**
 * Generate CSS for background colors
 * @return string
 */
function conn_bg_colors_css() {
    
    $colors = function_exists( 'cn_get_colors' ) ?  cn_get_colors( 'bg_main_color', 7 ) : [];
    $css = '';

    foreach ( $colors as $key => $color ) {
        if ( $color ) {
            $css .= sprintf( '.%s{ background-color: %s }', $key, $color );
        }
    }
    
    return $css;
}

/**
 * Generate CSS for background colors
 * @return string
 */
function conn_text_colors_css() {
    
    $colors = function_exists( 'cn_get_colors' ) ?  cn_get_colors( 'h_main_color', 6 ) : [];
    $css = '';

    foreach ( $colors as $key => $color ) {
        if ( $color ) {
            $css .= sprintf( '.%s{ color: %s }', $key, $color );
        }
    }
    
    return $css;
}
