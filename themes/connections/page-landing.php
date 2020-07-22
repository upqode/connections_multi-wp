<?php
/**
 * Template Name: Landing Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header('landing');
?>

	<main id="primary" class="site-main">

		<h1 class="hidden"><?php _e( 'Connections', 'connections' ); ?></h1>

		<?php
		while ( have_posts() ) :
			the_post();

			$content  = get_the_content();
			$template = (stripos($content, 'vc_')) ? 'vc' : 'page';

			get_template_part('template-parts/content', $template);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer('landing');
