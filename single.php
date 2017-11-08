<?php
/**
 * The template use for singular post or custom post type.
 *
 * @package CodeAndBeauty
 */
get_header(); ?>

<section class="single-section">
	<div class="container">
		<div class="with-right-sidebar">
			<div class="main-container">
				<?php if ( have_posts() ) : ?>

					<?php
					while ( have_posts() ) :
						the_post();

						/**
						 * To override this template in a child-theme, create a template called
						 * `templates/content/content-{post_type}.php` and it will be use instead.
						 */
						get_template_part( 'templates/content/content', get_post_type() );

						/**
						 * Include comments template if comment is enabled and/or there are previous comments
						 * submitted for this post.
						 */
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

						the_post_navigation( array(
							'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'TEXTDOMAIN' ) . '</span><span class="nav-subtitle"><i class="fa fa-long-arrow-left"></i></span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'TEXTDOMAIN' ) . '</span><span class="nav-subtitle"><i class="fa fa-long-arrow-right"></i></span> <span class="nav-title">%title</span>',
						) );
					endwhile;
					?>

				<?php else : ?>

				<?php endif; ?>
			</div>

			<div class="right-container">
				<?php
				get_sidebar( 'right', get_post_type() );
				?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
