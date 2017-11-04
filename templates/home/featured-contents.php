<?php
global $post;

$featured_contents = codeandbeauty_get_featured_contents( 'featured_contents' );
if ( empty( $featured_contents ) ) :
    return; // Bail if nothing is set
endif;

?>

<section class="featured-contents">
	<div class="container">
		<?php if ( ! empty( $featured_contents['heading'] ) || ! empty( $featured_contents['description'] ) ) : ?>
			<header class="section-header">
				<?php if ( ! empty( $featured_contents['heading'] ) ) : ?>
					<h2 class="section-title"><?php echo $featured_contents['heading']; ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $featured_contents['description'] ) ) : ?>
					<div class="section-description">
						<?php echo wpautop( $featured_contents['description'] ); ?>
					</div>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php if ( ! empty( $featured_contents['posts'] ) ) : ?>

			<div class="section-loop">
				<?php
				foreach ( $featured_contents['posts'] as $post ) :
					setup_postdata( $post );

					get_template_part( 'templates/content/content', 'featured' );
				endforeach;

				// Reset back to orig $post
				wp_reset_postdata();
				?>
			</div>

			<?php if ( ! empty( $featured_contents['view_more_link'] ) ) : ?>
                <div class="section-footer">
                    <a href="<?php echo esc_url_raw( $featured_contents['view_more_link'] ); ?>" class="view-more">
						<?php echo $featured_contents['view_more_label']; ?>
                    </a>
                </div>
			<?php endif; ?>

		<?php endif; ?>
	</div>
</section>