<?php
/**
 * Return html shortcode.
 */

extract( $atts );

$class = ! empty( $el_class ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );
$class .= " $row_bg";

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}

    
?>

<?php if ( ! empty( $items ) ) : ?>
    
    <div <?php echo $el_id; ?> class="cn-accordion <?php echo esc_attr( $class ); ?>">
                
        <?php foreach ( $items as $key => $item ) :
            $item_class = '';
            $item_class .= ( ! empty( $item['el_class'] ) ) ? $item['el_class'] : '';
            $el_id_item = ( ! empty( $item['el_id'] ) ) ? 'id="' . $item['el_id'] . '"' : ''; ?>
            
            <?php if ( ! empty( $item['title'] ) ) : ?>

                <div class="cn-accordion-item__title-wrap">
                    <h5 class="cn-accordion-item__title"><?php echo nl2br( wp_kses( $item['title'], ['br', 'b', 'i'] ) ); ?></h5>
                    <span class="lk-accordion-item__icon fa fa-plus <?php echo esc_attr( $bg_drawer_color ); ?>"></span>
                </div>

                <?php if ( ! empty( $item['content'] ) ) : ?>
                    <div class="cn-accordion-item__content">
                        <?php echo do_shortcode( $item['content'] ); ?>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
            
        <?php endforeach; ?>

    </div>

<?php endif;