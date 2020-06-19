<?php
/**
 * Return html shortcode.
 */
global $brightcove_user_id, $brightcove_player_id;

extract( $atts );

$class = ! empty( $el_class ) ? $el_class : '';
$class .= vc_shortcode_custom_css_class( $class );
$class .= ( ! empty( $fixed_nav ) ) ? ' js-sidebar-wrapp' : '';

$el_id = ( ! empty( $el_id ) ) ? 'id="' . esc_attr( $el_id ) . '"' : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes( $atts );
if ( ! empty( $responsive_classes ) ) {
    $class .= $responsive_classes;
}

// Select CPT Items
$taxonomy = 'cn-asset-category';
$count_posts = ( ! empty( $posts_per_page ) && is_numeric( $posts_per_page ) ) ? $posts_per_page : -1;
$args = array(
    'taxonomy'   => $taxonomy,
    'slug'       => explode( ',', $categories ),
);
$terms = get_terms( $args );
?>

<?php if ( ! empty( $terms ) ) : ?>
    
    <div <?php echo $el_id; ?> class="lk-asset-library <?php echo esc_attr( $class ); ?>">
        <div class="lk-asset-library__row">

            <div class="lk-asset-library__col lk-asset-library__col--left">
                <ul class="lk-asset-library__nav js-sidebar">
                    <?php

                    $count = 1;

                    foreach ( $terms as $term ) : 
                        $active = $count === 1 ? 'active' : '';

                        if ( ! empty( $term->name ) ) : ?>
                            <li class="lk-asset-library__nav-item">
                                <a href="#<?php echo esc_html( $term->term_id ); ?>" class="ch-btn ch-btn--block ch-btn--dark js-scroll-anchor <?php echo esc_attr($active); ?>">
                                    <?php echo esc_html( $term->name ); ?>
                                </a>
                            </li>
                        <?php endif;

                        $count++;

                    endforeach; ?>

                </ul>
            </div>

            <div class="lk-asset-library__col lk-asset-library__col--right">

                <?php foreach ( $terms as $key => $term ) : ?>
                    <div id="<?php echo esc_html( $term->term_id ); ?>" class="lk-asset-library__item lk-asset-block js-asset-block">
                        
                        <?php if ( ! empty( $term->name ) ) :
                            printf( '<%1$s class="ch-asset__title ' . esc_attr( $title_color ) . '">%2$s</%1$s>', $title_tag, $term->name );
                        endif;

                        $args = array(
                            'post_type'         => 'cn-asset',
                            'orderby'           => $orderby,
                            'order'             => $order,
                            'posts_per_page'    => $count_posts,
                            'tax_query'         => array(
                                array(
                                    'taxonomy' => $taxonomy,
                                    'field'    => 'slug',
                                    'terms'    => $term,
                                )
                            ),
                        );
                        $assets = new WP_Query( $args );

                        if ( $assets->have_posts() ) : ?>

                            <div class="ch-asset__row">

                                <?php while ( $assets->have_posts() ) : $assets->the_post(); 

                                    global $content_block_args;

                                    $content_block_args = array(
                                        'item_post_type'        => 'cn-case',
                                        'brightcove_user_id'    => $brightcove_user_id,
                                        'brightcove_player_id'  => $brightcove_player_id,
                                    );

                                    get_template_part( 'template-parts/content-asset-file' ); ?>

                                <?php endwhile;
                                wp_reset_postdata(); ?>

                            </div>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>
    </div>
<?php endif; ?>
