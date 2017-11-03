<?php
/**
 * General template.
 *
 * Use as template for posts, pages, and custom post types where no set unique template.
 *
 * @package CodeAndBeauty
 */
get_header(); ?>

<section class="section">
	<div class="container">
		<div class="with-right-sidebar">
			<div class="main-container">
				<?php if ( have_posts() ) : ?>

					<?php if ( is_archive() || is_category() || is_tag() ) : ?>

						<header class="page-header">
							<?php
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<p class="page-description">', '</p>' );
							?>
						</header>

					<?php endif; ?>

					<?php
					while ( have_posts() ) :
						the_post();

						/**
						 * To override this template in a child-theme, create a file called
						 * `templates/content/content-{post_type}.php` and it will be use instead.
						 */
						get_template_part( 'templates/content/content', get_post_type() );

						if ( is_singular() ) :

							/**
							 * Add comments template
							 */
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

							the_post_navigation( array(
								'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'ui' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'ui' ) . '</span> <span class="nav-title">%title</span>',
								'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'ui' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'ui' ) . '</span> <span class="nav-title">%title</span>',
							) );
						endif;
					endwhile;

					if ( ! is_singular() ) :

						the_posts_pagination( array(
							'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'ui' ) . '</span><span class="meta-prev">' . __( 'Previous', 'ui' ) . '</span>',
							'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'ui' ) . '</span><span class="meta-next">' . __( 'Next', 'ui' ) . '</span>',
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'ui' ) . ' </span>',
						) );

					endif;
					?>

				<?php else : ?>

					<?php
					/**
					 * To override this template in a child-theme, create a template called
					 * `templates/contents/content-none.php` and it will be use instead.
					 */
					get_template_part( 'templates/content/content', 'none' );
					?>

				<?php endif; ?>
			</div>

            <div class="right-container">
	            <?php get_sidebar( 'right' ); ?>
            </div>

		</div>
	</div>
</section>

<?php get_footer();
