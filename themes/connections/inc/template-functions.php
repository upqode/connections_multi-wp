<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package connections
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function conn_body_classes( $classes ) {

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'conn_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function conn_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'conn_pingback_header' );

/**
 * Add Options Page
 */
if ( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Options',
		'menu_title'	=> 'Site Options',
		'menu_slug' 	=> 'general-options',
		'capability'	=> 'manage_options',
		'redirect'		=> false
	));

	// Newtwork Options
	acf_add_options_page([
	    'network' 		=> true,
	    'post_id' 		=> 'acf_network_options',
	    'page_title' 	=> 'Network Options',
	    'menu_title' 	=> 'Network Options'
	]);

    /**
     * template for options subpage
	 acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	 ));
    */
}

/**
 * Get Main site link
 * @return boolean
 */
function conn_main_link(){
    if( !is_multisite() || is_main_site() )
        return false;

    return main_site_link();
}


/**
 * Added to extend allowed files types in Media upload
 */
function conn_upload_mimes ( $existing_mimes = array() ) {

    // Add *.zip files to Media upload
    $existing_mimes['zip'] = 'application/zip';

    return $existing_mimes;
}

add_filter('upload_mimes', 'conn_upload_mimes');


/**
 * Add buttons for toolbar
 */
function conn_mce_buttons_2( $buttons ) {	
	/**
	 * Add in a core button that's disabled by default
	 */
	$buttons[] = 'superscript';
	$buttons[] = 'subscript';

	return $buttons;
}

add_filter( 'mce_buttons_2', 'conn_mce_buttons_2' );


/**
 * Unzip assets when asset created
 */
function conn_unzip_asset( $asset_id ) {

	$asset_type = get_post_meta( $asset_id, 'asset_type', true );
	$current_blog_id = get_current_blog_id();
	$subsite_folder = "subsite_{$current_blog_id}";

	if ( $asset_type == 'html' ) {

		$asset_zip_id = get_post_meta( $asset_id, 'asset_zip', true );
		$asset_zip_url = wp_get_attachment_url( $asset_zip_id );
		// $path_upload_file = conn_path_uploads( 'basedir' ) . "/{$subsite_folder}/unip_files/zip_{$asset_id}_{$asset_zip_id}";

		if ( ! empty( $asset_zip_url ) ) {

			$unique_id = "{$asset_id}_{$asset_zip_id}"; // nothing broken if user change .zip-file in settings
			$path_html = conn_unzip_file( $asset_zip_url, $unique_id );
			
		}
	}

}

add_action( 'save_post_cn-asset', 'conn_unzip_asset' );