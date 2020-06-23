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
	wp_enqueue_style( 'font-awesome11', CN_THEME_URI . '/assets/css/font-awesome.css', array(), time() );
	wp_enqueue_style('connections-header', CN_THEME_URI . '/assets/css/header.css', array(),_S_VERSION);

	$custom_css = '';
	$custom_css .= conn_bg_colors_css();

	if ( $custom_css ) {
		wp_add_inline_style( 'connections-style', $custom_css );
	}

	wp_style_add_data( 'connections-style', 'rtl', 'replace' );

	wp_enqueue_script( 'connections-jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'connections-main', CN_THEME_URI . '/assets/js/main.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}




}
add_action( 'wp_enqueue_scripts', 'connections_scripts' );