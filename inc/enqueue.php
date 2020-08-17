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
		wp_enqueue_style( 'sweetalert-css', get_template_directory_uri() . '/css/sweetalert2.min.css' );
		wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.4.1' );
		wp_enqueue_style( 'normalize-css', get_template_directory_uri() . '/css/normalize.css', array(), '1.0.0' );
		wp_enqueue_style( 'mc-styles', get_template_directory_uri() . '/css/main.css', array(), $css_version );

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wp-util' );

		

		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/main.js' );

		wp_enqueue_script( 'modernizr-script', get_template_directory_uri() . '/js/vendor/modernizr-3.8.0.min.js', array(), '5.12.1', true );
		wp_enqueue_script( 'fontawesome-script', get_template_directory_uri() . '/js/all.min.js', array(), '5.12.1', true );
		wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '4.4.1', true );
		wp_enqueue_script( 'sweetalert-script', get_template_directory_uri() . '/js/sweetalert2.min.js', array(), $js_version, true );
		wp_enqueue_script( 'plugin-script', get_template_directory_uri() . '/js/plugins.js', array(), '4.4.1', true );
		wp_enqueue_script( 'mc-scripts', get_template_directory_uri() . '/js/main.js', array(), $js_version, true );
		wp_enqueue_script( 'mc-custom-scripts', get_template_directory_uri() . '/js/custom.js', array(), $js_version, true );
		wp_localize_script( 'mc-custom-scripts', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // endif function_exists( 'mc_scripts' ).

add_action( 'wp_enqueue_scripts', 'mc_scripts' );


if ( ! function_exists( 'mc_admin_scripts' ) ) {
	function mc_admin_scripts() {
		// Get the theme data.
		$the_theme     = wp_get_theme();
		$theme_version = $the_theme->get( 'Version' );
		$js_version = $theme_version . '.' . filemtime( get_template_directory() . '/js/admin.js' );
		wp_enqueue_script( 'mc-admin-scripts', get_template_directory_uri() . '/js/admin.js', array('wp-blocks'), $js_version, true );
	}
}
add_action( 'admin_enqueue_scripts', 'mc_admin_scripts' );