<?php
/**
 * Return html shortcode.
 */

extract( $atts );

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

$class = ( ! empty( $el_class ) ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );
$class .= " {$bg_color}";

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}

$title_class = " $title_color";
$title_class .= ( $underline_title ) ? " border_{$underline_color}" : '';

$layout_classes = [
    'content' => [
        '100' => 'col-12',
        '50'  => 'col-6',
        '75'  => 'col-9',
        '25'  => 'col-3',
    ],
    'image'   => [
        '100' => 'col-12',
        '50'  => 'col-6',
        '75'  => 'col-3',
        '25'  => 'col-9',
    ],
];

$content_class = isset( $layout_classes['content'][ $content_layout_width ] ) ? $layout_classes['content'][ $content_layout_width ] : '';
$img_class = isset( $layout_classes['image'][ $content_layout_width ] ) ? " {$layout_classes['image'][ $content_layout_width ]}" : '';
$img_class .= " {$type_image}";

$link = vc_build_link( $btn_link );
$link_target = ( ! empty( $link['target'] ) ) ? 'target="' . $link['target'] . '"' : '';
$nof_link    = ( ! empty( $link['rel'] ) ) ? 'rel="' . $link['rel'] .'"' : '';

?>

<div class="cn-content-block <?php echo esc_attr( $class ); ?>" <?php echo $el_id; ?>>

    <?php if ( $title ) : ?>
        <h2 class="title <?php echo esc_attr( $title_class ); ?>">
            <?php echo esc_html( $title ); ?>
        </h2>
    <?php endif; ?>

    <div>
    
        <?php 
        ob_start();
        if ( $image ) : ?>
            <div class="img-block <?php echo esc_attr( $img_class ); ?>">
                <img src="<?php echo wp_get_attachment_image_url( $image ); ?>" alt="content-block-image">
            </div>    
        <?php endif;
        $img_block = ob_get_clean(); ?>

        <?php ob_start(); ?>

            <div class="content-block <?php echo esc_attr( $content_class ); ?>">

                <?php 
                if ( $content ) : ?>
                    <div class="text">
                        <?php echo wp_kses_post( $content ); ?>
                    </div>
                <?php endif;

                if ( ! empty( $link['url'] ) && ! empty( $link['title'] ) ) : ?>
                    <a href="<?php echo esc_url( $link['url'] ); ?>" class="cn-btn" <?php echo $link_target, $nof_link; ?>>
                        <?php echo esc_html( $link['title'] ); ?>
                    </a>
                <?php endif; ?>

            </div>

        <?php $content_block = ob_get_clean(); ?>
        
        <?php

        if ( $content_layout_width == '100' ) {
            echo $img_block, $content_block;
        } else {
            if ( $align_img == 'right' ) {
                echo $content_block, $img_block;
            } else {
                echo $img_block, $content_block;
            }
        }
                    
        ?>
        
    
    </div>

</div>