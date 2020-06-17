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
 * Get background color list
 * @return array
 */
function cn_get_bg_colors() {

    if ( ! function_exists( 'get_field' ) )
        return [];

    $bg_colors = [];
    $count_colors = 7;
    
    for ( $i = 0; $i < $count_colors; $i++ ) {
        $color = get_field( "bg_main_color_{$i}", "acf_network_options" );
        if ( $color ) {
            $bg_colors[] = $color;
        }
    }

    return $bg_colors;

}

/**
 * Color List
 * @param string $type
 * @param string $type_prefix
 * @return array
 */
function cn_color_list( $type = 'Color', $type_prefix = '' ) {
    return array(
        esc_html__( $type . ' - transparent', 'connections' )               => 'lk-' . $type_prefix . '-transparent',
        esc_html__( $type . ' - navy', 'connections' )                      => 'lk-' . $type_prefix . '-navy',
        esc_html__( $type . ' - light-blue', 'connections' )                => 'lk-' . $type_prefix . '-light-blue',
        esc_html__( $type . ' - grey', 'connections' )                      => 'lk-' . $type_prefix . '-grey',
        esc_html__( $type . ' - white', 'connections' )                     => 'lk-' . $type_prefix . '-white',
        esc_html__( $type . ' - black', 'connections' )                     => 'lk-' . $type_prefix . '-black',
    );
}

function cn_alternate_color_list( $type = 'Color', $type_prefix = '' ) {
    return array(
        esc_html__( $type . ' - transparent', 'connections' )               => 'lk-p-' . $type_prefix . '-transparent',
        esc_html__( $type . ' - pale blue', 'connections' )                 => 'lk-p-' . $type_prefix . '-pale-blue',
        esc_html__( $type . ' - muted blue', 'connections' )                => 'lk-p-' . $type_prefix . '-muted-blue',
        esc_html__( $type . ' - orange', 'connections' )                    => 'lk-p-' . $type_prefix . '-orange',
        esc_html__( $type . ' - light gray', 'connections' )                => 'lk-p-' . $type_prefix . '-light-gray',
        esc_html__( $type . ' - white', 'connections' )                     => 'lk-p-' . $type_prefix . '-white',
        esc_html__( $type . ' - navy', 'connections' )                      => 'lk-p-' . $type_prefix . '-navy',
        esc_html__( $type . ' - light-blue', 'connections' )                => 'lk-p-' . $type_prefix . '-light-blue',
    );
}

function cn_border_color( $type = 'Border' ) {
	return array(
		esc_html__( $type . ' - blue', 'connections' )                => 'lk-brd-blue',
		esc_html__( $type . ' - orange', 'connections' )              => 'lk-brd-orange',
		esc_html__( $type . ' - yellow', 'connections' )              => 'lk-brd-yellow',
		esc_html__( $type . ' - white', 'connections' )               => 'lk-brd-white',
		esc_html__( $type . ' - red', 'connections' )                 => 'lk-brd-red',
		esc_html__( $type . ' - vivid blue', 'connections' )          => 'lk-brd-vivid-blue',
		esc_html__( $type . ' - light gray', 'connections' )          => 'lk-brd-light-gray',
		esc_html__( $type . ' - dark gray', 'connections' )           => 'lk-brd-dark-gray',
	);
}


function cn_button_color_list( $type = 'Color', array $add_colors = [] ) {
	$colors = array(
		esc_html__( $type . ' - pale blue', 'connections' )           => '-pale-blue',
		esc_html__( $type . ' - muted blue', 'connections' )          => '-muted-blue',
		esc_html__( $type . ' - white', 'connections' )               => '-white',
		esc_html__( $type . ' - light gray', 'connections' )          => '-light-gray',
		esc_html__( $type . ' - dark gray', 'connections' )           => '-dark-gray',
    );

    if ( $add_colors ) {
        array_unshift( $colors, $add_colors );
    }
    
    return $colors;
}

function cn_button_color_list2( $type = 'Color', array $add_colors = [] ) {
	$colors = array(
        esc_html__( $type . ' - navy', 'connections' )                      => '-navy',
        esc_html__( $type . ' - light-blue', 'connections' )                => '-light-blue',
        esc_html__( $type . ' - grey', 'connections' )                      => '-grey',
        esc_html__( $type . ' - white', 'connections' )                     => '-white',
        esc_html__( $type . ' - black', 'connections' )                     => '-black',
    );

    if ( $add_colors ) {
        array_unshift( $colors, $add_colors );
    }
    
    return $colors;
}

function cn_custom_color_list( $type = 'Background color' ) {
	return array(
		esc_html__( $type . ' - blue', 'connections' )                => '#425563',
		esc_html__( $type . ' - orange', 'connections' )              => '#F7941D',
		esc_html__( $type . ' - yellow', 'connections' )              => '#FFC56E',
		esc_html__( $type . ' - white', 'connections' )               => '#FFFFFF',
		esc_html__( $type . ' - red', 'connections' )                 => '#E56A54',
		esc_html__( $type . ' - vivid blue', 'connections' )          => '#5E8AB4',
		esc_html__( $type . ' - light gray', 'connections' )          => '#E4E5E5',
		esc_html__( $type . ' - dark gray', 'connections' )           => '#8F8F8F',
	);
}



function cn_get_asset_posts( $return_key_title = false, $asset_type = '' ) {
	$asset_posts_list = array();

	$args = array(
		'post_type'       => 'ch-asset',
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
