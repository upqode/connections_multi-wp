<?php
/**
 * Enqueue scripts and styles
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package connections
 */

/**
 * Enqueue scripts and styles.
 */
function connections_scripts() {

	wp_enqueue_style( 'connections-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'connections-style', 'rtl', 'replace' );

	wp_enqueue_script( 'connections-main', CN_THEME_URI . '/js/main.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'connections_scripts' );