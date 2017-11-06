<?php
/**
 * The template use to display everything there is at your footer's page.
 *
 * @package CodeAndBeauty
 **/
?>

	</div><!-- end #main-content -->

	<footer id="main-footer" class="main-footer" role="contentinfo">
		<?php
		/**
		 * Most page footer contains widgets. We use a widgets section at the top most of footer area
		 * to show contents that needs to be showcase in the footer section.
		 *
		 * To override this template in a child-theme, create a template called
		 * `templates/footer/widgets|widgets-{post_type}.php` and it will be use instead.
		 *
		 * @since 1.0.0
		 */
		get_template_part( 'templates/footer/widgets', get_post_type() );

		/**
		 * Footer text is commonly use in most themes. It can be a copyright or any other useful
		 * information that usually visible at the bottom of the page.
		 *
		 * We use customizer to set footer text contents.
		 */
		$footer_text = get_theme_mod( 'footer_text' );
		if ( ! empty( $footer_text ) ) :
		?>

		<section class="footer-section footer-text-section">
			<div class="container">
				<div class="footer-text">
					<?php echo wpautop( $footer_text ); ?>
				</div>
			</div>
		</section>

		<?php endif; ?>
	</footer>
</div><!-- end .site-inner -->
</div><!-- end #page -->
<?php wp_footer(); ?>

</body>
</html>
