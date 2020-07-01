<?php
/**
 * Register a new user
 *
 * @param $request Full details about the request.
 * @return array $args.
 */

function mc_rest_user_endpoints($request) {
  register_rest_route('wp/v2', 'smsapi', array(
    'methods' => 'GET',
    'callback' => 'mc_rest_sms_api_data',
  ));
  
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


function mc_rest_sms_api_data( $request = null ) {
    $sms_api = mc_get_sms_api_data();

    $response = array();

    $error = new WP_Error();
    if (empty($sms_api)) {
        $error->add(400, __("Nothing Found!", 'wp-rest-user'), array('status' => 404));
        return $error;
    }else {
        $response['data'] = $sms_api;
        $response['code'] = 200;
        $response['message'] = 'SMS Api data found!';
    }

    return new WP_REST_Response($response, 123);
}

/**
 * User Registration API callback
 * @api {post} /users/register Request user register
 * @apiGroup User
 *
 * @apiParam {String} mc_user_name User full name.
 * @apiParam {String} mc_user_location User location.
 * @apiParam {String} mc_user_phone User login phone.
 * @apiParam {String} mc_user_password User login password.
 * @apiParam {String} mc_user_role User role.
 */
function mc_rest_user_endpoint_handler($request = null) {
    $response = array();
    $parameters = $request->get_json_params();
    
    //all parameters
    $name = sanitize_text_field($parameters['mc_user_name']);
    $location = sanitize_text_field($parameters['mc_user_location']);
    $phone = sanitize_text_field($parameters['mc_user_phone']);
    $password = sanitize_text_field($parameters['mc_user_password']);
    $role = sanitize_text_field($parameters['mc_user_role']);
    $email = mc_generate_random_email();

    // get user with phone if exists
    $mc_user_phone_key = 'mc_user_phone';
    $user = get_users(
        array(
            'meta_key' => $mc_user_phone_key,
            'meta_value' => $phone,
            'number' => 1,
            'count_total' => false
        )
    );
    

    //error init
    $error = new WP_Error();

    //user name validate check
    if (empty($name)) {
        $error->add(404, __("User Full Name field is empty. Fieldname: 'mc_user_name'.", 'mechanic'), array('status' => 404));
        return $error;
    }   

    //user phone validate check
    if (empty($phone)) {
        $error->add(404, __("User phone field is empty. Fieldname: 'mc_user_phone'.", 'mechanic'), array('status' => 404));
        return $error;
    }
    
    if( count($user) > 0 ) {
        $error->add(400, __("User phone already exist. Please register with another phone number.", 'mechanic'), array('status' => 400));
        return $error;
    }

    //user password validate check
    if (empty($password)) {
        $error->add(404, __("User password field is empty. Fieldname: 'mc_user_password'.", 'mechanic'), array('status' => 404));
        return $error;
    }   

    //user email validate check
    if (empty($email)) {
        $error->add(404, __("Email is empty.", 'mechanic'), array('status' => 404));
        return $error;
    }elseif( email_exists($email) ) {
        $error->add(400, __("This Email has already an account.", 'mechanic'), array('status' => 400));
        return $error;
    }

    $user_data = array(
        'user_login' => $name,
        'user_pass'  => $password,
        'user_email' => $email,
        'role'       => $role ? $role : 'subscriber'
    );

    //insert user process
    $user_id = wp_insert_user( $user_data );
    if( is_wp_error( $user_id ) ) {
        $err_msg = 'Error on user creation: ' . $user_id->get_error_message();
        $error->add(404, __( $err_msg , 'mechanic'), array('status' => 404));
        return $error;
    } else {
        do_action('user_register', $user_id);

        //update user fullname
        update_user_meta( $user_id, 'mc_user_name', $name );
        update_user_meta( $user_id, 'mc_user_location', $location );
        update_user_meta( $user_id, 'mc_user_phone', $phone );
        update_user_meta( $user_id, 'mc_user_role', $role );

        //update user email
        $user_data = wp_update_user( array( 'ID' => $user_id, 'user_email' => $email ) );

        $response['user_id'] = $user_id;
        $response['message'] = 'User successfully registered.';

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


/**
 * User login API callback
 * @api {post} /users/login Request User login
 * @apiGroup User
 *
 * @apiParam {String} phone User login phone.
 * @apiParam {String} password User login password.
 */
function mc_rest_login_endpoint_handler($request = null) {
    $response = array();
    $parameters = $request->get_json_params();
    
    $phone = sanitize_text_field($parameters['phone']);
    $password = sanitize_text_field($parameters['password']);

    $error = new WP_Error();

    if (empty($phone)) {
        $error->add(404, __("Phone field is empty.", 'mechanic'), array('status' => 404));
        return $error;
    }

    if (empty($password)) {
        $error->add(404, __("Password field 'password' is required.", 'mechanic'), array('status' => 400));
        return $error;
    }else {
        // get user with phone if exists
        $mc_user_phone_key = 'mc_user_phone';
        $user = get_users(
            array(
                'meta_key' => $mc_user_phone_key,
                'meta_value' => $phone,
                'number' => 1,
                'count_total' => false
            )
        );

        if( count($user) == 0 ) {
            $error->add(400, __("User not exist. Please register first to login.", 'mechanic'), array('status' => 400));
            return $error;
        }

        $user_encryted_pass = $user[0]->data->user_pass;

        if ( $user && wp_check_password( $password, $user_encryted_pass, $user[0]->ID ) ) {
            $response['user_id'] = $user[0]->ID;
            $response['phone'] = $phone;
            $response['code'] = '202';
            $response['msg'] = 'User login credentials matched.';
        }else {
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


/**
 * Woocommerce Functions
 * 
 */

 
if( !function_exists( 'mc_woocommerce_extra_register_fields' ) ) {
    function mc_woocommerce_extra_register_fields() {?>
        <p class="form-row form-row-wide">
            <label for="reg_mc_wc_user_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
            <input type="text" class="input-text" name="mc_wc_user_phone" id="reg_mc_wc_user_phone" value="<?php //esc_attr_e( $_POST['billing_phone'] ); ?>" />
        </p>
        <p class="form-row form-row-first">
            <label for="reg_mc_wc_full_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="mc_wc_full_name" id="reg_mc_wc_full_name" value="<?php if ( ! empty( $_POST['mc_wc_full_name'] ) ) esc_attr_e( $_POST['mc_wc_full_name'] ); ?>" />
        </p>
        <p class="form-row form-row-last">
            <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
        </p>
        <div class="clear"></div>
        <?php
    }
}
// add_action( 'woocommerce_register_form', 'mc_woocommerce_extra_register_fields' );


/**
 * register fields Validating.
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Nazrul Islam Nayan
 * @copyright mechanicchai.com
 * @param username - username
 * @param email - email of user
 * @param validation_errors - validation errors
 */
if( !function_exists( 'mc_woocommerce_validate_extra_register_fields' ) ) {
    function mc_woocommerce_validate_extra_register_fields( $username, $email, $validation_errors ) {

        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        
        // if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        //        $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
        // }
        // if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        //        $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
        // }
        //    return $validation_errors;
    }
}
add_action( 'woocommerce_register_post', 'mc_woocommerce_validate_extra_register_fields', 15, 3 );