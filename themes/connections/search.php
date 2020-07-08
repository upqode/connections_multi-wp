<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package liquid-knowledge
 */

$search_query = isset( $_GET['s'] ) ? trim( $_GET['s'] ) : "";

get_header();
?>

	<div class="cn-main-wrapp__inner cn-bg-grey-light cn-search js-only-fullheight">
		<div class="cn-search__top">
			<div class="container">
				<div class="row">
					<div class="col-12">

						<?php if ( have_posts() ) : ?>
							<h3 class="cn-search__title cn-color-black">
								<?php echo esc_html__( 'Search results for: ', 'liquid-knowledge' ) . '<span class="cn-color-pink">' . $_GET['s'] . '</span>'; ?>
							</h3>
						<?php elseif ( ! empty( $search_query ) && strlen( $search_query ) <= 2 ) : ?>
							<h3 class="cn-search__title cn-color-black">
								<?php echo esc_html__( 'Search value must be greater than 2 symbols', 'liquid-knowledge' ); ?>
							</h3>
							<div class="cn-search-form">
								<?php get_search_form(); ?>
							</div>
						<?php else : ?>
							<h3 class="cn-search__title cn-color-black">
								<?php echo esc_html__( 'Sorry, No Posts Matched Your Criteria.', 'liquid-knowledge' ); ?>
							</h3>
							<div class="cn-search-form">
								<?php get_search_form(); ?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
		<?php if ( have_posts() ) : ?>
			<div class="cn-search__bottom cn-bg-white">
				<div class="container">
					<div class="row">
						<div class="col-12">

							<!-- Start the Loop -->
							<?php while( have_posts() ) : the_post(); ?>

								<div class="cn-search__item">
									<?php
									get_template_part( 'template-parts/content', 'search' );
									?>
								</div>

							<?php endwhile; ?>

							<div class="cn-pagination">
								<?php echo paginate_links(); ?>
							</div>

						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>

<?php
get_footer();
