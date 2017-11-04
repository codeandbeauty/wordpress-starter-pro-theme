<?php
global $post;

$featured_page = get_theme_mod( 'featured_page', array() );

if ( empty( $featured_page ) && ! empty( $featured_page['page_id'] ) ) :
	return; // Don't bother continuing if no selected page
endif;

if ( empty( $featured_page['read_more'] ) ) :
    $featured_page['read_more'] = __( 'Continue reading...', 'ui' );
endif;

$post = get_post( (int) $featured_page['page_id'] );
setup_postdata( $post );
?>

<section class="featured-page <?php echo has_post_thumbnail() ? 'has-thumb' : ''; ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="feature-image">
			<?php the_post_thumbnail( 'full-feature-2' ); ?>
		</div>
	<?php endif; ?>

    <div class="featured-content-container">
        <div class="container">
            <header class="feature-header">
		        <?php the_title( '<h2 class="feature-title">', '</h2>' ); ?>
            </header>

            <div class="featured-content">
		        <?php the_excerpt(); ?>
            </div>

            <?php if ( ! empty( $featured_page['read_more'] ) ) :
            /**
             * We'll set the footer only if read more label is set.
             */
            ?>
            <div class="featured-footer">
                <a href="<?php echo esc_url_raw( get_permalink() ); ?>" rel="bookmark" class="url read-more">
		            <?php echo $featured_page['read_more']; ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// Restore original $post
	wp_reset_postdata();