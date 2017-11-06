<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="inner">
		<header class="entry-header">
			<?php if ( is_singular() ) : ?>

				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

				<?php if ( 'post' == get_post_type() ) : ?>
					<p class="post-meta">
						<span class="meta"><?php _e( 'Posted on', 'TEXTDOMAIN' ); ?> <?php echo codeandbeauty_posted_date(); ?></span>
						<span class="meta"><?php echo codeandbeauty_posted_by(); ?></span>
						<span class="meta meta-comments">
							<i class="fa fa-comments"></i>
							<small><?php echo get_comments_number(); ?></small>
						</span>
					</p>
				<?php endif; ?>

			<?php else : ?>

				<?php the_title( '<h3 class="entry-title"><a href="' . esc_url_raw( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

				<a href="<?php echo esc_url_raw( get_permalink() ); ?>#comments" rel="bookmark" class="comment-meta">
					<i class="fa fa-comments"></i>
					<?php echo get_comments_number(); ?>
				</a>
			<?php endif; ?>

		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="feature-image">
				<?php the_post_thumbnail( is_singular() ? 'full-feature' : 'feature-image' ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-content">
			<?php
			if ( is_singular() ) :
				/* translators: %s: Name of current post */
				the_content( sprintf(
					'%1$s <span class="screen-reader-text">%2$s</span>',
					__( 'Continue reading', 'TEXTDOMAIN' ),
					get_the_title()
				) );
			else :
				the_excerpt();
			endif;
			?>
		</div>

		<footer class="entry-footer">
			<?php if ( 'post' == get_post_type() ) : ?>

				<?php if ( is_singular() ) : ?>
					<?php the_category(); ?>

					<span class="meta meta-tag">
						<?php the_tags( '<i class="fa fa-tags"></i>' ); ?>
					</span>
				<?php else : ?>

					<span class="meta"><?php codeandbeauty_posted_by(); ?></span>

					<?php the_category(); ?>

					<span class="meta meta-tag">
						<?php the_tags( '<i class="fa fa-tags"></i>' ); ?>
					</span>

				<?php endif; ?>
			<?php endif; ?>
		</footer>
	</div>
</article>
