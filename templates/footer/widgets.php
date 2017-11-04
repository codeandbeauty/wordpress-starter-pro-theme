<?php
if ( ! is_active_sidebar( 'footer-widgets' ) ) :
	return;
endif;
?>
<section class="footer-widgets">
	<div class="container">
		<div class="widgets-container wf-container">
			<?php dynamic_sidebar( 'footer-widgets' ); ?>
		</div>
	</div>
</section>