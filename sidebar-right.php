<?php
/**
 * The template use to show sidebar widgets set on the right side.
 *
 * @package CodeAndBeauty
 */

if ( ! defined( 'ABSPATH' ) || ! is_active_sidebar( 'right-sidebar' ) ) :
	return;// Bail if access directly or right-sidebar is not set.
endif;
?>

<div class="sidebar right-sidebar" aria-label="<?php _e( 'Right Sidebar', 'TEXTDOMAIN' ); ?>">
	<h3 class="screen-reader-text"><?php _e( 'Sidebar', 'TEXTDOMAIN' ); ?></h3>

	<?php dynamic_sidebar( 'right-sidebar' ); ?>
</div>
