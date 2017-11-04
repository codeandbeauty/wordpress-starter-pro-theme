<?php
/**
 * Template Name: Custom Home Page
 *
 * An optional home page template.
 *
 * @package CodeAndBeauty
 */
get_header();

/**
 * Include featured page template.
 */
get_template_part( 'templates/home/featured', 'page' );

/**
 * Include featured contents template.
 */
get_template_part( 'templates/home/featured-contents' );

get_footer();
