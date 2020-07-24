<?php
/**
 * Return html shortcode.
 */

extract($atts);
$link_class = ' ';
$class      = !empty($el_class) ? $el_class : '';
$class      .= vc_shortcode_custom_css_class($class);

$el_id = (!empty($el_id)) ? 'id="' . esc_attr($el_id) . '"' : '';

/* Add responsive options to container */
$responsive_classes = cn_create_responsive_classes($atts);
if ( !empty($responsive_classes) ) {
	$class .= $responsive_classes;
}
$btn_link_first = vc_build_link($btn_link_first);
$link_target1   = (!empty($btn_link_first['target'])) ? 'target="' . $btn_link_first['target'] . '" ' : '';
$nof_link1      = (!empty($btn_link_first['rel'])) ? 'rel="' . $btn_link_first['rel'] . '"' : '';

$btn_link_second = vc_build_link($btn_link_second);
$link_target2    = (!empty($btn_link_second['target'])) ? 'target="' . $btn_link_second['target'] . '" ' : '';
$nof_link2       = (!empty($btn_link_second['rel'])) ? 'rel="' . $btn_link_second['rel'] . '"' : '';
if ( $btn_bg_color ) {
	$link_class .= " {$btn_bg_color} ";
}
if ( $btn_b_color ) {
	$link_class .= " border_{$btn_b_color} ";
}
if ( $btn_text_color ) {
	$link_class .= " {$btn_text_color} ";
}
?>

<?php ob_start(); ?>
<div class="cn-landing__buttons-wrap">
	<?php if ( !empty($btn_link_first['url']) && !empty($btn_link_first['title']) ) : ?>
		<a href="<?php echo esc_url($btn_link_first['url']); ?>"
			class="cn-btn-sel <?php echo esc_attr($link_class); ?>" <?php echo $link_target1, $nof_link1; ?>>
			<?php echo esc_html($btn_link_first['title']); ?>
		</a>
	<?php endif; ?>
	<?php if ( !empty($btn_link_second['url']) && !empty($btn_link_second['title']) ) : ?>
		<a href="<?php echo esc_url($btn_link_second['url']); ?>"
			class="cn-btn-sel <?php echo esc_attr($link_class); ?>" <?php echo $link_target2, $nof_link2; ?>>
			<?php echo esc_html($btn_link_second['title']); ?>
		</a>
	<?php endif; ?>
	<?php if ( !empty($items) && !empty($title_select) ): ?>
		<div class="cn-btn-sel js-select-landing cn-landing__select <?php echo esc_attr($link_class); ?>">
			<?php echo esc_html($title_select); ?>
			<div class="cn-landing__select-block js-select-landing-block">
				
				<?php foreach ( $items as $key => $item ) : ?>
					<?php if ( !empty($item['title']) ): ?>
						<a href="#block_landing_<?php echo $key; ?>" class="cn-landing__link">
							<?php echo esc_html($item['title']); ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</div>
<?php $buttons_links = ob_get_clean(); ?>

<?php if ( !empty($items) ) : ?>

	<div <?php echo $el_id; ?> class="cn-landing  <?php echo esc_attr($class); ?>">
		
		<?php
		$top_image = '';
		$top_image .= (!empty($image_top)) ? wp_get_attachment_image_url($image_top, 'full') : '';
		?>
		<div class="cn-landing__header-wrap fixed js-sticky-header" style="background-image: url(<?php echo esc_attr($top_image); ?>);">
			<span class="cn-landing__hamburger cn-menu-btn js-landing-haburger"><i></i></span>
			<div class="cn-landing__header cn-landing__container">
				<?php if ( !empty($image_logo) ): ?>
					<div class="cn-landing__logo">
						<img src="<?php echo esc_url(wp_get_attachment_image_url($image_logo, 'full')); ?>" alt="logo">
					</div>
				<?php endif; ?>

				<div class="cn-landing__desktop-menu">
					<?php echo $buttons_links; ?>
				</div>

			</div>
		</div>

		<div class="cn-landing__mobile-links js-landing-mobile-links">
			<?php echo $buttons_links; ?>
		</div>

		<div class="cn-landing__items js-sticky-retreat">
			<?php foreach ( $items as $key => $item ) : ?>
				<div class=" cn-landing__item cn-landing__container-item">
					<div class=" cn-landing__item-header <?php echo esc_attr($item['block_color']); ?>">
						<?php if ( !empty($item['title']) ): ?>
							<h2 id="block_landing_<?php echo $key; ?>" class="cn-landing__content-block">
								<?php echo esc_html($item['title']); ?>
							</h2>
						<?php endif; ?>
						<?php $item_btn = vc_build_link($item['btn_link']);
						if ( !empty($item_btn['title']) && !empty($item_btn['url']) ): ?>
							<a href="<?php echo esc_url($item_btn['url']); ?>"
							class="cn-btn-sel cn-landing__btn" target="<?php echo $item_btn['target']; ?>">
								<?php echo esc_html($item_btn['title']); ?>
							</a>
						<?php endif; ?>
					</div>
					<div class=" cn-landing__item-blocks">
						<?php
						$item['items']      = (array) vc_param_group_parse_atts( $item['items'] );
						$column_classes = [
							1 => 'col-12',
							2 => 'col-6',
							3 => 'col-4',
							4 => 'col-3',
						];
						foreach ( $item['items'] as $key => $block ) : ?>
							<?php if ( ! empty( $block['url'] ) ) :
								$style_wrap = '';
								$style_wrap .= ( ! empty( $block['image'] ) ) ? wp_get_attachment_image_url($block['image'], 'full') : '';
								$item_class = '';
								$item_class .= ( isset( $item['column'] ) && $item['column'] > 1 ) ? "{$column_classes[ $item['column'] ]}" : 'col-12';
								?>
								<div class="item-col <?php echo esc_attr( $item_class ); ?>">
									<a href="<?php echo esc_url($block['url']); ?>"
									class=" cn-landing__item-block "
									style="background-image: url(<?php echo esc_attr($style_wrap); ?>);">
										<?php if ( !empty($block['title']) ): ?>
											<h4 class=" cn-landing__item-blocks-name <?php echo esc_attr($item['block_color']) . ' ' . esc_attr($item['block_text_color']); ?>">
												<?php echo esc_html($block['title']); ?>
											</h4>
										<?php endif; ?>
									</a>
								</div>
								
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	
		<?php
		$bottom_image = '';
		$bottom_image .= (!empty($image_bottom)) ? wp_get_attachment_image_url($image_bottom, 'full') : '';
		?>
		<div class="cn-landing__bottom_block"
			 style="background-image: url(<?php echo esc_attr($bottom_image); ?>);"></div>
	</div>

<?php endif;