<?php
mc_function_init();

function mc_function_init() {
    mc_registration_submit();
}

function mc_registration_submit() {
    if( isset($_POST['mc_register']) ) {
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        $full_name = isset($_POST['mc_reg_full_name']) ? sanitize_text_field($_POST['mc_reg_full_name']) : '';
        $location = isset($_POST['mc_reg_location']) ? sanitize_text_field($_POST['mc_reg_location']) : '';
        $email = isset($_POST['mc_reg_email']) ? sanitize_email($_POST['mc_reg_email']) : '';
        $mobile_first = isset($_POST['mc_reg_mobile_first']) ? sanitize_text_field($_POST['mc_reg_mobile_first']) : '';
        $mobile_last = isset($_POST['mc_reg_mobile_last']) ? sanitize_text_field($_POST['mc_reg_mobile_last']) : '';
         
        if( !empty($mobile_first) && !empty($mobile_last) ) {
            $phone = $mobile_first . $mobile_last;
        }

        $password = isset($_POST['mc_reg_password']) ? $_POST['mc_reg_password'] : '';
        $rep_password = isset($_POST['mc_reg_rep_password']) ? $_POST['mc_reg_rep_password'] : '';

        if( $password == $rep_password ) {

        }
        $mc_agree = isset($_POST['mc_reg_agree']) ? $_POST['mc_reg_agree'] : '';

        // $user_id = username_exists($username);
        $user_id = wp_create_user('persone1', $password, $email);

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
        } 
        // if( is_email( $email ) ) {
        //     if ( email_exists($email) == false) {
        //     }else {
        //         mc_get_error('error', 'This Email is already exists!');
        //     }
        // }else {
        //     mc_get_error('error', 'This is not a valid email!');
        // }
        
        
    }
}