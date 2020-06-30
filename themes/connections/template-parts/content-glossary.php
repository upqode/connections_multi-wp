<?php
/**
 * Glossary list
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package connections
 */

global $brightcove_user_id, $brightcove_player_id;

$args = array(
    'post_type'         => 'cn-glossary',
    'posts_per_page'    => -1,
);

$glossary_posts = new WP_Query( $args );

while ( $glossary_posts->have_posts() ) : $glossary_posts->the_post();

    $audio = get_field( 'audio' );
    $glossary_type_audio = get_field( 'type_audio' );
    $audioMP3 = get_field( 'mp3' );
    $unique_id = 'player_' . get_the_ID() . '_' . rand(0, 99); ?>
    <div class="cn-glossary-item">
        <div class="cn-glossary-item__header">

            <?php the_title('<h5 class="cn-glossary-item__title">', '</h5>'); ?>

            <?php if ( $audio || $audioMP3 ) : ?>
                <div id="<?php echo $unique_id; ?>" class="cn-glossary-item__audio-box audio">

                    <span data-href="#<?php echo $unique_id; ?>" class="cn-btn-icon js-item-BC" data-type-audio="<?php echo esc_attr( $glossary_type_audio ); ?>" data-custom-audio-src="<?php echo esc_attr( $audioMP3 ); ?>">
                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                    </span>

                    <?php conn_get_brightcove_source_code( 'audio', $brightcove_user_id, $brightcove_player_id, $audio, 'glossary-' . get_the_ID(), 'data-autoplay="autoplay"' ); ?>
                    
                </div>

            <?php endif; ?>

        </div>

        <?php if ( get_the_content() ) : ?>
            <div class="cn-glossary-item__desc">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>

    </div>

<?php endwhile; 
wp_reset_postdata();