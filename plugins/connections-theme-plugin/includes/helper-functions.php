<?php
/**
 * Get terms field
 * @param $taxonomy - taxonomy slug
 * @param $field - field title
 * @param $output_key - If specify term field title then output an associative array with specified key or default output numbered array
 * @return array
*/
function cn_get_terms_field( $taxonomy, $field, $output_key = '', $return_wp_error = false ) {

    // Params for terms
    $args = array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    );
    $error_message = esc_html__( "Not found {$taxonomy}", "connections" );

    // Get terms
    $terms = get_terms( $args );

    // For invalid taxonomy
    if ( is_wp_error( $terms ) ) {
        if ( $return_wp_error ) {
            return (array) $terms;
        } else {
            return [ $error_message => $error_message ];
        }
    }

    // Results
    $result = array();
    if ( ! empty( $terms ) ) {
        for ( $i = 0, $count_terms = count( $terms ); $i < $count_terms; $i++ ) {
            if ( ! empty( $terms[ $i ]->$field ) ) {
                $key = isset( $terms[ $i ]->$output_key ) ? $terms[ $i ]->$output_key : $i;
                $result[ $key ] = $terms[ $i ]->$field;
            }
        }
    } else {
        $result[ $error_message ] = '';
    }
    return $result;
}


/**
 * Get color list
 * @param string $key_color
 * @param int $count_colors
 * @param string $return_value value which will return in each item color value or color title
 * @return array
 */
function cn_get_colors( $key_color = 'primary_color', $count_colors = 5, $return_value = 'color' ) {

    if ( ! function_exists( 'get_field' ) )
        return [];        

    $output_colors = [];
    $theme_options_colors = get_field( $key_color, 'option' ) ?: [];
    
    for ( $i = 1; $i <= $count_colors; $i++ ) {

        $full_key_color = "{$key_color}_{$i}";
        $key_title_color = "{$key_color}_title_{$i}";
        $color = get_field( $full_key_color, 'acf_network_options' );

        if ( $color ) {
            $color_title = get_field( $key_title_color, 'acf_network_options' ) ?: str_replace( '_', ' ', $full_key_color );
            
            $value = ( $return_value == 'color' ) ? $color : $color_title;
            $output_colors[ $full_key_color ] = $value;
        }
    }

    // Theme options colors
    foreach ( $theme_options_colors as $theme_color ) {

        $full_key_color = "{$key_color}_{$i}";
        $key_title_color = "{$full_key_color}_title_{$i}";

        if ( ! empty( $theme_color['color'] ) ) {
            $color_title = ( ! empty( $theme_color['title_color'] ) ) ? $theme_color['title_color'] : str_replace( '_', ' ', $full_key_color );
            $color = $theme_color['color'];
            $value = ( $return_value == 'color' ) ? $color : $color_title;
            $output_colors[ $full_key_color ] = $value;
        }

        $i++;

    }

    return $output_colors;
}


/**
 * Get background color list
 * @param string $return_value value which will return in each item color value or color title
 * @return array
 */
function cn_get_bg_vc_colors( $return_value = 'color' ) {

    $colors[] = 'TRANSPARENT';
    $colors = array_merge( $colors, cn_get_colors( 'bg_main_color', 7, $return_value ) );
    $colors = ( $colors ) ? array_flip( $colors ) : $colors;

    return $colors;

}

/**
 * Get heading color list
 * @param string $return_value value which will return in each item color value or color title
 * @return array
 */
function cn_get_heading_vc_colors( $return_value = 'color' ) {

    $colors = cn_get_colors( 'h_main_color', 6, $return_value );
    $colors = ( $colors ) ? array_flip( $colors ) : $colors;

    return $colors;

}

/**
 * Get assets
 * @param string $return_value value which will return in each item color value or color title
 * @return array
 */
function cn_get_asset_posts( $return_key_title = false, $asset_type = '' ) {
	$asset_posts_list = array();

	$args = array(
		'post_type'       => 'cn-asset',
		'posts_per_page'  => -1,
	);

    if ( $asset_type ) {
        $args['meta_query'] = [
            [
                'key'           => 'asset_type',
                'value'         => 'video',
                'compare'       => '=',
            ]
        ];
    }

	$posts = get_posts( $args );

	if ( ! empty( $posts ) ) {
		foreach ( $posts as $post ) {
			if ( $return_key_title ) {
				$asset_posts_list[ $post->post_title ] = $post->ID;
			} else {
				$asset_posts_list[ $post->ID ] = $post->post_title;
			}
		}
	} else {
		return [ esc_html__( 'Posts not found', 'connections' ) ];
	}

	return $asset_posts_list;
}
