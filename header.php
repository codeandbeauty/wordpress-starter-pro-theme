<?php
/**
 * The header template.
 *
 * @package CodeAndBeauty
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#main-content"><?php _e( 'Skip to single', 'wpui' ); ?></a>

		<header id="main-header" class="main-header" role="banner">
            <?php
            /**
             * We'll put a top section in our header. Some theme doesn't need top section
             * and if you want to remove this section, simply remove the lines below.
             *
             * If you want override top section template in a child-theme, create a template
             * called `templates/header/top|top-{post_type}.php`and it will be use instead.
             *
             * @since 1.0.0
             */
            get_template_part( 'templates/header/top', get_post_type() );

            /**
             * Now let's include the page's masthead. Masthead is very important on all pages as
             * it shows the site's log and all other important information that needs to be printed
             * at the top.
             *
             * To override this template in a child-theme, create a file called
             * `templates/header/masthead|masthead-{post_type}.php` and it will be use instead.
             *
             * @since 1.0.0
             */
            get_template_part( 'templates/header/masthead', get_post_type() );

            /**
             * Now let's add the main navigation template. If you wish to remove the main navigation simply
             * remove this line below.
             *
             * To override the template below in a child-theme, create a file called
             * `templates/header/main-navigation.php` and it will be use instead.
             */
            get_template_part( 'templates/header/main-navigation' );
            ?>
		</header>

		<div id="main-content" role="main">