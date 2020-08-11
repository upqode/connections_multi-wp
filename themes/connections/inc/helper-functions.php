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
            $source_format = '<div class="js-lazy-load-BC" data-video-id="'. $src_id .'" data-class="video-js lk-video '. $classes .'" '. $attributes .'></div>';
        } else {
            $source_format = '<video-js data-account="%s" data-player="%s" data-video-id="%s" data-embed="default" '. $attributes .' data-application-id class="video-js js-video-BC lk-video '. $classes .'" controls ></video-js>';
        }
        
    }
    else {

        if ( $lazy_load ) {
            $source_format = '<div class="js-lazy-load-BC" data-video-id="'. $src_id .'" data-class="video-js lk-video '. $classes .'"'. $attributes .'></div>';
        } else {
            $source_format = '<video-js data-test="uruie" data-account="%s" data-player="%s" data-video-id="%s" data-embed="default" '. $attributes .' data-application-id class="video-js js-video-BC lk-video '. $classes .'" controls></video-js>';
        }
        
    }

    $source_code = sprintf( $source_format, $user_id, $player_id, $src_id );

    echo $source_code;
}


/**
 * Get color scheme
 * @param bool $echo
 * @return string
 */
function conn_get_color_scheme( $echo = false ) {

    if ( ! function_exists('cn_get_colors') )
        return '';

    $colors = cn_get_colors() ?: [];
    $bg_colors = cn_get_colors( 'bg_main_color', CN_BG_COLORS ) ?: [];
    $paragraph_colors = cn_get_colors( 'p_main_color', CN_P_COLORS ) ?: [];

    $colors = array_merge( $colors, $bg_colors );
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

    if ( ! function_exists( 'cn_get_colors' ) )
        return '';
    
    $primary_colors = cn_get_colors( 'primary_color', CN_PRIMARY_COLORS ) ?: [];
    $colors = cn_get_colors( 'bg_main_color', CN_BG_COLORS ) ?: [];
    $colors = array_merge( $primary_colors, $colors );

    $css = '';
    $counter = 1;

    foreach ( $colors as $key => $color ) {

        if ( $color ) {
            $key_color = "bg_main_color_{$counter}";
            $css .= sprintf( '.%s{ background-color: %s }', $key_color, $color );
            // TO DO DELETE
            // $css .= sprintf( '.border_main_color_%s{ border-color: %s }', $counter, $color );
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
    
    // TO DO DELETE
    // $colors = function_exists( 'cn_get_colors' ) ?  cn_get_colors( 'h_main_color', CN_H_COLORS ) : [];
    $colors = function_exists( 'cn_get_colors' ) ?  cn_get_colors( 'primary_color', CN_PRIMARY_COLORS ) : [];
    
    // Theme options color
    $theme_options_colors = get_field( 'h_main_color', 'option' ) ?: [];
    $counter = count( $colors ) + 1;

    if ( $theme_options_colors ) {
        foreach ( $theme_options_colors as $theme_color ) {
            $colors["primary_color_{$counter}"] = $theme_color['color'];
        }
    }
        
    $css = '';

    foreach ( $colors as $key => $color ) {
        if ( $color ) {
            $css .= sprintf( '.%s { color: %s }', $key, $color );
            $css .= sprintf( '.%s svg { fill: %s }', $key, $color );
            $css .= sprintf( '.%s svg * { fill: %s }', $key, $color );
        }
    }
    
    return $css;
}


/**
 * Generate CSS for border colors
 * @return string
 */
function conn_border_colors_css() {
    
    $colors = function_exists( 'cn_get_colors' ) ?  cn_get_colors( 'primary_color', CN_PRIMARY_COLORS ) : [];
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

    $subsite_str = ( is_multisite() && ! is_main_site() ) ? "/sites/{$current_blog_id}" : '';
    
    if ( $subsite_str ) {
        $base_dir_upload = str_replace( $subsite_str, '', $base_dir_upload );
    }

    if ( $unique_id ) {
        $unique_id = "zip_{$unique_id}";
    }

    // Path to unzip file
    return "{$base_dir_upload}/unip_files{$subsite_folder}{$unique_id}";

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

    $subsite_str = ( is_multisite() && ! is_main_site() ) ? "/sites/{$current_blog_id}" : '';
    $file_path = explode( "/uploads{$subsite_str}", $file_uri );

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

/**
 * Asset popup
 *  
 * @param int|string $asset_id
 * @param string $popup_id
 * 
 * @return null
 */
function conn_asset_popup( $asset_id, $popup_id ) {

    global $brightcove_user_id, $brightcove_player_id;

    if ( $asset_id ) :

        $asset_type = get_field( 'asset_type', $asset_id );
                        
        // $asset_key  = ( $asset_type == 'html' ) ? 'asset_zip' : "asset_{$asset_type}";
        $asset_data = get_field( "asset_{$asset_type}", $asset_id );
        
        $popup_class = '';
        $popup_class .= "asset-{$asset_type}";
        $popup_class .= " asset-{$asset_id}";
        ?>

        <div id="<?php echo $popup_id; ?>" class="white-popup-block mfp-hide <?php echo esc_attr( $popup_class ); ?>">
            <?php include locate_template( 'template-parts/content-asset-popup.php' ); ?>
        </div>

    <?php endif;

}

/**
 * Clean unzip HTML files
 *  
 * @param int|string $asset_id
 * 
 * @return null
 */
function conn_clean_unzip_assets( $asset_id ) {

    $src_html = conn_get_path_unzip_html( $asset_id );
    $dirs = glob( "{$src_html}*", GLOB_ONLYDIR );

    foreach ( $dirs as $dir ) {
        conn_delete_directory( $dir );
    }

}

/**
 * Saniztize SVG
 *  
 * @param string $svg
 * 
 * @return string
 */
function conn_sanitize_svg( $svg ) {

    $kses_defaults = wp_kses_allowed_html( 'post' );

    $svg_args = array(
        'svg'       => array(
            'class'             => true,
            'aria-hidden'       => true,
            'aria-labelledby'   => true,
            'role'              => true,
            'xmlns'             => true,
            'width'             => true,
            'height'            => true,
            'viewbox'           => true, // <= Must be lower case!
        ),
        'rect'      => array( 
            'd'                 => true, 
            'fill'              => true,
            'width'             => true,
            'height'            => true,
            'class'             => true,
            'x'                 => true,
            'y'                 => true,
        ),
        'g'         => array( 
            'fill'              => true, 
            'rect'              => true 
        ),
        'title'     => array( 'title' => true ),
        'path'      => array( 
            'd'                 => true, 
            'fill'              => true,
            'class'             => true,
        ),
    );

    $allowed_tags = array_merge( $kses_defaults, $svg_args );

    return wp_kses( $svg, $allowed_tags );

}