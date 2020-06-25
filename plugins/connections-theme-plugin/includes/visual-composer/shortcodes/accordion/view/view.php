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
    
<section <?php echo $el_id; ?> class="cn-accordion <?php echo esc_attr( $class ); ?>">
    <div class="">
        <div class="cn-accordion">
            
            <?php foreach ( $items as $key => $item ) :
                $item_class = '';
                $item_class .= ( ! empty( $item['el_class'] ) ) ? $item['el_class'] : '';
                $el_id_item = ( ! empty( $item['el_id'] ) ) ? 'id="' . $item['el_id'] . '"' : ''; ?>
                
                <?php if ( ! empty( $item['title'] ) ) : ?>

                    <h5 class="cn-accordion-item__title <?php echo esc_attr( $bg_title_color ); ?>">
                        <?php echo nl2br( wp_kses( $item['title'], ['br', 'b', 'i'] ) ); ?>
                    </h5>

                    <?php if ( ! empty( $item['content'] ) ) : ?>
                        <div class="cn-accordion-item__content">
                            <?php echo do_shortcode( $item['content'] ); ?>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>
                
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif;