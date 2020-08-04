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

  
  register_rest_route('wp/v2', 'service-post-id', array(
    'methods' => 'GET',
    'callback' => 'mc_rest_get_service_post_id',
  ));

  register_rest_route('wp/v2', 'service-post-meta-by-id', array(
    'methods' => 'POST',
    'callback' => 'mc_rest_service_posts_meta_by_id',
  ));

  register_rest_route('wp/v2', 'all-services', array(
    'methods' => 'GET',
    'callback' => 'mc_rest_get_service_posts',
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

function mc_rest_get_service_posts( $request = null ) {
    $response = array();

    $args = array(
        'post_type' => 'service',
        'posts_per_page' => 50,
    );

    $posts = get_posts( $args );

    $post_arr = [];
    if( $posts ) {
        foreach( $posts as $post ) {
            setup_postdata($post);
            $id = $post->ID;

            $slug = get_post_field( 'post_name', $id );
            $service_ammount = get_post_meta( $id, 'service_amount' );
            $service_ammount = $service_ammount[0];


            //get categories
            $categories = get_the_terms( $id, 'service_category' );
            $cat_ids = wp_list_pluck( $categories, 'term_id' );

            $service_type = get_post_meta( $id, 'mc_service_type' );
            $service_type_option = get_post_meta( $id, 'mc_service_type_option' );
            

            $new_post_arr = [
                'id' => $id,
                'slug' => $slug,
                'acf' => [ 'service_ammount' => $service_ammount ],
                'catgories' => $cat_ids,
                'service_type' => $service_type,
                'service_type_option' => $service_type_option
            ];

            array_push( $post_arr, $new_post_arr );

            wp_reset_postdata();
        }
    }

    $response['posts'] = $post_arr; 
    $response['code'] = 200;

    return new WP_REST_Response($response, 123);
}


function test_shortcode() {
    $args = array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'order_by' => 'DESC',
        'order' => 'date'
    );

    $posts = get_posts( $args );

    echo '<pre>';
    print_r($posts);
    echo '</pre>';
    
}
add_shortcode( 'test_shortcode', 'test_shortcode' );


/**
 * Get a single post id
 */
function mc_rest_get_service_post_id( $request = null ) {
    $response = array();

    $args = array(
        'post_type' => 'service',
        'posts_per_page' => 1,
        'order_by' => 'DESC',
        'order' => 'date'
    );

    $posts = get_posts( $args );

    $id = '';
    if( $posts ) {
        $id = $posts[0]->ID;
    }

    $response['id'] = $id; 
    $response['code'] = 200;

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
                        <?php mc_get_quote_button(home_url('service'), 'Get a Service'); ?>
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


/**
 * WP Customer Login
 */
if( !function_exists('mc_customer_process_login') ) {
    function mc_customer_process_login() {
		$nonce_value = wc_get_var( $_REQUEST['woocommerce-login-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) );

		if ( isset( $_POST['login'], $_POST['mc_login_phone_number'], $_POST['mc_login_password'] ) && wp_verify_nonce( $nonce_value, 'woocommerce-login' ) ) {

            $users = get_users(
                array(
                 'meta_key' => 'mc_user_phone',
                 'meta_value' => $_POST['mc_login_phone_number'],
                 'number' => 1,
                 'count_total' => false
                )
            );

            $username = $users[0]->data->user_login;

			try {
				$creds = array(
					'user_login'    => trim( wp_unslash( $username ) ),
					'user_password' => $_POST['mc_login_password'],
                    'remember'      => true,
                );

				$validation_error = new WP_Error();
				$validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $creds['user_login'], $creds['user_password'] );

				if ( $validation_error->get_error_code() ) {
					throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . $validation_error->get_error_message() );
				}

				if ( empty( $creds['user_login'] ) ) {
					throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . __( 'Username is required.', 'woocommerce' ) );
				}

				// Perform the login.
				$user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );

				if ( is_wp_error( $user ) ) {
					$message = $user->get_error_message();
					$message = str_replace( '<strong>' . esc_html( $creds['user_login'] ) . '</strong>', '<strong>' . esc_html( $creds['user_login'] ) . '</strong>', $message );
					throw new Exception( $message );
				} else {

					if ( ! empty( $_POST['redirect'] ) ) {
						$redirect = wp_unslash( $_POST['redirect'] );
					} elseif ( wc_get_raw_referer() ) {
						$redirect = wc_get_raw_referer();
					} else {
						$redirect = home_url();
					}

					wp_redirect( wp_validate_redirect( home_url() ) );
					exit;
				}
			} catch ( Exception $e ) {
				wc_add_notice( apply_filters( 'login_errors', $e->getMessage() ), 'error' );
				do_action( 'woocommerce_login_failed' );
			}
		}
    }
}
add_action( 'wp_loaded', 'mc_customer_process_login', 20 );

/**
 * Send OTP
 *
 * @param string $nonce
 * @return string
 *
 */
