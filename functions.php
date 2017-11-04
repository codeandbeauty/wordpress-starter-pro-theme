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
	add_image_size( 'full-feature-2', 1600, 600, true );

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
	 * Custom customizer options are optional but are commonly practice in most theme.
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

		$customizer->add_panel( 'home-page', array(
			'title' => __( 'Homepage', 'ui' ),
			'description' => __( 'A custom homepage template.', 'ui' ),
		) );

		// Featured page
		$customizer->add_section( 'featured_page', array(
			'title' => __( 'Featured Page', 'ui' ),
			'panel' => 'home-page',
		) );
		$customizer->add_setting( 'featured_page[page_id]' );
		$control_args = array(
			'label' => __( 'Select page', 'ui' ),
			'type' => 'dropdown-pages',
			'section' => 'featured_page',
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'featured_page[page_id]', $control_args ) );

		$customizer->add_setting( 'featured_page[read_more]' );
		$control_args = array(
			'label' => __( 'Read More Label', 'ui' ),
			'section' => 'featured_page',
			'input_attrs' => array(
				'placeholder' => __( 'Continue reading...', 'ui' ),
			),
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'featured_page[read_more]', $control_args ) );

		// Featured Contents
		$customizer->add_section( 'featured_contents', array(
			'title' => __( 'Featured Contents', 'ui' ),
			'panel' => 'home-page',
		) );
		$customizer->add_setting( 'featured_contents[heading]' );
		$control_args = array(
			'label' => __( 'Heading', 'ui' ),
			'sanitize_callback' => 'sanitize_textfield',
			'section' => 'featured_contents',
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'featured_contents[heading]', $control_args ) );

		$customizer->add_setting( 'featured_contents[description]' );
		$control_args = array(
			'label' => __( 'Description', 'ui' ),
			'type' => 'textarea',
			'sanitize_callback' => 'sanitize_textarea',
			'section' => 'featured_contents',
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'featured_contents[description]', $control_args ) );

		$post_types = get_post_types( array( 'public' => true ), 'objects' );

		if ( $post_types ) {
			foreach ( $post_types as $post_type => $object ) {
				$post_types[ $post_type ] = $object->label;
			}
		}
		unset( $post_types['page'], $post_types['attachment'] );

		$customizer->add_setting( 'featured_contents[post_type]' );
		$control_args = array(
			'label' => __( 'Content type', 'ui' ),
			'type' => 'select',
			'section' => 'featured_contents',
			'choices' => $post_types,
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'featured_contents[post_type]', $control_args ) );

		$customizer->add_setting( 'featured_contents[tax]' );
		$control_args = array(
			'label' => __( 'Category, Tags, or custom Taxonomy', 'ui' ),
			'description' => __( 'Separate each with comma. (i.e. Apple, Orange)', 'ui' ),
			'section' => 'featured_contents',
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'featured_contents[tax]', $control_args ) );

		$customizer->add_setting( 'featured_contents[posts_per_page]' );
		$control_args = array(
			'label' => __( 'Number of items', 'ui' ),
			'sanitize_callback' => 'intval',
			'section' => 'featured_contents',
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'featured_contents[posts_per_page]', $control_args ) );

		$customizer->add_setting( 'featured_contents[view_more]' );
		$control_args = array(
			'label' => __( 'View More label', 'ui' ),
			'sanitize_callback' => 'sanitize_textfield',
			'section' => 'featured_contents',
			'input_attrs' => array(
				'placeholder' => __( 'View More', 'wpui' ),
			),
		);
		$customizer->add_control( new WP_Customize_Control( $customizer, 'featured_contents[view_more]', $control_args ) );
	}
	add_action( 'customize_register', 'codeandbeauty_customizer' );
endif;

// Include template-tags
get_template_part( 'inc/template-tags' );