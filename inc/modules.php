<?php
/**
 * Register a new user
 *
 * @param $request Full details about the request.
 * @return array $args.
 */

function mc_rest_user_endpoints($request) {
  register_rest_route('wp/v2', 'users/register', array(
    'methods' => 'POST',
    'callback' => 'mc_rest_user_endpoint_handler',
  ));

  register_rest_route('wp/v2', 'users/login', array(
    'methods' => 'GET',
    'callback' => 'mc_rest_login_endpoint_handler',
  ));

}
add_action('rest_api_init', 'mc_rest_user_endpoints');

$args2 = array(
    'type'             => 'string', // Validate and sanitize the meta value as a string.
    'description'    => 'A meta key associated with a string meta value.', // Shown in the schema for the meta key.
    'single'        => true, // Return an array with the type used as the items type. Default: false.
    'show_in_rest'    => true, // Show in the WP REST API response. Default: false.
);
 
register_meta( 'user', 'fullname', $args2 );


$args3 = array(
    'type'             => 'string', // Validate and sanitize the meta value as a string.
    'description'    => 'A meta key associated with a string meta value.', // Shown in the schema for the meta key.
    'single'        => true, // Return an array with the type used as the items type. Default: false.
    'show_in_rest'    => true, // Show in the WP REST API response. Default: false.
);
 
register_meta( 'user', 'location', $args3 );

$args3 = array(
    'type'             => 'string', // Validate and sanitize the meta value as a string.
    'description'    => 'A meta key associated with a string meta value.', // Shown in the schema for the meta key.
    'single'        => true, // Return an array with the type used as the items type. Default: false.
    'show_in_rest'    => true, // Show in the WP REST API response. Default: false.
);
 
register_meta( 'user', 'phone', $args3 );

function mc_rest_user_endpoint_handler($request = null) {
    $response = array();
    $parameters = $request->get_json_params();
    
    $username = sanitize_text_field($parameters['username']);
    $password = sanitize_text_field($parameters['password']);
    $full_name = !empty($parameters['meta']['fullname']) ? sanitize_text_field($parameters['meta']['fullname']) : '';
    $location = !empty($parameters['meta']['location']) ? sanitize_text_field($parameters['meta']['location']) : '';
    $phone = !empty($parameters['meta']['phone']) ? sanitize_text_field($parameters['meta']['phone']) : '';
    //$email = sanitize_text_field($parameters['email']);
    // $role = sanitize_text_field($parameters['role']);

    $error = new WP_Error();
    if (empty($username)) {
        $error->add(400, __("Username field 'username' is required.", 'wp-rest-user'), array('status' => 400));
        return $error;
    }

    // if (empty($email)) {
    //     $error->add(401, __("Email field 'email' is required.", 'wp-rest-user'), array('status' => 400));
    //     return $error;
    // }
    if (empty($password)) {
        $error->add(404, __("Password field 'password' is required.", 'wp-rest-user'), array('status' => 400));
        return $error;
    }
    // if (empty($role)) {
    //  $role = 'subscriber';
    // } else {
    //     if ($GLOBALS['wp_roles']->is_role($role)) {
    //      // Silence is gold
    //     } else {
    //    $error->add(405, __("Role field 'role' is not a valid. Check your User Roles from Dashboard.", 'wp_rest_user'), array('status' => 400));
    //    return $error;
    //     }
    // }
    $user_id = username_exists($username);
    if (!$user_id) {
        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {

            //update fullname            
            update_user_meta($user_id, 'fullname', $full_name);

            //update location
            update_user_meta($user_id, 'location', $location);
            
            //update phone
            update_user_meta($user_id, 'phone', $phone);

            $user = get_user_by('id', $user_id);
            // $user->set_role($role);
            $user->set_role('subscriber');
            // WooCommerce specific code
            if (class_exists('WooCommerce')) {
                $user->set_role('customer');
            }
            // Ger User Data (Non-Sensitive, Pass to front end.)
            $response['code'] = 200;
            $response['message'] = __("User '" . $username . "' Registration was Successful", "wp-rest-user");
        } else {
            return $user_id;
        }
    } else {
        $error->add(406, __("Email already exists, please try 'Reset Password'", 'wp-rest-user'), array('status' => 400));
        return $error;
    }
    return new WP_REST_Response($response, 123);
}


function mc_rest_login_endpoint_handler($request = null) {
    $response = array();
    $parameters = $request->get_json_params();
    
    $username = sanitize_text_field($parameters['username']);
    $password = sanitize_text_field($parameters['password']);

    $error = new WP_Error();
    if (empty($username)) {
        $error->add(400, __("Username field 'username' is required.", 'wp-rest-user'), array('status' => 400));
        return $error;
    }

    if (empty($password)) {
        $error->add(404, __("Password field 'password' is required.", 'wp-rest-user'), array('status' => 400));
        return $error;
    }


    $user_id = username_exists($username);
    if( !$user_id ) {
        $error->add(406, __("This user is not exists", 'wp-rest-user'), array('status' => 400));
        return $error;   
    }else {
        $user = get_user_by( 'login', $username );
        
        if ( $user && wp_check_password( '123', $user->data->user_pass, $user->ID ) ) {
           $users = wp_remote_get('http://mechanicchai.test/wp-json/wp/v2/user/'. $user->ID );
            
            

           return $users;
           
        } else {
            $error->add(406, __("The Password is not correct", 'wp-rest-user'), array('status' => 401));
            return $error;
        }
    }


    return new WP_REST_Response($response, 123);
}