<?php
/**
 * Functions and definitions commonly use upfront.
 *
 * @package CodeAndBeauty
 */

/**
 * Set stylesheets and javascript assets.
 */
function codeandbeauty_assets() {
	$src = get_template_directory_uri() . '/assets/';
	$version = '1.0.0'; // Always check and change the version number whenever you update your theme.
	$css_dependencies = array( 'dashicons' );
	$js_dependencies = array( 'jquery' );

	wp_enqueue_style( 'cad-google-font', 'https://fonts.googleapis.com/css?family=Montserrat' );
	wp_enqueue_style( 'cad-font-awesome', $src . 'external/css/font-awesome.min.css' );

	/**
	 * Though the theme contains the main style.css at the main root, we are including the
	 * style.css inside the assets folder.
	 */
	wp_enqueue_style( 'cad-style', $src . 'css/style.min.css', $css_dependencies, $version );
}
add_action( 'wp_enqueue_scripts', 'codeandbeauty_assets' );

if ( ! function_exists( 'codeandbeauty_mini_logo' ) ) :
	/**
	 * Print the site's custom mini logo.
	 */
	function codeandbeauty_mini_logo() {
		$url = get_theme_mod( 'mini_logo' );

		if ( ! empty( $url ) ) {
			$img = sprintf( '<img src="%1$s" class="mini-logo" alt="%2$s" />', esc_url_raw( $url ), __( 'Mini logo', 'ui' ) );

			printf( '<a href="%1$s" rel="bookmark" class="mini-logo-link">%2$s</a>', esc_url( home_url( '/' ) ), $img );
		}
	}
endif;

if ( ! function_exists( 'codeandbeauty_excerpt_more' ) ) :
	/**
	 * Change [...] in excerpt into a simple three dots.
	 */
	function codeandbeauty_excerpt_more() {
		return '...';
	}
	add_filter( 'excerpt_more', 'codeandbeauty_excerpt_more' );
endif;

if ( ! function_exists( 'codeandbeauty_posted_date' ) ) :
	function codeandbeauty_posted_date( $date_format = false ) {
		$date_format = ! $date_format ? DATE_W3C : $date_format;
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			get_the_date( $date_format ),
			get_the_date(),
			get_the_modified_date( $date_format ),
			get_the_modified_date()
		);

		$postdate = sprintf(
		/* translators: %s: post date */
			__( '<span class="screen-reader-text">Posted on</span> %s', 'ui' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $postdate . '</span>';
	}
endif;

if ( ! function_exists( 'codeandbeauty_posted_by' ) ) :
	/**
	 * Returns the post author.
	 */
	function codeandbeauty_posted_by() {

		// Get the author name; wrap it in a link.
		$byline = sprintf(
		/* translators: %s: post author */
			__( 'by %s', 'ui' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>';
	}
endif;