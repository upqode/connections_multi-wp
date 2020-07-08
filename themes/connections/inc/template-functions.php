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

    /* TO DO DELETE
     * template for options subpage
	 acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	 ));
    */
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

	$asset_type = isset( $_POST['acf']['field_5ccac25b97adf'] ) ? $_POST['acf']['field_5ccac25b97adf'] : get_post_meta( $asset_id, 'asset_type', true );
	$current_blog_id = get_current_blog_id();
	$subsite_folder = "subsite_{$current_blog_id}";
	$action = isset( $_POST['action'] ) ? $_POST['action'] : '';

	if ( $asset_type == 'html' ) {

		$new_zip_id = isset( $_POST['acf']['field_5ccac4bb70090'] ) ? $_POST['acf']['field_5ccac4bb70090'] : '';
		$asset_zip_id = ( $new_zip_id ) ? $new_zip_id : get_post_meta( $asset_id, 'asset_zip', true );

		$asset_zip_url = wp_get_attachment_url( $asset_zip_id );

		if ( ! empty( $asset_zip_url ) ) {

			$unique_id = "{$asset_id}_{$asset_zip_id}"; // nothing broken if user change .zip-file in settings
			$path_html = conn_unzip_file( $asset_zip_url, $unique_id );
			
		}

		// Clean unzip folder
		if ( empty( $new_zip_id ) && $action == 'editpost' ) {
			conn_clean_unzip_assets( $asset_id );
		}

	}

}

add_action( 'save_post_cn-asset', 'conn_unzip_asset' );
add_action( 'publish_cn-asset', 'conn_unzip_asset' );


/**
 * Remove unnecessary files when asset delete
 */
function conn_remove_unzip_files_trash_asset( $id ) {

	if ( get_post_type( $id ) == 'cn-asset' ) {
		
		conn_clean_unzip_assets( $id );

	}

}

add_action('delete_post', 'conn_remove_unzip_files_trash_asset');


/**
 * Remove unnecessary files when subsite delete
 */
function conn_remove_unzip_files_delete_subsite( $id ) {

	$dir_subsite = conn_get_path_unzip_html('');
	// $dirs = glob( "{$src_html}*", GLOB_ONLYDIR );
	conn_delete_directory( $dir_subsite );

}

add_action('delete_blog', 'conn_remove_unzip_files_delete_subsite');


/**
 * Add iFrame to allowed wp_kses_post tags
 *
 * @param array  $tags Allowed tags, attributes, and/or entities.
 * @param string $context Context to judge allowed tags by. Allowed values are 'post'.
 *
 * @return array
 */
function conn_wpkses_post_tags( $tags, $context ) {

	if ( 'post' === $context ) {
		$tags['iframe'] = array(
			'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
		);
	}

	return $tags;
}

add_filter( 'wp_kses_allowed_html', 'conn_wpkses_post_tags', 10, 2 );


/**
 * Hide admin bar for non-admins and non content manager
 */
function conn_hide_admin_bar( $show ) {

	if ( ! current_user_can( 'administrator' ) && ! current_user_can( 'content-manager' ) ) {
		return false;
	}

	return $show;
}

add_filter( 'show_admin_bar', 'conn_hide_admin_bar' );


/**
 * Block wp-admin access for non-admins and non content manager
 */
function conn_wp_admin() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! current_user_can( 'content-manager' ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

add_action( 'admin_init', 'conn_wp_admin' );


/**
 * Run init
 */
function conn_init() {

	/**
	 * Add access to WP All Export Plugin for a user whose role is a content manager
	 */
	if ( is_user_logged_in() && class_exists( 'PMXE_Plugin' ) ) {
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;
		if ( in_array( 'content-manager', $roles ) ) {
			PMXE_Plugin::$capabilities = 'read';
			// Disable access some option PMXE_Plugin for a user whose role is a content manager
			if ( isset( $_GET['page'] ) && ( $_GET['page'] == 'pmxe-admin-export' || $_GET['page'] == 'pmxe-admin-settings' ) ) {
				wp_redirect( admin_url('admin.php?page=pmxe-admin-manage') );
			}
		}
	}

}

add_action( 'init', 'conn_init' );