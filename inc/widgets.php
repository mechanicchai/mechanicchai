<?php
/**
 * Mechanicchai widgets
 *
 * @package everstrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'widgets_init', 'mc_widgets_initialize' );
if ( ! function_exists( 'mc_widgets_initialize' ) ) {
	/**
	 * Initializes themes widgets.
	 */
	function mc_widgets_initialize() {

		register_sidebar( array(
			'name'          => __( 'Footer widget', 'everstrap' ),
			'id'            => 'footer-widget',
			'description'   => 'You may set maximum 3 widget here.',
			'before_widget' => '<div class="col-md-4 col-sm-4"><div id="%1$s" class="footer-widget footer-menu-widget %2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3 class="footer-widget-title">',
			'after_title'   => '</h3>',
		) );

	}
}
