<?php
/**
 * Template part for displaying case items
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package connections
 */

$tags       = wp_get_post_terms( $post->ID, $tag_slug );
$categories = wp_get_post_terms( $post->ID, $cat_slug );
$user_data  = get_userdata( $post->post_author );
$asset_type = get_post_meta( get_the_ID(), 'asset_type', true );
$page_case  = ( function_exists( 'get_field' ) && $post_type == 'cn-case' ) ? get_field( 'page_case_library', 'option' ) : '';
$post_link  = ( $page_case && is_scalar( $page_case ) ) ? get_the_permalink( $page_case ) : get_the_permalink();

?>

<div class="cn-search-item__author">

    <?php if ( $post_type == 'cn-glossary' || $post_type == 'cn-contributor' ) :
        the_title("<h3 class='title'>", "</h3>");
    else : ?>
        <a href="<?php echo $post_link; ?>" class="<?php echo esc_attr( $article_link_class ); ?>">
            <?php the_title("<h3 class='title'>", "</h3>"); ?>
        </a>
    <?php endif; ?>

    <?php if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
        <ul class="cn-search-item__cats">
            <li class="cn-search-item__cats-item">
                <?php
                    echo '<b>' . esc_html__( 'Tags: ', 'connections' ) . '</b>';
                    conn_display_post_terms( $tags );
                ?>
            </li>
        </ul>
    <?php endif; ?>

    <?php if ( ! empty( $categories ) ) : ?>
        <ul class="cn-search-item__cats">
            <li class="cn-search-item__cats-item">
                <?php
                    echo '<b>' . esc_html__( 'Categories: ', 'connections' ) . '</b>';
                    conn_display_post_terms( $categories );
                ?>
            </li>
        </ul>
    <?php endif; ?>

</div>

<?php if ( ! empty( $post->post_content ) ) : ?>
    <div class="cn-search-item__text">
        <p><?php the_excerpt(); ?></p>
    </div>
<?php endif; ?>
