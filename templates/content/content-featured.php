<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="inner">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="feature-image">
				<?php the_post_thumbnail( 'feature-image' ); ?>
			</div>
		<?php endif; ?>

		<header class="entry-header">
			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url_raw( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
		</header>

		<?php if ( ! has_post_thumbnail() ) : ?>

			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div>

		<?php endif; ?>
	</div>
</article>
