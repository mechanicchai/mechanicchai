<?php
/**
 * Template Name: Vendor Registration
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

    <?php
        

        // $bearar_code = mc_get_jwt_token();
        
        // $headers = array( 
        //     'Content-Type' => 'application/json', 
        //     'Authorization' => 'Bearer '. $bearar_code 
        // );

        // $full_url = get_home_url() .'/wp-json/gf/v2/entries';

        // //Form to be created
        // $form = array( 
        //     'title' => "Form title" 
        // );
        
        //Send request
        // $response = wp_remote_request( $full_url,
        //     array(
        //         'method'  => 'POST',
        //         'body'    => json_encode( $form ),
        //         'headers' => $headers
        //     )
        // );

        // // Check the response code.
        // if ( wp_remote_retrieve_response_code( $response ) != 200 || ( empty( wp_remote_retrieve_body( $response ) ) ) ){
        //     // If not a 200, HTTP request failed.
        //     die( 'There was an error attempting to access the API.' );
        // }
    ?>

    <!--  content  -->
    <div class="container-fluid my-2">
        <div class="card bg-light signup">
            <article class="card-body mx-auto" style="max-width: 400px;">
                <h4 class="card-title mt-3 text-center">Create Account</h4>
                <p class="text-center">Get started with your free account</p>
                <?php echo do_shortcode('[gravityform id="3"]'); ?>
            </article>
        </div> <!-- card.// -->
    </div> <!--container end.//-->
    <!--  content  -->

<?php get_footer(); ?>
