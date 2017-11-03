<?php
/**
 * Functions and definitions
 *
 * This file contains functions that are required to this theme. Some functions can be overriden in a child-theme
 * while others are not.
 */

/**
 * Setup menus and various supports.
 */
function codeandbeauty_setup() {
	// Let WP set the page's <title> tag
	add_theme_support( 'title-tag' );

	// This theme's uses custom logo
	$custom_logo_args = array(
		'height' => 160,
		'flex-height' => true,
		'flex-width' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	);
	add_theme_support( 'custom-logo', $custom_logo_args );

	// Add feature image support to posts and pages
	add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
	add_image_size( 'full-feature', 1024, 400, true );

	// Add custom image size for archive's posts
	add_image_size( 'feature-image', 572, 372, true );

	// This theme uses 3 menu locations
	register_nav_menus( array(
		'top-menu' => __( 'Top Menu', 'ui' ),
		'primary' => __( 'Primary Menu', 'ui' ),
		'main' => __( 'Main Navigation', 'ui' ),
		'footer-links' => __( 'Footer Links', 'ui' ),
	) );

	// Enable background support
	add_theme_support( 'custom-background' );
}
add_action( 'after_setup_theme', 'codeandbeauty_setup' );

function codeandbeauty_widgets_init() {
	$sidebar_args = array(
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="inner-widget">',
		'after_widget' => '</div></aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	);

	// Header Box
	register_sidebar( wp_parse_args( array(
		'id' => 'header-box',
		'name' => __( 'Header Box', 'ui' ),
		'description' => __( 'Visible at the top-right corner of your page.', 'ui' ),
	), $sidebar_args ) );

	// Left Sidebar
	register_sidebar( wp_parse_args( array(
		'id' => 'left-sidebar',
		'name' => __( 'Left Sidebar', 'ui' ),
		'description' => __( 'Visible at the left side corner of your page.', 'ui' ),
	), $sidebar_args ) );

	// Right sidebar
	register_sidebar( wp_parse_args( array(
		'id' => 'right-sidebar',
		'name' => __( 'Right Sidebar', 'ui' ),
		'description' => __( 'Visible at the right side corner of your page.', 'ui' ),
	), $sidebar_args ) );

	// Footer Widgets
	register_sidebar( wp_parse_args( array(
		'id' => 'footer-widgets',
		'name' => __( 'Footer Widgets', 'ui' ),
		'description' => __( 'Visible at the bottom of your page.', 'ui' ),
	), $sidebar_args ) );
}
add_action( 'widgets_init', 'codeandbeauty_widgets_init' );

if ( ! function_exists( 'codeandbeauty_customizer' ) ) :
	/**
	 * Custom customizer options are optional but are commonly practice in most themes.
	 * Here are some minimal customizer options that you can either remove or extend
	 * at your disposal.
	 *
	 * @param $customizer
	 */
	function codeandbeauty_customizer( $customizer ) {
		/**
		 * Our top section header use mini logo. Let's add an option to allow
		 * uploading a mini logo at `Site Identity` section.
		 */
		$customizer->add_setting( 'mini_logo' );
		$control_args = array(
			'label' => __( 'Mini Logo', 'ui' ),
			'section' => 'title_tagline',
		);
		$customizer->add_control( new WP_Customize_Image_Control( $customizer, 'mini_logo', $control_args ) );

		/**
		 * Let's create a new section that will hold all other site informations
		 * needed in our theme.
		 */
		$customizer->add_section( 'site_info', array(
			'title' => __( 'Site Info', 'ui' ),
		));

		/**
		 * Another feature our top section have is a custom text, this could be a plain text or
		 * a shortcode.
		 */
		$customizer->add_setting( 'top_text' );
		$control_args = array(
			'label' => __( 'Top Text', 'ui' ),
			'description' => __( 'Add a single line text or shortcode that will be visible at the top-left corner of your page.', 'ui' ),
			'section' => 'site_info',
			'type' => 'textarea',
			'sanitize_callback' => 'sanitize_textarea',
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'top_text', $control_args ) );

		/**
		 * The bottom most part of our footer use footer text. Let's add an box area option
		 * for our footer text.
		 */
		$customizer->add_setting( 'footer_text' );
		$control_args = array(
			'label' => __( 'Footer/Copyright Text', 'ui' ),
			'description' => __( 'Write your site\'s copyright or any useful text that will be visible at the bottom most part of the page.', 'ui' ),
			'type' => 'textarea',
			'sanitize_callback' => 'sanitize_textarea',
			'section' => 'site_info',
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'footer_text', $control_args ) );
	}
	add_action( 'customize_register', 'codeandbeauty_customizer' );
endif;

// Include template-tags
get_template_part( 'inc/template-tags' );