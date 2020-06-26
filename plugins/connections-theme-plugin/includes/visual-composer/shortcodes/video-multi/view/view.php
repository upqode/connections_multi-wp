<?php
/**
 * Return html shortcode.
 */
global $brightcove_user_id, $brightcove_player_id;

extract( $atts );

$class = ! empty( $el_class ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );
$class .= ' ' . $bg_color;

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}

$videos = (array) vc_param_group_parse_atts( $videos );

$title_class = '';
$title_class .= " $title_color";

if ( $underline_title && $underline_color ) {
    $title_class .= " border_{$underline_color}";
}

?>  

<div <?php echo $el_id; ?> class="cn-video-tabs <?php echo esc_attr( $class ); ?>">

    <div class="container">

        <?php 
            $output_tablist = '';
            $output_content = '';
            $item_counter = 0;           

            foreach ( $videos as $key => $video ) :
                
                $active_item = ( $key == 0 ) ? 'active' : '';
                $tab_id = $key .'__'. rand( 0, 999 );
        
                if ( ! empty( $video['title'] ) ) {
                    $output_tablist .= '<li class="' . esc_attr( $active_item ) . '">';
                    $output_tablist .= '<a class="js-tablink" href="#' . esc_attr( $tab_id ) . '">' . wp_kses_post( $video['title'] ) . '</a>';
                    $output_tablist .= '</li>';
                }
            
                $output_content .= '<div id="#' . esc_attr( $tab_id ) . '" class="cn-tabs__tabpanel-item cn-tabs__tabpanel-item--nobrd js-vid-tabpanel ' . esc_attr( $active_item ) . '">';
                $assets_ID = ( ! empty( $video['asset_lists'] ) ) ? $video['asset_lists'] : 0;
                $asset_video_ID = get_post_meta( $assets_ID, 'asset_video', true );
                $aspect_ratio = get_post_meta( $assets_ID, 'aspect_ratio', true );
                
                ob_start();
                if ( $asset_video_ID ) {
                    conn_get_brightcove_source_code( 'video', $brightcove_user_id, $brightcove_player_id, $asset_video_ID, 'library-' . $tab_id, '', $aspect_ratio, false );
                }
                $output_content .= ob_get_clean();

                $output_content .= '</div>';

            endforeach; ?>
        
        <?php if ( ! empty( $title ) ) : ?>
            <h2 class="cn-video-tabs__title <?php echo esc_attr( $title_class ); ?>">
                <?php echo esc_html( $title ); ?>
            </h2>
        <?php endif; ?>

        <div class="cn-tabs cn-video-tab js-video-tabs">

            <?php if ( count( $videos ) > 1 ) : ?>
                <ul class="cn-video-tab__tablist">
                    <?php echo $output_tablist; ?>
                </ul>
            <?php endif; ?>

            <div class="cn-video-tab__tabpanel">
                <?php echo $output_content; ?>
            </div>
            
        </div>
    </div>
</div>

