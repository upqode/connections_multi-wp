<?php
/**
 * Return html shortcode.
 */
global $brightcove_user_id, $brightcove_player_id;

extract($atts);

$class = !empty($el_class) ? $el_class : '';
$class .= vc_shortcode_custom_css_class($class);
$class .= (!empty($fixed_nav)) ? ' js-sidebar-wrapp cn-asset-library__nav-col ' : '';

$el_id = (!empty($el_id)) ? 'id="' . esc_attr($el_id) . '"' : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes($atts);
if ( !empty($responsive_classes) ) {
	$class .= $responsive_classes;
}
$class .= " {$bg_color}";
// Title class
$title_class = '';
$row_class   = '';
$title_class .= ($title_color) ? " {$title_color}" : '';
$title_class .= ($underline_title && $underline_color) ? " border_{$underline_color}  cn-table__title-underline" : '';
$row_class   .= ($columns && $columns) ? " {$columns}" : '';

// Select CPT Items
$taxonomy = 'cn-asset-category';
$args     = array(
	'taxonomy' => $taxonomy,
	'slug'     => explode(',', $categories),
);
$terms    = get_terms($args);
?>

<?php if ( !empty($terms) ) : ?>

	<div <?php echo $el_id; ?> class="cn-asset-library cn-asset-library-section <?php echo esc_attr($class); ?>">
		<div class="cn-asset-library__row asset-library">

			<div class="cn-asset-library__col cn-asset-library__col--left">
				<ul class="cn-asset-library__nav js-sidebar">
					<?php

					$count = 1;

					foreach ( $terms as $term ) :
						$active = $count === 1 ? 'active' : '';

						if ( !empty($term->name) ) : ?>
							<li class="cn-asset-library__nav-item">
								<a href="#term_<?php echo esc_html($term->term_id); ?>"
								   class="ch-btn js-scroll-anchor <?php echo esc_attr($active); ?>">
									<?php echo esc_html($term->name); ?>
								</a>
							</li>
						<?php endif;

						$count++;

					endforeach; ?>

				</ul>
			</div>

			<div class="cn-asset-library__col cn-asset-library__col--right">
				<div class="cn-asset-library-wrap">

					<?php

					$args = array(
						'post_type'      => 'cn-asset',
						// 'orderby'           => $orderby,
						// 'order'             => $order,
						'posts_per_page' => ($posts_per_page) ? $posts_per_page : 6,
					);

					foreach ( $terms as $key => $term ) :

						if ( $term ) :
							$args['tax_query'] = [
								[
									'taxonomy' => $taxonomy,
									'field'    => 'slug',
									'terms'    => $term,
								]
							];
						endif; ?>

						<div id="term_<?php echo esc_html($term->term_id); ?>" class="cn-asset-library__item">

							<?php if ( !empty($term->name) ) :
								printf('<%1$s class="cn-asset__title %3$s">%2$s</%1$s>', $title_tag, $term->name, $title_class);
							endif;


							$assets = new WP_Query($args);

							if ( $assets->have_posts() ) : ?>

								<div class="cn-asset__row <?php echo esc_attr($row_class); ?>">

									<?php while ( $assets->have_posts() ) : $assets->the_post();
										
										$asset_id = get_the_ID();
										include locate_template('template-parts/content-asset-file.php'); ?>

									<?php endwhile;
									wp_reset_postdata(); ?>

								</div>

							<?php endif; ?>

						</div>

					<?php endforeach;

					/* TO DO DELETE

					$link = vc_build_link( $link );

					if ( ! empty( $link['title'] ) && ! empty( $link['url'] ) ) :

						$link_target = ( ! empty( $link['target'] ) ) ? 'target="' . $link['target'] . '"' : '';
						$nof_link = ( ! empty( $link['rel'] ) ) ? 'rel="' . $link['rel'] .'"' : ''; ?>

						<a href="<?php echo $link['url']; ?>" class="cn-asset__link" <?php echo $link_target, $nof_link; ?>>
							<?php echo esc_html( $link['title'] ); ?>
						</a>

					<?php endif;?>
					*/
					?>
				</div>

			</div>

		</div>
	</div>
<?php endif; ?>
