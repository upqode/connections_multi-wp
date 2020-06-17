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
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="cn-main-wrap">

	<header class="cn-header">

		<div class="cn-header__nav-panel">

			<span class="cn-menu-btn"></span>

			<div class="cn-header__nav">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main-menu',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</div>

		</div>

		<div class="cn-header__help-panel">
			
			<div class="cn-header__search">
				<?php get_search_form(); ?>
				<span class="cn-heade__search__icon">
					<i class="fa fa-search"></i>
				</span>
			</div>
			<div class="cn-btn-drop-glossary"></div>

		</div>

		<div id="drop-glossary" class="cn-sidebar-glossary">
			<?php get_template_part( 'template-parts/content', 'glossary' ); ?>
		</div>

	</header>
