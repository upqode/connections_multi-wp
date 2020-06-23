<?php
/**
 * Return html shortcode.
 */

extract( $atts );

$class = ! empty( $el_class ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}
$class .= " {$bg_color}";

// Title
$class_title = isset( $title_color ) ? ' ' . $title_color : '';
$class_title .= ( $title_underline ) ? ' border_main_color_7' : '';

// Link
$link = vc_build_link( $link );
$link_target = ( ! empty( $link['target'] ) ) ? 'target="' . $link['target'] . '"' : '';
$nof_link    = ( ! empty( $link['rel'] ) ) ? 'rel="' . $link['rel'] .'"' : '';

?>

<div <?php echo $el_id; ?> class="cn-table <?php echo esc_attr( $class ); ?>">

    <div class="container">
        
        <div class="">

            <?php if ( ! empty( $title ) ) : ?>
                <?php printf( '<%1$s class="cn-heading %2$s">%3$s</%1$s>', $title_tag, esc_attr( $class_title ), nl2br( wp_kses( $title, ['br'] ) ) ); ?>
            <?php endif; ?>
        
            <?php if ( ! empty( $content ) ) : ?>
                <div class="cn-table__text">
                    <?php echo do_shortcode( $content ); ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $link['url'] ) && ! empty( $link['title'] ) ) : ?>
                <div class="text-center">
                    <a href="<?php echo esc_url( $link['url'] ); ?>" class="cn-btn" <?php echo $link_target, $nof_link; ?>>
                        <?php echo esc_html( $link['title'] ); ?>
                    </a>
                </div>
            <?php endif; ?>
            
        </div>
    </div>

</div>
