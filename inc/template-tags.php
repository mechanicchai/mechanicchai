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

// get all service locations
if( !function_exists( 'mc_get_service_locations' ) ) {
    function mc_get_service_locations() {
        if( function_exists( 'get_field' ) ) {
            $locations = get_field( 'location_names', 'option' );

            return $locations;
        }
    }
}


// get all service repair types
if( !function_exists( 'mc_get_service_types' ) ) {
    function mc_get_service_types() {
        $repair_service = array();

        if( function_exists( 'get_field' ) ) {
            $repair_types = get_field( 'service_repair_types', 'option' );

            if( $repair_types ) {
                foreach( $repair_types as $repair_type ) {
                    $service_repair_type = strtolower($repair_type['service_repair_type']);
                    $service_repair_ids = explode(" ", $service_repair_type);
                    $service_repair_id = implode("-", $service_repair_ids);

                    $service_repair_arr = array(
                        'id' => $service_repair_id,
                        'name' => $repair_type['service_repair_type'],
                    );

                    array_push( $repair_service, $service_repair_arr );
                }
            }
        }

        return $repair_service;
    }
}

// get json token
if( !function_exists( 'mc_get_jwt_token' ) ) {
    function mc_get_jwt_token() {

        $headers = array( 
            'Content-Type' => 'application/json'
        );

        $token_url = get_home_url() .'/wp-json/jwt-auth/v1/token';

        //token arguments array
        $params = array( 
            'username' => "nayan",  
            'password' => "123",  
        );

        //Send request
        $response = wp_remote_request( $token_url,
            array(
                'method'  => 'POST',
                'body'    => json_encode( $params ),
                'headers' => $headers
            )
        );

        // Check the response code.
        if ( wp_remote_retrieve_response_code( $response ) != 200 || ( empty( wp_remote_retrieve_body( $response ) ) ) ){
            // If not a 200, HTTP request failed.
            die( 'There was an error attempting to access the API.' );
        }else {
            return json_decode($response['body'])->token;
        }
    }
}