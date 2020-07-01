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

?>

<?php if ( ! empty( $items ) ) : ?>

    <div <?php echo $el_id; ?> class="cn-tabs js-tabs <?php echo esc_attr( $class ); ?>">
        
        <?php 
            $output_tab_list = '';
            $output_content = '';
            $item_counter = 0;

            foreach ( $items as $key => $item ) :

                if ( $item_counter > 4 )
                    break;
                
                $item_class = '';

                $active_item = ( $item_counter ) == 0  ? " active {$bg_color_tab_active}" : " {$bg_color_tab}";
                $item_class .= $active_item;
                $item_class .= ( ! empty( $item['el_class'] ) ) ? ' ' . $item['el_class'] : '';

                $el_id_item = ( ! empty( $item['el_id'] ) ) ? 'id="' . $item['el_id'] . '"' : '';

                if ( ! empty( $item['title'] ) ) :
                    
                    $output_tab_list .= '<li '. $el_id_item .' class="cn-tabs__tablist-item ' . esc_attr( $item_class ) . '">';
                    $output_tab_list .= '<a class="js-tablinks" href="#cn-tab-' . esc_attr( $item_counter ) . '">' . wp_kses( nl2br( $item['title'] ), ['br'] ) . '</a>';
                    $output_tab_list .= '</li>';

                    if ( ! empty( $item['content'] ) ) :
                        $output_content .= '<div id="cn-tab-' . esc_attr( $item_counter ) . '" class="cn-tabs__tabpanel-item js-tabpanel ' . esc_attr( $active_item ) . '">';
                        $output_content .= do_shortcode( $item['content'] );
                        $output_content .= '</div>';
                    endif;

                endif;
                $item_counter++;

            endforeach; ?>

            <ul class="cn-tabs__tablist" data-active-tab-class="<?php echo esc_attr( $bg_color_tab_active ); ?>">
                <?php echo $output_tab_list; ?>
            </ul>

            <div class="cn-tabs__tabpanel">
                <?php echo $output_content; ?>
            </div>

    </div>

<?php endif;