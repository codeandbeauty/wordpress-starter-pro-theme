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

            <button type="button" class="toggle toggle-search" data-target=".search-box">
                <span class="screen-reader-text"><?php _e( 'Search', 'ui' ); ?></span>
                <i class="fa fa-ellipsis-h"></i>
                <i class="fa fa-times"></i>
            </button>

            <?php
            $top_text = get_theme_mod( 'top_text' );

            if ( ! empty( $top_text ) ) : ?>
            <div class="top-text">
                <?php echo do_shortcode( $top_text ); ?>
            </div>
            <?php endif; ?>

			<div class="search-box">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</section>