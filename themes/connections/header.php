<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package connections
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php conn_get_color_scheme(true); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<?php

global $is_active_ACF;

$header_class = '';
$link = [];
$back_button = false;
$hide_glossary = false;
$search_glossary = false;

if ( $is_active_ACF ) {
	$link = get_field( 'menu_link', 'option' ) ?: [];
	$back_button = get_field( 'back_button', 'option' ) ?: false;
	$hide_glossary = get_field( 'hide_glossary', 'option' ) ?: false;
	$search_glossary = get_field( 'search_glossary', 'option' ) ?: false;
	$header_class .= get_field( 'header_position', 'option' ) ?: '';
}

$link_target = ( ! empty( $link['target'] ) ) ? 'target="_blank"' : '';
$referer_page = ( ! empty( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : '';
?>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="cn-main-wrap">

	<header class="cn-header  <?php echo esc_attr( $header_class ); ?>">

		<div class="cn-header__wrapp">

			<div class="cn-header__nav-panel">

				<span class="cn-menu-btn js-nav-menu-btn"><i></i></span>

				<div class="cn-header__nav js-header-nav">

					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'main-menu',
							'menu_id'        => 'primary-menu',
						)
					);
					?>
					<div class="cn-header__nav__inner-links">
						<?php if ( ! empty( $link['title'] ) && ! empty( $link['url'] ) ) : ?>
							<a href="<?php echo esc_url( $link['url'] ); ?>" <?php echo $link_target; ?>>
								<?php echo esc_html( $link['title'] ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $referer_page  && $back_button ) : ?>
					<a href="<?php echo $referer_page; ?>" class="cn-btn-icon cn-btn-icon--back">
						<i class="fa fa-angle-left"></i>
					</a>
				<?php endif; ?>

				<h3 class="cn-breadcrumbs"><?php echo esc_html(get_the_title()); ?></h3>
			</div>

			<div class="cn-header__help-panel">
				<?php if ( $search_glossary == false  ) : ?>

				<div class="cn-header__search js-form-toggle-wrapp">
					<?php get_search_form(); ?>
					<span class="cn-header__search__icon js-form-toggle-btn">
					<i class="fa fa-search"></i>
				</span>
				</div>
				<?php endif;?>

				<?php if ( $hide_glossary == false ) : ?>

				<a href="#" data-dropdown="drop-glossary" class="cn-btn-icon cn-header__help-btn js-dropdown-btn">
					<i class="fa fa-book" aria-hidden="true"></i>
				</a>
				<?php endif;?>

			</div>
			<?php if ( $hide_glossary == false  ) : ?>

			<div id="drop-glossary" class="cn-header__sidebar js-dropdown ">
				<?php get_template_part('template-parts/content', 'glossary'); ?>
			</div>
			<?php endif;?>
		</div>

	</header>
