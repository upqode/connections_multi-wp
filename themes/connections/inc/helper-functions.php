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
    $counter = 1;

    foreach ( $colors as $key => $color ) {
        if ( $color ) {
            $css .= sprintf( '.%s{ background-color: %s }', $key, $color );
            $css .= sprintf( '.border_main_color_%s{ border-color: %s }', $counter, $color );
            $counter++;
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


/**
 * Generate CSS for border colors
 * @return string
 */
function conn_border_colors_css() {
    
    $colors = function_exists( 'cn_get_colors' ) ?  cn_get_colors( 'primary_color', 6 ) : [];
    $css = '';

    foreach ( $colors as $key => $color ) {
        if ( $color ) {
            $css .= sprintf( '.border_%s{ border-color: %s }', $key, $color );
        }
    }
    
    return $css;
}

/*
 * Delete directory with files
 *  
 * @param string $dirname directory path you want to delete
 * 
 * @return bool
 */

function conn_delete_directory( $dirname ) {
    if ( is_dir( $dirname ) )
        $dir_handle = opendir( $dirname );
    if ( ! $dir_handle )
        return false;
    while ( $file = readdir( $dir_handle ) ) {
           if ( $file != "." && $file != ".." ) {
                if ( ! is_dir( $dirname . "/" . $file ) )
                    unlink( $dirname . "/" . $file );
                else
                    conn_delete_directory( $dirname . '/' . $file );
           }
    }
    closedir( $dir_handle );
    rmdir( $dirname );
    return true;
}

/**
 * Get path uploads
 *  
 * @param string $return_path
 * @return array|string
 */

function conn_path_uploads( $return_path = '' ) {
    
    require_once ABSPATH . 'wp-admin/includes/file.php';
    WP_Filesystem();

    $destination = wp_upload_dir();

    if ( empty( $destination ) )
        return;

    if ( isset( $destination[ $return_path ] ) ) {
        return $destination[ $return_path ];
    } else {
        return $destination;
    }

}

/*
 * Get path unzip HTML
 */
function conn_get_path_unzip_html( $unique_id, $path = 'basedir' ) {

    $base_dir_upload = conn_path_uploads( $path );

    // For Multisite
    $subsite_folder = '';
    if ( is_multisite() ) {
        $current_blog_id = get_current_blog_id();
	    $subsite_folder = "/subsite_{$current_blog_id}/";
    }

    // Path to unzip file
    return "{$base_dir_upload}/unip_files{$subsite_folder}zip_{$unique_id}";

}

/**
 * Unzip files
 *  
 * @param string $file_uri full uri to zip archive
 * @param string $unique_id - unique id for folder
 * 
 * @return string path to folder unzip files
 */

function conn_unzip_file( $file_uri, $unique_id, $custom_folder = '' ) {

    $base_dir_upload = conn_path_uploads( 'basedir' );
    // $custom_folder = ( ! empty( $custom_folder ) ) ? '/' . $custom_folder : '';

    // For Multisite
    $subsite_folder = '';
    if ( is_multisite() ) {
        $current_blog_id = get_current_blog_id();
	    $subsite_folder = "/subsite_{$current_blog_id}/";
    }

    // Path to unzip file
    // $destination_path_to = $base_dir_upload . "/unip_files{$subsite_folder}/zip_{$unique_id}";
    $destination_path_to = conn_get_path_unzip_html( $unique_id );

    if ( empty( $file_uri ) ) {
        conn_delete_directory( $destination_path_to );
    }

    // if ( is_dir( $destination_path_to ) && count( scandir( $destination_path_to ) ) > 2 ) {
    //     return $destination_path_to;
    // }

    $file_path = explode( '/uploads', $file_uri );

    $file_path = isset( $file_path[1] ) ? $file_path[1] : '';

    if ( empty( $destination_path_to ) || empty( $base_dir_upload ) ) {
        return;
    }

    // Path to zip archive
    $path_file = $base_dir_upload . $file_path;

    // Unzip file
    $unzipfile = unzip_file( $path_file, $destination_path_to );

    if ( ! is_wp_error( $unzipfile ) ) {
        return $destination_path_to;
    }
}

/**
 * Get unzip files
 *  
 * @param string $path path file
 * @param string $expansion_file find files for expansion
 * @param string $file_name find files for name
 *               Default return all files
 * 
 * @return array
 */

function conn_get_unzip_files( $path, $expansion_file = 'html', $file_name = '*' ) {
    $files = array();

    if ( ! $path || ! is_string( $path ) ) return;

    foreach ( glob( $path . '/'. $file_name . '.' . $expansion_file ) as $file ) {
        $uri_path_file = get_site_url() . '/wp-content' . explode( 'wp-content', $path )[1];
        $files[] = $uri_path_file . '/'. basename( $file );
    }
    return $files;
}
