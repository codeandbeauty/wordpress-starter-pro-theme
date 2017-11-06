<?php
/**
 * The template use for main navigation at header area.
 *
 * @package CodeAndBeauty
 */
if ( ! defined( 'ABSPATH' ) || ! has_nav_menu( 'main' ) ) :
	return; // Bail if access directly or no menu set at main navigation
endif;
?>

<nav id="main-navigation" aria-label="<?php _e( 'Main Navigation', 'TEXTDOMAIN' ); ?>" role="navigation">
	<label for="main-nav-menu-toggle" class="toggle toggle-menu">
		<span class="screen-reader-text"><?php _e( 'Menu', 'ui' ); ?></span>
		<i class="fa fa-ellipsis-h"></i>
	</label>
	<input type="checkbox" id="main-nav-menu-toggle" autocomplete="off" />

	<div class="container">
		<?php
		wp_nav_menu( array(
			'theme_location'  => 'main',
			'container_class' => 'main-nav',
			'fallback_cb'     => false, // This will prevent pages from showing up if there are no menus set
		) );
		?>

		<div class="search-box">
			<?php get_search_form(); ?>
		</div>
	</div>
</nav>
