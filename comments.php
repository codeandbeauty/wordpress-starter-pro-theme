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
    <ol class="comment-list">
		<?php
		wp_list_comments( array(
			'avatar_size' => 100,
			'style'       => 'ol',
			'short_ping'  => true,
			'reply_text'  => __( 'Reply', 'ui' ),
		) );
		?>
    </ol>

    <?php the_comments_pagination( array(
        'prev_text' => '<span class="screen-reader-text">' . __( 'Previous', 'ui' ) . '</span>',
        'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'ui' ) . '</span>',
    ) );

    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <p class="no-comments"><?php _e( 'Comments are closed.', 'ui' ); ?></p>
	    <?php
    endif;

    comment_form();
    ?>
</div>
