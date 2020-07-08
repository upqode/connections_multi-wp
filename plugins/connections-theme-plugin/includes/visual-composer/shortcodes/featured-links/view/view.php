<?php
/**
 * Return html shortcode.
 */

global $brightcove_user_id, $brightcove_player_id;

extract( $atts );

$class = ! empty( $el_class ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );
$class .= ( $bg_color ) ? " {$bg_color}" : '';

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}

$style_wrap = '';
$style_wrap .= ( $bg_img ) ? 'background-image: url(' . wp_get_attachment_image_url( $bg_img, 'full' ) . ');' : '';

if ( $style_wrap ) {
    $style_wrap = 'style="' . $style_wrap . '"';
}

// Title
$class_title = isset( $title_color ) ? " $title_color" : '';
$class_title .= ( $underline_title && $underline_color ) ? " border_{$underline_color} cn-featured-links__title-underline" : '';

$col_classes = [
    1 => ' col-12',
    2 => ' col-6',
    3 => ' col-4',
    4 => ' col-3',
];

?>

<div class="cn-featured-links <?php echo esc_attr( $class ); ?>" <?php echo $el_id; ?> <?php echo $style_wrap; ?>>
<div class="cn-featured-links-wrap">

    <?php if ( $title ) : ?>
        <h2 class="cn-featured-links__title <?php echo esc_attr( $class_title ); ?>"><?php echo esc_html( $title ); ?></h2>
    <?php endif; ?>

    <?php if ( $subtitle ) : ?>
        <p class="cn-featured-links__subtitle <?php echo esc_attr( $subtitle_color ); ?>"><?php echo esc_html( $subtitle ); ?></p>
    <?php endif; ?>

    <?php if ( ! empty( $content ) ) : ?>
        <div class="cn-featured-links__text">
            <?php echo do_shortcode( $content ); ?>
        </div>
    <?php endif; ?>
    
    <?php if ( ! empty( $items ) ) : ?>
        <div class="cn-featured-links__items">
            <?php foreach ( $items as $item ) :

                $asset_id = isset( $item['asset'] ) ? $item['asset'] : 0;
                $unique_id  = "asset_{$asset_id}_" . rand( 0, 99 );
                $asset_type = get_field( 'asset_type', $asset_id );

                // Item ID
                $el_item_id = ( ! empty( $item['el_id'] ) ) ? 'id="' . esc_attr( $item['el_id'] ) . '"' : '';
                
                // Item Class
                $items_class = '';
                $items_class .= ( ! empty( $item['el_class'] ) ) ? " {$item['el_class']}" : '';
                $items_class .= ( ! empty( $item['bg_color'] ) ) ? " {$item['bg_color']}" : '';
                $items_class .= ( ! empty( $item['border_color'] ) ) ? " border_{$item['border_color']}" : '';
                $items_class .= isset( $col_classes[ $column ] ) ? " {$col_classes[ $column ]}" : '';
                
                // Title class
                $title_class = '';
                $title_class .= isset( $item['title_color'] ) ? " {$item['title_color']}" : '';
                
                // Content class
                $content_class = '';
                $content_class .= isset( $item['text_color'] ) ? " {$item['text_color']}" : '';
                
                // Button class
                $btn_class = '';
                $btn_class .= ( ! empty( $item['btn_bg_color'] ) ) ? " {$item['btn_bg_color']}" : '';
                $btn_class .= ( ! empty( $item['btn_text_color'] ) ) ? " {$item['btn_text_color']}" : '';

                // Asset link class
                $asset_link_class = '';
                $asset_link_class .= ( $asset_type == 'audio' ) ? 'js-item-BC' : 'js-popup';
                $asset_link_class .= ( $asset_type == 'video' ) ? ' js-item-BC' : '';
                $asset_link_class .= ( $asset_type == 'html' ) ? ' js-item-html' : '';
                $asset_link_class .= ( $asset_type == 'pdf' ) ? ' js-lazy-load-asset-pdf' : '';

                $link = isset( $item['link'] ) ? vc_build_link( $item['link'] ) : [];
                $link_target = ( ! empty( $link['target'] ) ) ? 'target="' . $link['target'] . '" ' : '';
                $nof_link    = ( ! empty( $link['rel'] ) ) ? 'rel="' . $link['rel'] .'"' : ''; ?>

                <div class="cn-featured-links__items__item <?php echo esc_attr( $items_class ); ?>" <?php echo $el_item_id; ?>>

                    <?php if ( ! empty( $item['title'] ) ) : ?>
                        <h3 class="title <?php echo esc_attr( $title_class ); ?>">
                            <?php echo esc_html( $item['title'] ); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ( ! empty( $item['content'] ) ) : ?>
                        <div class="text <?php echo esc_attr( $content_class ); ?>">
                            <?php echo wp_kses_post( "<p>" . $item['content'] ."</p>" ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $item['type_link'] == 'asset_library' && ! empty( $asset_id ) ) : ?>
                        <a href="#<?php echo $unique_id; ?>" class="<?php echo esc_attr( $btn_class ); ?> <?php echo esc_attr( $asset_link_class ); ?>">
                            <?php echo ( $item['title_link'] ) ? $item['title_link'] : __( 'Open Asset', 'connections' ); ?>
                        </a>
                    <?php else :
                        if ( ! empty( $link['title'] ) && ! empty( $link['url'] ) ) :
                            $link_target = ( ! empty( $link['target'] ) ) ? 'target="' . $link['target'] . '" ' : '';
                            $nof_link = ( ! empty( $link['rel'] ) ) ? 'rel="' . $link['rel'] .'"' : ''; ?>
                            <a href="<?php echo $link['url']; ?>" class="<?php echo esc_attr( $btn_class ); ?>" <?php echo $link_target, $nof_link; ?>>
                                <?php echo esc_html( $link['title'] ); ?>
                            </a>
                    <?php endif;
                    endif; ?>

                    <?php conn_asset_popup( $asset_id, $unique_id ); ?>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
</div>
