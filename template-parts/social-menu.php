<?php
/**
 * mechanicchai social menu
 *
 * @package mc
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;


if( function_exists('get_field') ) {
    $social_menu_items = get_field( 'social_menu_section', 'option' );
}
               
?>
<div class="social-links">
    <div class="row text-center" style="padding-right: 0px">
        <div class="col-12 py-3 links">
        <?php
            if( !empty( $social_menu_items ) ) {
                foreach( $social_menu_items as $social_menu_item ) {
        ?>
            <a href="<?php echo esc_url( $social_menu_item['social_menu_link'] ); ?>" target="_blank"><i class="<?php echo $social_menu_item['social_menu_class']; ?>"></i></a>
        <?php
                }
            }
        ?>    
        </div>
    </div>
</div>