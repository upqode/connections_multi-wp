<?php
/**
 * Return html shortcode.
 */
global $brightcove_user_id, $brightcove_player_id;

if ( ! function_exists( 'get_field' ) )
    return;

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
$title_class .= ( $underline_title && $underline_color ) ? " border_{$underline_color}" : '';

$layout_classes = [
    'content' => [
        '100' => 'col-12',
        '50'  => 'col-6',
        '75'  => 'col-9',
        '25'  => 'col-3',
    ],
    'media'   => [
        '100' => 'col-12',
        '50'  => 'col-6',
        '75'  => 'col-3',
        '25'  => 'col-9',
    ],
];

$content_class = isset( $layout_classes['content'][ $content_layout_width ] ) ? $layout_classes['content'][ $content_layout_width ] : '';

$media_wrap_class = isset( $layout_classes['media'][ $content_layout_width ] ) ? " {$layout_classes['media'][ $content_layout_width ]}" : '';
$media_wrap_class .= " {$type_image}";

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
        if ( $media_type == 'video_type' ) :
            $video_id = ( $media_type == 'video_type' ) ? get_field( 'asset_video', $asset_video_id ) : 0;
            $aspect_ratio = get_field( 'aspect_ratio', $asset_video_id );
            if ( $video_id ) : ?>
                <div class="media-block <?php echo esc_attr( $media_wrap_class ); ?>">
                    <?php conn_get_brightcove_source_code( 'video', $brightcove_user_id, $brightcove_player_id, $video_id, 'library-' . get_the_ID(), '', $aspect_ratio, false ); ?>
                </div>    
            <?php endif;
        else :
            if ( $image ) : ?>
                <div class="media-block <?php echo esc_attr( $media_wrap_class ); ?>">
                    <img src="<?php echo wp_get_attachment_image_url( $image ); ?>" alt="content-block-image">
                </div>    
            <?php endif;
        endif;
        $media_block = ob_get_clean(); ?>

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
            echo $media_block, $content_block;
        } else {
            if ( $media_align == 'right' ) {
                echo $content_block, $media_block;
            } else {
                echo $media_block, $content_block;
            }
        }
                    
        ?>
    
    </div>

</div>