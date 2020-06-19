<?php
/**
 * Return html shortcode.
 */

extract( $atts );

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

$class = ( ! empty( $el_class ) ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}

?>

<div class="cn-sheet <?php echo esc_attr( $class ); ?>" <?php echo $el_id; ?>>

    <?php if ( $text_header ) : ?>
        <div class="cn-sheet__header">
            <?php echo esc_html( $text_header ); ?>
        </div>
    <?php endif; ?>

    <div class="cn-sheet__title-wrap">
        <?php if ( $title ) : ?>
            <h2 class="cn-sheet__title">
                <?php echo esc_html( $title ); ?>
            </h2>
        <?php endif;

        if ( $desc ) : ?>
            <div class="cn-sheet__description">
                <?php echo wp_kses_post( $desc ); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( $content ) : ?>
        <div class="cn-sheet__content">
            <?php echo wp_kses_post( $content ); ?>
        </div>
    <?php endif; ?>

    <?php if ( $text_footer ) : ?>
        <div class="cn-sheet__footer">
            <?php echo esc_html( $text_footer ); ?>
        </div>
    <?php endif; ?>

</div>

