<?php
/**
 * Template part for displaying asset items
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package connections
 */

$asset_type         = get_post_meta( get_the_ID(), 'asset_type', true );
$terms              = wp_get_post_terms( $post->ID, 'cn-asset-category' );
$asset_id           = get_the_ID();
$unique_section_id  = sprintf( 'library-%s-%s', $asset_id, rand( 0, 99 ) );

$asset_type_audio = get_field( 'type_audio', $post->ID );
$asset_audio_custom = get_field( 'mp3', $post->ID );

$article_link_classes = [
    'iframe'    => 'js-lazy-load-iframe',
    'html'      => 'js-lazy-load-iframe',
    'video'     => 'js-item-BC',
    'audio'     => 'js-item-BC',
    'pdf'       => 'js-lazy-load-asset-pdf',
];

$article_link_class .= ( $asset_type != 'audio' ) ? 'js-popup' : '';
$article_link_class .= isset( $article_link_classes[ $asset_type ] ) ? " {$article_link_classes[ $asset_type ]}" : '';

if ( ! empty( $asset_type ) || ! empty( $terms ) ) : ?>

    <a href="#<?php echo esc_attr( $unique_section_id ); ?>" class="<?php echo esc_attr( $article_link_class ); ?>" data-type-audio="<?php echo esc_attr( $asset_type_audio ); ?>" data-custom-audio-src="<?php echo esc_attr( $asset_audio_custom ); ?>">
		<?php the_title("<h3 class='title'>", "</h3>"); ?>
	</a>

    <ul class="cn-search-item__cats">
    
        <?php if ( ! empty( $asset_type ) ) : ?>
            <li class="cn-search-item__cats-item">
                <?php printf( '<b>%s</b> %s', esc_html__( 'Asset Type: ', 'connections' ), esc_html( $asset_type ) ); ?>
            </li>
        <?php endif; ?>

        <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
            <li class="cn-search-item__cats-item">
                <?php
                    echo '<b>' . esc_html__( 'Location: ', 'connections' ) . '</b>';
                    conn_display_post_terms( $terms );
                ?>
            </li>
        <?php endif; ?>

    </ul>
<?php endif; ?>

<?php if ( ! empty( $post->post_content ) ) : ?>
    <div class="cn-search-item__text">
        <p><?php the_excerpt(); ?></p>
    </div>
<?php endif; 

// Popup
conn_asset_popup( $asset_id, $unique_section_id );
