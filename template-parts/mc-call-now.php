<?php
/**
 * Call Now Section
 * 
 * @package mc
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<div class="call-now">
    <?php
        $call_number = '';
        if( function_exists( 'get_field' ) ) {
            $call_number = get_field( 'call_now_number', 'option' );
        }

        //call now number
        echo sprintf( '<h3>%s<br><strong><i class="fas fa-phone-alt"></i> %s</strong></h3>', esc_html__( 'call now', 'mechanic' ), $call_number );
        
        // call now content
        if( function_exists( 'get_field' ) ) {
            echo get_field( 'call_now_content', 'option' );
        }
    ?>
</div>