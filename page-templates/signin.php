<?php
/**
 * Template Name: Login
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php echo do_shortcode('[woocommerce_my_account]'); ?>


<?php get_footer(); ?>