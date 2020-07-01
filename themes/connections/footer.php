<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package connections
 */
if ( ! function_exists('get_field') ) {
	return;
}

$copyright = get_field( 'footer_copyright', 'option' );
?>
	<?php if ( $copyright ) : ?>
		<footer class="cn-footer">
			<?php echo wp_kses( nl2br( $copyright ), ['br'] ); ?>
		</footer>
	<?php endif; ?>

</div><!-- #page -->
<?php connection_popup_guest_users(); ?>

<?php wp_footer(); ?>

</body>
</html>
