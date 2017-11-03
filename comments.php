<?php
/**
 * The template use for displaying both comments and comment form.
 *
 * @package CodeAndBeauty
 */
if ( post_password_required() ) :
	return; // Bail if the current post is password protected and the user did not enter the password.
endif;
?>

<div id="comments" class="comment-area">

</div>
