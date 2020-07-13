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
$type_icon          = get_post_meta( $asset_id, 'asset_icon_type', true ) ?: 'font';

$asset_icons        = get_field( 'asset_icons', 'option' );
$asset_font_icons   = get_field( 'asset_font_icons', 'option' );

// Asset icon
if ( $type_icon == 'icon' ) {

    $asset_icon_url     = isset( $asset_icons[ $asset_type ] ) ? $asset_icons[ $asset_type ] : '';
    $asset_icon_id      = get_post_meta( $asset_id, 'asset_icon', true );
    if ( $asset_icon_id ) {
        $asset_icon_url =  wp_get_attachment_image_url( $asset_icon_id, 'full' );
    }

} else {

    $asset_icon = isset( $asset_font_icons[ $asset_type ] ) ? $asset_font_icons[ $asset_type ] : '';

    if ( get_field( 'asset_font_icon' ) ) {
        $asset_icon = get_field( 'asset_font_icon' );
    }
    
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

if ( $asset_type == 'pdf' ) {
    $asset_item_class   .= ' js-lazy-load-asset-pdf';
}

// Item wrap class
$asset_item_wrap_class  = '';
$asset_item_wrap_class .= ( $asset_type == 'audio' ) ? ' js-audio-asset' : '';

$icon_wrap_classes  = '';
$icon_wrap_classes .= ( ! empty( $bg_color_icon ) ) ? " {$bg_color_icon}" : '';

$icon_classes  = '';
$icon_classes .= ( ! empty( $color_icon ) ) ? " {$color_icon}" : '';
$icon_classes .= ( ! empty( $asset_icon ) ) ? " {$asset_icon}" : '';

?>

<div class="cn-asset__item <?php echo $asset_item_wrap_class; ?>">
    
    <a href="#library-<?php echo esc_attr( $unique_section_id ); ?>" class="cn-asset-item__link <?php echo esc_attr( $asset_item_class); ?>">
    
    <div class="cn-asset-item">
        <div class="cn-asset-item__image <?php echo esc_attr( $icon_wrap_classes ); ?>">

            <?php 
            if ( $type_icon == 'icon' ) :
                if ( ! empty( $asset_icon_url ) ) : ?>
                    <img src="<?php echo $asset_icon_url; ?>" alt="icon">
                <?php endif;
            else : ?>
                <span class="<?php echo esc_attr( $icon_classes ); ?>"></span>
            <?php endif;
            
            // State icon
            if ( $asset_type == 'audio' ) : ?>
                <i class="fa cn-asset-item__icon-state" aria-hidden="true"></i>
                <i class="fa fa-pause cn-asset-item__icon-paused"></i>
            <?php endif; ?>

        </div>

        <?php if ( $alt_title ) : ?>
            <div class="cn-asset-item__bottom text-center">
                <h5 class="cn-asset-item__title"><?php echo esc_html( $alt_title ); ?></h5>
            </div>
        <?php endif; ?>

    </div>
	</a>
</div>


<?php 

conn_asset_popup( $asset_id, "library-{$unique_section_id}" );