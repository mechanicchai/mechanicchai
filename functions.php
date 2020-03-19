<?php
// add user email in user api
register_rest_field( 'user', 'user_email',
    array(
        'get_callback'    => 'mc_get_user_email_by_id',
        'update_callback' => null,
        'schema'          => null,
    )
);

//get user email by user id
function mc_get_user_email_by_id( $user ) {
    $user_id = $user['id'];

    $user_data = get_userdata( $user_id );
    $user_email = $user_data->data->user_email;
    
    return !empty($user_email) ? $user_email : '';
}