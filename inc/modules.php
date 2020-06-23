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
    'methods' => 'POST',
    'callback' => 'mc_rest_login_endpoint_handler',
  ));
  
  register_rest_route('wp/v2', 'service-categories', array(
    'methods' => 'GET',
    'callback' => 'mc_rest_service_category_api',
  ));

  register_rest_route('wp/v2', 'service-post-meta-by-id', array(
    'methods' => 'POST',
    'callback' => 'mc_rest_service_posts_meta_by_id',
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

    if (empty($email)) {
        $error->add(401, __("Email field 'email' is required.", 'wp-rest-user'), array('status' => 400));
        return $error;
    }

    if (empty($password)) {
        $error->add(404, __("Password field 'password' is required.", 'wp-rest-user'), array('status' => 400));
        return $error;
    }

    $user = get_users(
        array(
            'meta_key' => 'phone',
            'meta_value' => $phone,
            'number' => 1,
            'count_total' => false
        )
    );

    if ( !empty( $user ) ) {
        $error->add(404, __("This phone number already have an account.", 'wp-rest-user'), array('status' => 400));
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

function mc_rest_service_category_api($request = null) {
    $categories = mc_get_all_parent_categories('service_category');

    $brands = [];
    $models = [];
    foreach ($categories as $category) {
        $cat_id = $category->term_id;
        $brands_as_child_categories = get_categories(array(
            'parent' => $cat_id,
            'taxonomy' => 'service_category'
        ));

        if( $brands_as_child_categories ) {
            array_push( $brands, $brands_as_child_categories );

            
            foreach ($brands_as_child_categories as $brand) {
                $models_as_child_categories = get_categories(array(
                    'parent' => $brand->term_id,
                    'taxonomy' => 'service_category'
                ));

                if( $models_as_child_categories ) {
                    array_push( $models, $models_as_child_categories );
                }
            }

            
        }
    }    

    $response['categories'] = $categories;
    $response['brands'] = $brands;
    $response['models'] = $models;
    $response['code'] = 200;
    
    return new WP_REST_Response($response, 123);
}

function mc_rest_service_posts_meta_by_id( $request = null ) {
    $response = array();
    $parameters = $request->get_json_params();


    if( empty($parameters) ) {
        $response['msg'] = 'post_id is missing';
        $response['code'] = 422;
        
    }else {
        if (get_post_status($parameters['post_id'])) {
            $all_service_type_options = get_post_meta( absint($parameters['post_id']), 'mc_service_type_all_options', true);
            $service_main_type = get_post_meta($parameters['post_id'], 'mc_service_type', true);
        }

        $response['service_types']['repair']['value'] = "1"; 
        $response['service_types']['repair']['types'] = $all_service_type_options; 
        $response['service_types']['diagnosis']['value'] = "0"; 
        $response['current_type'] = $service_main_type; 
        $response['code'] = 200;
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
        
        if ( $user && wp_check_password( $password, $user->data->user_pass, $user->ID ) ) {
           
            $activated_user_id = $user->ID;

           $response = array(
               'user_id' => $activated_user_id
           );
           
        } else {
            $error->add(406, __("The Password is not correct", 'wp-rest-user'), array('status' => 401));
            return $error;
        }
    }


    return new WP_REST_Response($response, 123);
}

/**
 * MC page head section
 * 
 * @param string
 * @param string
 * 
 */
function mc_get_quote_button( $link = '', $title = 'Get a Quote' ) {
    echo sprintf( '<a href="%s" class="btn btn-primary btn-lg px-5">%s</a>', $link, $title );
}

 /**
 * MC page head section
 * 
 * @param string
 * @param string
 * 
 */
function mc_page_head_section( $title = '', $subtitle = '' ) { 

    if( empty( $title ) || empty( $subtitle ) ) {
        return;
    }
    ?>
    <div class="head-section text-center">
        <div class="head-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo sprintf('<h2>%s</h2>', esc_html__( $title, 'mechanic' ) ); ?>
                        <?php echo sprintf('<p>%s</p>', esc_html__( $subtitle, 'mechanic' ) ); ?>
                        <?php mc_get_quote_button(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}

//  Save the phone number field in the database when the user registers into the website
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields', 10, 3 );
function wooc_save_extra_register_fields( $customer_id ) {
    if (isset($_POST['wooc_user_phone'])) {
        update_user_meta( $customer_id, 'wooc_user_phone', sanitize_text_field( $_POST['wooc_user_phone'] ) );
    }else {
        echo 'no update user meta';
    }
}


// Now we need to edit the WordPress authentication process so we can tell it to login the user with his phone number or any custom field

function wooc_get_users_by_phone($phone_number){

    // //echo $phone_number;
    // $user =  get_user_by('email','qqq@gmail.com');
    // echo $user_id = $user->ID;

    // $c_user = get_user_meta( $user_id, 'wooc_user_phone' );
    // echo '<pre>';
    // print_r( $c_user );
    // echo '</pre>';
    
    $user_query = new WP_User_Query( array(
        'meta_key' => 'wooc_user_phone',
        'meta_value' => $phone_number,
        'compare'=> '='
    ));


    // $user = get_users(
    //     array(
    //         'meta_key' => 'wooc_user_phone',
    //         'meta_value' => $phone_number,
    //         'number' => 1,
    //         'count_total' => false
    //     )
    // );

    return $user_query->get_results();
    // return $user;
}

// Then we check if the email and username doesn’t exist in the authentication process, that’s how we know the user might have written his phone number, so we search for him by his phone number and return the user.
add_filter('authenticate','wooc_login_with_phone',10,3);
function wooc_login_with_phone($user, $username, $password ) {
    $phone_number = $username;
    if($phone_number != '') {
        $users_with_phone = wooc_get_users_by_phone($phone_number);
        
        if(empty($users_with_phone)){
            return $user;
        }
        $phone_user = $users_with_phone[0];
            
        if ( wp_check_password( $password, $phone_user->user_pass, $phone_user->ID ) ){
            return $phone_user;
        }
    }
    return $user;
}