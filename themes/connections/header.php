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
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat" media="screen">
	<?php wp_head(); ?>
</head>
<?php

global $is_active_ACF;

$header_class = '';
$link = [];

if ( $is_active_ACF ) {
	$link = get_field( 'menu_link', 'option' ) ?: [];
	$header_class .= get_field( 'header_position', 'option' ) ?: '';
}

$link_target = ( ! empty( $link['target'] ) ) ? 'target="_blank"' : '';
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
				<h3 class="cn-breadcrumbs"><?php echo esc_html(get_the_title()); ?></h3>
			</div>

			<div class="cn-header__help-panel">

				<div class="cn-header__search js-form-toggle-wrapp">
					<?php get_search_form(); ?>
					<span class="cn-header__search__icon js-form-toggle-btn">
					<i class="fa fa-search"></i>
				</span>
				</div>
				<a href="#" data-dropdown="drop-glossary" class="cn-btn-icon cn-header__help-btn js-dropdown-btn">
					<i class="fa fa-book" aria-hidden="true"></i>
				</a>

			</div>

			<div id="drop-glossary" class="cn-header__sidebar js-dropdown ">
				<?php get_template_part('template-parts/content', 'glossary'); ?>
			</div>
		</div>

	</header>
