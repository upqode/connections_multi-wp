<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package connections
 */

$color = get_field('main_color', 'option');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header" style="background-color:<?php echo $color; ?>;">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php connections_post_thumbnail(); ?>


</article><!-- #post-<?php the_ID(); ?> -->
