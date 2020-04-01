<?php
/**
 * Mechanicchai enqueue scripts
 *
 * @package mc
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'mc_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function mc_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );

		$css_version = $theme_version . '.' . filemtime( get_template_directory() . '/css/main.css' );
		wp_enqueue_style( 'font-awesome-css', get_template_directory_uri() . '/css/all.css' );
		wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.4.1' );
		wp_enqueue_style( 'normalize-css', get_template_directory_uri() . '/css/normalize.css', array(), '1.0.0' );
		wp_enqueue_style( 'mc-styles', get_template_directory_uri() . '/css/main.css', array(), $css_version );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wp-util' );

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/main.js' );
		wp_enqueue_script( 'fontawesome-scripts', get_template_directory_uri() . '/js/all.min.js', array(), '5.12.1', true );
		wp_enqueue_script( 'bootstrap-scripts', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '4.4.1', true );
		wp_enqueue_script( 'mc-scripts', get_template_directory_uri() . '/js/main.js', array(), $js_version, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // endif function_exists( 'mc_scripts' ).

add_action( 'wp_enqueue_scripts', 'mc_scripts' );