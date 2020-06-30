<?php
/**
 * Template part for asset block
 */

if ( ! function_exists( 'get_field' ) )
    return;

global $brightcove_user_id, $brightcove_player_id;

$asset_id           = isset( $asset_id ) ? $asset_id : get_the_ID();
$asset_type         = get_post_meta( $asset_id, 'asset_type', true );
$unique_section_id  = $asset_id . '-' . rand( 0, 999 );
$alt_title          = get_post_meta( $asset_id, 'asset_alt_title', true ) ?: get_the_title();
$asset_icons        = get_field( 'asset_icons', 'option' );

// Asset icon
$asset_icon_url     = isset( $asset_icons[ $asset_type ] ) ? $asset_icons[ $asset_type ] : '';
$asset_icon_id      = get_post_meta( $asset_id, 'asset_icon', true );
if ( $asset_icon_id ) {
    $asset_icon_url =  wp_get_attachment_image_url( $asset_icon_id, 'full' );
}

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

// Item wrap class
$asset_item_wrap_class  = '';
$asset_item_wrap_class .= ( $asset_type == 'audio' ) ? ' js-audio-asset' : '';

?>

<div class="cn-asset__item <?php echo $asset_item_wrap_class; ?>">
    
    <a href="#library-<?php echo esc_attr( $unique_section_id ); ?>" class="cn-asset-item__link <?php echo esc_attr( $asset_item_class); ?>">test text</a>
    
    <div class="cn-asset-item">
        <div class="cn-asset-item__image">

            <?php if ( ! empty( $asset_icon_url ) ) : ?>
                <img src="<?php echo $asset_icon_url; ?>" alt="icon">
            <?php endif;
            
            if ( $asset_type == 'audio' ) : ?>
                <i class="fa fa-play cn-asset-item__icon-state" aria-hidden="true"></i>
            <?php endif; ?>

        </div>

        <?php if ( $alt_title ) : ?>
            <div class="cn-asset-item__bottom cn-txt-center">
                <h5 class="cn-asset-item__title"><?php echo esc_html( $alt_title ); ?></h5>
            </div>
        <?php endif; ?>

    </div>
</div>


<?php 

conn_asset_popup( $asset_id, "library-{$unique_section_id}" );