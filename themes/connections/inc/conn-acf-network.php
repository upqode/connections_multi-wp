<?php
/**
 * @package connections
 */
if ( is_multisite() && is_main_site() ) {

    function conn_acf_netw_options_meta_box() {

        $screens = array( 'acf-field-group' );

        foreach ( $screens as $screen ) {
            add_meta_box(
                    'global-notice',
                    __( 'Subsite Options', 'connections' ), 'conn_subsite_acf_restrict_cb',
                    $screen
            );
        }
    }

    add_action( 'add_meta_boxes', 'conn_acf_netw_options_meta_box' );

    function conn_subsite_acf_restrict_cb() {
        global $post;

        $value = intval( get_post_meta( $post->ID, 'duplicate_acf_to_subsites', true ) );
        $ch = $value == 1 ? 'checked' : '';
        ?>
        <label for="duplicate_acf_to_subsites">
            <input name="duplicate_acf_to_subsites"
                   type="checkbox"
                   id="duplicate_acf_to_subsites"
                   value="1"
                   <?php echo $ch; ?> >
                   <?php _e( 'Duplicate For Subsites', 'connections' ); ?>
        </label>
        <?php
    }

    /**
     * Save metabox data
     * @param int $post_id
     * @return void
     */
    function save_global_notice_meta_box_data( $post_id ) {

        // Check if our nonce is set.
        if ( !isset( $_POST[ 'duplicate_acf_to_subsites' ] ) )
            return;

        // Update the meta field in the database.
        $duplicate_acf_to_subsites = intval( $_POST[ 'duplicate_acf_to_subsites' ] );
        update_post_meta( $post_id, 'duplicate_acf_to_subsites', $duplicate_acf_to_subsites );
    }

    add_action( 'save_post', 'save_global_notice_meta_box_data' );
}

/**
 * Fully Duplicate Post
 * @param int $original_id
 * @param array $args
 * @return int (new post ID)
 */
function conn_duplicate_post( $original_id, $args = array() ) {
    // Get access to the database
    global $wpdb;
    $global_settings = array(
        "status" => "same",
        "type" => "same",
        "timestamp" => "current",
        "title" => " Copy",
        "slug" => "_copy",
        "time_offset" => false,
        "time_offset_days" => 0,
        "time_offset_hours" => 0,
        "time_offset_minutes" => 0,
        "time_offset_seconds" => 0,
        "time_offset_direction" => "newer"
    );

    // Get the post as an array
    $duplicate = get_post( $original_id, 'ARRAY_A' );

    $settings = wp_parse_args( $args, $global_settings );

    // Modify Title
    if ( $settings[ 'title' ] != '' )
        $duplicate[ 'post_title' ] .= $settings[ 'title' ];

    // Modify Slug
    if ( $settings[ 'slug' ] != '' )
        $duplicate[ 'post_name' ] .= $settings[ 'slug' ];

    // Set the status
    if ( $settings[ 'status' ] != 'same' ) {
        $duplicate[ 'post_status' ] = $settings[ 'status' ];
    }

    // Set the type
    if ( $settings[ 'type' ] != 'same' ) {
        $duplicate[ 'post_type' ] = $settings[ 'type' ];
    }

    // Set the post date
    $timestamp = ( $settings[ 'timestamp' ] == 'duplicate' ) ? strtotime( $duplicate[ 'post_date' ] ) : current_time( 'timestamp', 0 );
    $timestamp_gmt = ( $settings[ 'timestamp' ] == 'duplicate' ) ? strtotime( $duplicate[ 'post_date_gmt' ] ) : current_time( 'timestamp', 1 );

    if ( $settings[ 'time_offset' ] ) {
        $offset = intval( $settings[ 'time_offset_seconds' ] + $settings[ 'time_offset_minutes' ] * 60 + $settings[ 'time_offset_hours' ] * 3600 + $settings[ 'time_offset_days' ] * 86400 );
        if ( $settings[ 'time_offset_direction' ] == 'newer' ) {
            $timestamp = intval( $timestamp + $offset );
            $timestamp_gmt = intval( $timestamp_gmt + $offset );
        } else {
            $timestamp = intval( $timestamp - $offset );
            $timestamp_gmt = intval( $timestamp_gmt - $offset );
        }
    }
    $duplicate[ 'post_date' ] = date( 'Y-m-d H:i:s', $timestamp );
    $duplicate[ 'post_date_gmt' ] = date( 'Y-m-d H:i:s', $timestamp_gmt );
    $duplicate[ 'post_modified' ] = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
    $duplicate[ 'post_modified_gmt' ] = date( 'Y-m-d H:i:s', current_time( 'timestamp', 1 ) );

    // Remove some of the keys
    unset( $duplicate[ 'ID' ] );
    unset( $duplicate[ 'guid' ] );
    unset( $duplicate[ 'comment_count' ] );

    // Insert the post into the database
    $duplicate_id = wp_insert_post( $duplicate );

    // Duplicate all the taxonomies/terms
    $taxonomies = get_object_taxonomies( $duplicate[ 'post_type' ] );
    foreach ( $taxonomies as $taxonomy ) {
        $terms = wp_get_post_terms( $original_id, $taxonomy, array( 'fields' => 'names' ) );
        wp_set_object_terms( $duplicate_id, $terms, $taxonomy );
    }

    // Duplicate all the custom fields
    $custom_fields = get_post_custom( $original_id );
    foreach ( $custom_fields as $key => $value ) {
        if ( is_array( $value ) && count( $value ) > 0 ) {
            foreach ( $value as $i => $v ) {
                $result = $wpdb->insert( $wpdb->prefix . 'postmeta', array(
                    'post_id' => $duplicate_id,
                    'meta_key' => $key,
                    'meta_value' => $v
                        ) );
            }
        }
    }

    return $duplicate_id;
}