if( !function_exists('mc_send_otp_for_register_form') ) {
    function mc_send_otp_for_register_form() {
        
        if( isset($_POST['reg_nonce']) && wp_verify_nonce($_POST['reg_nonce'], 'woocommerce-register-nonce') ) {
            
            if( !isset($_POST['mobile']) ) {
                return;
            }else {
                $mobile_number = $_POST['mobile'];
            }

            // get user with phone if exists
            $mc_user_phone_key = 'mc_user_phone';
            $user = get_users(
                array(
                    'meta_key' => $mc_user_phone_key,
                    'meta_value' => $mobile_number,
                    'number' => 1,
                    'count_total' => false
                )
            );

            if( count($user) > 0 ) {
                $user_exists = true;
            }

            // generate random otp code
            $digits = 4;
            $otp_code = rand(pow(10, $digits-1), pow(10, $digits)-1);

            // api data
            $sms_api = mc_get_sms_api_data();
             
            // otp request
            $url = "http://bulk.fmsms.biz/smsapi";
            $data = [
                "api_key" => $sms_api['api_key'],
                "type" => "text",
                "contacts" => $mobile_number,
                "senderid" => $sms_api['sender_id'],
                "msg" => "Your Registration OTP is ". $otp_code . ". by Mechanicchai.com",
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        
        echo json_encode( array( 'result' => $response, 'otp_code' => $otp_code, 'user_exists' => $user_exists ), JSON_PRETTY_PRINT );
        exit();	
    }

}
add_action( 'wp_ajax_mc_send_otp_for_register_form', 'mc_send_otp_for_register_form' );
add_action( 'wp_ajax_nopriv_mc_send_otp_for_register_form', 'mc_send_otp_for_register_form' );



/**
 * Send Services Data
 *
 * @param string $nonce
 * @return string
 *
 */
if( !function_exists('mc_submit_services_value') ) {
    function mc_submit_services_value() {
        
        if( isset($_POST['mc_service_nonce']) && wp_verify_nonce($_POST['mc_service_nonce'], 'mc_send_services') ) {
            
            if( ! isset( $_POST['data'] ) ) {
                return;
            }

            

            //get token
            $token_url = 'https://www.mechanicchai.com/wp-json/jwt-auth/v1/token';
            $user_data['username'] = 'mechanic';
            $user_data['password'] = '08122059';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $token_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $user_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            $token_headers = [
                'Content-Type: application/json'
            ];
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $token_headers);
            $token_response = curl_exec($ch);
            curl_close($ch);
            
            $token = json_decode($token_response, true);
            $token = $token['token'];
            $bearer_token = 'Bearer '.$token;

            // service post request
            $url = "https://www.mechanicchai.com/wp-json/gf/v2/entries";
            $data = [
                "form_id" => "1",
                "7" => $_POST['data']['services'],
                "8" => $_POST['data']['info'],
                "9" => $_POST['data']['categories']
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $headers = [
                'Content-Type: application/json',
                'Authorization: '.$bearer_token
            ];
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            curl_close($ch);
        }
        
        echo json_encode( array( 'result' => $response, 'url' => $token_response, 'headers' => $headers ), JSON_PRETTY_PRINT );
        exit();	
    }

}
add_action( 'wp_ajax_mc_submit_services_value', 'mc_submit_services_value' );
add_action( 'wp_ajax_nopriv_mc_submit_services_value', 'mc_submit_services_value' );


/**
 * Send Register Form Data
 *
 * @param string $nonce
 * @return string
 *
 */
if( !function_exists('mc_send_otp_send_register_data') ) {
    function mc_send_otp_send_register_data() {
        $response = [];
        if( isset($_POST['otp_reg_nonce']) && wp_verify_nonce($_POST['otp_reg_nonce'], 'woocommerce-otp') ) {
            
            if( isset($_POST['data']['name']) ) {
                $name = $_POST['data']['name'];
            }
            if( isset($_POST['data']['location']) ) {
                $location = $_POST['data']['location'];
            }
            if( isset($_POST['data']['phone']) ) {
                $phone = $_POST['data']['phone'];
            }
            if( isset($_POST['data']['password']) ) {
                $password = $_POST['data']['password'];
            }

            //generate random email 
            $email = mc_generate_random_email();

             // generate random otp code
             $digits = 2;
             $user_login = $name . rand(pow(10, $digits-1), pow(10, $digits)-1);

            //user data
            $user_data = array(
                'user_login' => $user_login,
                'user_pass'  => $password,
                'user_email' => $email,
                'role'       => 'customer'
            );
        
            //insert user process
            $user_id = wp_insert_user( $user_data );

            if( is_wp_error( $user_id ) ) {
                $response['message'] = 'Error on user creation: ' . $user_id->get_error_message();
            } else {
                do_action('user_register', $user_id);
        
                //update user fullname
                update_user_meta( $user_id, 'mc_user_name', $name );
                update_user_meta( $user_id, 'mc_user_location', $location );
                update_user_meta( $user_id, 'mc_user_phone', $phone );
                update_user_meta( $user_id, 'mc_user_role', 'customer' );
        
                //update user email
                $user_data = wp_update_user( array( 'ID' => $user_id, 'user_email' => $email ) );
        
                $response['user_id'] = $user_id;
                $response['message'] = 'User successfully registered.';
        
            }

        }
        
        echo json_encode( array( 'result' => $response, 'name' => $name ), JSON_PRETTY_PRINT );
        exit();	
        
    }

}
add_action( 'wp_ajax_mc_send_otp_send_register_data', 'mc_send_otp_send_register_data' );
add_action( 'wp_ajax_nopriv_mc_send_otp_send_register_data', 'mc_send_otp_send_register_data' );