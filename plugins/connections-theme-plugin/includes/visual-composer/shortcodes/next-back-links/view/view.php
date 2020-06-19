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

$style_wrap = '';
$style_wrap .= ( $bg_img ) ? 'background-image: url(' . wp_get_attachment_image_url( $bg_img, 'full' ) . ');' : '';

if ( $style_wrap ) {
    $style_wrap = 'style="' . $style_wrap . '"';
}

?>

<div class="cn-next-back-links <?php echo esc_attr( $class ); ?>" <?php echo $el_id; ?> <?php echo $style_wrap; ?>>

    <?php if ( $prev_link ) :
        $prev_link = vc_build_link( $prev_link );
        $target_link = ( ! empty( $prev_link['target'] ) ) ? 'target="' . $prev_link['target'] .'"' : '';
        $nof_link = ( ! empty( $prev_link['rel'] ) ) ? 'rel="' . $prev_link['rel'] .'"' : ''; ?>
        <?php if ( $prev_link['title'] ) : ?>
            <a href="<?php echo esc_url( $prev_link['url'] ); ?>" <?php echo $target_link; ?> <?php echo $nof_link; ?>>
                <div class="cn-next-back-links__link-wrap">
                    <h3 class="title <?php echo esc_attr( $title_color ); ?>"><?php echo esc_html( $prev_link['title'] ); ?></h3>
                    <p class="subtitle <?php echo esc_attr( $subtitle_color ); ?>">
                        <?php echo esc_html( $prev_subtitle ); ?>
                    </p>
                </div>
            </a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ( $next_link ) :
        $next_link = vc_build_link( $next_link );
        $target_link = ( ! empty( $next_link['target'] ) ) ? 'target="' . $next_link['target'] .'"' : '';
        $nof_link = ( ! empty( $next_link['rel'] ) ) ? 'rel="' . $next_link['rel'] .'"' : ''; ?>
        <?php if ( $next_link['title'] ) : ?>
            <a href="<?php echo esc_url( $next_link['url'] ); ?>" <?php echo $target_link; ?> <?php echo $nof_link; ?>>
                <div class="cn-next-back-links__link-wrap">
                    <h3 class="title <?php echo esc_attr( $title_color ); ?>"><?php echo esc_html( $next_link['title'] ); ?></h3>
                    <p class="subtitle <?php echo esc_attr( $subtitle_color ); ?>">
                        <?php echo esc_html( $next_subtitle ); ?>
                    </p>
                </div>
            </a>
        <?php endif; ?>
    <?php endif; ?>

</div>