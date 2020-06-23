<?php
/**
 * Template part for asset block
 */

    global $brightcove_user_id, $brightcove_player_id;

    $asset_item_wrap_class = '';
    $asset_id           = isset( $asset_id ) ? $asset_id : get_the_ID();
    $asset_type         = get_post_meta( $asset_id, 'asset_type', true );
    $unique_section_id  = $asset_id . '-' . rand( 0, 999 );
    $alt_title          = get_post_meta( $asset_id, 'asset_alt_title', true ) ?: get_the_title();

    $asset_icon_id      = get_post_meta( $asset_id, 'asset_icon', true );
    $asset_icon_url     = ( ! empty( $asset_icon_id ) ) ? wp_get_attachment_image_url( $asset_icon_id, 'full' ) : '';

    $asset_item_class   = '';

    if ( $asset_type != 'audio' ) {
        $asset_item_class   .= ' js-popup';
    }

    if ( $asset_type == 'audio' || $asset_type == 'video' ) {
        $asset_item_class   .= ' js-item-BC';
    }

    if ( $asset_type == 'html' ) {
        $asset_item_class   .= ' js-item-html';
    }

    $asset_fa_icon  = get_post_meta( $asset_id, 'asset_fa_icon', true );

    $asset_item_wrap_class .= ( $asset_type == 'audio' ) ? ' js-audio-asset' : '';

    if ( ! empty( $title_color_item ) ) {
        $asset_item_wrap_class .= " $title_color_item";
    }
?>

<div class="cn-asset__item js-glossary-item--icon <?php echo $asset_item_wrap_class; ?>">
    
    <a href="#library-<?php echo esc_attr( $unique_section_id ); ?>" class="cn-asset-item__link <?php echo esc_attr( $asset_item_class); ?>">dasdasdasdad</a>
    
    <div class="cn-asset-item">
        <div class="cn-asset-item__image">
            <?php if ( ! empty( $asset_fa_icon ) ) : ?>
               <i class="fa <?php echo $asset_fa_icon;  ?>"></i>
             <?php elseif ( ! empty( $asset_icon_url ) ) : ?>
                <img src="<?php echo $asset_icon_url; ?>" alt="icon">
            <?php endif;
            if ( $asset_type == 'audio' ) : ?>
                <!-- <i class="fa fa-play cn-asset-item__icon-state" aria-hidden="true"></i> -->
            <?php endif; ?>
        </div>

        <?php if ( $alt_title ) : ?>
            <div class="cn-asset-item__bottom cn-txt-center">
                <h5 class="cn-asset-item__title"><?php echo esc_html( $alt_title ); ?></h5>
            </div>
        <?php endif; ?>
    </div>
</div>

<div id="library-<?php echo esc_attr( $unique_section_id ); ?>" class="white-popup-block mfp-hide cn-popup-wrap <?php echo $asset_type; ?>">

    <?php switch ( $asset_type ) :

        case 'image':
            $asset_img_id = get_post_meta( $asset_id, 'asset_image', true ); ?>
            <div class="cn-content-wrapp">
                <?php echo wp_get_attachment_image( $asset_img_id, 'full' ); ?>
            </div>
            <?php break;

        case 'audio':
            $asset_audio = get_post_meta( $asset_id, 'asset_audio', true ); ?>
            <div class="cn-content-wrapp cn-content-wrapp--width">
                <?php conn_get_brightcove_source_code( 'audio', $brightcove_user_id, $brightcove_player_id, $asset_audio, 'library-' . $unique_section_id, 'data-autoplay="autoplay"' ); ?>
            </div>
            <?php break;

        case 'video':
            $asset_video = get_post_meta( $asset_id, 'asset_video', true );
            $aspect_ratio = get_post_meta( $asset_id, 'aspect_ratio', true ); ?>
            <div class="cn-content-wrapp cn-content-wrapp--width <?php echo $aspect_ratio; ?>">
                <?php conn_get_brightcove_source_code( 'video', $brightcove_user_id, $brightcove_player_id, $asset_video, 'library-' . $unique_section_id, '', $aspect_ratio ); ?>
            </div>
            <?php break;
        
        case 'pdf':
            $asset_pdf_id = get_post_meta( $asset_id, 'asset_pdf', true );
            $asset_pdf_url = wp_get_attachment_url( $asset_pdf_id );
                
            if ( class_exists( 'WonderPlugin_PDF_Plugin' ) ) :
                echo do_shortcode( '[wonderplugin_pdf src="' . esc_url( $asset_pdf_url ) . '" ]' );
            else : ?>
                <div class="cn-content-wrapp cn-content-wrapp--full">
                    <object data="<?php echo esc_url( $asset_pdf_url ); ?>" type="application/pdf"></object>
                </div>
            <?php endif; ?>
            <?php break;
        
        case 'html':

            $asset_zip_id = get_post_meta( $asset_id, 'asset_zip', true );
            // $asset_zip_url = wp_get_attachment_url( $asset_zip_id );
            // $path_upload_file = conn_path_uploads( 'basedir' ) . '/unip_files/zip_' . $asset_id . '_' . $asset_zip_id; ?>

            <div class="cn-content-wrapp cn-content-wrapp--full">
                <?php 
                $unique_id = "{$asset_id}_{$asset_zip_id}";
                $src_html = conn_get_path_unzip_html( $unique_id, 'baseurl' ); ?>

                <span class="js-iframe-html" data-src="<?php echo esc_attr( $src_html ); ?>"></span>

                <?php
                // TO DO DELETE
                /* if ( ! empty( $asset_zip_url ) ) :
                    // check if the directory is already exists
                    if ( ! is_dir( $path_upload_file ) ) {
                        $unique_id = $asset_id . '_' . $asset_zip_id;    // nothing broken if user change .zip-file in settings
                        $path_html = conn_unzip_file( $asset_zip_url, $unique_id );
                    } else {
                        $path_html = $path_upload_file;
                    }

                    $src_html = conn_get_unzip_files( $path_html );
                    
                    if ( ! empty( $src_html[0] ) ) : ?>
                        <!-- <iframe src="<?php echo esc_attr( $src_html[0] ); ?>"></iframe> -->
                        <span class="js-iframe-html" data-src="<?php echo esc_attr( $src_html[0] ); ?>"></span>
                    <?php endif;
                endif; */
                ?> 
            </div>
            <?php break;
        
        case 'iframe':

            $asset_iframe = get_field( 'asset_iframe', $asset_id ); 
            
            if ( ! empty( $asset_iframe ) ):
                echo $asset_iframe;
            endif;

        break;

    endswitch; ?>        

</div>
