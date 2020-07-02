<?php
/**
 * Return html shortcode.
 */

extract( $atts );

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

$class = ( ! empty( $el_class ) ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );
$class .= ( $bg_color ) ? " {$bg_color}" : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}

$style_wrap = '';
$style_wrap .= ( $bg_type == 'image' && ! empty( $bg_img ) ) ? 'background-image: url(' . wp_get_attachment_image_url( $bg_img, 'full' ) . ');' : '';

if ( $style_wrap ) {
    $style_wrap = 'style="' . $style_wrap . '"';
}

?>

<div class="cn-callout <?php echo esc_attr( $class ); ?>" <?php echo $el_id; ?> <?php echo $style_wrap; ?>>

<?php if ( $title ) : ?>
        <h2 class="cn-callout__title <?php echo esc_attr( $title_color ); ?>"><?php echo nl2br( wp_kses( $title, ['br'] ) ); ?></h2>
    <?php endif; ?>

    <?php if ( $subtitle ) : ?>
        <p class="cn-callout__subtitle <?php echo esc_attr( $subtitle_color ); ?>"><?php echo esc_html( $subtitle ); ?></p>
    <?php endif; ?>

    <?php if ( $overlay_img ) : 

        $style_overlay_wrap = '';
        $style_overlay_wrap .= 'background-image: url(' . wp_get_attachment_image_url( $overlay_img, 'full' ) . ');';
        $overlay_opacity = ( $overlay_opacity ) ? (int) $overlay_opacity : 0;
        $style_overlay_wrap .= ( $overlay_opacity && $overlay_opacity <= 100 ) ? 'opacity: ' . $overlay_opacity / 100 . ';' : '';

        if ( $style_overlay_wrap ) {
            $style_overlay_wrap = 'style="' . $style_overlay_wrap . '"';
        }
        ?>

        <div class="cn-callout__overlay_img" <?php echo $style_overlay_wrap; ?>></div>

    <?php endif; ?>

</div>