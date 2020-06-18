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
function connections_body_classes( $classes ) {
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
add_filter( 'body_class', 'connections_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function connections_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'connections_pingback_header' );

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