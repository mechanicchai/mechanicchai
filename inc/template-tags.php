<?php
/**
 * Theme template tags
 *
 * @package mechanicchai
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Get all parent categories
if( !function_exists('mc_get_all_parent_categories') ) {
    function mc_get_all_parent_categories( $taxonomy='category', $orderby = 'name', $hide_empty = false ) {

        $args = array(
            'taxonomy' => $taxonomy,
            'orderby' => $orderby,
            'order' => 'ASC',
            'hide_empty' => $hide_empty,
            'parent' => 0
        );

        $categories = get_categories($args);

        if($categories) {
            return $categories;    
        }
    }
}




?>

