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
 * @param int $source_id
 * @return string
 */
function cn_get_brightcove_source_code( $source_type, $user_id, $player_id, $video_id, $post_id, $attributes = '', $classes = '', $lazy_load = true ) {

    if ( $source_type === "video" ) {

        if ( $lazy_load ) {
            $source_format = '<div id="'. $video_id .'" class="js-lazy-load-BC" data-video-id="'. $video_id .'" data-class="video-js lk-video '. $classes .'" '. $attributes .'></div>';
        } else {
            $source_format = '<video-js data-account="%s" data-player="%s" data-video-id="%s" id="%s" data-embed="default" '. $attributes .' data-application-id class="video-js js-video-BC lk-video '. $classes .'" controls ></video-js>';
        }
        
    }
    else {

        if ( $lazy_load ) {
            $source_format = '<div id="'. $video_id .'" class="js-lazy-load-BC" data-video-id="'. $video_id .'" data-class="video-js lk-video '. $classes .'"'. $attributes .'></div>';
        } else {
            $source_format = '<video-js data-test="uruie" data-account="%s" data-player="%s" data-video-id="%s" id="%s" data-embed="default" '. $attributes .' data-application-id class="video-js js-video-BC lk-video '. $classes .'" controls></video-js>';
        }
        
    }

    $source_code = sprintf( $source_format, $user_id, $player_id, $video_id, $post_id );

    echo $source_code;
}