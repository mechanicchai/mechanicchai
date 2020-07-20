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

// get all faqs
if( !function_exists( 'mc_get_faqs' ) ) {
    function mc_get_faqs() {
        if( function_exists( 'get_field' ) ) {
            $faqs = get_field( 'faq_items', 'option' );

            return $faqs;
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

/**
 * Generate Random String form email
 */
if( !function_exists( 'mc_generate_random_email' ) ) {

    function mc_generate_random_email($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString . '@gmail.com';
    }
}


/**
 * Get users by their role
 */
if( !function_exists( 'mc_get_users_by_role' ) ) {
    function mc_get_users_by_role($role = 'author', $orderby = 'user_nicename', $order = 'ASC') {
        $args = array(
            'role'    => $role,
            'orderby' => $orderby,
            'order'   => $order
        );
    
        $users = get_users( $args );
    
        return $users;
    }
}

/**
 * Get smsapi data
 */
if( !function_exists( "mc_get_sms_api_data" ) ) {
    function mc_get_sms_api_data() {
        $sms_api = [];
        if( function_exists('get_field') ) {
            $sms_api_key = get_field( 'sms_api_key', 'option' );
            $sms_sender_id = get_field( 'sms_sender_id', 'option' );

            $sms_api = [ 'api_key' => trim($sms_api_key), 'sender_id' => trim($sms_sender_id) ];
        }

        return $sms_api;
    }
}

/**
 * Get and Parse current page url
 */

if( !function_exists( 'mc_parse_current_url' ) ) {
    function mc_parse_current_url() {
        global $wp;
        $url = home_url( $wp->request );
        $parse_url = parse_url($url);

        return $parse_url;
    }
}



/**
 * Add dashboard menu item to nav menu
 */

if( !function_exists( 'add_last_nav_item' ) ) {
    function add_last_nav_item($items) {
        return $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-116 nav-item"><a href="'. home_url('dashboard') .'" class="nav-link" role="button" data-toggle="modal">Dashboard</a></li>';
    }
}
// add_filter( 'wp_nav_menu_items', 'add_last_nav_item' );
