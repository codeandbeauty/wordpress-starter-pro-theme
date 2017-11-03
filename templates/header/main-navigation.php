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

<nav id="main-navigation" aria-label="<?php _e( 'Main Navigation', 'ui' ); ?>" role="navigation">
	<div class="container">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'main',
			'fallback_cb' => false, // This will prevent pages from showing up if there are no menus set
		) );
		?>
	</div>
</nav>
