<?php
/**
 * The top header template.
 *
 * @package User_Interface
 */
?>

<section class="top-section">
	<div class="container">
		<div class="inner-container">
			<?php codeandbeauty_mini_logo(); ?>

            <?php
            $top_text = get_theme_mod( 'top_text' );

            if ( ! empty( $top_text ) ) : ?>
            <div class="top-text">
                <?php echo do_shortcode( $top_text ); ?>
            </div>
            <?php endif; ?>

            <div class="social-media-links">
                <?php codeandbeauty_social_media_links(); ?>
            </div>
		</div>
	</div>
</section>