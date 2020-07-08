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

	global $is_active_ACF, $brightcove_user_id, $brightcove_player_id;

	$is_active_ACF = class_exists( 'ACF' ) ? true : false;
	$brightcove_user_id = $is_active_ACF ? get_field( 'brightcove_user_id', 'option' ) : '';
	$brightcove_player_id = $is_active_ACF ? get_field( 'brightcove_player_id', 'option' ) : '';

	wp_enqueue_style( 'connections-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'font-awesome', CN_THEME_URI . '/assets/css/font-awesome.css', array(), _S_VERSION );
	wp_enqueue_style( 'bootstrap-grid', CN_THEME_URI . '/assets/css/bootstrap-grid.css', array(), _S_VERSION );
	wp_enqueue_style( 'magnific-popup', CN_THEME_URI . '/assets/css/magnific-popup.css', array(), _S_VERSION );
	wp_enqueue_style('connections-header', CN_THEME_URI . '/assets/css/header.css', array(),_S_VERSION);
	wp_enqueue_style('connections-banner', CN_THEME_URI . '/assets/css/banner.css', array(),_S_VERSION);
	wp_enqueue_style('connections-typography', CN_THEME_URI . '/assets/css/typography.css', array(),_S_VERSION);
	wp_enqueue_style('connections-table', CN_THEME_URI . '/assets/css/table.css', array(),_S_VERSION);
	wp_enqueue_style('connections-sheet', CN_THEME_URI . '/assets/css/sheet.css', array(),_S_VERSION);
	wp_enqueue_style('connections-accordion', CN_THEME_URI . '/assets/css/accordion.css', array(),_S_VERSION);
	wp_enqueue_style('connections-colout', CN_THEME_URI . '/assets/css/colout.css', array(),_S_VERSION);
	wp_enqueue_style('connections-tabs', CN_THEME_URI . '/assets/css/tabs.css', array(),_S_VERSION);
	wp_enqueue_style('connections-search', CN_THEME_URI . '/assets/css/search.css', array(),_S_VERSION);
	wp_enqueue_style('connections-video_multi', CN_THEME_URI . '/assets/css/video_multi.css', array(),_S_VERSION);
	wp_enqueue_style('connections-content_block', CN_THEME_URI . '/assets/css/content_block.css', array(),_S_VERSION);
	wp_enqueue_style('connections-featured_links', CN_THEME_URI . '/assets/css/featured_links.css', array(),_S_VERSION);
	wp_enqueue_style('connections-asset-library', CN_THEME_URI . '/assets/css/asset-library.css', array(),_S_VERSION);
	wp_enqueue_style('connections-next_back_link', CN_THEME_URI . '/assets/css/next_back_link.css', array(),_S_VERSION);

	$custom_css = '';
	$custom_css .= conn_bg_colors_css();
	$custom_css .= conn_text_colors_css();
	$custom_css .= conn_border_colors_css();

	if ( $custom_css ) {
		wp_add_inline_style( 'connections-style', $custom_css );
	}

	wp_style_add_data( 'connections-style', 'rtl', 'replace' );

//	wp_enqueue_script( 'brightcove-player', "//players.brightcove.net/{$brightcove_user_id}/{$brightcove_player_id}_default/index.min.js?ver=5.0.4", array(), _S_VERSION, true );
	
	wp_enqueue_script( 'magnific-popup', CN_THEME_URI . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), time(), true );
	wp_enqueue_script( 'connections-main', CN_THEME_URI . '/assets/js/main.js', array('jquery'), time(), true );
	wp_enqueue_script( 'connections-user-quest', CN_THEME_URI . '/assets/js/user-quest.js', array('jquery'), time(), true );

	// Localize
	wp_localize_script('connections-main', 'connections_data',
		array(
			'brigtcovePlayerData' => [
				'accountId' => $brightcove_user_id,
				'playerId'  => $brightcove_player_id,
			],
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}

add_action( 'wp_enqueue_scripts', 'connections_scripts' );


/**
 * Admin Scripts
 */
function conn_admin_scripts() {

    $user  = wp_get_current_user();
	$roles = ( array ) $user->roles;
	    
    // Hide some option PMXE_Plugin for a user whose role is a content manager
    if ( in_array( 'content-manager', $roles ) ) {
        $css = '
        .toplevel_page_pmxe-admin-home .wp-submenu .wp-first-item, 
        .toplevel_page_pmxe-admin-home .wp-submenu > li:last-child,
        .toplevel_page_pmxe-admin-home.opensub .wp-submenu .wp-first-item, 
        .toplevel_page_pmxe-admin-home.opensub .wp-submenu > li:last-child {
            display: none !important;
        }';
        wp_add_inline_style( 'pmxe-admin-style', $css );
    }
    
}

add_action( 'admin_enqueue_scripts', 'conn_admin_scripts' );



function wpb_add_google_fonts() {
	wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat', false );
}

add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

