<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package connections
 */
$post_type = get_post_type( $post );
$article_link_class = '';

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<?php
	if ( $post_type == 'cn-asset' ) {

		include locate_template( "template-parts/search/content-asset.php" );
		
	} else {

		
		$taxonomies = [
			'cn-case'  			=> 'cn-case-category',
			'cn-asset'			=> 'cn-asset-category',
			'cn-contributor'	=> 'cn-contributor-category',
			'cn-glossary'		=> 'cn-glossary-category',
		];

		$cat_slug = isset( $taxonomies[ $post_type ] ) ? $taxonomies[ $post_type ] : '';
		$tag_slug = ( $post_type == 'post' ) ? 'post_tag' : '';

		include locate_template( "template-parts/search/content-default.php" );
	}
    ?>

</div>
