<?php
/**
 * Return html shortcode.
 */

extract( $atts );

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

$class = ( ! empty( $el_class ) ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );
$class .= ( $banner_height ) ? "cn-banner-height--{$banner_height}" : '';
$class .= ( $bg_type == 'color' && !empty($bg_color) )  ? " {$bg_color}" : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}

$style_wrap = '';
$style_wrap .= ( $bg_type == 'image' && !empty($bg_img) ) ? 'background-image: url(' . wp_get_attachment_image_url( $bg_img, 'full' ) . ');' : '';

if ( $style_wrap ) {
    $style_wrap = 'style="' . $style_wrap . '"';
}

?>

<div class="cn-banner <?php echo esc_attr( $class ); ?>" <?php echo $el_id; ?> <?php echo $style_wrap; ?>>

    <?php if ( $title ) : ?>
        <h1 class="cn-banner__title <?php echo esc_attr( $title_color ); ?>"><?php echo nl2br( wp_kses( $title, ['br'] ) ); ?></h1>
    <?php endif; ?>

    <?php if ( $subtitle ) : ?>
        <h2 class="cn-banner__subtitle <?php echo esc_attr( $subtitle_color ); ?>"><?php echo esc_html( $subtitle ); ?></h2>
    <?php endif; ?>

    <?php if ( $overlay_img ) : 

        $style_overlay_wrap = '';
        $style_overlay_wrap .= 'background-image: url(' . wp_get_attachment_image_url( $overlay_img, 'full' ) . ');';
        $overlay_opacity = ( $overlay_opacity ) ? (int) $overlay_opacity : 0;
        $style_overlay_wrap .= ( $overlay_opacity && $overlay_opacity <= 100 ) ? 'opacity: ' . $overlay_opacity / 100 . ';' : '';
        ?>

        <div class="cn-banner__overlay_img" style="<?php echo $style_overlay_wrap; ?>"></div>

    <?php endif; ?>

</div>