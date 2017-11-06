<section class="header-section">
	<div class="container">
		<div class="masthead">
			<?php if ( has_custom_logo() ) : ?>

				<?php the_custom_logo(); ?>

			<?php else : ?>

				<div class="site-branding-text">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><?php bloginfo( 'name' ); ?></a>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				</div>

			<?php endif; ?>
		</div>

		<div class="header-box">
			<?php if ( is_active_sidebar( 'header-box' ) ) : ?>
				<div class="header-box-widgets">
					<?php dynamic_sidebar( 'header-box' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( has_nav_menu( 'primary' ) ) : ?>

				<nav id="primary-menu" class="primary-menu" role="navigation" aria-label="<?php _e( 'Primary Menu', 'TEXTDOMAIN' ); ?>">
					<button type="button" class="toggle toggle-menu" data-target="#primary-menu-container">
						<span class="menu-label"><?php _e( 'Menu', 'TEXTDOMAIN' ); ?></span>
						<i class="icon icon-menu"></i>
						<i class="icon icon-cross"></i>
					</button>

					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'fallback_cb'    => false,
						'container_id'   => 'primary-menu-container',
					) );
					?>
				</nav>

			<?php endif; ?>

		</div>
	</div>
</section>
