<?php
/**
 * Template part for popup asset block
 */

switch ( $asset_type ) :

    case 'image': ?>

        <?php if ( $asset_data ) : ?>
            <div class="cn-asset-popup-wrap">
                <img src="<?php echo esc_url( wp_get_attachment_image_url( $asset_data, 'full') ); ?>" alt="image">
            </div>
        <?php endif; ?>

        <?php break;

    case 'audio': ?>

        <div class="cn-asset-popup-wrap">
            <?php conn_get_brightcove_source_code( 'audio', $brightcove_user_id, $brightcove_player_id, $asset_data, 'library-' . $popup_id, ' data-autoplay="autoplay" ' ); ?>
        </div>

        <?php break;

    case 'video':

        $aspect_ratio = get_post_meta( $asset_id, 'aspect_ratio', true ); ?>

        <div class="cn-asset-popup-wrap cn-content-wrapp <?php echo $aspect_ratio; ?>">
            <?php conn_get_brightcove_source_code( 'video', $brightcove_user_id, $brightcove_player_id, $asset_data, 'library-' . $popup_id, '', $aspect_ratio ); ?>
        </div>
        
        <?php break;
    
    case 'pdf':
        
        if ( $asset_data ) :

            if ( class_exists( 'WonderPlugin_PDF_Plugin' ) ) :
                $iframe = do_shortcode( '[wonderplugin_pdf src="' . esc_url( $asset_data ) . '" ]' );
                $iframe = str_replace( 'src=', 'data-src=', $iframe );
                echo $iframe;
                // TO DO DELETE
                // echo do_shortcode( '[wonderplugin_pdf src="' . esc_url( $asset_data ) . '" ]' );
            else : ?>
                <div class="cn-asset-popup-wrap">
                    <object data="<?php echo esc_url( $asset_data ); ?>" type="application/pdf"></object>
                </div>
            <?php endif;

        endif; ?>
        
        <?php break;
    
    case 'html': 

        $asset_zip_id = get_post_meta( $asset_id, 'asset_zip', true );
        $path_id = "{$asset_id}_{$asset_zip_id}";
        $src_html = conn_get_path_unzip_html( $path_id, 'baseurl' );

        if ( $src_html ) : ?>
            <div class="cn-asset-popup-wrap">
                <?php if ( $asset_id && $asset_zip_id ) : ?>
                    <span class="js-iframe-html js-lazy-loader-iframe" data-src="<?php echo esc_attr( $src_html ); ?>"></span>
                <?php else :
                    _e( 'Not found', 'connections' );
                endif; ?>
            </div>
        <?php endif;

        break;
    
    case 'iframe':

        $asset_iframe = get_field( 'asset_iframe', $asset_id ); 
        
        if ( ! empty( $asset_iframe ) ):
            echo wp_kses_post( $asset_iframe );
        else:
            _e( 'Not found', 'connections' );
        endif;

    break;

endswitch; 


