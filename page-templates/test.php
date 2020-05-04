<?php
/**
 * Template Name: Test  
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php
    // $user = reset(
    //     get_users(
    //         array(
    //             'meta_key' => 'user_phone',
    //             'meta_value' => '01685773283',
    //             'number' => 1,
    //             'count_total' => false
    //         )
    //     )
    // );
    
    // $user = get_users(
    //         array(
    //             'meta_key' => 'phone',
    //             'meta_value' => '01756589954',
    //             'number' => 1,
    //             'count_total' => false
    //         )
    //     );

    // echo '<pre>';
    // print_r( $user );
    // echo '</pre>';
    
    // Add phone number field in the woocommerce registration form
    function wooc_add_phone_number_field() {
        return apply_filters( 'woocommerce_forms_field', array(
            'wooc_user_phone' => array(
                'type'        => 'text',
                'label'       => __( 'Phone Number', ' woocommerce' ),
                'placeholder' => __( 'Your phone number', 'woocommerce' ),
                'required'    => true,
            ),
        ) );
    }
    add_action( 'woocommerce_register_form', 'wooc_add_field_to_registeration_form', 15 );
    function wooc_add_field_to_registeration_form() {
        $fields = wooc_add_phone_number_field();
        foreach ( $fields as $key => $field_args ) {
            woocommerce_form_field( $key, $field_args );
        }
    }

    // Finally we need to edit the login label to tell the user that he can login with his phone number
    add_filter( 'gettext', 'wooc_change_login_label', 10, 3 );
    function wooc_change_login_label( $translated, $original, $domain ) {
        if ( $translated == "Username or email address" && $domain === 'woocommerce' ) {
            $translated = "phone";
        }
        return $translated;
    } 
?>

<div class="container">
    <div class="row">
        <?php
            if( have_posts() ):

                while( have_posts() ):
                    the_post();

                    the_content();
                endwhile;
            endif; 
        ?>
    </div>
</div>

<?php
get_footer();
?>