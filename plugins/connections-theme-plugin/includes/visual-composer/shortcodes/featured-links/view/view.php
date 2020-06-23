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
$class_title .= ( $underline_title && $underline_color ) ? " border_{$underline_color}" : '';

$col_classes = [
    1 => ' col-12',
    2 => ' col-6',
    3 => ' col-4',
    4 => ' col-3',
];

?>

<div class="cn-featured-links <?php echo esc_attr( $class ); ?>" <?php echo $el_id; ?> <?php echo $style_wrap; ?>>

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
                $btn_class .= isset( $item['btn_bg_color'] ) ? " {$item['btn_bg_color']}" : '';
                $btn_class .= isset( $item['btn_text_color'] ) ? " {$item['btn_text_color']}" : '';

                $link = isset( $item['link'] ) ? vc_build_link( $item['link'] ) : [];
                $link_target = ( ! empty( $link['target'] ) ) ? 'target="' . $link['target'] . '"' : '';
                $nof_link    = ( ! empty( $link['rel'] ) ) ? 'rel="' . $link['rel'] .'"' : ''; ?>

                <div class="cn-featured-links__items__item <?php echo esc_attr( $items_class ); ?>" <?php echo $el_item_id; ?>>

                    <?php if ( ! empty( $item['title'] ) ) : ?>
                        <h3 class="title <?php echo esc_attr( $title_class ); ?>">
                            <?php echo esc_html( $item['title'] ); ?>
                        </h3>
                    <?php endif; ?>

                    <?php if ( ! empty( $item['content'] ) ) : ?>
                        <div class="text <?php echo esc_attr( $content_class ); ?>">
                            <?php echo wp_kses_post( $item['content'] ); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( ! empty( $link['title'] ) && ! empty( $link['url'] ) ) : ?>
                        <a href="<?php echo $link['url']; ?>" class="<?php echo esc_attr( $btn_class ); ?>">
                            <?php echo esc_html( $link['title'] ); ?>
                        </a>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
