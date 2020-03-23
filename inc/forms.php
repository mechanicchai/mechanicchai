<?php
mc_function_init();

function mc_function_init() {
    mc_registration_submit();
}

function mc_registration_submit() {
    if( isset($_POST['mc_register']) ) {
        echo '<pre>';
        print_r($_REQUEST);
        echo '</pre>';

        $name = isset($_POST['mc_reg_full_name']) ? sanitize_text_field($_POST['mc_reg_full_name']) : '';
        $location = isset($_POST['mc_reg_location']) ? sanitize_text_field($_POST['mc_reg_location']) : '';
        $email = isset($_POST['mc_reg_email']) ? sanitize_email($_POST['mc_reg_email']) : '';
        $mobile_first = isset($_POST['mc_reg_mobile_first']) ? sanitize_text_field($_POST['mc_reg_mobile_first']) : '';
        $mobile_last = isset($_POST['mc_reg_mobile_last']) ? sanitize_text_field($_POST['mc_reg_mobile_last']) : '';
         
        if( !empty($mobile_first) && !empty($mobile_last) ) {
            $mobile = $mobile_first . $mobile_last;
        }

        $password = isset($_POST['mc_reg_password']) ? $_POST['mc_reg_password'] : '';
        $rep_password = isset($_POST['mc_reg_rep_password']) ? $_POST['mc_reg_rep_password'] : '';

        if( $password == $rep_password ) {

        }
        $mc_agree = isset($_POST['mc_reg_agree']) ? $_POST['mc_reg_agree'] : '';

        // $user_id = username_exists($username);
        if( is_email( $email ) ) {
            if ( email_exists($email) == false) {
                $user_id = wp_create_user('persone1', $password, $email);
            }else {
                mc_get_error('error', 'This Email is already exists!');
            }
        }else {
            mc_get_error('error', 'This is not a valid email!');
        }
        
        
    }
}