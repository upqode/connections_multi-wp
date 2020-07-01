<?php
/*
Plugin Name: Connections
Description: Include Shortcodes Visual Composer and custom post types
Author: Upqode
Version: 1.0.0
*/

defined( 'CN_DIR_PATH' ) or define( 'CN_DIR_PATH', plugin_dir_path( __FILE__ ) );

$cur_theme = wp_get_theme();    
if ( stripos( $cur_theme->get( 'Name' ), 'connections' ) === false ) {
    return;
}

/**
 * Class Connection Plugin
 */

class ConnectionsThemePlugin {

        /**
         * Constructor
         */
        public function __construct() {

            $this->includes();

            add_action( 'vc_before_init', array( $this, 'custom_shortcodes' ) );
            add_action( 'vc_after_init', array( $this, 'vc_after_init_actions' ) );
        }

        /**
         * Includes
         */
        private function includes() {

            require_once CN_DIR_PATH . '/includes/post-types.php';
            require_once CN_DIR_PATH . '/includes/helper-functions.php';
            require_once CN_DIR_PATH . '/includes/visual-composer/vc-functions.php';
            
        }

        /**
         * After vc init
         */
        public function vc_after_init_actions() {
            require_once CN_DIR_PATH . '/includes/visual-composer/vc-extends/vc-init.php';
        }

        /**
         * Before vc init
         */
        public function custom_shortcodes() {

            require_once CN_DIR_PATH . '/includes/visual-composer/base-shortcode.php';

            $shortcodes = [
                'asset',
                'accordion',
                'banner',
                'sheet',
                'table',
                'tabs',
                'callout',
                'video-multi',
                'next-back-links',
                'featured-links',
                'content-block',
                'asset-library',
            ];

            // Order shortcodes
            sort( $shortcodes );

            foreach ( $shortcodes as $shortcode ) {

                $file = CN_DIR_PATH . "includes/visual-composer/shortcodes/{$shortcode}/{$shortcode}.php";

                if ( file_exists( $file ) ) {
                    include_once $file;
                }
            }
        }

}

new ConnectionsThemePlugin;
